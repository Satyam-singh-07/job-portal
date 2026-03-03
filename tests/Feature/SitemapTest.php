<?php

namespace Tests\Feature;

use App\Models\Job;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_xml_route_returns_valid_xml_response(): void
    {
        $response = $this->get(route('sitemap'));

        $response
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('<?xml version="1.0" encoding="UTF-8"?>', false)
            ->assertSee('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', false)
            ->assertSee(route('home'))
            ->assertSee(route('jobs.index'))
            ->assertSee(route('employers.index'));
    }

    public function test_sitemap_includes_only_public_dynamic_urls_and_updates_automatically(): void
    {
        $candidateRole = Role::create(['name' => 'candidate']);
        $employerRole = Role::create(['name' => 'employer']);

        $employer = User::create([
            'email' => 'employer@example.com',
            'password' => Hash::make('secret123'),
            'role_id' => $employerRole->id,
            'username' => '@acmehq',
            'company_name' => 'Acme HQ',
            'email_verified' => true,
        ]);

        $candidate = User::create([
            'email' => 'candidate@example.com',
            'password' => Hash::make('secret123'),
            'role_id' => $candidateRole->id,
            'username' => 'candidate001',
            'company_name' => 'Candidate Profile',
            'email_verified' => true,
        ]);

        $publishedJob = $this->createJob($employer, [
            'title' => 'Laravel Engineer',
            'location' => 'Noida,India',
            'status' => 'Published',
        ]);

        $draftJob = $this->createJob($employer, [
            'title' => 'Hidden Draft Job',
            'location' => 'Hidden City',
            'status' => 'Draft',
        ]);

        $response = $this->get(route('sitemap'));

        $response
            ->assertOk()
            ->assertSee(route('jobs.show', ['slug' => $publishedJob->slug]))
            ->assertSee(route('jobs.index', ['location' => 'Noida,India']))
            ->assertDontSee(route('jobs.show', ['slug' => $draftJob->slug]))
            ->assertDontSee(route('jobs.index', ['location' => 'Hidden City']))
            ->assertSee(route('company.show', ['username' => 'acmehq']))
            ->assertDontSee(route('company.show', ['username' => $candidate->username]));

        $newJob = $this->createJob($employer, [
            'title' => 'Senior PHP Engineer',
            'status' => 'Published',
        ]);

        $updatedResponse = $this->get(route('sitemap'));

        $updatedResponse
            ->assertOk()
            ->assertSee(route('jobs.show', ['slug' => $newJob->slug]));
    }

    protected function createJob(User $employer, array $overrides = []): Job
    {
        return Job::create(array_merge([
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
            'status' => 'Published',
        ], $overrides));
    }
}
