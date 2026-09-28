<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Seat extends Model
{
    protected $fillable = [
        'trip_id',
        'seat_code',
        'is_booked',
    ];

    protected $casts = [
        'is_booked' => 'boolean',
    ];

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
}
