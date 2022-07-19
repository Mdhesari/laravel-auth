<?php

namespace Mdhesari\LaravelAuth\Models;

use Mdhesari\LaravelAuth\Traits\AuthUser;

class User extends \Illuminate\Foundation\Auth\User
{
    use AuthUser;

    protected $fillable = [
        'email', 'password', 'name',
    ];
}
