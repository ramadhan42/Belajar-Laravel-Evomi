<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductNote;
use App\Models\ProductCharacter;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $product = Product::create([
            'id' => 'PRD-EVOMI-001',
            'brand_id' => 'EVOMI-BR',
            'nama' => 'Evomi Signature Noir',
            'deskripsi' => 'A sophisticated glass-bottled fragrance with a minimalist vibe, designed for modern elegance.',
            'ukuran' => '100ml',
            'konsentrasi' => 'Extrait de Parfum',
            'gender' => 'Unisex',
            'ketahanan' => '12+ Hours',
            'sillage' => 'Strong',
            'proyeksi' => '2 Meters',
            'vibe' => 'Dark, Mysterious, Elegant',
            'image_url' => 'evomi-noir.png',
            'harga_retail' => 450000,
            'stok_tersedia' => 50,
            'status_stok' => 'Available Stock'
        ]);

        // Seed Notes (Olfactory Pyramid)
        $notes = [
            ['jenis' => 'top', 'note' => 'Bergamot'],
            ['jenis' => 'top', 'note' => 'Black Pepper'],
            ['jenis' => 'middle', 'note' => 'Rose Damascena'],
            ['jenis' => 'middle', 'note' => 'Oud'],
            ['jenis' => 'base', 'note' => 'Vanilla'],
            ['jenis' => 'base', 'note' => 'Amber'],
        ];

        foreach ($notes as $note) {
            ProductNote::insert([
                'product_id' => $product->id,
                'jenis' => $note['jenis'],
                'note' => $note['note']
            ]);
        }

        // Seed Characters
        ProductCharacter::insert([
            ['product_id' => $product->id, 'karakter' => 'Sophisticated'],
            ['product_id' => $product->id, 'karakter' => 'Night-time'],
        ]);

        // Generate additional random products
        Product::factory(10)->create();
    }
}
