<?php

namespace Tests\Feature;

use App\Models\Job;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MessagingTest extends TestCase
{
    use RefreshDatabase;

    public function test_candidate_can_contact_employer_from_job_page(): void
    {
        [$candidate, $employer] = $this->seedUsers();

        $job = Job::create($this->jobPayload($employer, [
            'title' => 'Laravel Developer',
            'status' => 'Published',
        ]));

        $response = $this->actingAs($candidate)->postJson(
            route('candidate.jobs.contact', $job->id),
            ['message' => 'Hello, I am interested in this role.']
        );

        $response
            ->assertOk()
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('conversations', [
            'candidate_user_id' => $candidate->id,
            'employer_user_id' => $employer->id,
            'job_id' => $job->id,
        ]);

        $this->assertDatabaseHas('messages', [
            'sender_user_id' => $candidate->id,
            'body' => 'Hello, I am interested in this role.',
        ]);
    }

    public function test_employer_cannot_access_conversation_not_belonging_to_them(): void
    {
        [$candidate, $ownerEmployer] = $this->seedUsers();
        $otherEmployer = $this->createEmployer('other@acme.test', 'other-employer');

        $job = Job::create($this->jobPayload($ownerEmployer, [
            'title' => 'Frontend Developer',
            'status' => 'Published',
        ]));

        $this->actingAs($candidate)->postJson(route('candidate.jobs.contact', $job->id), [
            'message' => 'I would like to discuss this role.',
        ]);

        $conversationId = (int) DB::table('conversations')->value('id');

        $response = $this->actingAs($otherEmployer)->post(
            route('employer.messages.send', ['conversation' => $conversationId]),
            ['body' => 'Unauthorized message attempt']
        );

        $response->assertStatus(403);
    }

    protected function seedUsers(): array
    {
        Role::insert([
            ['name' => 'candidate'],
            ['name' => 'employer'],
            ['name' => 'admin'],
        ]);

        $candidateRole = Role::where('name', 'candidate')->firstOrFail();
        $candidate = User::create([
            'email' => 'candidate@acme.test',
            'password' => Hash::make('secret123'),
            'role_id' => $candidateRole->id,
            'username' => 'candidate001',
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email_verified' => true,
        ]);

        $employer = $this->createEmployer('employer@acme.test', 'employer001');

        return [$candidate, $employer];
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
