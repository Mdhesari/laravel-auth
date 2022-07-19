<?php

namespace Mdhesari\LaravelAuth\Actions;

use Illuminate\Foundation\Auth\User;

class SetupToken
{
    public function __invoke(User $user, array $data = []): string
    {
        return $user->createToken($data['platform'] ?? $user->email)->plainTextToken;
    }
}
