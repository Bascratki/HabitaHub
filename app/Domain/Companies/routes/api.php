<?php

use App\Domain\Companies\Controllers\CompaniesController;
use Illuminate\Support\Facades\Route;

Route::controller(CompaniesController::class)
    ->prefix('companies')
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{id}', 'show');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
    });
