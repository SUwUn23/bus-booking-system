<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests as BaseThrottleRequests;

class VerifyCsrfToken
{
    protected $except = [];

    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
