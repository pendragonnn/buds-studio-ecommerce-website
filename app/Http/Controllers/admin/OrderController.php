<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function cancel(Order $order)
    {
        \DB::transaction(function () use ($order) {
            // Kembalikan stok produk
            foreach ($order->orderDetails as $detail) {
                $product = $detail->product;
                if ($product) {
                    $product->increment('stock', $detail->quantity);
                }
            }

            // Update status order & payment
            $order->update(['status' => 'cancelled']);
            if ($order->payment) {
                $order->payment->update(['status' => 'rejected']);
            }
        });

        return back()->with('success', 'Order & payment cancelled. Product stock restored.');
    }

    public function confirmPayment(Order $order)
    {
        DB::transaction(function () use ($order) {
            $order->update(['status' => 'shipped']);
            if ($order->payment) {
                $order->payment->update(['status' => 'paid']);
            }
        });

        return back()->with('success', 'Payment confirmed & order completed.');
    }
}
