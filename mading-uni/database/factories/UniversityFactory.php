<?php

namespace Database\Factories;

use App\Enums\UniversityStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class UniversityFactory extends Factory
{
    public function definition(): array
    {
        $cities = ['Bandung', 'Depok', 'Yogyakarta', 'Surabaya', 'Bogor', 'Jakarta', 'Semarang', 'Malang'];

        return [
            'name' => $this->faker->unique()->company() . ' University',
            'slug' => null, // auto dari trait HasSlug
            'logo_path' => null,
            'description' => $this->faker->paragraph(3),
            'primary_color' => $this->faker->hexColor(),
            'secondary_color' => $this->faker->hexColor(),
            'city' => $this->faker->randomElement($cities),
            'address' => $this->faker->address(),
            'website' => $this->faker->url(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'status' => UniversityStatus::ACTIVE,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn () => ['status' => UniversityStatus::INACTIVE]);
    }
}