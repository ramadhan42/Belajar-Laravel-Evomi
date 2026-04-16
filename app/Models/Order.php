<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_harga',
        'ongkos_kirim',
        'status_pembayaran',
        'alamat_pengiriman',
        'catatan_pengiriman',
        'kurir'
    ];

    // RELASI: Satu Order memiliki banyak Detail

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
