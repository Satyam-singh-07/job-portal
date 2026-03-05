<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class FollowingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_candidate_can_follow_and_unfollow_employer(): void
    {
        [$candidate, $employer] = $this->seedCandidateAndEmployer();

        $this->actingAs($candidate)
            ->post(route('candidate.followings.store', $employer->id))
            ->assertRedirect();

        $this->assertDatabaseHas('employer_followers', [
            'candidate_user_id' => $candidate->id,
            'employer_user_id' => $employer->id,
        ]);

        $this->actingAs($candidate)
            ->delete(route('candidate.followings.destroy', $employer->id))
            ->assertRedirect();

        $this->assertDatabaseMissing('employer_followers', [
            'candidate_user_id' => $candidate->id,
            'employer_user_id' => $employer->id,
        ]);
    }

    public function test_employer_cannot_follow_another_employer_with_candidate_route(): void
    {
        [, $employer] = $this->seedCandidateAndEmployer();
        $otherEmployer = $this->createEmployer('second-employer@example.com', 'second-employer');

        $response = $this->actingAs($employer)
            ->post(route('candidate.followings.store', $otherEmployer->id));

        $response->assertStatus(403);
    }

    protected function seedCandidateAndEmployer(): array
    {
        Role::insert([
            ['name' => 'candidate'],
            ['name' => 'employer'],
            ['name' => 'admin'],
        ]);

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

        $employer = $this->createEmployer('employer@example.com', 'employer001');

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
}
