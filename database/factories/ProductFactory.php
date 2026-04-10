<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => 'EVO-' . $this->faker->unique()->numberBetween(100, 999),
            'nama' => $this->faker->word(),
            'deskripsi' => $this->faker->sentence(),
            'harga_retail' => 25000,
            'stok_tersedia' => $this->faker->numberBetween(1, 50),
            'status_stok' => 'In Stock'
        ];
    }
}
