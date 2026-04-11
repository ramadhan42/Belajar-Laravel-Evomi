<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    //
    // OrderDetail.php
    protected $fillable = ['order_id', 'product_id', 'jumlah', 'harga_saat_beli'];
}
