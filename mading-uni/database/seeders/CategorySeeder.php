<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Pengumuman', 'icon' => 'megaphone',  'description' => 'Pengumuman resmi universitas'],
            ['name' => 'Event',      'icon' => 'calendar',   'description' => 'Acara dan kegiatan kampus'],
            ['name' => 'Lomba',      'icon' => 'trophy',     'description' => 'Kompetisi dan perlombaan'],
            ['name' => 'Seminar',    'icon' => 'presentation', 'description' => 'Seminar dan workshop'],
            ['name' => 'Beasiswa',   'icon' => 'award',      'description' => 'Informasi beasiswa'],
            ['name' => 'Prestasi',   'icon' => 'star',       'description' => 'Pencapaian mahasiswa & alumni'],
        ];

        foreach ($categories as $data) {
            Category::updateOrCreate(
                ['name' => $data['name']],
                [
                    'slug' => null,
                    'icon' => $data['icon'],
                    'description' => $data['description'],
                    'is_active' => true,
                ]
            );
        }

        $this->command->info('✅ 6 Categories created');
    }
}