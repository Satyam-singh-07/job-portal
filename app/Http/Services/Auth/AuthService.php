<?php

namespace App\Http\Services\Auth;

use App\Mail\OtpVerificationMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    public function __construct(
        protected OtpService $otpService,
        protected UsernameService $usernameService
    ) {}

    public function register($request)
    {
        return DB::transaction(function () use ($request) {

            $role = Role::where('name', $request->role)->firstOrFail();
            $existing = User::where('email', $request->email)->first();

            if ($existing && $existing->email_verified) {
                throw new \Exception('Email already registered.');
            }

            $otp = $this->otpService->generate();

            if ($existing && ! $existing->email_verified) {
                $existing->update([
                    'password' => Hash::make($request->password),
                    'otp_code' => $this->otpService->hash($otp),
                    'otp_expires_at' => now()->addMinutes(10),
                ]);

                $this->sendOtp($existing, $otp);

                return $existing;
            }

            $username = $this->usernameService->generate($request);

            $user = User::create([
                'role_id' => $role->id,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'username' => $username,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'otp_code' => $this->otpService->hash($otp),
                'otp_expires_at' => now()->addMinutes(10),
                'email_verified' => false,
            ]);

            $this->sendOtp($user, $otp);

            return $user;
        });
    }

    public function login($request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw new \Exception('Invalid credentials.');
        }

        if (! $user->email_verified) {
            return [
                'otp_required' => true,
                'user_id' => $user->id,
            ];
        }

        Auth::login($user, $request->remember ?? false);

        return [
            'otp_required' => false,
            'role' => $user->role->name,
        ];
    }

    protected function sendOtp($user, $otp)
    {
        Mail::to($user->email)
            ->queue(new OtpVerificationMail($user, $otp));
    }
}
