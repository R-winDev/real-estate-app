<?php

namespace Database\Seeders;

use App\Models\FloorMaterial;
use Illuminate\Database\Seeder;

class FloorMaterialSeeder extends Seeder
{
    public function run(): void
    {
        $materials = [
            ['name' => 'Tile', 'name_fa' => 'سرامیک', 'slug' => 'tile'],
            ['name' => 'Parquet', 'name_fa' => 'پارکت', 'slug' => 'parquet'],
            ['name' => 'Laminate', 'name_fa' => 'لمینت', 'slug' => 'laminate'],
            ['name' => 'Stone', 'name_fa' => 'سنگ', 'slug' => 'stone'],
            ['name' => 'Marble', 'name_fa' => 'مرمریت', 'slug' => 'marble'],
            ['name' => 'Carpet', 'name_fa' => 'موکت', 'slug' => 'carpet'],
            ['name' => 'Epoxy', 'name_fa' => 'اپوکسی', 'slug' => 'epoxy'],
        ];

        foreach ($materials as $material) {
            FloorMaterial::create($material);
        }
    }
}
