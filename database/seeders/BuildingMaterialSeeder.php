<?php

namespace Database\Seeders;

use App\Models\BuildingMaterial;
use Illuminate\Database\Seeder;

class BuildingMaterialSeeder extends Seeder
{
    public function run(): void
    {
        $materials = [
            ['name' => 'Brick', 'name_fa' => 'آجر', 'slug' => 'brick'],
            ['name' => 'Concrete', 'name_fa' => 'بتن', 'slug' => 'concrete'],
            ['name' => 'Steel', 'name_fa' => 'فولاد', 'slug' => 'steel'],
            ['name' => 'Block', 'name_fa' => 'بلوک', 'slug' => 'block'],
            ['name' => 'Stone', 'name_fa' => 'سنگ', 'slug' => 'stone'],
            ['name' => 'Wood', 'name_fa' => 'چوب', 'slug' => 'wood'],
        ];

        foreach ($materials as $material) {
            BuildingMaterial::create($material);
        }
    }
}
