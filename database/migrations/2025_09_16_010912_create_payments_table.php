<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                  ->nullable()
                  ->unique()
                  ->constrained('orders')
                  ->nullOnDelete()
                  ->cascadeOnUpdate();
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['bank_transfer','e_wallet']);
            $table->enum('status', ['admin_validation','paid','rejected'])->default('admin_validation');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
