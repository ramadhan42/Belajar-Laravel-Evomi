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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total_harga', 15, 2);
            $table->decimal('ongkos_kirim', 15, 2)->default(0);
            $table->enum('status_pembayaran', ['pending', 'success', 'failed', 'expired'])->default('pending');
            $table->text('alamat_pengiriman')->nullable();
            $table->text('catatan_pengiriman')->nullable();
            $table->string('kurir', 50)->nullable();
            $table->timestamps();
        });

        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('product_id', 50);
            $table->integer('jumlah');
            $table->decimal('harga_saat_beli', 15, 2);
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
