<?php

use App\Domain\Condominiums\Controllers\CondominiumsController;
use Illuminate\Support\Facades\Route;

Route::controller(CondominiumsController::class)
    ->prefix('condominiums')
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{id}', 'show');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
    });
