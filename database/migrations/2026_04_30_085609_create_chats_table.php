<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            // Pengirim pesan
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            // Penerima pesan (Admin/User)
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
            // Isi pesan
            $table->text('message');
            // Status dibaca atau belum
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};