<?php

use App\Domain\Companies\Controllers\CompaniesController;
use Illuminate\Support\Facades\Route;

Route::controller(CompaniesController::class)
    ->prefix('companies')
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });
