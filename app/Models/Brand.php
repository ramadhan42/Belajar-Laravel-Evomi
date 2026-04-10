<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    // Tambahkan baris ini untuk memberitahu Laravel bahwa tabel ini tidak punya created_at/updated_at
    public $timestamps = false;

    protected $fillable = ['nama'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}