<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        Order::create([
            'user_id' => 2, // Sayida (customer)
            'status' => 'pending',
            'total_amount' => 120000,
        ]);
    }
}

