<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResendOtpRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Http\Services\Auth\AuthService;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function store(RegisterRequest $request, AuthService $service)
    {
        try {
            $user = $service->register($request);

            return response()->json([
                'status' => true,
                'message' => 'OTP sent successfully.',
                'user_id' => $user->id,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function login(LoginRequest $request, AuthService $service)
    {
        try {
            $response = $service->login($request);

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function checkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'role' => 'required|in:candidate,employer',
            'website' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid data provided.',
            ], 422);
        }

        $email = strtolower(trim($request->email));
        $role = $request->role;
        $website = $request->website;

        // Check if email already exists
        if (User::where('email', $email)->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Email is already registered.',
            ]);
        }

        // If employer → validate domain matches website
        if ($role === 'employer') {

            if (! $website) {
                return response()->json([
                    'status' => false,
                    'message' => 'Company website is required for employer.',
                ]);
            }

            $websiteDomain = parse_url($website, PHP_URL_HOST);
            $emailDomain = substr(strrchr($email, '@'), 1);

            if (! $websiteDomain || ! str_contains($websiteDomain, $emailDomain)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email must match company website domain.',
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Email is available.',
        ]);
    }

    public function resendOtp(
        ResendOtpRequest $request,
        OtpService $otpService
    ) {
        try {

            $user = User::findOrFail($request->user_id);

            $otpService->resend($user);

            return response()->json([
                'status' => true,
                'message' => 'OTP resent successfully.',
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function verifyOtp(
        VerifyOtpRequest $request,
        OtpService $otpService
    ) {
        try {

            $user = User::findOrFail($request->user_id);

            $result = $otpService->verify($user, $request->otp);

            return response()->json([
                'status' => true,
                'role' => $result['role'],
                'message' => 'Email verified successfully.',
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('home');
    }

    // public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|email',
    //         'password' => 'required|min:6',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     $user = User::where('email', $request->email)->first();

    //     if (!$user || !Hash::check($request->password, $user->password)) {
    //         return response()->json([
    //             'message' => 'Invalid credentials.'
    //         ], 422);
    //     }

    //     // 🚨 Check email verified
    //     if (!$user->email_verified) {
    //         return response()->json([
    //             'status' => false,
    //             'otp_required' => true,
    //             'message' => 'Please verify your email first.',
    //             'user_id' => $user->id
    //         ], 403);
    //     }

    //     Auth::login($user, $request->remember ?? false);

    //     $request->session()->regenerate(); // prevent session fixation

    //     return response()->json([
    //         'status' => true,
    //         'role' => $user->role->name,
    //         'message' => 'Login successful.',
    //     ]);
    // }
}
