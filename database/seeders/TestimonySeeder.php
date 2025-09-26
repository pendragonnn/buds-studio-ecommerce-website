<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Testimony;
use Illuminate\Database\Seeder;

class TestimonySeeder extends Seeder
{
    public function run(): void
    {
        $orders = OrderDetail::take(10)->get();

        foreach ($orders as $order) {
            Testimony::create([
                'order_id' => $order->id,
                'rating'   => rand(3, 5), 
                'comment'  => fake()->sentence(12),
            ]);
        }
    }
}
