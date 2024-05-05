<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveNoteRequest;
use App\Models\Note;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Note::latest('id')
            ->get();

        return view('notes.index', [
            'notes' => $notes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveNoteRequest $request)
    {
        Note::create($request->validated());

        return to_route('notes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        return '<b>Detalle de la nota:</b> '.$note->title;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        return view('notes.edit', ['note' => $note]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveNoteRequest $request, Note $note)
    {
        $note->update($request->validated());

        return to_route('notes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        //
    }
}
