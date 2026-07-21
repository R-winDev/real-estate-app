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
            'listing_type' => 'sale',
            'description' => fake()->paragraph(3),
            'area_total' => fake()->numberBetween(50, 300),
            'price' => fake()->numberBetween(50_000_000_000, 1000_000_000_000),
            'deposit_amount' => null,
            'rent_amount' => null,
            'location_id' => Location::inRandomOrder()->value('id'),
            'type_id' => PropertyType::inRandomOrder()->value('id'),
            'status_id' => PropertyStatus::where('slug', 'unsold')->value('id'),
            'owner_id' => User::inRandomOrder()->value('id'),
        ];
    }

    public function forSale(): static
    {
        return $this->state(fn () => [
            'listing_type' => 'sale',
            'price' => fake()->numberBetween(50_000_000_000, 1000_000_000_000),
            'deposit_amount' => null,
            'rent_amount' => null,
            'status_id' => PropertyStatus::where('slug', 'unsold')->value('id'),
        ]);
    }

    public function forRent(): static
    {
        return $this->state(fn () => [
            'listing_type' => 'rental',
            'price' => null,
            'deposit_amount' => fake()->numberBetween(500_000_000, 5_000_000_000),
            'rent_amount' => fake()->numberBetween(5_000_000, 100_000_000),
            'status_id' => PropertyStatus::where('slug', 'available_for_rent')->value('id'),
        ]);
    }
}
