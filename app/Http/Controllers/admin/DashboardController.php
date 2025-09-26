<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Testimony;
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
        $totalRevenue = $orders->where('status', 'completed')->sum('total_amount');

        // Ratings summary
        $reviews = Testimony::with(['orderDetail.product', 'orderDetail.order.user'])->latest()->get();
        $totalReviews = $reviews->count();
        $averageRating = $reviews->avg('rating');
        $fiveStarReviews = $reviews->where('rating', 5)->count();

        // dd($reviews->toArray());

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
            'users',
        ));
    }
}
