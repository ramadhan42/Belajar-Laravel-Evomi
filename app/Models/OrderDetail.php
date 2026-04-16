<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = ['order_id', 'product_id', 'jumlah', 'harga_saat_beli'];

    // RELASI: Satu baris detail merujuk ke satu Produk

    public function product() {
    return $this->belongsTo(Product::class, 'product_id');
}
}
