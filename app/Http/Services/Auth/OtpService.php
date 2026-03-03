<?php

namespace App\Http\Services\Auth;

use App\Mail\OtpVerificationMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class OtpService
{
    protected int $expiryMinutes = 10;

    protected int $cooldownSeconds = 60;

    protected int $maxAttempts = 5;

    protected int $lockMinutes = 15;

    public function sendPasswordlessOtp(string $email): void
    {
        $user = User::where('email', strtolower(trim($email)))->first();

        if (! $user || ! $user->email_verified) {
            return;
        }

        $this->issueOtp($user);
    }

    public function resend(User $user): void
    {
        if ($user->email_verified) {
            throw new \Exception('Email already verified.');
        }

        $this->issueOtp($user);
    }

    public function verify(User $user, string $otp): array
    {
        if ($user->email_verified) {
            throw new \Exception('Email already verified.');
        }

        $this->validateOtpAttempt($user);
        $this->assertOtpMatches($user, $otp);

        DB::transaction(function () use ($user) {
            $user->update([
                'email_verified' => true,
                'otp_code' => null,
                'otp_expires_at' => null,
                'otp_attempts' => 0,
                'otp_locked_until' => null,
            ]);
        });

        Auth::login($user);

        return [
            'role' => $user->role->name,
        ];
    }

    public function verifyPasswordless(string $email, string $otp, bool $remember = false): array
    {
        $user = User::with('role')->where('email', strtolower(trim($email)))->first();

        if (! $user || ! $user->email_verified) {
            throw ValidationException::withMessages([
                'otp' => ['Invalid or expired OTP.'],
            ]);
        }

        if ($user->isEmployer() && $user->isSuspended()) {
            throw ValidationException::withMessages([
                'otp' => ['Your employer account is suspended. Contact support.'],
            ]);
        }

        $this->validateOtpAttempt($user);
        $this->assertOtpMatches($user, $otp);

        DB::transaction(function () use ($user) {
            $user->update([
                'otp_code' => null,
                'otp_expires_at' => null,
                'otp_attempts' => 0,
                'otp_locked_until' => null,
            ]);
        });

        Auth::login($user, $remember);

        return [
            'role' => $user->role?->name,
            'message' => 'Login successful.',
        ];
    }

    public function generate(): int
    {
        return random_int(100000, 999999);
    }

    public function hash($otp)
    {
        return Hash::make($otp);
    }

    protected function issueOtp(User $user): void
    {
        if ($user->otp_last_sent_at && now()->diffInSeconds($user->otp_last_sent_at) < $this->cooldownSeconds) {
            throw ValidationException::withMessages([
                'otp' => ['Please wait before requesting another OTP.'],
            ]);
        }

        $otp = $this->generate();

        DB::transaction(function () use ($user, $otp) {
            $user->update([
                'otp_code' => $this->hash($otp),
                'otp_expires_at' => now()->addMinutes($this->expiryMinutes),
                'otp_attempts' => 0,
                'otp_locked_until' => null,
                'otp_last_sent_at' => now(),
            ]);
        });

        Mail::to($user->email)
            ->queue(new OtpVerificationMail($user, $otp));
    }

    protected function validateOtpAttempt(User $user): void
    {
        if ($user->otp_locked_until && now()->lt($user->otp_locked_until)) {
            throw ValidationException::withMessages([
                'otp' => ['Too many attempts. Please try again later.'],
            ]);
        }

        if (! $user->otp_expires_at || now()->gt($user->otp_expires_at) || empty($user->otp_code)) {
            throw ValidationException::withMessages([
                'otp' => ['Invalid or expired OTP.'],
            ]);
        }
    }

    protected function assertOtpMatches(User $user, string $otp): void
    {
        if (Hash::check($otp, $user->otp_code)) {
            return;
        }

        $attempts = (int) $user->otp_attempts + 1;

        $updatePayload = ['otp_attempts' => $attempts];

        if ($attempts >= $this->maxAttempts) {
            $updatePayload['otp_locked_until'] = now()->addMinutes($this->lockMinutes);
            $updatePayload['otp_code'] = null;
            $updatePayload['otp_expires_at'] = null;
        }

        $user->update($updatePayload);

        throw ValidationException::withMessages([
            'otp' => ['Invalid or expired OTP.'],
        ]);
    }
}
