<?php

use App\Domain\Empresas\Controllers\EmpresasController;
use Illuminate\Support\Facades\Route;

Route::controller(EmpresasController::class)
    ->prefix('empresas')
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
    });
