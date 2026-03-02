<?php

namespace Tests\Feature\Auth;

use App\Mail\OtpVerificationMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PasswordlessOtpLoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::insert([
            ['name' => 'candidate'],
            ['name' => 'employer'],
            ['name' => 'admin'],
        ]);
    }

    public function test_passwordless_otp_request_returns_generic_response_for_unknown_email(): void
    {
        Mail::fake();

        $response = $this->postJson(route('passwordless.request-otp'), [
            'email' => 'unknown@example.com',
        ]);

        $response
            ->assertOk()
            ->assertJson([
                'status' => true,
                'message' => 'If the account exists, an OTP has been sent.',
            ]);

        Mail::assertNothingQueued();
    }

    public function test_verified_user_can_login_with_passwordless_otp(): void
    {
        Mail::fake();

        $role = Role::where('name', 'candidate')->firstOrFail();

        $user = User::create([
            'email' => 'candidate@example.com',
            'password' => Hash::make('secret123'),
            'role_id' => $role->id,
            'username' => 'candidate100',
            'email_verified' => true,
        ]);

        $this->postJson(route('passwordless.request-otp'), [
            'email' => 'candidate@example.com',
        ])->assertOk();

        $otp = null;

        Mail::assertQueued(OtpVerificationMail::class, function (OtpVerificationMail $mail) use (&$otp, $user) {
            if ($mail->user->id !== $user->id) {
                return false;
            }

            $otp = (string) $mail->otp;

            return true;
        });

        $verifyResponse = $this->postJson(route('passwordless.verify-otp'), [
            'email' => 'candidate@example.com',
            'otp' => $otp,
        ]);

        $verifyResponse
            ->assertOk()
            ->assertJson([
                'status' => true,
                'role' => 'candidate',
                'message' => 'Login successful.',
            ]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_passwordless_otp_verification_locks_after_too_many_attempts(): void
    {
        Mail::fake();

        $role = Role::where('name', 'candidate')->firstOrFail();

        User::create([
            'email' => 'candidate@example.com',
            'password' => Hash::make('secret123'),
            'role_id' => $role->id,
            'username' => 'candidate101',
            'email_verified' => true,
        ]);

        $this->postJson(route('passwordless.request-otp'), [
            'email' => 'candidate@example.com',
        ])->assertOk();

        for ($i = 0; $i < 5; $i++) {
            $this->postJson(route('passwordless.verify-otp'), [
                'email' => 'candidate@example.com',
                'otp' => '123456',
            ])->assertStatus(422);
        }

        $lockedResponse = $this->postJson(route('passwordless.verify-otp'), [
            'email' => 'candidate@example.com',
            'otp' => '123456',
        ]);

        $lockedResponse
            ->assertStatus(422)
            ->assertJson([
                'status' => false,
                'message' => 'Too many attempts. Please try again later.',
            ]);

        $this->assertGuest();
    }
}
