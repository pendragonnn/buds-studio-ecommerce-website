<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data diambil dari total_amount di OrderSeeder:
        // 1: 185000 (Completed)
        // 2: 110000 (Pending)
        // 3: 75000 (Shipped)
        // 4: 300000 (Completed)
        // 5: 140000 (Cancelled)
        // 6: 65000 (Pending)
        // 7: 210000 (Shipped)
        // 8: 90000 (Completed)
        // 9: 155000 (Pending)
        // 10: 125000 (Shipped)

        Payment::create([
            'order_id' => 1,
            'amount' => 185000,
            'payment_method' => 'bank_transfer',
            'status' => 'paid',
        ]);

        Payment::create([
            'order_id' => 2,
            'amount' => 110000,
            'payment_method' => 'bank_transfer',
            'status' => 'admin_validation', 
        ]);

        Payment::create([
            'order_id' => 3,
            'amount' => 75000,
            'payment_method' => 'e_wallet',
            'status' => 'paid',
        ]);

        Payment::create([
            'order_id' => 4,
            'amount' => 300000,
            'payment_method' => 'bank_transfer',
            'status' => 'paid',
        ]);

        Payment::create([
            'order_id' => 5,
            'amount' => 140000,
            'payment_method' => 'bank_transfer',
            'status' => 'rejected',
        ]);

        Payment::create([
            'order_id' => 6,
            'amount' => 65000,
            'payment_method' => 'e_wallet',
            'status' => 'admin_validation',
        ]);

        Payment::create([
            'order_id' => 7,
            'amount' => 210000,
            'payment_method' => 'bank_transfer',
            'status' => 'paid',
        ]);

        Payment::create([
            'order_id' => 8,
            'amount' => 90000,
            'payment_method' => 'e_wallet',
            'status' => 'paid',
        ]);

        Payment::create([
            'order_id' => 9,
            'amount' => 155000,
            'payment_method' => 'e_wallet',
            'status' => 'admin_validation',
        ]);

        Payment::create([
            'order_id' => 10,
            'amount' => 125000,
            'payment_method' => 'bank_transfer',
            'status' => 'paid',
        ]);
    }
}
