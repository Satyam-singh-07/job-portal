<?php

namespace Tests\Feature\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
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

    public function test_verified_user_can_login_successfully(): void
    {
        $candidateRole = Role::where('name', 'candidate')->firstOrFail();

        $user = User::create([
            'email' => 'candidate@example.com',
            'password' => Hash::make('secret123'),
            'role_id' => $candidateRole->id,
            'username' => 'candidate001',
            'email_verified' => true,
        ]);

        $response = $this->post('/login', [
            'email' => '  CANDIDATE@EXAMPLE.COM  ',
            'password' => 'secret123',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
                'otp_required' => false,
                'role' => 'candidate',
                'message' => 'Login successful.',
            ]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_unverified_user_gets_otp_required_response(): void
    {
        $employerRole = Role::where('name', 'employer')->firstOrFail();

        $user = User::create([
            'email' => 'employer@example.com',
            'password' => Hash::make('secret123'),
            'role_id' => $employerRole->id,
            'username' => 'employer001',
            'email_verified' => false,
        ]);

        $response = $this->post('/login', [
            'email' => 'employer@example.com',
            'password' => 'secret123',
        ]);

        $response
            ->assertStatus(403)
            ->assertJson([
                'status' => false,
                'otp_required' => true,
                'user_id' => $user->id,
                'message' => 'Please verify your email before logging in.',
            ]);

        $this->assertGuest();
    }

    public function test_invalid_credentials_return_validation_error(): void
    {
        $candidateRole = Role::where('name', 'candidate')->firstOrFail();

        User::create([
            'email' => 'candidate@example.com',
            'password' => Hash::make('secret123'),
            'role_id' => $candidateRole->id,
            'username' => 'candidate001',
            'email_verified' => true,
        ]);

        $response = $this->post('/login', [
            'email' => 'candidate@example.com',
            'password' => 'wrong-password',
        ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'status' => false,
                'message' => 'Invalid email or password.',
            ])
            ->assertJsonValidationErrors(['email']);

        $this->assertGuest();
    }

    public function test_login_validation_errors_always_return_json(): void
    {
        $response = $this->post('/login', [
            'email' => 'not-an-email',
            'password' => '',
        ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'status' => false,
                'message' => 'Validation failed.',
            ])
            ->assertJsonValidationErrors(['email', 'password']);
    }
}
