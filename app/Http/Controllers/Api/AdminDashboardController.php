<?php

// app/Http/Controllers/Api/V1/AdminDashboardController.php

// namespace App\Http\Controllers\Api\V1;
namespace App\Http\Controllers\Api; // Pastikan foldernya sesuai

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function getStats()
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'total_revenue' => Order::where('status_pembayaran', 'success')->sum('total_harga'),
                'total_orders'  => Order::count(),
                'pending_orders' => Order::where('status_pembayaran', 'pending')->count(),
                'total_products' => Product::count(),
                'total_users'   => User::count(),
                'recent_orders' => Order::with('user')->latest()->take(5)->get()
            ]
        ]);
    }
}
