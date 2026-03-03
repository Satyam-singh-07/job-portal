<?php

namespace Tests\Feature\Employer;

use App\Models\CandidateProfile;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ResumeViewTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_employer_can_open_resume_and_view_is_tracked(): void
    {
        [$employer, $candidate] = $this->seedEmployerAndCandidate();

        $job = Job::create($this->jobPayload($employer, [
            'title' => 'Backend Engineer',
            'status' => 'Published',
        ]));

        CandidateProfile::create([
            'user_id' => $candidate->id,
            'resume' => 'resumes/candidate-resume.pdf',
            'is_searchable' => true,
            'is_public_link_active' => true,
            'is_indexed_by_search_engines' => true,
        ]);

        $application = JobApplication::create([
            'job_id' => $job->id,
            'user_id' => $candidate->id,
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($employer)->get(
            route('employer.jobs.applications.resume', [$job->id, $application->id])
        );

        $response->assertRedirect();

        $this->assertDatabaseHas('resume_views', [
            'job_application_id' => $application->id,
            'candidate_user_id' => $candidate->id,
            'employer_user_id' => $employer->id,
        ]);
    }

    public function test_other_employer_cannot_open_resume_for_job_they_do_not_own(): void
    {
        [$ownerEmployer, $candidate] = $this->seedEmployerAndCandidate();
        $otherEmployer = $this->createEmployer('other-employer@example.com', 'otherEmployer');

        $job = Job::create($this->jobPayload($ownerEmployer, [
            'title' => 'Frontend Engineer',
            'status' => 'Published',
        ]));

        CandidateProfile::create([
            'user_id' => $candidate->id,
            'resume' => 'resumes/candidate-resume.pdf',
        ]);

        $application = JobApplication::create([
            'job_id' => $job->id,
            'user_id' => $candidate->id,
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($otherEmployer)->get(
            route('employer.jobs.applications.resume', [$job->id, $application->id])
        );

        $response->assertStatus(403);

        $this->assertDatabaseCount('resume_views', 0);
    }

    protected function seedEmployerAndCandidate(): array
    {
        Role::insert([
            ['name' => 'candidate'],
            ['name' => 'employer'],
            ['name' => 'admin'],
        ]);

        $employer = $this->createEmployer('employer@example.com', 'employer001');

        $candidateRole = Role::where('name', 'candidate')->firstOrFail();
        $candidate = User::create([
            'email' => 'candidate@example.com',
            'password' => Hash::make('secret123'),
            'role_id' => $candidateRole->id,
            'username' => 'candidate001',
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email_verified' => true,
        ]);

        return [$employer, $candidate];
    }

    protected function createEmployer(string $email, string $username): User
    {
        $employerRole = Role::where('name', 'employer')->firstOrFail();

        return User::create([
            'email' => $email,
            'password' => Hash::make('secret123'),
            'role_id' => $employerRole->id,
            'username' => $username,
            'company_name' => 'Acme Labs',
            'email_verified' => true,
        ]);
    }

    protected function jobPayload(User $employer, array $overrides = []): array
    {
        return array_merge([
            'user_id' => $employer->id,
            'title' => 'Software Engineer',
            'department' => 'Engineering',
            'location' => 'Remote',
            'employment_type' => 'Full Time',
            'salary_range' => '$100,000',
            'seniority' => 'Mid Level',
            'experience' => '1-2 years',
            'open_roles' => 1,
            'visa_sponsorship' => false,
            'summary' => 'Build and maintain web applications.',
            'responsibilities' => 'Deliver backend services.',
            'skills' => 'PHP, Laravel',
            'application_email' => 'jobs@acme.test',
            'external_apply_link' => null,
            'allow_quick_apply' => true,
            'status' => 'Draft',
        ], $overrides);
    }
}
