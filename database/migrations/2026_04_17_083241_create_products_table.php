<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('id')->primary(); // String primary key
            $table->string('brand_id')->nullable();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->string('ukuran')->nullable();
            $table->string('konsentrasi')->nullable(); // e.g., EDP, EDT
            $table->string('gender')->nullable();
            $table->string('ketahanan')->nullable(); // Longevity
            $table->string('sillage')->nullable();
            $table->string('proyeksi')->nullable();
            $table->string('vibe')->nullable();
            $table->string('image_url')->nullable();
            $table->string('artboard_ref')->nullable();
            $table->decimal('harga_retail', 12, 2);
            $table->string('mata_uang')->default('IDR');
            $table->integer('stok_tersedia')->default(0);
            $table->string('status_stok')->default('Out of Stock');
            // Timestamps = false berdasarkan model
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
