<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'super@mading.id'],
            [
                'university_id' => null,
                'name' => 'Super Admin',
                'password' => 'password',
                'role' => UserRole::SUPER_ADMIN,
                'status' => UserStatus::ACTIVE,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Super Admin created: super@mading.id / password');
    }
}