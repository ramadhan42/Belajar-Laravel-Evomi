<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(base_path('evomi.json'));
        $data = json_decode($json, true);

        $brand = \App\Models\Brand::create(['nama' => $data['brand']]);

        foreach ($data['kategori_produk'] as $item) {
            $product = \App\Models\Product::create([
                'id' => $item['id'],
                'brand_id' => $brand->id,
                'nama' => $item['nama'],
                'deskripsi' => $item['deskripsi'],
                'ukuran' => $item['spesifikasi']['ukuran'],
                'konsentrasi' => $item['spesifikasi']['konsentrasi'],
                'gender' => $item['spesifikasi']['gender'],
                'ketahanan' => $item['spesifikasi']['performa']['ketahanan'],
                'sillage' => $item['spesifikasi']['performa']['sillage'],
                'proyeksi' => $item['spesifikasi']['performa']['proyeksi'],
                'vibe' => $item['profil_aroma']['vibe'],
                'image_url' => $item['media']['image_url'],
                'artboard_ref' => $item['media']['artboard_ref'],
                'harga_retail' => $item['transaksi']['harga_retail'],
                'stok_tersedia' => $item['transaksi']['inventaris']['stok_tersedia'],
                'status_stok' => $item['transaksi']['inventaris']['status'],
            ]);

            // Insert Notes
            foreach ($item['profil_aroma']['piramida_notes'] as $tipe => $notes) {
                $type = str_replace('_notes', '', $tipe); // top_notes -> top
                foreach ($notes as $noteName) {
                    $product->notes()->create(['tipe_note' => $type, 'nama_note' => $noteName]);
                }
            }

            // Insert Characters
            foreach ($item['profil_aroma']['karakter'] as $char) {
                $product->characters()->create(['nama_karakter' => $char]);
            }
        }
    }
}
