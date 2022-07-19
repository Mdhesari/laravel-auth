<?php

namespace Mdhesari\LaravelAuth\Actions;

use Illuminate\Foundation\Auth\User;
use Mdhesari\LaravelAuth\Events\UserCreated;

class CreateUser
{
    public function __construct(
        public GenerateUserReferralCode $generateUserReferralCode
    )
    {
        //
    }

    public function __invoke(array $data): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|User|\Illuminate\Database\Query\Builder
    {
        $user = User::withTrashed()->firstOrCreate([
            'email' => $data['email'],
        ], $this->getData($data)
        );

        if ( $user->trashed() ) {
            $user->update($this->getData($data));
            $user->restore();
        }

        if ( $this->hasReferralCode() ) {
            ($this->generateUserReferralCode)($user);
        }

        event(new UserCreated($user->refresh()));

        return $user;
    }

    private function getData(array $data): array
    {
        return $this->hasReferralCode() ? array_replace($data, [
            'referrer_id' => isset($data['referrer_code']) ?
                optional(User::whereReferralCode($data['referrer_code'])->first())->id : null,
        ]) : $data;
    }

    private function hasReferralCode()
    {
        return config('laravel-auth.has_referral_code');
    }
}
