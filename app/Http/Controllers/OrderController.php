<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function checkout(Request $request)
    {
        // 1. Simpan Header Order
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_harga' => $request->total_harga,
            'ongkos_kirim' => $request->ongkos_kirim,
            'alamat_pengiriman' => $request->alamat,
            'catatan_pengiriman' => $request->catatan,
            'kurir' => $request->kurir,
        ]);

        // 2. Simpan Detail dari Item Keranjang
        $cartItems = Cart::where('user_id', auth()->id())->get();
        foreach ($cartItems as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'jumlah' => $item->jumlah,
                'harga_saat_beli' => $item->product->harga_retail,
            ]);
        }

        // 3. Kosongkan Keranjang
        Cart::where('user_id', auth()->id())->delete();

        return response()->json(['message' => 'Pesanan berhasil dibuat', 'order_id' => $order->id]);
    }
}
