<?php

namespace Database\Seeders;

use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\Post;
use App\Models\University;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $universities = University::all();
        $categories = Category::all();

        foreach ($universities as $university) {
            $admin = User::where('university_id', $university->id)
                ->where('role', 'university_admin')
                ->first();

            if (! $admin) {
                continue;
            }

            // Bikin 10 post per universitas dengan status variatif
            foreach (range(1, 10) as $i) {
                $category = $categories->random();
                $status = match ($i % 4) {
                    0 => PostStatus::PUBLISHED,
                    1 => PostStatus::PENDING,
                    2 => PostStatus::DRAFT,
                    3 => PostStatus::PUBLISHED,
                };

                $isPublished = $status === PostStatus::PUBLISHED;

                // Login sebagai admin universitas biar university_id auto-fill
                auth()->login($admin);

                Post::create([
                    'university_id' => $university->id,
                    'category_id' => $category->id,
                    'author_id' => $admin->id,
                    'title' => "{$category->name} {$university->name} #{$i}",
                    'excerpt' => "Informasi terbaru tentang {$category->name} di {$university->name}.",
                    'body' => "Ini adalah konten dummy untuk keperluan testing.\n\nKategori: {$category->name}\nUniversitas: {$university->name}\n\nLorem ipsum dolor sit amet, consectetur adipiscing elit.",
                    'event_start' => $category->name === 'Event' || $category->name === 'Lomba'
                        ? now()->addDays(rand(7, 60))
                        : null,
                    'event_end' => $category->name === 'Event' || $category->name === 'Lomba'
                        ? now()->addDays(rand(61, 90))
                        : null,
                    'location' => $university->city,
                    'status' => $status,
                    'submitted_at' => in_array($status, [PostStatus::PENDING, PostStatus::PUBLISHED])
                        ? now()->subDays(3)
                        : null,
                    'reviewed_at' => $isPublished ? now()->subDays(2) : null,
                    'published_at' => $isPublished ? now()->subDays(1) : null,
                    'view_count' => rand(0, 1000),
                ]);

                auth()->logout();
            }
        }

        $this->command->info('✅ 50 Posts created (10 per university)');
    }
}