<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'metode_pembayaran',
        'total_bayar',
        'status_pembayaran',
        'bukti_pembayaran',
        'tgl_bayar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
