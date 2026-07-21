<?php

namespace Database\Factories;

use App\Models\PropertyStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyStatusFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'unsold',
            'name_fa' => 'موجود',
            'slug' => 'unsold',
        ];
    }

    public function unsold(): static
    {
        return $this->state(fn () => ['name' => 'unsold', 'name_fa' => 'موجود', 'slug' => 'unsold']);
    }

    public function sold(): static
    {
        return $this->state(fn () => ['name' => 'sold', 'name_fa' => 'فروخته شده', 'slug' => 'sold']);
    }

    public function blacklisted(): static
    {
        return $this->state(fn () => ['name' => 'blacklisted', 'name_fa' => 'بلک لیست', 'slug' => 'blacklisted']);
    }

    public function availableForRent(): static
    {
        return $this->state(fn () => ['name' => 'available_for_rent', 'name_fa' => 'اجاره‌ای', 'slug' => 'available_for_rent']);
    }

    public function rentedOut(): static
    {
        return $this->state(fn () => ['name' => 'rented_out', 'name_fa' => 'اجاره رفته', 'slug' => 'rented_out']);
    }
}
