<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_notes', function (Blueprint $table) {
            $table->id();
            $table->string('product_id');
            $table->string('jenis'); // top, middle, base
            $table->string('note'); // e.g., Bergamot, Vanilla

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_notes');
    }
};
