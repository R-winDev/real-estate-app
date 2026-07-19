<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        $documents = [
            ['name' => 'Title Deed', 'name_fa' => 'سند مالکیت', 'slug' => 'title-deed'],
            ['name' => 'Building Permit', 'name_fa' => 'پایان کار', 'slug' => 'building-permit'],
            ['name' => 'Construction License', 'name_fa' => 'پروانه ساخت', 'slug' => 'construction-license'],
            ['name' => 'Sale Agreement', 'name_fa' => 'مبایعه نامه', 'slug' => 'sale-agreement'],
            ['name' => 'Valuation Report', 'name_fa' => 'کارشناسی', 'slug' => 'valuation-report'],
            ['name' => 'Tax Certificate', 'name_fa' => 'گواهی مالیاتی', 'slug' => 'tax-certificate'],
        ];

        foreach ($documents as $document) {
            Document::create($document);
        }
    }
}
