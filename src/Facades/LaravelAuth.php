<?php

namespace LaravelAuth\LaravelAuth\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LaravelAuth\LaravelAuth\LaravelAuth
 */
class LaravelAuth extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-auth';
    }
}
