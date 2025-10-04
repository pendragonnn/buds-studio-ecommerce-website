<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Testimony;
use Illuminate\Database\Seeder;

class TestimonySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Order ID yang memiliki status 'completed' dari OrderSeeder: 1, 4, dan 8.
        $completedOrderIds = [1, 4, 8]; // Data testimoni hanya dibuat untuk ID ini.

        Testimony::insert([
            // Testimony untuk Order ID 1 (Status: COMPLETED | Customer: Sayida Syahira)
            // Produk: Nude Daisy Nails + Pure White Heart Strap
            [
                'order_detail_id' => 1,
                'rating' => 5,
                'comment' => 'Kukunya bagus banget! Desain bunga daisy dan rantai emasnya cantik. Phone strap-nya juga elegan dan kualitas manik-maniknya premium. Puas banget!',
            ],

            // Testimony untuk Order ID 4 (Status: COMPLETED | Customer: Fajar Nugraha)
            // Produk: 2x Red Romance Nails + 1x Sweet Candy Pop Strap
            [
                'order_detail_id' => 4,
                'rating' => 5,
                'comment' => 'Kuku Red Romance-nya keren, cocok buat acara formal. Phone strap candy pop-nya lucu banget, warnanya cerah dan playful. Anakku suka!',
            ],

            // Testimony untuk Order ID 8 (Status: COMPLETED | Customer: Wulan Sari)
            // Produk: Simple Light Pink Nails + Dark Star Galaxy Strap
            [
                'order_detail_id' => 8,
                'rating' => 5,
                'comment' => 'Press-on Simple Pink Glossy ini sempurna buat daily, terlihat natural. Phone strap Dark Star-nya juga keren, cocok buat style gothic minimalis. Love it!',
            ],
        ]);
    }
}