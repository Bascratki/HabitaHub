<?php

use App\Domain\Visitantes\Controllers\VisitantesController;
use Illuminate\Support\Facades\Route;

Route::controller(VisitantesController::class)
    ->prefix('visitantes')
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
    });
