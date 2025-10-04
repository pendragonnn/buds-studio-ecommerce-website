<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::create([
            'user_id' => 2, // Sayida Syahira (Customer)
            'status' => 'completed',
            'total_amount' => 185000, 
        ]);

        Order::create([
            'user_id' => 3, // Rizky Pratama (Customer)
            'status' => 'pending',
            'total_amount' => 110000, 
        ]);

        Order::create([
            'user_id' => 5, // Aisha Putri (Customer)
            'status' => 'shipped',
            'total_amount' => 75000, 
        ]);

        Order::create([
            'user_id' => 6, // Fajar Nugraha (Customer)
            'status' => 'completed',
            'total_amount' => 300000,
        ]);

        Order::create([
            'user_id' => 9, // Dian Setiawan (Customer)
            'status' => 'cancelled',
            'total_amount' => 140000, 
        ]);

        Order::create([
            'user_id' => 4, // Citra Dewi (Customer)
            'status' => 'pending',
            'total_amount' => 65000,
        ]);

        Order::create([
            'user_id' => 7, // Lina Maria (Customer)
            'status' => 'shipped',
            'total_amount' => 210000,
        ]);

        Order::create([
            'user_id' => 10, // Wulan Sari (Customer)
            'status' => 'completed',
            'total_amount' => 90000,
        ]);

        Order::create([
            'user_id' => 8, // Bima Sakti (Customer)
            'status' => 'pending',
            'total_amount' => 155000,
        ]);

        Order::create([
            'user_id' => 2, // Sayida Syahira (Customer) - Order kedua
            'status' => 'shipped',
            'total_amount' => 125000,
        ]);
    }
}