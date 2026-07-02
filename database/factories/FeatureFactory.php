<?php

namespace Database\Factories;

use App\Models\Feature;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeatureFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Central Heating', 'Parking', 'Swimming Pool', 'Elevator', 'Balcony', 'Storage Room', 'Rooftop', 'Garden', 'Security System', 'Smart Home']),
            'name_fa' => fake()->randomElement(['شوفاژ', 'کابینت', 'کولرگازی', 'استخر', 'آسانسور', 'بالکن', 'انباری', 'باغچه', 'دوربین مداربسته', 'سیستم هوشمند']),
            'category' => fake()->randomElement(['comfort', 'security', 'outdoor', 'utility']),
        ];
    }
}
