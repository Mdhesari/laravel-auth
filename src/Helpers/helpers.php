<?php

/**
 * @return \Illuminate\Contracts\Foundation\Application|mixed
 */
function get_user_model(): mixed
{
    return app(config('laravel-auth.user_model'));
}
