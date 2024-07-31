<?php

use App\Domain\Visitors\Controllers\VisitorsController;
use Illuminate\Support\Facades\Route;

Route::controller(VisitorsController::class)
    ->prefix('visitors')
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{id}', 'show');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
    });
