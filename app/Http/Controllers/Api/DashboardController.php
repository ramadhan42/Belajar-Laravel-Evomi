<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Lebih aman untuk testing
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            // Pastikan nama tabel 'products' dan 'orders' sudah ada di database
            $stats = [
                'total_products' => DB::table('products')->count(),
                'total_orders'   => DB::table('orders')->count(),
                'total_revenue'  => DB::table('orders')->sum('total_harga') ?? 0,
                'recent_orders'  => DB::table('orders')->latest()->take(5)->get(),
            ];

            return response()->json($stats, 200);
        } catch (\Exception $e) {
            // Ini akan mengirimkan pesan error asli ke Next.js
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}