<?php

use App\Domain\Visitors\Controllers\VisitorsController;
use Illuminate\Support\Facades\Route;

Route::controller(VisitorsController::class)
    ->prefix('visitors')
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
    });
