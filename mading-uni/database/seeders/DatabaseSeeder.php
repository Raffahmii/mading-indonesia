<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SuperAdminSeeder::class,
            UniversitySeeder::class,
            CategorySeeder::class,
            PostSeeder::class,
        ]);

        $this->command->info('');
        $this->command->info('🎉 SEMUA SEEDER BERHASIL DIJALANKAN');
        $this->command->info('');
        $this->command->info('📧 Login Credentials:');
        $this->command->info('   Super Admin:        super@mading.id / password');
        $this->command->info('   Admin ITB:          admin@itb.ac.id / password');
        $this->command->info('   Admin UI:           admin@ui.ac.id / password');
        $this->command->info('   Admin UGM:          admin@ugm.ac.id / password');
        $this->command->info('   Admin ITS:          admin@its.ac.id / password');
        $this->command->info('   Admin IPB:          admin@ipb.ac.id / password');
    }
}