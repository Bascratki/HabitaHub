<?php

use App\Domain\Users\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::controller(UsersController::class)
    ->prefix('users')
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{userId}', 'show');
        Route::put('/{userId}', 'update');
        Route::delete('/{userId}', 'delete');
    });
