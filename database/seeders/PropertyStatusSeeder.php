<?php

namespace Database\Seeders;

use App\Models\PropertyStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertyStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'unsold', 'name_fa' => 'موجود', 'slug' => 'unsold'],
            ['name' => 'sold', 'name_fa' => 'فروخته شده', 'slug' => 'sold'],
            ['name' => 'blacklisted', 'name_fa' => 'بلک لیست', 'slug' => 'blacklisted'],
        ];

        foreach ($statuses as $status) {
            PropertyStatus::updateOrCreate(
                ['slug' => $status['slug']],
                $status
            );
        }
    }
}
