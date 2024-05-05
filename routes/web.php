<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return 'Página de inicio';
})->name('home');

Route::get('/notas', function () {
    $notes = DB::table('notes')->get();

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
    $note = DB::table('notes')->find($id);

    abort_if($note === null, 404);

    return '<b>Editar nota:</b> '.$note->title;
})->name('notes.edit');
