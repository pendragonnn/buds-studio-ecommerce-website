<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Http\Controllers\Controller;
use App\Models\Testimony;
use App\Models\OrderDetail;

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

    public function storeTestimony(Request $request, OrderDetail $orderDetail)
    {
        // dd($orderDetail->order->user_id);
        if ($orderDetail->order->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Testimony::create([
            'order_detail_id' => $orderDetail->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return back()->with('success', 'Testimony added successfully!');
    }

    public function updateTestimony(Request $request, OrderDetail $orderDetail)
    {
        if ($orderDetail->order->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $testimony = $orderDetail->testimony; // relasi 1:1
        if ($testimony) {
            $testimony->update($validated);
        }

        return back()->with('success', 'Testimony updated successfully!');
    }

    public function whatsappData(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $order->load(['user', 'orderDetails.product']);

        return response()->json([
            'id' => $order->id,
            'status' => $order->status,
            'total' => $order->total_amount,
            'user' => [
                'name' => $order->user->name,
                'phone' => $order->user->phone,
                'address' => $order->user->address,
            ],
            'address' => $order->address,
            'items' => $order->orderDetails->map(function ($detail) {
                return [
                    'name' => $detail->product->name,
                    'quantity' => $detail->quantity,
                    'price' => $detail->price,
                    'subtotal' => $detail->subtotal,
                ];
            }),
        ]);
    }
}
