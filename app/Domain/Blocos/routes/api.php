<?php

use App\Domain\Blocos\Controllers\BlocosController;
use Illuminate\Support\Facades\Route;

Route::controller(BlocosController::class)
    ->prefix('blocos')
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
    });
