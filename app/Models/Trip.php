<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_id',
        'bus_name',
        'license_plate',
        'departure_date',
        'departure_time',
        'arrival_time',
        'total_seats',
        'fare',
    ];

    protected $casts = [
        'departure_date' => 'date',
    ];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function availableSeats()
    {
        return $this->seats()->where('is_booked', false)->count();
    }
}
