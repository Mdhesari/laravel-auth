<?php

namespace Mdhesari\LaravelAuth\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mdhesari\LaravelAuth\LaravelAuth
 */
class LaravelAuth extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-auth';
    }
}
