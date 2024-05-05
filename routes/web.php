<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return 'Página de inicio';
})->name('home');

Route::get('/notas', [NoteController::class, 'index'])->name('notes.index');
Route::get('/notas/crear', [NoteController::class, 'create'])->name('notes.create');
Route::post('/notas', [NoteController::class, 'store'])->name('notes.store');
Route::get('/notas/{note}', [NoteController::class, 'show'])->name('notes.show');
Route::get('/notas/{note}/editar', [NoteController::class, 'edit'])->name('notes.edit');
Route::put('/notas/{note}', [NoteController::class, 'update'])->name('notes.update');
