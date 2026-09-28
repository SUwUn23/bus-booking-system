<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Route extends Model
{
    protected $table = 'routes';

    protected $fillable = [
        'from_city',
        'to_city',
        'base_price',
    ];

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }
}
