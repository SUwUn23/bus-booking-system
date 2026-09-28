<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trip extends Model
{
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
        'fare' => 'decimal:2',
    ];

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function availableSeats()
    {
        return $this->seats()->where('is_booked', false)->count();
    }
}
