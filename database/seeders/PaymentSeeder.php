<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        Payment::create([
            'order_id' => 1,
            'amount' => 120000,
            'payment_method' => 'bank_transfer',
            'status' => 'admin_validation',
        ]);
    }
}

