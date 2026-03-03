<?php

namespace Tests\Feature\Admin;

use App\Models\Conversation;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobView;
use App\Models\Message;
use App\Models\ResumeView;
use App\Models\Role;
use App\Models\User;
use App\Models\UserPageActivity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ReportManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_reports_index_with_dynamic_data(): void
    {
        [$admin, $candidate, $employer] = $this->seedUsers();
        $this->seedAnalytics($candidate, $employer);

        $this->actingAs($admin)
            ->get(route('admin.reports.index', ['preset' => 'last7']))
            ->assertOk()
            ->assertSee('Reports Intelligence')
            ->assertSee('/jobs')
            ->assertSee('Engagement Diagnostics');
    }

    public function test_admin_can_export_reports_csv(): void
    {
        [$admin, $candidate, $employer] = $this->seedUsers();
        $this->seedAnalytics($candidate, $employer);

        $response = $this->actingAs($admin)
            ->get(route('admin.reports.export', ['preset' => 'last7']));

        $response->assertOk();
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');

        $csv = $response->streamedContent();
        $this->assertStringContainsString('metric,value,period_start,period_end', $csv);
        $this->assertStringContainsString('page_views', $csv);
        $this->assertStringContainsString('applications', $csv);
    }

    private function seedUsers(): array
    {
        Role::insert([
            ['name' => 'candidate', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'employer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'admin', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $candidateRole = Role::query()->where('name', 'candidate')->firstOrFail();
        $employerRole = Role::query()->where('name', 'employer')->firstOrFail();
        $adminRole = Role::query()->where('name', 'admin')->firstOrFail();

        $admin = User::create([
            'email' => 'admin-report@example.com',
            'password' => Hash::make('Secret123!'),
            'role_id' => $adminRole->id,
            'username' => 'adminreport',
            'first_name' => 'Admin',
            'last_name' => 'Report',
            'email_verified' => true,
            'account_status' => 'Active',
        ]);

        $candidate = User::create([
            'email' => 'candidate-report@example.com',
            'password' => Hash::make('Secret123!'),
            'role_id' => $candidateRole->id,
            'username' => 'candidatereport',
            'first_name' => 'Candidate',
            'last_name' => 'One',
            'email_verified' => true,
            'account_status' => 'Active',
        ]);

        $employer = User::create([
            'email' => 'employer-report@example.com',
            'password' => Hash::make('Secret123!'),
            'role_id' => $employerRole->id,
            'username' => 'employerreport',
            'company_name' => 'Acme Inc',
            'email_verified' => true,
            'account_status' => 'Active',
        ]);

        return [$admin, $candidate, $employer];
    }

    private function seedAnalytics(User $candidate, User $employer): void
    {
        Carbon::setTestNow(Carbon::parse('2026-03-03 10:00:00'));

        $job = Job::create([
            'user_id' => $employer->id,
            'title' => 'Senior Engineer',
            'department' => 'Engineering',
            'location' => 'Remote',
            'employment_type' => 'Full-time',
            'seniority' => 'Senior',
            'experience' => '5+ years',
            'summary' => 'Build systems',
            'status' => 'Published',
        ]);

        $application = JobApplication::create([
            'job_id' => $job->id,
            'user_id' => $candidate->id,
            'status' => 'Pending',
        ]);

        UserPageActivity::create([
            'user_id' => $candidate->id,
            'path' => '/jobs',
            'path_hash' => hash('sha256', '/jobs'),
            'page_title' => 'Jobs',
            'activity_date' => Carbon::now()->toDateString(),
            'total_seconds' => 180,
            'last_seen_at' => Carbon::now()->subMinutes(3),
            'session_id' => 'session-1',
        ]);

        UserPageActivity::create([
            'user_id' => $employer->id,
            'path' => '/employer/dashboard',
            'path_hash' => hash('sha256', '/employer/dashboard'),
            'page_title' => 'Employer Dashboard',
            'activity_date' => Carbon::now()->toDateString(),
            'total_seconds' => 240,
            'last_seen_at' => Carbon::now()->subMinutes(1),
            'session_id' => 'session-2',
        ]);

        JobView::create([
            'job_id' => $job->id,
            'user_id' => $candidate->id,
            'viewer_key' => 'candidate-' . $candidate->id,
            'viewed_on' => Carbon::now()->toDateString(),
        ]);

        ResumeView::create([
            'job_application_id' => $application->id,
            'candidate_user_id' => $candidate->id,
            'employer_user_id' => $employer->id,
            'viewed_at' => Carbon::now()->subMinutes(5),
        ]);

        $conversation = Conversation::create([
            'candidate_user_id' => $candidate->id,
            'employer_user_id' => $employer->id,
            'job_id' => $job->id,
            'subject' => 'Application Follow-up',
            'last_message_at' => Carbon::now()->subMinutes(2),
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_user_id' => $candidate->id,
            'body' => 'Interested in the role.',
        ]);

        DB::table('employer_followers')->insert([
            'candidate_user_id' => $candidate->id,
            'employer_user_id' => $employer->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Carbon::setTestNow();
    }
}
