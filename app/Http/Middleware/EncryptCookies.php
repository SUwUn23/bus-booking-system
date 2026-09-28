<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Encryption\Encrypter;

class EncryptCookies
{
    protected $except = [
        //
    ];

    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
