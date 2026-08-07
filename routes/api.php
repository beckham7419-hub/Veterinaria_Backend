<?php

<<<<<<< HEAD
use App\Http\Controllers\UsuarioController;
<<<<<<< HEAD
use App\Http\Controllers\DuenoController;
use App\Http\Controllers\AuthUsuarioController;
=======
>>>>>>> 15dc3ebb5282873499bc39e87cda2b8bb120bc99
use App\Http\Controllers\AuthDuenoController;
use App\Http\Controllers\AuthUsuarioController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\DuenoController;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\MisCitasController;
use App\Http\Controllers\MisMascotasController;
use App\Http\Controllers\PerfilDuenoController;
<<<<<<< HEAD
=======
use App\Http\Controllers\ConsultaMedicaController;
use App\Http\Controllers\VacunaController;
>>>>>>> 98a6ac0 (chavos aqui esta gran parte de mi jale, vean en controllers consulta medica y vacuna, de los repo igual, consulta medica y vacuna, de request storeconsultamedica, storevacuna, update consulta medica y update vacuna, de los models consulta medica y vacuna, aqui ojo por que en mascota agregue algo bonito que ocupaba, tambien sus migraciones ya estan, sobres ahi les mando lo demas al raton, arriba el santos)
=======
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\ArchivoConsultaController;
>>>>>>> 15dc3ebb5282873499bc39e87cda2b8bb120bc99

Route::get('/login-prueba', function () {
    return view('login');
});

Route::get('/panel/recepcion', function () {
    return view('panel.recepcion');
});

Route::get('/panel/consultas', function () {
    return view('panel.consultas');
});

Route::get('/panel/admin', function () {
    return view('panel.admin');
});

Route::get('/panel/veterinario', function () {
    return view('panel.veterinario');
});

Route::apiResource('usuarios', UsuarioController::class)->middleware(['auth:usuarios', 'token.valido:usuarios', 'rol:administrador']);
Route::get('veterinarios', [UsuarioController::class, 'veterinarios'])->middleware(['auth:usuarios', 'token.valido:usuarios', 'rol:recepcionista,administrador']);
Route::post('usuarios/buscar-correo', [UsuarioController::class, 'readOne'])->middleware(['auth:usuarios', 'token.valido:usuarios', 'rol:administrador']);
Route::put('/usuarios/{id}/reactivar', [UsuarioController::class, 'reactivar'])->middleware(['auth:usuarios', 'token.valido:usuarios', 'rol:administrador']);
Route::apiResource('duenos', DuenoController::class)->except(['store'])->middleware(['auth:usuarios', 'token.valido:usuarios', 'rol:recepcionista']);
Route::post('duenos', [DuenoController::class, 'store']);
Route::get('mi-perfil', [PerfilDuenoController::class, 'show'])->middleware(['auth:duenos', 'token.valido:duenos']);
Route::put('mi-perfil', [PerfilDuenoController::class, 'update'])->middleware(['auth:duenos', 'token.valido:duenos']);
Route::put('mi-perfil/contrasena', [PerfilDuenoController::class, 'cambiarContrasena'])->middleware(['auth:duenos', 'token.valido:duenos']);
Route::post('auth/usuarios/login', [AuthUsuarioController::class, 'login']);
Route::post('auth/usuarios/logout', [AuthUsuarioController::class, 'logout'])->middleware('auth:usuarios');
Route::post('auth/duenos/login', [AuthDuenoController::class, 'login']);
<<<<<<< HEAD
<<<<<<< HEAD
Route::post('auth/duenos/logout', [AuthDuenoController::class, 'logout'])->middleware('auth:duenos');
=======
=======
>>>>>>> 15dc3ebb5282873499bc39e87cda2b8bb120bc99
Route::post('auth/duenos/logout', [AuthDuenoController::class, 'logout'])->middleware('auth:duenos');
Route::apiResource('mascotas', MascotaController::class)->middleware(['auth:usuarios', 'token.valido:usuarios', 'rol:recepcionista']);
Route::get('mis-mascotas', [MisMascotasController::class, 'index'])->middleware(['auth:duenos', 'token.valido:duenos']);
Route::post('mis-mascotas', [MisMascotasController::class, 'store'])->middleware(['auth:duenos', 'token.valido:duenos']);
Route::get('mis-mascotas/{mascota}', [MisMascotasController::class, 'show'])->middleware(['auth:duenos', 'token.valido:duenos']);
Route::put('mis-mascotas/{mascota}', [MisMascotasController::class, 'update'])->middleware(['auth:duenos', 'token.valido:duenos']);
Route::apiResource('citas', CitaController::class)->except(['destroy'])->middleware(['auth:usuarios', 'token.valido:usuarios', 'rol:recepcionista']);
Route::get('mi-agenda', [CitaController::class, 'miAgenda'])->middleware(['auth:usuarios', 'token.valido:usuarios', 'rol:veterinario']);
Route::put('citas/{cita}/cancelar', [CitaController::class, 'cancelar'])->middleware(['auth:usuarios', 'token.valido:usuarios', 'rol:recepcionista']);
Route::put('citas/{cita}/check-in', [CitaController::class, 'registrarLlegada'])->middleware(['auth:usuarios', 'token.valido:usuarios', 'rol:recepcionista']);
Route::put('citas/{cita}/confirmar', [CitaController::class, 'confirmar'])->middleware(['auth:usuarios', 'token.valido:usuarios', 'rol:recepcionista']);
Route::put('citas/{cita}/iniciar-consulta', [CitaController::class, 'iniciarConsulta'])->middleware(['auth:usuarios', 'token.valido:usuarios', 'rol:recepcionista,veterinario']);
Route::put('citas/{cita}/completar', [CitaController::class, 'completar'])->middleware(['auth:usuarios', 'token.valido:usuarios', 'rol:recepcionista,veterinario']);
<<<<<<< HEAD

