<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/panel/recepcion', function () {
    return view('panel.recepcion');
});

Route::get('/panel/admin', function () {
<<<<<<< HEAD
   $users = Usuario::where('activo', true)->get();
    return view('panel.admin', compact('users'));
})->name('gestionPersonal');

Route::get('/buscarEmpleado', [UsuarioController::class, 'readOne'])->name('buscarEmpleado');
=======
    return view('panel.admin');
});
>>>>>>> Taisha

Route::get('/panel/veterinario', function () {
    return view('panel.veterinario');
});
