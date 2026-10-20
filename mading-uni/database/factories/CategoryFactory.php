<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'slug' => null,
            'description' => $this->faker->sentence(),
            'icon' => $this->faker->randomElement(['megaphone', 'calendar', 'trophy', 'presentation', 'award', 'star']),
            'is_active' => true,
        ];
    }
}