<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Grouping route untuk versi API (opsional, tapi disarankan)
Route::prefix('v1')->group(function () {

    // Route Resource untuk Products
    // Ini otomatis mencakup: GET, POST, GET {id}, PUT, dan DELETE
    Route::apiResource('products', ProductController::class);

    // Jika Anda ingin menambah route khusus di luar CRUD standar
    // Contoh: Mencari produk berdasarkan brand
    Route::get('products/brand/{brand_id}', [ProductController::class, 'getByBrand']);
    
});

// Route cadangan untuk mengecek koneksi API
Route::get('/health-check', function () {
    return response()->json([
        'status' => 'online',
        'message' => 'Evomi API is running smoothly',
        'timestamp' => now()
    ]);
});