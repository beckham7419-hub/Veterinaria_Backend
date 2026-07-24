<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('login');
});

Route::get('/panel/recepcion', function () {
    return view('panel.recepcion'); 
});

Route::get('/panel/admin', function () {
    return view('panel.admin');
});

Route::get('/panel/veterinario', function () {
    return view('panel.veterinario');
});
