<?php

use App\Domain\Usuarios\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;

Route::controller(UsuariosController::class)
    ->prefix('usuarios')
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::put('/{usuarioId}', 'update');
        Route::delete('/', 'destroy');
    });
