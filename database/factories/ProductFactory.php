<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $stok = fake()->numberBetween(0, 100);
        $status_stok = $stok == 0 ? 'Out of Stock' : ($stok <= 19 ? 'Low Stock' : 'Available Stock');

        return [
            'id' => 'PRD-' . strtoupper(Str::random(8)),
            'brand_id' => 'BRD-001',
            'nama' => fake()->words(2, true),
            'deskripsi' => fake()->paragraph(),
            'ukuran' => fake()->randomElement(['50ml', '100ml']),
            'konsentrasi' => fake()->randomElement(['Eau de Parfum', 'Extrait de Parfum']),
            'gender' => fake()->randomElement(['Unisex', 'Male', 'Female']),
            'ketahanan' => fake()->randomElement(['6-8 Hours', '8-12 Hours', '12+ Hours']),
            'sillage' => fake()->randomElement(['Moderate', 'Strong', 'Enormous']),
            'proyeksi' => fake()->randomElement(['1-2 Meters', 'Room Filler']),
            'vibe' => fake()->randomElement(['Elegant', 'Fresh', 'Mysterious', 'Warm']),
            'image_url' => 'default-product.png',
            'harga_retail' => fake()->randomElement([250000, 350000, 499000, 750000]),
            'mata_uang' => 'IDR',
            'stok_tersedia' => $stok,
            'status_stok' => $status_stok,
        ];
    }
}
