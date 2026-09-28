<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Seat;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::with('route')->orderBy('departure_date')->paginate(10);
        return view('admin.trips.index', compact('trips'));
    }

    public function create()
    {
        $routes = Route::all();
        return view('admin.trips.create', compact('routes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'route_id' => 'required|exists:routes,id',
            'bus_name' => 'required|string',
            'license_plate' => 'required|string|unique:trips',
            'departure_date' => 'required|date|after:today',
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i',
            'total_seats' => 'required|integer|min:20|max:60',
            'fare' => 'required|numeric|min:0',
        ]);

        $trip = Trip::create($validated);

        // Create seats
        $this->createSeats($trip, $validated['total_seats']);

        return redirect()->route('admin.trips.index')
            ->with('success', 'Chuyến xe đã được tạo');
    }

    public function edit(Trip $trip)
    {
        $routes = Route::all();
        return view('admin.trips.edit', compact('trip', 'routes'));
    }

    public function update(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'route_id' => 'required|exists:routes,id',
            'bus_name' => 'required|string',
            'license_plate' => 'required|string|unique:trips,license_plate,' . $trip->id,
            'departure_date' => 'required|date',
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i',
            'total_seats' => 'required|integer|min:20|max:60',
            'fare' => 'required|numeric|min:0',
        ]);

        $trip->update($validated);

        return redirect()->route('admin.trips.index')
            ->with('success', 'Chuyến xe đã được cập nhật');
    }

    public function destroy(Trip $trip)
    {
        $trip->seats()->delete();
        $trip->delete();
        return back()->with('success', 'Chuyến xe đã bị xóa');
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
