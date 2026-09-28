<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    protected $fillable = [
        'trip_id',
        'user_id',
        'seat_code',
        'customer_name',
        'phone',
        'email',
        'amount',
        'status',
        'booking_code',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->booking_code = 'BK' . date('YmdHis') . rand(1000, 9999);
        });
    }
}