Route::post(
    'consultas-medicas',
    [ConsultaMedicaController::class, 'store']
)->middleware([
    'auth:usuarios',
    'token.valido:usuarios',
    'rol:veterinario'
]);

Route::get(
    'consultas-medicas/{consultaMedica}',
    [ConsultaMedicaController::class, 'show']
)->middleware([
    'auth:usuarios',
    'token.valido:usuarios',
    'rol:veterinario'
]);

Route::put(
    'consultas-medicas/{consultaMedica}',
    [ConsultaMedicaController::class, 'update']
)->middleware([
    'auth:usuarios',
    'token.valido:usuarios',
    'rol:veterinario'
]);

Route::post(
    'vacunas',
    [VacunaController::class, 'store']
)->middleware([
    'auth:usuarios',
    'token.valido:usuarios',
    'rol:veterinario'
]);

Route::get(
    'vacunas/{vacuna}',
    [VacunaController::class, 'show']
)->middleware([
    'auth:usuarios',
    'token.valido:usuarios',
    'rol:veterinario'
]);

Route::put(
    'vacunas/{vacuna}',
    [VacunaController::class, 'update']
)->middleware([
    'auth:usuarios',
    'token.valido:usuarios',
    'rol:veterinario'
]);
>>>>>>> 98a6ac0 (chavos aqui esta gran parte de mi jale, vean en controllers consulta medica y vacuna, de los repo igual, consulta medica y vacuna, de request storeconsultamedica, storevacuna, update consulta medica y update vacuna, de los models consulta medica y vacuna, aqui ojo por que en mascota agregue algo bonito que ocupaba, tambien sus migraciones ya estan, sobres ahi les mando lo demas al raton, arriba el santos)
=======
Route::get('mis-citas', [MisCitasController::class, 'index'])->middleware(['auth:duenos', 'token.valido:duenos']);
Route::post('mis-citas', [MisCitasController::class, 'store'])->middleware(['auth:duenos', 'token.valido:duenos']);
Route::put('mis-citas/{cita}/cancelar', [MisCitasController::class, 'cancelar'])->middleware(['auth:duenos', 'token.valido:duenos']);
Route::get('mis-citas/horarios-disponibles', [MisCitasController::class, 'horariosDisponibles'])->middleware(['auth:duenos', 'token.valido:duenos']);
Route::post('citas/{cita}/consulta', [ConsultaController::class, 'store'])->middleware(['auth:usuarios', 'token.valido:usuarios', 'rol:veterinario']);
Route::get('citas/{cita}/consulta', [ConsultaController::class, 'show'])->middleware(['auth:usuarios', 'token.valido:usuarios', 'rol:veterinario']);
Route::put('consultas/{consulta}', [ConsultaController::class, 'update'])->middleware(['auth:usuarios', 'token.valido:usuarios', 'rol:veterinario']);
Route::post('consultas/{consulta}/archivos', [ArchivoConsultaController::class, 'store'])->middleware(['auth:usuarios', 'token.valido:usuarios', 'rol:veterinario']);
Route::get('consultas/{consulta}/archivos', [ArchivoConsultaController::class, 'index'])->middleware(['auth:usuarios', 'token.valido:usuarios', 'rol:veterinario']);
>>>>>>> 15dc3ebb5282873499bc39e87cda2b8bb120bc99
