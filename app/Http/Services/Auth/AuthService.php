<?php

namespace App\Http\Services\Auth;

use App\Mail\OtpVerificationMail;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\PlatformSetting;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(
        protected OtpService $otpService,
        protected UsernameService $usernameService
    ) {}

    public function register($request)
    {
        $role = Role::where('name', $request->role)->firstOrFail();
        $existing = User::where('email', $request->email)->first();

        if ($existing && $existing->email_verified) {
            throw ValidationException::withMessages([
                'email' => ['Email already registered.'],
            ]);
        }

        $otp = $this->otpService->generate();

        if ($existing && ! $existing->email_verified) {
            return DB::transaction(function () use ($existing, $request, $otp) {
                $defaultPostingBalance = PlatformSetting::getInt('employer_default_posting_balance', 10);
                $defaultApplicationBalance = PlatformSetting::getInt('candidate_default_application_balance', 25);

                $existing->update([
                    'password' => Hash::make($request->password),
                    'otp_code' => $this->otpService->hash($otp),
                    'otp_expires_at' => now()->addMinutes(10),
                    'job_posting_balance' => $request->role === 'employer' ? $defaultPostingBalance : 0,
                    'job_application_balance' => $request->role === 'candidate' ? $defaultApplicationBalance : 0,
                ]);

                $this->sendOtp($existing, $otp);

                return $existing;
            });
        }

        for ($attempt = 1; $attempt <= 3; $attempt++) {
            $username = $attempt === 1
                ? $this->usernameService->generate($request)
                : $this->usernameService->generateWithEntropy($request);

            try {
                $user = DB::transaction(function () use ($request, $role, $otp, $username) {
                    $defaultPostingBalance = PlatformSetting::getInt('employer_default_posting_balance', 10);
                    $defaultApplicationBalance = PlatformSetting::getInt('candidate_default_application_balance', 25);

                    return User::create([
                        'role_id' => $role->id,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'username' => $username,
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'company_name' => $request->company_name,
                        'website' => $request->website,
                        'team_size' => $request->team_size,
                        'desired_role' => $request->desired_role,
                        'otp_code' => $this->otpService->hash($otp),
                        'otp_expires_at' => now()->addMinutes(10),
                        'email_verified' => false,
                        'job_posting_balance' => $request->role === 'employer' ? $defaultPostingBalance : 0,
                        'job_application_balance' => $request->role === 'candidate' ? $defaultApplicationBalance : 0,
                    ]);
                });

                $this->sendOtp($user, $otp);

                return $user;
            } catch (QueryException $e) {
                if ($this->isDuplicateUsernameError($e) && $attempt < 3) {
                    continue;
                }

                throw $e;
            }
        }

        throw ValidationException::withMessages([
            'email' => ['Unable to create account right now. Please try again.'],
        ]);
    }

    public function login(LoginRequest $request): array
    {
        $credentials = $request->validated();
        $user = User::with('role')->where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid email or password.'],
            ]);
        }

        if (! $user->email_verified) {
            return [
                'status' => false,
                'otp_required' => true,
                'user_id' => $user->id,
                'message' => 'Please verify your email before logging in.',
            ];
        }

        if (! $user->role) {
            throw new \RuntimeException('No role assigned for this account.');
        }

        if ($user->isEmployer() && $user->isSuspended()) {
            return [
                'status' => false,
                'otp_required' => false,
                'message' => 'Your employer account is suspended. Contact support.',
            ];
        }

        Auth::login($user, (bool) ($credentials['remember'] ?? false));

        return [
            'status' => true,
            'otp_required' => false,
            'role' => $user->role->name,
            'message' => 'Login successful.',
        ];
    }

    protected function sendOtp($user, $otp)
    {
        Mail::to($user->email)
            ->queue(new OtpVerificationMail($user, $otp));
    }

    protected function isDuplicateUsernameError(QueryException $e): bool
    {
        $errorInfo = $e->errorInfo;

        if (! is_array($errorInfo)) {
            return false;
        }

        $sqlState = $errorInfo[0] ?? null;
        $driverCode = $errorInfo[1] ?? null;
        $message = (string) ($errorInfo[2] ?? '');

        return $sqlState === '23000'
            && (int) $driverCode === 1062
            && str_contains($message, 'users_username_unique');
    }
}
