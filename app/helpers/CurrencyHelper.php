<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('business_currency')) {
    function business_currency()
    {
        return Auth::check() && Auth::user()->business
            ? Auth::user()->business->currency_symbol
            : 'USD';
    }
}
