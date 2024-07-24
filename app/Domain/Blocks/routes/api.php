<?php

use App\Domain\Blocks\Controllers\BlocksController;
use Illuminate\Support\Facades\Route;

Route::controller(BlocksController::class)
    ->prefix('blocks')
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
    });
