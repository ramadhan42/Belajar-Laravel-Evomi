<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Rama',
            'username' => 'adminrama',
            'email' => 'admin@evomi.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Regular User
        User::create([
            'name' => 'Customer',
            'username' => 'customer01',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        User::factory(5)->create();
    }
}
