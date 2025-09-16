<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'role_id' => 1, // admin
            'name' => 'Admin Buds Studio',
            'email' => 'admin@budsstudio.com',
            'password' => Hash::make('password123'),
            'phone' => '081234567890',
            'address' => 'Jakarta, Indonesia',
        ]);

        User::create([
            'role_id' => 2, // customer
            'name' => 'Sayida Syahira',
            'email' => 'sayida@example.com',
            'password' => Hash::make('password123'),
            'phone' => '089876543210',
            'address' => 'Bandung, Indonesia',
        ]);
    }
}

