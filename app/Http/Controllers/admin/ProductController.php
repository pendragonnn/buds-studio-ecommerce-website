<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        $categories = Category::all();

        return view('admin.products', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destination = public_path('storage/product_images');

            // pastikan foldernya ada
            if (!File::exists($destination)) {
                File::makeDirectory($destination, 0755, true);
            }

            $image->move($destination, $imageName);
            $imagePath = 'product_images/' . $imageName;
        }

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'image_url' => $imagePath,
        ]);

        return back()->with('success', 'Product added successfully.');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $product->image_url;

        if ($request->hasFile('image')) {
            // hapus gambar lama kalau ada
            if ($imagePath && File::exists(public_path('storage/' . $imagePath))) {
                File::delete(public_path('storage/' . $imagePath));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destination = public_path('storage/product_images');

            if (!File::exists($destination)) {
                File::makeDirectory($destination, 0755, true);
            }

            $image->move($destination, $imageName);
            $imagePath = 'product_images/' . $imageName;
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'image_url' => $imagePath,
        ]);

        return back()->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // hapus gambar fisik di public/storage/product_images
        if ($product->image_url && File::exists(public_path('storage/' . $product->image_url))) {
            File::delete(public_path('storage/' . $product->image_url));
        }

        $product->delete();

        return back()->with('success', 'Product deleted successfully.');
    }

}
