<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = ['from_city', 'to_city', 'base_price'];

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
