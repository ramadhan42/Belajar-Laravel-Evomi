<?php

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'metode_pembayaran' => 'required|string',
        ]);

        $order = Order::findOrFail($request->order_id);

        $pembayaran = Pembayaran::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'metode_pembayaran' => $request->metode_pembayaran,
            'total_bayar' => $order->total_harga + $order->ongkos_kirim,
            'status_pembayaran' => ($request->metode_pembayaran == 'COD') ? 'pending' : 'pending',
            'tgl_bayar' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pembayaran berhasil diproses',
            'data' => $pembayaran
        ], 201);
    }

    public function index()
    {
        $history = Pembayaran::with('order')->where('user_id', Auth::id())->get();
        return response()->json(['status' => 'success', 'data' => $history]);
    }
}
