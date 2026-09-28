<?php

use Illuminate\Support\Facades\Auth;

if (! function_exists('auth')) {
    function auth($guard = null)
    {
        return Auth::guard($guard);
    }
}
