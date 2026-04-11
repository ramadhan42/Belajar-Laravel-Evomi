<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;

class CartController extends Controller
{
    //
    public function addToCart(Request $request)
{
    $cart = Cart::updateOrCreate(
        ['user_id' => auth()->id(), 'product_id' => $request->product_id],
        ['jumlah' => DB::raw("jumlah + $request->jumlah")]
    );
    return response()->json(['message' => 'Produk berhasil ditambah ke keranjang', 'data' => $cart]);
}
}
