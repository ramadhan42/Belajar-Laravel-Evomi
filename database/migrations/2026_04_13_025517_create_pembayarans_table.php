<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayaran', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('metode_pembayaran')->default('COD'); // Contoh: COD, Bank Transfer
            $table->decimal('total_bayar', 15, 2);
            $table->enum('status_pembayaran', ['pending', 'success', 'failed'])->default('pending');
            $table->string('bukti_pembayaran')->nullable(); // Untuk upload bukti jika bukan COD
            $table->timestamp('tgl_bayar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
