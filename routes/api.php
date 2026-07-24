<?php

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DuenoController;
use App\Http\Controllers\AuthUsuarioController;
use App\Http\Controllers\AuthDuenoController;
use App\Http\Controllers\PerfilDuenoController;

Route::get('/login-prueba', function () {
    return view('login');
});

Route::apiResource('usuarios', UsuarioController::class)->middleware(['auth:usuarios', 'token.valido:usuarios', 'rol:administrador']);
Route::apiResource('duenos', DuenoController::class)->except(['store'])->middleware(['auth:usuarios', 'token.valido:usuarios', 'rol:recepcionista']);
Route::post('duenos', [DuenoController::class, 'store']);
Route::get('mi-perfil', [PerfilDuenoController::class, 'show'])->middleware(['auth:duenos', 'token.valido:duenos']);
Route::put('mi-perfil', [PerfilDuenoController::class, 'update'])->middleware(['auth:duenos', 'token.valido:duenos']);
Route::put('mi-perfil/contrasena', [PerfilDuenoController::class, 'cambiarContrasena'])->middleware(['auth:duenos', 'token.valido:duenos']);
Route::post('auth/usuarios/login', [AuthUsuarioController::class, 'login']);
Route::post('auth/usuarios/logout', [AuthUsuarioController::class, 'logout'])->middleware('auth:usuarios');
Route::post('auth/duenos/login', [AuthDuenoController::class, 'login']);
Route::post('auth/duenos/logout', [AuthDuenoController::class, 'logout'])->middleware('auth:duenos');