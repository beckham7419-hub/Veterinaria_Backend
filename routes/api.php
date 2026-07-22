<?php

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DuenoController;
use App\Http\Controllers\AuthUsuarioController;

Route::apiResource('usuarios', UsuarioController::class);
Route::apiResource('duenos', DuenoController::class);
Route::post('auth/usuarios/login', [AuthUsuarioController::class, 'login']);
Route::post('auth/usuarios/logout', [AuthUsuarioController::class, 'logout'])->middleware('auth:usuarios');