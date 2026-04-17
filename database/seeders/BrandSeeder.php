<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Data utama berdasarkan file SQL dump (id = 4, nama = Evomi)
        // Kita menggunakan DB::table agar bisa memasukkan ID secara manual (hardcode)
        DB::table('brands')->insert([
            'id' => 4,
            'nama' => 'Evomi'
        ]);

        // 2. Jika kamu butuh data tambahan untuk testing, bisa nyalakan kode di bawah ini:
        // Brand::factory(5)->create();
    }
}
