<?php

use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return 'Página de inicio';
})->name('home');

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
})->name('notes.index');

Route::get('/notas/{id}', function ($id) {
    return 'Detalle de la nota: '.$id;
})->name('notes.show');

Route::get('/notas/crear', function () {
    return view('notes.create');
})->name('notes.create');

Route::get('/notas/{id}/editar', function ($id) {
    return 'Editar nota: '.$id;
})->name('notes.edit');
