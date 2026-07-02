<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyStatus;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(3),
            'area_total' => fake()->numberBetween(50, 300),
            'price' => fake()->numberBetween(50_000_000_000, 1000_000_000_000),
            'location_id' => Location::inRandomOrder()->value('id'),
            'type_id' => PropertyType::inRandomOrder()->value('id'),
            'status_id' => PropertyStatus::inRandomOrder()->value('id'),
            'owner_id' => User::inRandomOrder()->value('id'),
        ];
    }
}
