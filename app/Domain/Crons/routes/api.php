<?php

use App\Domain\Crons\Controllers\CronsController;
use Illuminate\Support\Facades\Route;

Route::controller(CronsController::class)
    ->prefix('crons')
    ->group(function () {
        //
});