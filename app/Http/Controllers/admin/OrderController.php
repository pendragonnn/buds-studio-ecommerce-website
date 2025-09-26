<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function cancel(Order $order)
    {
        DB::transaction(function () use ($order) {
            $order->update(['status' => 'cancelled']);
            if ($order->payment) {
                $order->payment->update(['status' => 'rejected']);
            }
        });

        return back()->with('success', 'Order & payment cancelled.');
    }

    public function confirmPayment(Order $order)
    {
        DB::transaction(function () use ($order) {
            $order->update(['status' => 'completed']);
            if ($order->payment) {
                $order->payment->update(['status' => 'paid']);
            }
        });

        return back()->with('success', 'Payment confirmed & order completed.');
    }
}
