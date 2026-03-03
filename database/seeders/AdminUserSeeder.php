<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $email = (string) env('ADMIN_SEED_EMAIL', 'admin@jobportal.local');
        $password = (string) env('ADMIN_SEED_PASSWORD', 'Admin@12345');

        User::updateOrCreate(
            ['email' => $email],
            [
                'first_name' => (string) env('ADMIN_SEED_FIRST_NAME', 'System'),
                'last_name' => (string) env('ADMIN_SEED_LAST_NAME', 'Admin'),
                'username' => (string) env('ADMIN_SEED_USERNAME', 'admin'),
                'role_id' => $adminRole->id,
                'password' => Hash::make($password),
                'email_verified' => true,
            ]
        );
    }
}
