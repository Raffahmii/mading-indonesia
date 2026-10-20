<?php

namespace Database\Factories;

use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\University;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $status = $this->faker->randomElement(PostStatus::cases());
        $isPublished = $status === PostStatus::PUBLISHED;

        return [
            'university_id' => University::factory(),
            'category_id' => Category::factory(),
            'author_id' => User::factory()->universityAdmin(),
            'reviewed_by' => null,
            'title' => $this->faker->sentence(6),
            'slug' => null,
            'excerpt' => $this->faker->paragraph(2),
            'body' => $this->faker->paragraphs(5, true),
            'cover_image_path' => null,
            'event_start' => $this->faker->optional()->dateTimeBetween('now', '+3 months'),
            'event_end' => $this->faker->optional()->dateTimeBetween('+3 months', '+6 months'),
            'location' => $this->faker->optional()->city(),
            'status' => $status,
            'submitted_at' => in_array($status, [PostStatus::PENDING, PostStatus::APPROVED, PostStatus::PUBLISHED, PostStatus::REJECTED]) ? now() : null,
            'reviewed_at' => in_array($status, [PostStatus::APPROVED, PostStatus::PUBLISHED, PostStatus::REJECTED]) ? now() : null,
            'published_at' => $isPublished ? now() : null,
            'view_count' => $this->faker->numberBetween(0, 5000),
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'status' => PostStatus::PUBLISHED,
            'submitted_at' => now()->subDays(5),
            'reviewed_at' => now()->subDays(3),
            'published_at' => now()->subDays(2),
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn () => [
            'status' => PostStatus::PENDING,
            'submitted_at' => now(),
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn () => [
            'status' => PostStatus::DRAFT,
        ]);
    }
}