<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return 'Página de inicio';
})->name('home');

Route::resource('notas', NoteController::class)->parameters(['notas' => 'note'])->names('notes');
