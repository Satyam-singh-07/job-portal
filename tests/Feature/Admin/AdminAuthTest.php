<?php

namespace Tests\Feature\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login_and_access_dashboard(): void
    {
        [$admin] = $this->seedUsers();

        $response = $this->post(route('admin.login.store'), [
            'email' => $admin->email,
            'password' => 'Secret123!',
        ]);

        $response->assertRedirect(route('admin.dashboard'));

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Admin Dashboard');
    }

    public function test_non_admin_cannot_login_through_admin_portal(): void
    {
        [, $candidate] = $this->seedUsers();

        $response = $this->from(route('admin.login'))->post(route('admin.login.store'), [
            'email' => $candidate->email,
            'password' => 'Secret123!',
        ]);

        $response
            ->assertRedirect(route('admin.login'))
            ->assertSessionHasErrors('email');
    }

    public function test_unauthenticated_user_is_redirected_to_admin_login(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'));
    }

    protected function seedUsers(): array
    {
        Role::insert([
            ['name' => 'candidate'],
            ['name' => 'employer'],
            ['name' => 'admin'],
        ]);

        $adminRole = Role::where('name', 'admin')->firstOrFail();
        $candidateRole = Role::where('name', 'candidate')->firstOrFail();

        $admin = User::create([
            'email' => 'admin@example.com',
            'password' => Hash::make('Secret123!'),
            'role_id' => $adminRole->id,
            'username' => 'admin001',
            'first_name' => 'System',
            'last_name' => 'Admin',
            'email_verified' => true,
        ]);

        $candidate = User::create([
            'email' => 'candidate@example.com',
            'password' => Hash::make('Secret123!'),
            'role_id' => $candidateRole->id,
            'username' => 'candidate001',
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email_verified' => true,
        ]);

        return [$admin, $candidate];
    }
}
