<?php

namespace Database\Seeders;

use App\Enums\UniversityStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\University;
use App\Models\User;
use Illuminate\Database\Seeder;

class UniversitySeeder extends Seeder
{
    public function run(): void
    {
        $universities = [
            [
                'name' => 'Institut Teknologi Bandung',
                'primary_color' => '#00629B',
                'secondary_color' => '#A9D6F5',
                'city' => 'Bandung',
                'website' => 'https://itb.ac.id',
                'email' => 'info@itb.ac.id',
                'admin_name' => 'Admin ITB',
                'admin_email' => 'admin@itb.ac.id',
            ],
            [
                'name' => 'Universitas Indonesia',
                'primary_color' => '#0057A8',
                'secondary_color' => '#A9C8F5',
                'city' => 'Depok',
                'website' => 'https://ui.ac.id',
                'email' => 'info@ui.ac.id',
                'admin_name' => 'Admin UI',
                'admin_email' => 'admin@ui.ac.id',
            ],
            [
                'name' => 'Universitas Gadjah Mada',
                'primary_color' => '#B71234',
                'secondary_color' => '#F5A9B8',
                'city' => 'Yogyakarta',
                'website' => 'https://ugm.ac.id',
                'email' => 'info@ugm.ac.id',
                'admin_name' => 'Admin UGM',
                'admin_email' => 'admin@ugm.ac.id',
            ],
            [
                'name' => 'Institut Teknologi Sepuluh Nopember',
                'primary_color' => '#00629B',
                'secondary_color' => '#A9D6F5',
                'city' => 'Surabaya',
                'website' => 'https://its.ac.id',
                'email' => 'info@its.ac.id',
                'admin_name' => 'Admin ITS',
                'admin_email' => 'admin@its.ac.id',
            ],
            [
                'name' => 'IPB University',
                'primary_color' => '#1B5E20',
                'secondary_color' => '#A5D6A7',
                'city' => 'Bogor',
                'website' => 'https://ipb.ac.id',
                'email' => 'info@ipb.ac.id',
                'admin_name' => 'Admin IPB',
                'admin_email' => 'admin@ipb.ac.id',
            ],
        ];

        foreach ($universities as $data) {
            $university = University::updateOrCreate(
                ['name' => $data['name']],
                [
                    'slug' => null,
                    'primary_color' => $data['primary_color'],
                    'secondary_color' => $data['secondary_color'],
                    'city' => $data['city'],
                    'website' => $data['website'],
                    'email' => $data['email'],
                    'description' => "Universitas {$data['name']} adalah salah satu universitas terkemuka di Indonesia.",
                    'status' => UniversityStatus::ACTIVE,
                ]
            );

            User::updateOrCreate(
                ['email' => $data['admin_email']],
                [
                    'university_id' => $university->id,
                    'name' => $data['admin_name'],
                    'password' => 'password',
                    'role' => UserRole::UNIVERSITY_ADMIN,
                    'status' => UserStatus::ACTIVE,
                    'email_verified_at' => now(),
                ]
            );
        }

        $this->command->info('✅ 5 Universities + Admins created');
        $this->command->info('   ITB: admin@itb.ac.id / password');
        $this->command->info('   UI:  admin@ui.ac.id / password');
        $this->command->info('   UGM: admin@ugm.ac.id / password');
        $this->command->info('   ITS: admin@its.ac.id / password');
        $this->command->info('   IPB: admin@ipb.ac.id / password');
    }
}