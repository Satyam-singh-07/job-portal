<?php

namespace Tests\Feature\Jobs;

use App\Models\Job;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class JobApplicationBalanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_candidate_cannot_apply_when_application_balance_is_zero(): void
    {
        Role::insert([
            ['name' => 'candidate'],
            ['name' => 'employer'],
            ['name' => 'admin'],
        ]);

        $candidateRole = Role::where('name', 'candidate')->firstOrFail();
        $employerRole = Role::where('name', 'employer')->firstOrFail();

        $candidate = User::create([
            'email' => 'candidate-balance@example.com',
            'password' => Hash::make('Secret123!'),
            'role_id' => $candidateRole->id,
            'username' => 'candidatebalance',
            'first_name' => 'Candidate',
            'last_name' => 'Balance',
            'email_verified' => true,
            'job_application_balance' => 0,
        ]);

        $candidate->candidateProfile()->create([
            'title' => 'Backend Engineer',
            'resume' => 'resumes/candidate.pdf',
            'is_searchable' => true,
        ]);

        $employer = User::create([
            'email' => 'employer-balance@example.com',
            'password' => Hash::make('Secret123!'),
            'role_id' => $employerRole->id,
            'username' => 'employerbalance',
            'company_name' => 'Acme Corp',
            'email_verified' => true,
            'job_posting_balance' => 5,
        ]);

        $job = Job::create([
            'user_id' => $employer->id,
            'title' => 'API Engineer',
            'department' => 'Engineering',
            'location' => 'Remote',
            'employment_type' => 'Full Time',
            'salary_range' => '$90,000',
            'seniority' => 'Mid Level',
            'experience' => '3+ years',
            'open_roles' => 1,
            'visa_sponsorship' => false,
            'summary' => 'Build API services.',
            'responsibilities' => 'Deliver backend services.',
            'skills' => 'PHP, Laravel',
            'application_email' => 'jobs@acme.test',
            'allow_quick_apply' => true,
            'status' => 'Published',
            'posting_credit_consumed' => true,
        ]);

        $response = $this->actingAs($candidate)->postJson(route('candidate.jobs.apply', $job), [
            'cover_letter' => 'I am interested in this role.',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'No job application balance left. Contact admin or upgrade your package.');

        $this->assertDatabaseCount('job_applications', 0);
    }
}
