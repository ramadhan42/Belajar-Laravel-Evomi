<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    // Order.php
    protected $fillable = ['user_id', 'total_harga', 'ongkos_kirim', 'status_pembayaran', 'alamat_pengiriman', 'catatan_pengiriman', 'kurir'];

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
