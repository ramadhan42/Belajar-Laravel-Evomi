<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Tambahkan baris ini untuk memberitahu Laravel bahwa tabel ini tidak punya created_at/updated_at
    public $timestamps = false;
    //
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'brand_id',
        'nama',
        'deskripsi',
        'ukuran',
        'konsentrasi',
        'gender',
        'ketahanan',
        'sillage',
        'proyeksi',
        'vibe',
        'image_url',
        'artboard_ref',
        'harga_retail',
        'mata_uang',
        'stok_tersedia',
        'status_stok'
    ];

    // app/Models/Product.php

    protected function imageUrl(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: function ($value) {
                // Jika image_url diawali http (link luar), kembalikan langsung
                if (str_starts_with($value, 'http')) {
                    return $value;
                }
                // Jika hanya nama file, arahkan ke folder storage lokal
                return asset('storage/products/' . $value);
            },
        );
    }

    public function notes()
    {
        return $this->hasMany(ProductNote::class);
    }
    public function characters()
    {
        return $this->hasMany(ProductCharacter::class);
    }
}
