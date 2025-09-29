<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Http\Controllers\Controller;

class MyOrderController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $user = $request->user();
        $status = $request->get('status', 'all');

        $ordersQuery = Order::with(['payment', 'orderDetails.product'])
            ->where('user_id', $user->id)
            ->latest();

        // filter status
        if ($status !== 'all') {
            switch ($status) {
                case 'admin_validation':
                    // order pending + payment masih admin_validation
                    $ordersQuery->where('status', 'pending')
                        ->whereHas('payment', function ($q) {
                            $q->where('status', 'admin_validation');
                        });
                    break;

                case 'shipping':
                    // order sudah dikirim
                    $ordersQuery->where('status', 'shipped');
                    break;

                case 'completed':
                    $ordersQuery->where('status', 'completed');
                    break;

                case 'cancelled':
                    $ordersQuery->where('status', 'cancelled');
                    break;
            }
        }

        $orders = $ordersQuery->get();

        return view('my-orders.index', compact('orders'));
    }

    public function cancel(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        if ($order->status !== 'pending' || $order->payment->status !== 'admin_validation') {
            return back()->with('error', 'Order tidak bisa dibatalkan.');
        }

        $order->update(['status' => 'cancelled']);
        $order->payment->update(['status' => 'rejected']);

        return back()->with('success', 'Order berhasil dibatalkan.');
    }

    public function complete(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        // hanya bisa complete kalau status masih shipped
        if ($order->status !== 'shipped') {
            return back()->with('error', 'Order tidak bisa diselesaikan.');
        }

        $order->update(['status' => 'completed']);

        return back()->with('success', 'Order berhasil ditandai sebagai completed.');
    }

}
