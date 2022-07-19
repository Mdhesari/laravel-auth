<?php

namespace Mdhesari\LaravelAuth\Actions;

use Illuminate\Foundation\Auth\User;

class GenerateUserReferralCode
{
    public function __invoke(User $user): string
    {
        $user->forceFill([
            'referral_code' => $code = $this->generateReferralCode(),
        ])->save();

        return $code;
    }

    private function generateReferralCode(): string
    {
        $code = 'foodiegram_' . substr($code = uniqid(), strlen($code) - 6, strlen($code));

        return User::whereReferralCode($code)->exists() ? $this->generateReferralCode() : $code;
    }
}
