<?php

namespace Database\Factories;

use App\Models\PropertyType;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'name_fa' => fake()->randomElement(['آپارتمان', 'ویلا', 'زمین', 'مغازه']),
            'slug' => fake()->slug(),
            'category' => fake()->randomElement(['commercial', 'residential']),
        ];
    }
}
