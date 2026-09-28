<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = ['trip_id', 'seat_code', 'is_booked'];

    protected $casts = [
        'is_booked' => 'boolean',
    ];
}
