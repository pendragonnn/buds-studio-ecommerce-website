<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Testimony;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        $categories = Category::all();

        // Orders summary
        $orders = Order::with(['user', 'orderDetails.product'])->latest()->get();
        $totalOrders = $orders->count();
        $pendingOrders = $orders->where('status', 'pending')->count();
        $completedOrders = $orders->where('status', 'completed')->count();
        $totalRevenue = $orders->sum('total_amount');

        // Ratings summary
        $reviews = Testimony::with('order.user')->latest()->get();
        $totalReviews = $reviews->count();
        $averageRating = $reviews->avg('rating');
        $fiveStarReviews = $reviews->where('rating', 5)->count();

        $roles = Role::all();
        $users = \App\Models\User::with('role')->get();

        return view('admin.dashboard', compact(
            'products',
            'categories',
            'orders',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'totalRevenue',
            'reviews',
            'totalReviews',
            'averageRating',
            'fiveStarReviews',
            'roles',
            'users'
        )); // blade: resources/views/admin/dashboard.blade.php
    }

    // Confirm Payment
    public function confirmPayment(Order $order)
    {
        $payment = Payment::where('order_id', $order->id)->first();

        if ($payment) {
            $payment->update(['status' => 'paid']);
            $order->update(['status' => 'completed']);
        }

        return back()->with('success', 'Payment confirmed successfully.');
    }

    public function storeProduct(Request $request)
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
            $imagePath = $request->file('image')->store('product_images', 'public');
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

    /**
     * Update the specified resource in storage.
     */
    public function updateProduct(Request $request, Product $product)
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
            // Delete old image if exists
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('product_images', 'public');
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

    public function destroyProduct(Product $product)
    {
        // Delete associated image if exists
        if ($product->image_url) {
            Storage::disk('public')->delete($product->image_url);
        }

        $product->delete();

        return back()->with('success', 'Product deleted successfully.');
    }
}
