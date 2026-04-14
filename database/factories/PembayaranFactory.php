<?php

// database/factories/PembayaranFactory.php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PembayaranFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'user_id' => User::factory(),
            'metode_pembayaran' => 'COD',
            'total_bayar' => $this->faker->randomFloat(2, 50000, 500000),
            'status_pembayaran' => 'pending',
            'tgl_bayar' => now(),
        ];
    }
}
