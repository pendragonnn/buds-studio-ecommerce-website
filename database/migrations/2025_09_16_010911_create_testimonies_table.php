<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                  ->unique()
                  ->constrained('orders')
                  ->onDelete('cascade'); // kalau order dihapus, testimoninya ikut
            $table->tinyInteger('rating'); // 1-5
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonies');
    }
};
