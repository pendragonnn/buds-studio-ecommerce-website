<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Product;

class CheckoutController extends Controller
{
    /**
     * Store a new order (create order, order_details, payment and update product stock).
     */
    public function store(Request $request)
    {
        // basic validation
        $data = $request->validate([
            'checkout' => 'required|array',
            'checkout.name' => 'nullable|string|max:150', // biar bisa ambil dari user login
            'checkout.phone' => 'nullable|string|max:30',
            'checkout.address' => 'required|string|max:1000',
            'checkout.province' => 'nullable|string',
            'checkout.province_name' => 'nullable|string',
            'checkout.city' => 'nullable|string',
            'checkout.city_name' => 'nullable|string',
            'checkout.district' => 'nullable|string',
            'checkout.district_name' => 'nullable|string',
            'checkout.subdistrict' => 'nullable|string',
            'checkout.subdistrict_name' => 'nullable|string',
            'checkout.postal_code' => 'nullable|string|max:20',
            'payment_method' => ['required', Rule::in(['bank_transfer', 'e_wallet'])],
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'required|integer|distinct',
            'cart.*.quantity' => 'required|integer|min:1',
        ]);

        $user = $request->user();

        // use DB transaction for safety
        DB::beginTransaction();
        try {
            // 1) Update user address (use only the address fields you want)
            $user->update([
                'name' => $data['checkout']['name'],
                'phone' => $data['checkout']['phone'],
                // we store full address into users.address column
                'address' => collect([
                    $data['checkout']['address'],
                    $data['checkout']['subdistrict_name'] ?? null,
                    $data['checkout']['district_name'] ?? null,
                    $data['checkout']['city_name'] ?? null,
                    $data['checkout']['province_name'] ?? null,
                    $data['checkout']['postal_code'] ?? null,
                ])->filter()->join(', '),
            ]);

            // 2) Re-check stock and compute total
            $cart = $data['cart'];
            $totalAmount = 0;
            $orderDetailsPayload = [];

            foreach ($cart as $cartItem) {
                $product = Product::lockForUpdate()->find($cartItem['id']); // lock row
                if (!$product) {
                    DB::rollBack();
                    return response()->json(['message' => "Product (id: {$cartItem['id']}) not found."], 404);
                }

                if ($product->stock < $cartItem['quantity']) {
                    DB::rollBack();
                    return response()->json([
                        'message' => "Insufficient stock for product: {$product->name}",
                        'product_id' => $product->id,
                        'available' => $product->stock,
                    ], 422);
                }

                $subtotal = $product->price * $cartItem['quantity'];
                $totalAmount += $subtotal;

                $orderDetailsPayload[] = [
                    'product' => $product,
                    'quantity' => $cartItem['quantity'],
                    'subtotal' => $subtotal,
                ];
            }

            // 3) Create Order
            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'pending', // default
                'total_amount' => $totalAmount,
            ]);

            // 4) Create Order Details & decrement product stock
            foreach ($orderDetailsPayload as $od) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $od['product']->id,
                    'quantity' => $od['quantity'],
                    'subtotal' => $od['subtotal'],
                ]);

                // update stock
                $od['product']->decrement('stock', $od['quantity']);
            }

            // 5) Create Payment record
            $paymentStatus = 'admin_validation';
            // you may set different default based on payment method
            $payment = Payment::create([
                'order_id' => $order->id,
                'amount' => $totalAmount,
                'payment_method' => $data['payment_method'],
                'status' => $paymentStatus,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Order created successfully',
                'order_id' => $order->id,
                'payment_id' => $payment->id,
            ], 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            // log the exception in production - for now return error
            return response()->json([
                'message' => 'Failed to create order',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
