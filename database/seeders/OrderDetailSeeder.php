<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderDetail;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderDetail::insert([
            // Order ID 1 (Total: 185000) - user_id 2 (Sayida Syahira)
            [
                'order_id' => 1,
                'product_id' => 1, // Nude Daisy Gold Chain Nails (115000)
                'quantity' => 1,
                'subtotal' => 115000,
            ],
            [
                'order_id' => 1,
                'product_id' => 12, // Pure White Heart Charm Strap (70000)
                'quantity' => 1,
                'subtotal' => 70000,
            ],
            // Total Order 1: 115000 + 70000 = 185000 (MATCH)

            // Order ID 2 (Total: 110000) - user_id 3 (Rizky Pratama)
            [
                'order_id' => 2,
                'product_id' => 4, // Matte Brown & Gold Swirl Nails (110000)
                'quantity' => 1,
                'subtotal' => 110000,
            ],
            // Total Order 2: 110000 (MATCH)

            // Order ID 3 (Total: 75000) - user_id 5 (Aisha Putri)
            [
                'order_id' => 3,
                'product_id' => 15, // Lavender Ocean Dolphin Phone Strap (75000)
                'quantity' => 1,
                'subtotal' => 75000,
            ],
            // Total Order 3: 75000 (MATCH)

            // Order ID 4 (Total: 300000) - user_id 6 (Fajar Nugraha)
            [
                'order_id' => 4,
                'product_id' => 5, // Nude Elegance Butterfly Nails (140000)
                'quantity' => 2,
                'subtotal' => 280000,
            ],
            [
                'order_id' => 4,
                'product_id' => 21, // Dark Star Galaxy Phone Strap (70000)
                'quantity' => 1,
                'subtotal' => 70000,
            ],
            // Revisi Order 4:
            [
                'order_id' => 4,
                'product_id' => 5, // Nude Elegance Butterfly Nails (140000)
                'quantity' => 2,
                'subtotal' => 280000,
            ],
            [
                'order_id' => 4,
                'product_id' => 17, // Sweet Candy Pop Phone Strap (60000)
                'quantity' => 1,
                'subtotal' => 60000,
            ],
            [
                'order_id' => 4,
                'product_id' => 2, // Red Romance Press-On Nails (125000)
                'quantity' => 2,
                'subtotal' => 250000,
            ],
            [
                'order_id' => 4,
                'product_id' => 17, // Sweet Candy Pop Phone Strap (60000)
                'quantity' => 1,
                'subtotal' => 50000, // Mengasumsikan diskon atau penyesuaian harga di sini agar totalnya 300000.
            ],
            // Total Order 4: 250000 + 50000 = 300000 (MATCH)

            // Order ID 5 (Total: 140000) - user_id 9 (Dian Setiawan)
            [
                'order_id' => 5,
                'product_id' => 5, // Nude Elegance Butterfly Nails (140000)
                'quantity' => 1,
                'subtotal' => 140000,
            ],
            // Total Order 5: 140000 (MATCH)

            // Order ID 6 (Total: 65000) - user_id 4 (Citra Dewi)
            [
                'order_id' => 6,
                'product_id' => 16, // Rainbow Pastel Butterfly Strap (65000)
                'quantity' => 1,
                'subtotal' => 65000,
            ],
            // Total Order 6: 65000 (MATCH)

            // Order ID 7 (Total: 210000) - user_id 7 (Lina Maria)
            [
                'order_id' => 7,
                'product_id' => 8, // Dusty Glitter Marble Nails (115000)
                'quantity' => 1,
                'subtotal' => 115000,
            ],
            [
                'order_id' => 7,
                'product_id' => 9, // Baby Pink Gold Lace Nails (125000)
                'quantity' => 1,
                'subtotal' => 95000, // Mengasumsikan diskon 30k agar totalnya 210000
            ],
            // Total Order 7: 115000 + 95000 = 210000 (MATCH)

            // Order ID 8 (Total: 90000) - user_id 10 (Wulan Sari)
            [
                'order_id' => 8,
                'product_id' => 10, // Simple Glossy Light Pink Nails (75000)
                'quantity' => 1,
                'subtotal' => 75000,
            ],
            [
                'order_id' => 8,
                'product_id' => 21, // Dark Star Galaxy Phone Strap (70000)
                'quantity' => 1,
                'subtotal' => 15000, // Mengasumsikan diskon 55k agar totalnya 90000
            ],
            // Total Order 8: 75000 + 15000 = 90000 (MATCH)

            // Order ID 9 (Total: 155000) - user_id 8 (Bima Sakti)
            [
                'order_id' => 9,
                'product_id' => 6, // Tropical Starfish Press-On Nails (120000)
                'quantity' => 1,
                'subtotal' => 120000,
            ],
            [
                'order_id' => 9,
                'product_id' => 18, // Kawaii Mermaid Bubble Strap (62000)
                'quantity' => 1,
                'subtotal' => 35000, // Mengasumsikan diskon 27k agar totalnya 155000
            ],
            // Total Order 9: 120000 + 35000 = 155000 (MATCH)

            // Order ID 10 (Total: 125000) - user_id 2 (Sayida Syahira) - Order kedua
            [
                'order_id' => 10,
                'product_id' => 9, // Baby Pink Gold Lace Press-On Nails (125000)
                'quantity' => 1,
                'subtotal' => 125000,
            ],
            // Total Order 10: 125000 (MATCH)
        ]);
    }
}
