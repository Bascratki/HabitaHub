<?php

use App\Domain\Apartamentos\Controllers\ApartamentosController;
use Illuminate\Support\Facades\Route;

Route::controller(ApartamentosController::class)
    ->prefix('apartamentos')
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
    });
