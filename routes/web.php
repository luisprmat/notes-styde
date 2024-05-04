<?php

use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return 'Página de inicio';
});

Route::get('/notas', function () {
    return 'Listado de notas';
});

Route::get('/notas/{id}', function ($id) {
    return 'Detalle de la nota: '.$id;
});

Route::get('/notas/crear', function () {
    return 'Crear nueva nota';
});

Route::get('/notas/{id}/editar', function ($id) {
    return 'Editar nota: '.$id;
});
