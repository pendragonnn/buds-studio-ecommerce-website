<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Pastel Pink Press-On Nails',
                'category_id' => 1,
                'price' => 75000,
                'stock' => 50,
                'image_url' => 'images/products/nails-pastel.jpg',
            ],
            [
                'name' => 'Cute Beads Phone Strap',
                'category_id' => 2,
                'price' => 45000,
                'stock' => 30,
                'image_url' => 'images/products/phone-strap.jpg',
            ],
        ]);
    }
}
