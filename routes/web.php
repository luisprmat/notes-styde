<?php

use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return 'Página de inicio';
});

Route::get('/notas', function () {
    return view('notes.index');
});

Route::get('/notas/{id}', function ($id) {
    return 'Detalle de la nota: '.$id;
});

Route::get('/notas/crear', function () {
    return view('notes.create');
});

Route::get('/notas/{id}/editar', function ($id) {
    return 'Editar nota: '.$id;
});
