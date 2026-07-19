<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'مدیر سیستم',
            'email' => 'admin@example.com',
            'is_admin' => true,
        ]);

        User::factory(10)->create();

        $this->call([
            LocationSeeder::class,
            PropertyTypeSeeder::class,
            PropertyStatusSeeder::class,
            FeatureSeeder::class,
            ClimateSystemSeeder::class,
            FloorMaterialSeeder::class,
            BuildingMaterialSeeder::class,
            DocumentSeeder::class,
            PropertySeeder::class,
        ]);
    }
}
