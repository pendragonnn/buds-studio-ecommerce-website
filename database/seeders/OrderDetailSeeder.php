<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderDetail;

class OrderDetailSeeder extends Seeder
{
    public function run(): void
    {
        OrderDetail::insert([
            [
                'order_id' => 1,
                'product_id' => 1, // Press-On Nails
                'quantity' => 1,
                'subtotal' => 75000,
            ],
            [
                'order_id' => 1,
                'product_id' => 2, // Phone Strap
                'quantity' => 1,
                'subtotal' => 45000,
            ],
        ]);
    }
}

