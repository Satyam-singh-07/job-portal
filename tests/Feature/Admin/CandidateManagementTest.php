<?php

namespace Tests\Feature\Admin;

use App\Models\CandidateProfile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CandidateManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_candidate_management_index(): void
    {
        [$admin, $candidateRole] = $this->seedRolesAndAdmin();

        $candidate = User::create([
            'email' => 'candidate-a@example.com',
            'password' => Hash::make('Secret123!'),
            'role_id' => $candidateRole->id,
            'username' => 'candidatea',
            'first_name' => 'Alice',
            'last_name' => 'Candidate',
            'email_verified' => true,
            'account_status' => 'Active',
        ]);

        CandidateProfile::create([
            'user_id' => $candidate->id,
            'title' => 'Frontend Developer',
            'experience_level' => 'Mid-level',
            'work_preference' => 'Remote',
            'skills' => ['React', 'TypeScript'],
            'is_searchable' => true,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.candidates.index'))
            ->assertOk()
            ->assertSee('Candidate Operations')
            ->assertSee('Alice Candidate');
    }

    public function test_admin_can_filter_candidates_by_status_and_work_preference(): void
    {
        [$admin, $candidateRole] = $this->seedRolesAndAdmin();

        $activeCandidate = User::create([
            'email' => 'candidate-active@example.com',
            'password' => Hash::make('Secret123!'),
            'role_id' => $candidateRole->id,
            'username' => 'activecandidate',
            'first_name' => 'Active',
            'last_name' => 'Candidate',
            'email_verified' => true,
            'account_status' => 'Active',
        ]);

        $suspendedCandidate = User::create([
            'email' => 'candidate-suspended@example.com',
            'password' => Hash::make('Secret123!'),
            'role_id' => $candidateRole->id,
            'username' => 'suspendedcandidate',
            'first_name' => 'Suspended',
            'last_name' => 'Candidate',
            'email_verified' => true,
            'account_status' => 'Suspended',
        ]);

        CandidateProfile::create([
            'user_id' => $activeCandidate->id,
            'experience_level' => 'Senior',
            'work_preference' => 'Remote',
            'is_searchable' => true,
        ]);

        CandidateProfile::create([
            'user_id' => $suspendedCandidate->id,
            'experience_level' => 'Junior',
            'work_preference' => 'Onsite',
            'is_searchable' => false,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.candidates.index', [
                'status' => 'Suspended',
                'work_preference' => 'Onsite',
            ]))
            ->assertOk()
            ->assertSee('Suspended Candidate')
            ->assertDontSee('Active Candidate');
    }

    public function test_admin_can_update_candidate_status_and_open_to_work(): void
    {
        [$admin, $candidateRole] = $this->seedRolesAndAdmin();

        $candidate = User::create([
            'email' => 'candidate-update@example.com',
            'password' => Hash::make('Secret123!'),
            'role_id' => $candidateRole->id,
            'username' => 'candidateupdate',
            'first_name' => 'Update',
            'last_name' => 'Candidate',
            'email_verified' => true,
            'account_status' => 'Active',
        ]);

        CandidateProfile::create([
            'user_id' => $candidate->id,
            'is_searchable' => true,
        ]);

        $this->actingAs($admin)
            ->patch(route('admin.candidates.status', $candidate), [
                'account_status' => 'Suspended',
            ])
            ->assertRedirect();

        $candidate->refresh();
        $this->assertSame('Suspended', $candidate->account_status);

        $this->actingAs($admin)
            ->patch(route('admin.candidates.open-to-work', $candidate), [
                'open_to_work' => false,
            ])
            ->assertRedirect();

        $candidate->refresh();
        $this->assertFalse((bool) $candidate->candidateProfile?->is_searchable);
    }

    private function seedRolesAndAdmin(): array
    {
        Role::insert([
            ['name' => 'candidate'],
            ['name' => 'employer'],
            ['name' => 'admin'],
        ]);

        $candidateRole = Role::where('name', 'candidate')->firstOrFail();
        $adminRole = Role::where('name', 'admin')->firstOrFail();

        $admin = User::create([
            'email' => 'admin@example.com',
            'password' => Hash::make('Secret123!'),
            'role_id' => $adminRole->id,
            'username' => 'admin001',
            'first_name' => 'System',
            'last_name' => 'Admin',
            'email_verified' => true,
            'account_status' => 'Active',
        ]);

        return [$admin, $candidateRole];
    }
}
