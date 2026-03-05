<?php

namespace Tests\Feature\Employer;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CvSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_employer_cv_search_shows_only_open_to_work_candidates(): void
    {
        [$employer, $openCandidate, $closedCandidate] = $this->seedUsersAndProfiles();

        $response = $this->actingAs($employer)->get(route('employer.cv-search'));

        $response
            ->assertOk()
            ->assertSee('CV Search')
            ->assertSee($openCandidate->email)
            ->assertDontSee($closedCandidate->email);
    }

    public function test_cv_search_filters_by_location_and_resume(): void
    {
        [$employer, $openCandidate] = $this->seedUsersAndProfiles();

        $otherCandidate = $this->createCandidate('other-candidate@example.com', 'other-candidate');
        $otherCandidate->candidateProfile()->create([
            'title' => 'Designer',
            'location' => 'Berlin',
            'resume' => null,
            'is_searchable' => true,
        ]);

        $response = $this->actingAs($employer)->get(route('employer.cv-search', [
            'location' => 'Noida',
            'has_resume' => '1',
        ]));

        $response
            ->assertOk()
            ->assertSee($openCandidate->email)
            ->assertDontSee($otherCandidate->email);
    }

    protected function seedUsersAndProfiles(): array
    {
        Role::insert([
            ['name' => 'candidate'],
            ['name' => 'employer'],
            ['name' => 'admin'],
        ]);

        $employer = $this->createEmployer('employer@example.com', 'employer001');

        $openCandidate = $this->createCandidate('candidate-open@example.com', 'candidate-open');
        $openCandidate->candidateProfile()->create([
            'title' => 'Laravel Developer',
            'location' => 'Noida',
            'experience_level' => '3+ years',
            'work_preference' => 'Remote',
            'desired_employment_type' => 'Full Time',
            'skills' => ['PHP', 'Laravel'],
            'resume' => 'resumes/open.pdf',
            'is_searchable' => true,
        ]);

        $closedCandidate = $this->createCandidate('candidate-closed@example.com', 'candidate-closed');
        $closedCandidate->candidateProfile()->create([
            'title' => 'Backend Engineer',
            'location' => 'Noida',
            'resume' => 'resumes/closed.pdf',
            'is_searchable' => false,
        ]);

        return [$employer, $openCandidate, $closedCandidate];
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

    protected function createCandidate(string $email, string $username): User
    {
        $candidateRole = Role::where('name', 'candidate')->firstOrFail();

        return User::create([
            'email' => $email,
            'password' => Hash::make('secret123'),
            'role_id' => $candidateRole->id,
            'username' => $username,
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email_verified' => true,
        ]);
    }
}
