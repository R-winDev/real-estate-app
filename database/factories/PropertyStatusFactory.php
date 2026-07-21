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
}
