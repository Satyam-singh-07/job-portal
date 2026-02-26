<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Mail\OtpVerificationMail;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|in:candidate,employer',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {

            // Employer Domain Check
            if ($request->role === 'employer') {


            $username = Str::slug($request->company_name);

                $websiteDomain = parse_url($request->website, PHP_URL_HOST);
                $emailDomain = substr(strrchr($request->email, "@"), 1);

                if ($websiteDomain && !str_contains($websiteDomain, $emailDomain)) {
                    return response()->json([
                        'errors' => [
                            'email' => ['Email must match company website domain.']
                        ]
                    ], 422);
                }
            }else {
                $username = Str::slug($request->first_name . '-' . $request->last_name);
            }

            $role = Role::where('name', $request->role)->first();

            $existingUser = User::where('email', $request->email)->first();

            // 🔥 CASE 1: Email exists AND verified
            if ($existingUser && $existingUser->email_verified) {
                return response()->json([
                    'errors' => [
                        'email' => ['Email already registered. Please login.']
                    ]
                ], 422);
            }

            // Generate OTP
            $otp = random_int(100000, 999999);

            // 🔥 CASE 2: Email exists but NOT verified
            if ($existingUser && !$existingUser->email_verified) {

                $existingUser->update([
                    'role_id' => $role->id,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'company_name' => $request->company_name ?? null,
                    'website' => $request->website ?? null,
                    'team_size' => $request->team_size ?? null,
                    'password' => Hash::make($request->password),
                    'otp_code' => Hash::make($otp),
                    'otp_expires_at' => now()->addMinutes(10),
                ]);

                DB::commit();

                Mail::to($existingUser->email)
                    ->queue(new OtpVerificationMail($existingUser, $otp));
                return response()->json([
                    'status' => true,
                    'message' => 'Account already exists but not verified. New OTP sent.',
                    'user_id' => $existingUser->id
                ]);
            }

            // 🔥 CASE 3: New User
            $user = User::create([
                'role_id' => $role->id,
                'email' => $request->email,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'company_name' => $request->company_name ?? null,
                'website' => $request->website ?? null,
                'team_size' => $request->team_size ?? null,
                'password' => Hash::make($request->password),
                'otp_code' => Hash::make($otp),
                'otp_expires_at' => now()->addMinutes(10),
                'username' => $username,
                'email_verified' => false
            ]);

            DB::commit();

            Mail::to($user->email)
                ->queue(new OtpVerificationMail($user, $otp));

            return response()->json([
                'status' => true,
                'message' => 'OTP sent to your email.',
                'user_id' => $user->id
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => 'Server error'
            ], 500);
        }
    }



    public function checkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'   => 'required|email',
            'role'    => 'required|in:candidate,employer',
            'website' => 'nullable|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid data provided.'
            ], 422);
        }

        $email = strtolower(trim($request->email));
        $role  = $request->role;
        $website = $request->website;

        // Check if email already exists
        if (User::where('email', $email)->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Email is already registered.'
            ]);
        }

        // If employer → validate domain matches website
        if ($role === 'employer') {

            if (!$website) {
                return response()->json([
                    'status' => false,
                    'message' => 'Company website is required for employer.'
                ]);
            }

            $websiteDomain = parse_url($website, PHP_URL_HOST);
            $emailDomain   = substr(strrchr($email, "@"), 1);

            if (!$websiteDomain || !str_contains($websiteDomain, $emailDomain)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email must match company website domain.'
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Email is available.'
        ]);
    }


    public function resendOtp(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $user = User::find($request->user_id);

        if ($user->email_verified) {
            return response()->json([
                'message' => 'Already verified.'
            ], 400);
        }

        // Prevent spam (1 min cooldown)
        if ($user->otp_expires_at && now()->lt($user->otp_expires_at->subMinutes(9))) {
            return response()->json([
                'message' => 'Please wait before requesting again.'
            ], 429);
        }

        $otp = random_int(100000, 999999);

        $user->update([
            'otp_code' => Hash::make($otp),
            'otp_expires_at' => now()->addMinutes(10)
        ]);

        Mail::raw("Your new OTP is: {$otp}", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Resend OTP');
        });

        return response()->json([
            'status' => true,
            'message' => 'OTP resent.'
        ]);
    }



    public function verifyOtp(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'otp' => 'required|digits:6'
        ]);

        $user = User::find($request->user_id);

        if ($user->email_verified) {
            return response()->json([
                'message' => 'Email already verified.'
            ], 400);
        }

        if (now()->gt($user->otp_expires_at)) {
            return response()->json([
                'message' => 'OTP expired.'
            ], 400);
        }

        if (!Hash::check($request->otp, $user->otp_code)) {
            return response()->json([
                'message' => 'Invalid OTP.'
            ], 400);
        }

        $user->update([
            'email_verified' => true,
            'otp_code' => null,
            'otp_expires_at' => null
        ]);

        Auth::login($user);

        return response()->json([
            'role'=> $user->role->name,
            'status' => true,
            'message' => 'Email verified successfully.'
        ]);
    }

// logout 
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');

    }



    public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Invalid credentials.'
        ], 422);
    }

    // 🚨 Check email verified
    if (!$user->email_verified) {
        return response()->json([
            'status' => false,
            'otp_required' => true,
            'message' => 'Please verify your email first.',
            'user_id' => $user->id
        ], 403);
    }

    Auth::login($user, $request->remember ?? false);

    $request->session()->regenerate(); // prevent session fixation

    return response()->json([
        'status' => true,
        'role' => $user->role->name,
        'message' => 'Login successful.',
    ]);
}
}