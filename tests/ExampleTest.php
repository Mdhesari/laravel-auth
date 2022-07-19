<?php

use Illuminate\Support\Facades\Hash;

it('can login a user', function () {
    get_user_model()->create([
        'email' => 'user@example.com',
        'password' => Hash::make('secret'),
    ]);

    $response = $this->post(route('auth.login'), [
        'email' => 'user@example.com',
        'password' => 'secret',
    ]);

    $response->dump()->assertSuccessful();
});
