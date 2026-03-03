<?php

namespace Tests\Feature;

use App\Models\Conversation;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Message;
use App\Models\ResumeView;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CandidateDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_candidate_dashboard_returns_dynamic_metrics(): void
    {
        Role::insert([
            ['name' => 'candidate'],
            ['name' => 'employer'],
            ['name' => 'admin'],
        ]);

        $candidateRole = Role::where('name', 'candidate')->firstOrFail();
        $employerRole = Role::where('name', 'employer')->firstOrFail();

        $candidate = User::create([
            'email' => 'candidate@example.com',
            'password' => Hash::make('secret123'),
            'role_id' => $candidateRole->id,
            'username' => 'candidate001',
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email_verified' => true,
        ]);

        $candidate->candidateProfile()->create([
            'title' => 'Backend Engineer',
            'location' => 'Noida',
            'resume' => 'resumes/jane.pdf',
            'target_roles' => 'Backend Engineer, Laravel Developer',
        ]);

        $employer = User::create([
            'email' => 'employer@example.com',
            'password' => Hash::make('secret123'),
            'role_id' => $employerRole->id,
            'username' => 'employer001',
            'company_name' => 'Acme Labs',
            'email_verified' => true,
        ]);

        $candidate->followingEmployers()->attach($employer->id);

        $job = Job::create([
            'user_id' => $employer->id,
            'title' => 'Laravel Developer',
            'department' => 'Engineering',
            'location' => 'Noida',
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
            'status' => 'Published',
        ]);

        $application = JobApplication::create([
            'job_id' => $job->id,
            'user_id' => $candidate->id,
            'status' => 'Pending',
        ]);

        ResumeView::create([
            'job_application_id' => $application->id,
            'candidate_user_id' => $candidate->id,
            'employer_user_id' => $employer->id,
            'viewed_at' => now(),
        ]);

        $conversation = Conversation::create([
            'candidate_user_id' => $candidate->id,
            'employer_user_id' => $employer->id,
            'job_id' => $job->id,
            'subject' => 'Regarding role',
            'last_message_at' => now(),
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_user_id' => $employer->id,
            'body' => 'Please share your availability.',
            'read_at' => null,
        ]);

        $response = $this->actingAs($candidate)->get(route('candidate.dashboard'));

        $response
            ->assertOk()
            ->assertViewHas('stats', function (array $stats): bool {
                return $stats['profile_views'] === 1
                    && $stats['followings'] === 1
                    && $stats['resume_versions'] === 1
                    && $stats['unread_messages'] === 1
                    && $stats['applications_total'] === 1
                    && $stats['applications_pending'] === 1;
            });
    }
}
