<?php

namespace Database\Seeders;

use App\Models\Trip;
use App\Models\Seat;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    public function run(): void
    {
        $trips = [
            [
                'route_id' => 1,
                'bus_name' => 'Tanna Travels Express',
                'license_plate' => '86A-123456',
                'departure_date' => now()->addDay()->toDateString(),
                'departure_time' => '06:00',
                'arrival_time' => '18:00',
                'total_seats' => 40,
                'fare' => 360000,
            ],
            [
                'route_id' => 1,
                'bus_name' => 'Tanna Travels Premium',
                'license_plate' => '86A-123457',
                'departure_date' => now()->addDay()->toDateString(),
                'departure_time' => '14:00',
                'arrival_time' => '02:00',
                'total_seats' => 40,
                'fare' => 420000,
            ],
            [
                'route_id' => 2,
                'bus_name' => 'Tanna Travels Comfort',
                'license_plate' => '86A-123458',
                'departure_date' => now()->addDay()->toDateString(),
                'departure_time' => '08:00',
                'arrival_time' => '16:00',
                'total_seats' => 36,
                'fare' => 280000,
            ],
            [
                'route_id' => 3,
                'bus_name' => 'Tanna Travels Local',
                'license_plate' => '86A-123459',
                'departure_date' => now()->addDay()->toDateString(),
                'departure_time' => '05:00',
                'arrival_time' => '10:00',
                'total_seats' => 40,
                'fare' => 130000,
            ],
        ];

        foreach ($trips as $tripData) {
            $trip = Trip::create($tripData);
            $this->createSeats($trip, $tripData['total_seats']);
        }
    }

    private function createSeats(Trip $trip, int $totalSeats)
    {
        $rows = ceil($totalSeats / 4);
        $seats = [];

        for ($row = 1; $row <= $rows; $row++) {
            foreach (['A', 'B', 'C', 'D'] as $col) {
                if (count($seats) < $totalSeats) {
                    $seats[] = [
                        'trip_id' => $trip->id,
                        'seat_code' => $col . $row,
                        'is_booked' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        Seat::insert($seats);
    }
}
