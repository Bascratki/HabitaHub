<?php

use App\Domain\Apartments\Controllers\ApartmentsController;
use Illuminate\Support\Facades\Route;

Route::controller(ApartmentsController::class)
    ->prefix('apartments')
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
    });
