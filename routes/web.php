<?php

use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return 'Página de inicio';
});

Route::get('/notas', function () {
    $notes = [
        'Primera nota',
        'Segunda nota',
        'Tercera nota',
        'Cuarta nota',
        'Quinta nota',
        '<script>alert("Código malicioso")</script>',
    ];

    return view('notes.index', [
        'notes' => $notes,
    ]);
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
