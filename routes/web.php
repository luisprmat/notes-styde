<?php

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return 'Página de inicio';
})->name('home');

Route::get('/notas', function () {
    $notes = Note::latest('id')
        ->get();

    return view('notes.index', [
        'notes' => $notes,
    ]);
})->name('notes.index');

Route::get('/notas/{id}', function ($id) {
    $note = DB::table('notes')->find($id);

    abort_if($note === null, 404);

    return '<b>Detalle de la nota:</b> '.$note->title;
})->name('notes.show');

Route::get('/notas/crear', function () {
    return view('notes.create');
})->name('notes.create');

Route::post('/notas', function (Request $request) {
    Note::create([
        'title' => $request->input('title'),
        'content' => $request->input('content'),
    ]);

    return to_route('notes.index');
})->name('notes.store');

Route::get('/notas/{id}/editar', function ($id) {
    $note = DB::table('notes')->find($id);

    abort_if($note === null, 404);

    return '<b>Editar nota:</b> '.$note->title;
})->name('notes.edit');
