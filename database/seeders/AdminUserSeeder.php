<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        AdminUser::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Mills IP Admin',
                'password' => Hash::make('TM@Admin2024!'),
            ]
        );
    }
}
