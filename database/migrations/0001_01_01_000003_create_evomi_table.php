<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_evomi_tables.php

    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
        });

        Schema::create('products', function (Blueprint $table) {
            $table->string('id', 50)->primary(); // Primary Key String (EVO-001)
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null');
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->string('ukuran', 50)->nullable();
            $table->string('konsentrasi', 100)->nullable();
            $table->string('gender', 50)->nullable();
            $table->string('ketahanan', 50)->nullable();
            $table->string('sillage', 50)->nullable();
            $table->string('proyeksi', 50)->nullable();
            $table->text('vibe')->nullable();
            $table->string('image_url')->nullable();
            $table->string('artboard_ref', 100)->nullable();
            $table->decimal('harga_retail', 15, 2)->default(0);
            $table->string('mata_uang', 10)->default('IDR');
            $table->integer('stok_tersedia')->default(0);
            $table->string('status_stok', 50)->nullable();
            $table->timestamps();
        });

        Schema::create('product_characters', function (Blueprint $table) {
            $table->id();
            $table->string('product_id', 50);
            $table->string('nama_karakter', 100);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('product_notes', function (Blueprint $table) {
            $table->id();
            $table->string('product_id', 50);
            $table->enum('tipe_note', ['top', 'middle', 'base']);
            $table->string('nama_note', 100);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->timestamps();
        });
    }
};
