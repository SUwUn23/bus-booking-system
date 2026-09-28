<?php

namespace Database\Seeders;

use App\Models\Route;
use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    public function run(): void
    {
        $routes = [
            ['from_city' => 'TP. Hồ Chí Minh', 'to_city' => 'Hà Nội', 'base_price' => 350000],
            ['from_city' => 'TP. Hồ Chí Minh', 'to_city' => 'Đà Nẵng', 'base_price' => 250000],
            ['from_city' => 'TP. Hồ Chí Minh', 'to_city' => 'Cần Thơ', 'base_price' => 120000],
            ['from_city' => 'Hà Nội', 'to_city' => 'Hải Phòng', 'base_price' => 100000],
            ['from_city' => 'Hà Nội', 'to_city' => 'Đà Nẵng', 'base_price' => 250000],
            ['from_city' => 'Đà Nẵng', 'to_city' => 'TP. Hồ Chí Minh', 'base_price' => 250000],
        ];

        foreach ($routes as $route) {
            Route::create($route);
        }
    }
}
