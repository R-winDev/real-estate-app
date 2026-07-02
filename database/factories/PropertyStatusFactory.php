<?php

namespace Database\Factories;

use App\Models\PropertyStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyStatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=> fake()->randomElement(['sold', 'unsold', 'blacklisted']),
            'name_fa'=> fake()->randomElement(['فروخته شده', 'موجود', 'بلک لیست']),
            'slug'=> fake()->slug(),
        ];
    }
}
