<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyStatus;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Database\Seeder;

class RentalPropertySeeder extends Seeder
{
    public function run(): void
    {
        $rentalStatus = PropertyStatus::where('slug', 'available_for_rent')->value('id');
        $rentedOutStatus = PropertyStatus::where('slug', 'rented_out')->value('id');
        $locations = Location::pluck('id')->toArray();
        $types = PropertyType::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();

        $rentals = [
            [
                'title' => 'آپارتمان ۱۲۰ متری - خیابان ولیعصر',
                'listing_type' => 'rental',
                'description' => 'آپارتمان نوساز با امکانات کامل. پارکینگ، انباری، آسانسور. نزدیک مترو و مجتمع تجاری. مناسب خانواده.',
                'area_total' => 120,
                'price' => null,
                'deposit_amount' => 3_500_000_000,
                'rent_amount' => 45_000_000,
                'location_id' => $locations[array_rand($locations)],
                'type_id' => $types[array_rand($types)],
                'status_id' => $rentalStatus,
                'owner_id' => $users[array_rand($users)],
            ],
            [
                'title' => 'واحد ۸۵ متری - مجتمع مسکونی آرامش',
                'listing_type' => 'rental',
                'description' => 'واحد شیک و تمیز با نورگیر عالی. کف سرامیک، درب ضد سرقت. ساختمان ۴ طبقه ۸ واحدی.',
                'area_total' => 85,
                'price' => null,
                'deposit_amount' => 2_000_000_000,
                'rent_amount' => 25_000_000,
                'location_id' => $locations[array_rand($locations)],
                'type_id' => $types[array_rand($types)],
                'status_id' => $rentalStatus,
                'owner_id' => $users[array_rand($users)],
            ],
            [
                'title' => 'پنت‌هاوس ۲۰۰ متری - برج آسمان',
                'listing_type' => 'rental',
                'description' => 'پنت‌هاوس لوکس با ویوی ۳۶۰ درجه شهر. استخر، سونا، باشگاه اختصاصی. نگهبانی ۲۴ ساعته.',
                'area_total' => 200,
                'price' => null,
                'deposit_amount' => 8_000_000_000,
                'rent_amount' => 120_000_000,
                'location_id' => $locations[array_rand($locations)],
                'type_id' => $types[array_rand($types)],
                'status_id' => $rentalStatus,
                'owner_id' => $users[array_rand($users)],
            ],
            [
                'title' => 'واحد ۶۰ متری - خیابان انقلاب',
                'listing_type' => 'rental',
                'description' => 'واحد مناسب برای زوج جوان. نوساز، با کابینت ام دی اف. نزدیک دانشگاه.',
                'area_total' => 60,
                'price' => null,
                'deposit_amount' => 1_200_000_000,
                'rent_amount' => 15_000_000,
                'location_id' => $locations[array_rand($locations)],
                'type_id' => $types[array_rand($types)],
                'status_id' => $rentalStatus,
                'owner_id' => $users[array_rand($users)],
            ],
            [
                'title' => 'آپارتمان ۱۵۰ متری - شهرک غرب',
                'listing_type' => 'rental',
                'description' => 'واحد بزرگ و لوکس در بهترین بلوک شهرک. پارکینگ دو ماشین، تراس بزرگ. مناسب خانواده پرجمعیت.',
                'area_total' => 150,
                'price' => null,
                'deposit_amount' => 5_000_000_000,
                'rent_amount' => 70_000_000,
                'location_id' => $locations[array_rand($locations)],
                'type_id' => $types[array_rand($types)],
                'status_id' => $rentedOutStatus,
                'owner_id' => $users[array_rand($users)],
            ],
            [
                'title' => 'آپارتمان ۹۵ متری - ولنجک',
                'listing_type' => 'rental',
                'description' => 'واحد مدرن با چشم‌انداز کوه. پارکینگ سرپوشیده، آسانسور، لاندری مرکزی.',
                'area_total' => 95,
                'price' => null,
                'deposit_amount' => 4_000_000_000,
                'rent_amount' => 55_000_000,
                'location_id' => $locations[array_rand($locations)],
                'type_id' => $types[array_rand($types)],
                'status_id' => $rentalStatus,
                'owner_id' => $users[array_rand($users)],
            ],
        ];

        foreach ($rentals as $data) {
            Property::create($data);
        }

        $this->command->info('Created ' . count($rentals) . ' rental properties.');
    }
}
