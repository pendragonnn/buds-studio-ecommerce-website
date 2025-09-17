<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil data kategori dari database
        $categories = Category::all();

        // Data tambahan (deskripsi dan gambar) untuk setiap kategori
        $additionalData = [
            'Press-On Nails' => [
                'description' => 'Beautiful, salon-quality press-on nails in various designs and colors. Easy to apply, long-lasting results.',
                'image_url' => 'https://i.pinimg.com/736x/86/67/f1/8667f155a505e0e15d08f7e0d9f63d27.jpg' 
            ],
            'Phone Straps' => [
                'description' => 'Trendy and functional phone straps to keep your device secure while adding a touch of personal style.',
                'image_url' => 'https://i.pinimg.com/736x/13/85/c5/1385c585671d78735b3430e971c243f2.jpg' 
            ],
        ];

        // Menggabungkan data kategori dari API dengan data tambahan
        foreach ($categories as $category) {
            // dd($category);
            if (isset($additionalData[$category->name])) {
                $category->description = $additionalData[$category->name]['description'];
                $category->image_url = $additionalData[$category->name]['image_url'];
            }
        }

        // dd( $categories);
        $products = Product::with('category')->take(6)->get(); 
        return view('home', compact('products', 'categories'));
    }
}
