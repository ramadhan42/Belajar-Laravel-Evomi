<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random()->id,
            'total_harga' => fake()->decimalBill(100000, 1000000),
            'status_pembayaran' => 'pending',
            'alamat_pengiriman' => fake()->address(),
            'kurir' => 'JNE',
        ];
    }
}
