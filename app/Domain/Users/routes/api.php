<?php

use App\Domain\Users\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::controller(UsersController::class)
    ->prefix('users')
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::put('/{userId}', 'update');
        Route::delete('/', 'destroy');
    });
