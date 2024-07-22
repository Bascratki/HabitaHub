<?php

use App\Domain\Condominios\Controllers\CondominiosController;
use Illuminate\Support\Facades\Route;

Route::controller(CondominiosController::class)
    ->prefix('condominios')
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
    });
