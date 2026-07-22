<?php

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DuenoController;

Route::apiResource('usuarios', UsuarioController::class);
Route::apiResource('duenos', DuenoController::class);