<?php

use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\AdminDashboardController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ParfumController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Http\Request; // <--- Tambahkan baris ini
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

// Di Laravel: routes/api.php
Route::get('/midtrans/status/{orderId}', function ($orderId) {
    $serverKey = 'Mid-server-F7eD7UaW10r3-CFaC16OBs4U:'; // Pastikan ada titik dua (:) di akhir untuk Basic Auth
    $base64Key = base64_encode($serverKey);

    $response = Http::withHeaders([
        'Authorization' => 'Basic '.$base64Key,
        'Accept' => 'application/json',
    ])->get("https://api.sandbox.midtrans.com/v2/{$orderId}/status");

    return $response->json();
});

/*
|--------------------------------------------------------------------------
| Public Routes (Akses Tanpa Login)
|--------------------------------------------------------------------------
*/

Route::prefix('parfum')->group(function () {
    Route::get('/', [ParfumController::class, 'index']);
    Route::post('/', [ParfumController::class, 'store']);
    Route::get('/{id}', [ParfumController::class, 'show']);
    Route::post('/{id}', [ParfumController::class, 'update']);
    Route::delete('/{id}', [ParfumController::class, 'destroy']);
});

// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Produk Evomi
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);          // Read All
    Route::post('/', [ProductController::class, 'store']);         // Create
    Route::get('{id}', [ProductController::class, 'show']);        // Read Detail
    Route::post('{id}', [ProductController::class, 'update']);     // Update
    Route::delete('{id}', [ProductController::class, 'destroy']);  // Delete
});

/*
|--------------------------------------------------------------------------
| Protected Routes (Harus Login / Menggunakan Sanctum)
|--------------------------------------------------------------------------
*/

Route::middleware([HandleCors::class])->group(function () {
    Route::post('/admin/login', [AdminAuthController::class, 'login']);    // login admin, ini tetap public karena untuk mendapatkan token
});

// routes/api.php
Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {

    // Mengambil pesan dengan user/admin tertentu (masukkan ID user lawan chat di URL)
    // Route::get('/chats/{contact_id}', [ChatController::class, 'getMessages']);

    // // Mengirim pesan baru
    // Route::post('/chats', [ChatController::class, 'sendMessage']);

    // // Menandai pesan telah dibaca
    // Route::post('/chats/read/{sender_id}', [ChatController::class, 'markAsRead']);

    Route::get('/dashboard-stats', [DashboardController::class, 'index']); // dashboard umum untuk admin dan user, bisa diakses setelah login admin

    // Pesanan (Orders)
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index']);              // Riwayat pesanan user
        Route::get('/{id}', [OrderController::class, 'show']);           // Detail pesanan tertentu
        Route::post('/checkout', [OrderController::class, 'checkout']);  // Proses beli

        // --- Order Routes Baru ---
        // Update pesanan (untuk edit status atau alamat)
        Route::put('/{id}', [OrderController::class, 'update']);

        // Menghapus pesanan
        Route::delete('/{id}', [OrderController::class, 'destroy']);
    });

    Route::post('/logout', [AdminAuthController::class, 'logout']);        // logout admin
    Route::get('/stats', [AdminDashboardController::class, 'getStats']);

    // User Controller
    // Ambil data semua user (Biasanya hanya untuk Admin)
    Route::get('/users', [UserController::class, 'index']);

    // Detail, Update, dan Delete satu user
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // Route tambahan untuk mendapatkan info user yang sedang login saat ini
    Route::get('/me', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => $request->user(),
        ]);
    });
});

// Tambahkan CRUD untuk produk dan brand di sini
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/chats/{contact_id}', [ChatController::class, 'getMessages']);
    Route::post('/chats', [ChatController::class, 'sendMessage']);
    Route::get('/conversations', [ChatController::class, 'getConversations']);

    // User Profile & Logout
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::put('/users/{id}', [UserController::class, 'update']);

    // ✅ Ubah menjadi POST untuk logout agar sesuai dengan praktik RESTful

    // Detail, Update, dan Delete satu user
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Keranjang Belanja (Cart)
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index']);           // Lihat isi keranjang
        Route::post('/add', [CartController::class, 'addToCart']);   // Tambah ke keranjang
        Route::delete('/{id}', [CartController::class, 'destroy']);  // Hapus satu item
        Route::delete('/', [CartController::class, 'clear']);        // Kosongkan keranjang
    });

    // Pesanan (Orders)
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index']);             // Riwayat pesanan user
        Route::get('/{id}', [OrderController::class, 'show']);          // Detail pesanan tertentu
        Route::post('/checkout', [OrderController::class, 'checkout']); // Proses beli

        // --- Order Routes Baru ---
        // Update pesanan (untuk edit status atau alamat)
        Route::put('/{id}', [OrderController::class, 'update']);

        // Menghapus pesanan
        Route::delete('/{id}', [OrderController::class, 'destroy']);
    });

    // Chat Routes
    Route::prefix('chat')->group(function () {
        Route::get('/messages/{contact_id}', [ChatController::class, 'getMessages']);    // Ambil riwayat chat dengan kontak tertentu
        Route::post('/send', [ChatController::class, 'sendMessage']);                   // Kirim pesan baru
        Route::put('/read/{sender_id}', [ChatController::class, 'markAsRead']);         // Tandai pesan telah dibaca
    });
});
