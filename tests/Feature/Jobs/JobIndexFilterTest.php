<?php

namespace Tests\Feature\Jobs;

use App\Models\Job;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class JobIndexFilterTest extends TestCase
{
    use RefreshDatabase;

    protected User $employer;

    protected function setUp(): void
    {
        parent::setUp();

        Role::insert([
            ['name' => 'candidate'],
            ['name' => 'employer'],
            ['name' => 'admin'],
        ]);

        $employerRole = Role::where('name', 'employer')->firstOrFail();

        $this->employer = User::create([
            'email' => 'employer@example.com',
            'password' => Hash::make('secret123'),
            'role_id' => $employerRole->id,
            'username' => 'employer001',
            'company_name' => 'Acme Labs',
            'email_verified' => true,
        ]);
    }

    public function test_jobs_index_applies_combined_filters(): void
    {
        $matching = $this->createPublishedJob([
            'title' => 'Senior Laravel Engineer',
            'department' => 'Engineering',
            'location' => 'Austin',
            'employment_type' => 'Full Time',
            'experience' => '3+ years',
        ]);

        $this->createPublishedJob([
            'title' => 'HR Specialist',
            'department' => 'People Ops',
            'location' => 'Austin',
            'employment_type' => 'Part Time',
            'experience' => 'Graduate',
        ]);

        $response = $this->get(route('jobs.index', [
            'search' => 'Laravel',
            'location' => 'Austin',
            'category' => 'Engineering',
            'types' => ['Full Time'],
            'experience' => ['3+ years'],
            'sort' => 'recent',
        ]));

        $response
            ->assertOk()
            ->assertSee($matching->title)
            ->assertDontSee('HR Specialist');
    }

    public function test_jobs_index_ignores_unknown_filter_values_instead_of_failing(): void
    {
        $firstJob = $this->createPublishedJob([
            'title' => 'Backend Developer',
            'employment_type' => 'Full Time',
            'experience' => '1-2 years',
            'created_at' => now()->subDay(),
        ]);

        $secondJob = $this->createPublishedJob([
            'title' => 'Frontend Developer',
            'employment_type' => 'Contract',
            'experience' => 'Graduate',
            'created_at' => now(),
        ]);

        $response = $this->get(route('jobs.index', [
            'types' => ['Not Real Type'],
            'experience' => ['Not Real Experience'],
            'sort' => 'totally-unknown',
        ]));

        $response
            ->assertOk()
            ->assertSee($firstJob->title)
            ->assertSee($secondJob->title);
    }

    public function test_jobs_ajax_response_returns_zero_based_count_text_for_empty_state(): void
    {
        $this->createPublishedJob([
            'title' => 'Data Analyst',
            'location' => 'Chicago',
        ]);

        $response = $this
            ->withHeader('X-Requested-With', 'XMLHttpRequest')
            ->get(route('jobs.index', [
                'search' => 'NoSuchRole',
            ]));

        $response
            ->assertOk()
            ->assertJson([
                'count_text' => 'Showing 0 - 0 of 0 results',
                'total_found' => '0 Jobs Found',
            ]);
    }

    protected function createPublishedJob(array $overrides = []): Job
    {
        return Job::create(array_merge([
            'user_id' => $this->employer->id,
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
            'status' => 'Published',
        ], $overrides));
    }
}
