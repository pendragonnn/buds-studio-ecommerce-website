<?php

namespace Database\Seeders;

use App\Models\Testimony;
use Illuminate\Database\Seeder;

class TestimonySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Testimony::insert([
            [
                'order_detail_id' => 1, // Nude Daisy Gold Chain Nails
                'rating' => 5,
                'comment' => 'Kukunya bagus banget! Desain bunga daisy dan rantai emasnya cantik. Kualitas premium dan tahan lama. Puas banget!',
            ],
            [
                'order_detail_id' => 2, // Pure White Heart Charm Strap
                'rating' => 5,
                'comment' => 'Phone strap Pure White-nya mewah banget! Kualitas manik-manik sangat bagus dan elegan. Will definitely order again!',
            ],
            [
                'order_detail_id' => 5, // Red Romance Press-On Nails (2 pcs)
                'rating' => 5,
                'comment' => 'Kuku Red Romance-nya keren, cocok buat acara formal. Detail bunga dan hati di kukunya rapi sekali, terlihat seperti nail art di salon mahal.',
            ],
            [
                'order_detail_id' => 6, // Sweet Candy Pop Phone Strap
                'rating' => 4,
                'comment' => 'Phone strap candy pop-nya lucu banget, warnanya cerah dan playful. Anakku suka! Pengiriman sedikit telat tapi produknya bagus.',
            ],
            [
                'order_detail_id' => 15, // Simple Glossy Light Pink Nails
                'rating' => 5,
                'comment' => 'Press-on Simple Pink Glossy ini sempurna buat daily, terlihat natural dan gampang diaplikasikan. Love it!',
            ],
            [
                'order_detail_id' => 16, // Dark Star Galaxy Phone Strap
                'rating' => 4,
                'comment' => 'Phone strap Dark Star-nya keren banget, cocok buat style gothic minimalis. Awalnya ragu tapi ternyata kokoh. Good value for money.',
            ],
        ]);
    }
}