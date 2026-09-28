<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'phone' => '0123456789',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Khách hàng',
            'email' => 'customer@example.com',
            'phone' => '0987654321',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);
    }
}
