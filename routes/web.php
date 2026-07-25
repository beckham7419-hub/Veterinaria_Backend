<?php

use Illuminate\Support\Facades\Route;
use App\Models\Usuario; 
use App\Http\Controllers\UsuarioController; 

Route::get('/', function () {
    return view('login');
});

Route::get('/panel/recepcion', function () {
    return view('panel.recepcion'); 
});

Route::get('/panel/admin', function () {
    $users = Usuario::all();
    return view('panel.admin', compact('users'));
});

Route::post('/agregarEmpleado',[UsuarioController::class, 'store'])->name('agregarEmpleado');

Route::put('/actualizarEmpleado/{usuario}', [UsuarioController::class, 'update'])->name('actualizarEmpleado');

Route::get('/panel/veterinario', function () {
    return view('panel.veterinario');
});
