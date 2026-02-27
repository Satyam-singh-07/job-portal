<?php

namespace App\Http\Services\Auth;

use App\Mail\OtpVerificationMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    protected int $expiryMinutes = 10;

    protected int $cooldownSeconds = 60;

    public function resend(User $user): void
    {
        if ($user->email_verified) {
            throw new \Exception('Email already verified.');
        }

        // Cooldown protection (1 minute)
        if ($user->otp_expires_at) {

            $lastSent = Carbon::parse($user->otp_expires_at)
                ->subMinutes($this->expiryMinutes);

            if (now()->diffInSeconds($lastSent) < $this->cooldownSeconds) {
                throw new \Exception('Please wait before requesting again.');
            }
        }

        $otp = $this->generate();

        DB::transaction(function () use ($user, $otp) {
            $user->update([
                'otp_code' => $this->hash($otp),
                'otp_expires_at' => now()->addMinutes($this->expiryMinutes),
            ]);
        });

        Mail::to($user->email)
            ->queue(new OtpVerificationMail($user, $otp));
    }

    public function verify(User $user, string $otp): array
    {
        if ($user->email_verified) {
            throw new \Exception('Email already verified.');
        }

        if (! $user->otp_expires_at || now()->gt($user->otp_expires_at)) {
            throw new \Exception('OTP expired.');
        }

        if (! Hash::check($otp, $user->otp_code)) {
            throw new \Exception('Invalid OTP.');
        }

        DB::transaction(function () use ($user) {
            $user->update([
                'email_verified' => true,
                'otp_code' => null,
                'otp_expires_at' => null,
            ]);
        });

        Auth::login($user);

        return [
            'role' => $user->role->name,
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
}
