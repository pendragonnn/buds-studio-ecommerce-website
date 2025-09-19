<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Testimony;
use Illuminate\Database\Seeder;

class TestimonySeeder extends Seeder
{
    public function run(): void
    {
        $orders = Order::take(10)->get();

        foreach ($orders as $order) {
            Testimony::create([
                'order_id' => $order->id,
                'rating'   => rand(3, 5), // random 3–5 biar realistis
                'comment'  => fake()->sentence(12),
            ]);
        }
    }
}
