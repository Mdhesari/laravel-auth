<?php

use Illuminate\Support\Facades\Route;
use Mdhesari\LaravelAuth\Http\Controllers\TokenController;

Route::prefix('api')->group(function () {
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post(null, [TokenController::class, 'store'])->name('login');
    });
});
