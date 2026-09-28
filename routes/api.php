<?php

use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Support\Facades\Route;

Route::get('/booking-test', function () {
    $trip = Trip::first();
    return response()->json([
        'trip' => $trip ? $trip->bus_name : 'No trip',
        'bookings' => Booking::count(),
    ]);
});
