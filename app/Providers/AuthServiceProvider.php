<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Policies\BookingPolicy;
use App\Models\Booking;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Booking::class => BookingPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
