<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('app.admin_email', 'admin@example.com');
        $password = config('app.admin_password', 'password');

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'مدیر سیستم',
                'password' => $password,
                'is_admin' => true,
                'must_change_password' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info("Admin user created: {$email}");
    }
}
