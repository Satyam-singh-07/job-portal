<?php

namespace Tests\Feature\Employer;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class JobPostingBalanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_employer_cannot_publish_job_when_posting_balance_is_zero(): void
    {
        Role::insert([
            ['name' => 'candidate'],
            ['name' => 'employer'],
            ['name' => 'admin'],
        ]);

        $employerRole = Role::where('name', 'employer')->firstOrFail();

        $employer = User::create([
            'email' => 'employer-nobalance@example.com',
            'password' => Hash::make('Secret123!'),
            'role_id' => $employerRole->id,
            'username' => 'employernobalance',
            'company_name' => 'Acme Corp',
            'email_verified' => true,
            'job_posting_balance' => 0,
        ]);

        $payload = [
            'title' => 'Senior PHP Developer',
            'department' => 'Engineering',
            'location' => 'Remote',
            'employment_type' => 'Full Time',
            'salary_range' => '$100,000',
            'seniority' => 'Senior',
            'experience' => '5+ years',
            'open_roles' => 1,
            'visa_sponsorship' => 0,
            'summary' => 'Build scalable backend systems.',
            'responsibilities' => 'Design and implement APIs.',
            'skills' => 'PHP, Laravel, MySQL',
            'application_email' => 'jobs@acme.test',
            'allow_quick_apply' => 1,
            'action' => 'publish',
        ];

        $response = $this->actingAs($employer)
            ->withHeader('X-Requested-With', 'XMLHttpRequest')
            ->postJson(route('employer.post-job.store'), $payload);

        $response
            ->assertStatus(422)
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'No job posting balance left. Ask admin to add more posting credits.');

        $this->assertDatabaseCount('jobs', 0);
    }
}
