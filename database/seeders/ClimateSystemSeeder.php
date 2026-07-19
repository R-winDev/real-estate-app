<?php

namespace Database\Seeders;

use App\Models\ClimateSystem;
use Illuminate\Database\Seeder;

class ClimateSystemSeeder extends Seeder
{
    public function run(): void
    {
        $systems = [
            ['name' => 'Split AC', 'name_fa' => 'اسپلیت', 'slug' => 'split-ac'],
            ['name' => 'Central AC', 'name_fa' => 'اسپلیت مرکزی', 'slug' => 'central-ac'],
            ['name' => 'Fan Coil', 'name_fa' => 'فن‌کویل', 'slug' => 'fan-coil'],
            ['name' => 'Chiller', 'name_fa' => 'چیلر', 'slug' => 'chiller'],
            ['name' => 'Heating Radiator', 'name_fa' => 'شوفاژ', 'slug' => 'heating-radiator'],
            ['name' => 'Floor Heating', 'name_fa' => 'گرمایش از کف', 'slug' => 'floor-heating'],
            ['name' => 'Wall Heater', 'name_fa' => 'بخاری دیواری', 'slug' => 'wall-heater'],
        ];

        foreach ($systems as $system) {
            ClimateSystem::create($system);
        }
    }
}
