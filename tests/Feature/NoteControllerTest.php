<?php

use App\Models\Note;

use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

describe('index', function () {
    it('displays the existing notes', function () {
        $note = Note::factory()->create();

        get(route('notes.index'))
            ->assertOk()
            ->assertSee($note->title);
    });

    it('renders notes ordered by the most recent id first', function () {
        $oldest = Note::factory()->create();
        $newest = Note::factory()->create();

        $response = get(route('notes.index'));

        $response->assertSeeInOrder([$newest->title, $oldest->title]);
    });

    it('does not display soft deleted notes', function () {
        $note = Note::factory()->create();
        $note->delete();

        get(route('notes.index'))
            ->assertOk()
            ->assertDontSee($note->title);
    });

    it('renders an empty state when there are no notes', function () {
        get(route('notes.index'))
            ->assertOk()
            ->assertSee('No tenemos notas');
    });
});

describe('create', function () {
    it('renders the note creation form', function () {
        get(route('notes.create'))
            ->assertOk()
            ->assertSee('Nueva nota');
    });
});

describe('store', function () {
    it('creates a new note and redirects to the notes index', function () {
        $data = [
            'title' => 'A brand new note',
            'content' => 'Some interesting content.',
        ];

        post(route('notes.store'), $data)
            ->assertRedirectToRoute('notes.index');

        $this->assertDatabaseHas('notes', $data);
    });

    it('requires a title', function () {
        post(route('notes.store'), [
            'title' => '',
            'content' => 'Some content.',
        ])->assertInvalid(['title' => 'El campo título es obligatorio.']);

        $this->assertDatabaseCount('notes', 0);
    });

    it('requires a title of at least 5 characters', function () {
        post(route('notes.store'), [
            'title' => 'Hi',
            'content' => 'Some content.',
        ])->assertInvalid(['title' => 'El campo título debe contener al menos 5 caracteres.']);

        $this->assertDatabaseCount('notes', 0);
    });

    it('requires a unique title', function () {
        $existing = Note::factory()->create();

        post(route('notes.store'), [
            'title' => $existing->title,
            'content' => 'Some content.',
        ])->assertInvalid(['title' => 'El campo título ya ha sido registrado.']);

        $this->assertDatabaseCount('notes', 1);
    });

    it('requires content', function () {
        post(route('notes.store'), [
            'title' => 'A valid title',
            'content' => '',
        ])->assertInvalid(['content' => 'El campo contenido es obligatorio.']);

        $this->assertDatabaseCount('notes', 0);
    });

    it('rejects an empty payload with errors for every required field', function () {
        post(route('notes.store'), [
            'title' => '',
            'content' => '',
        ])->assertInvalid(['title', 'content']);
    });
});

describe('show', function () {
    it('displays the note title', function () {
        $note = Note::factory()->create(['title' => 'My unique note title']);

        get(route('notes.show', $note))
            ->assertOk()
            ->assertSee('My unique note title');
    });

    it('purifies the note title to prevent stored XSS', function () {
        $note = Note::factory()->create([
            'title' => '<script>alert(\'xss\')</script>Note title',
        ]);

        get(route('notes.show', $note))
            ->assertOk()
            ->assertDontSee('<script>', escape: false)
            ->assertDontSee('alert(', escape: false)
            ->assertSee('Note title');
    });

    it('returns a 404 for a soft deleted note', function () {
        $note = Note::factory()->create();
        $note->delete();

        get(route('notes.show', $note))
            ->assertNotFound();
    });
});

describe('edit', function () {
    it('renders the note edit form with the note data', function () {
        $note = Note::factory()->create();

        get(route('notes.edit', $note))
            ->assertOk()
            ->assertSee($note->title)
            ->assertSee($note->content);
    });

    it('returns a 404 for a soft deleted note', function () {
        $note = Note::factory()->create();
        $note->delete();

        get(route('notes.edit', $note))
            ->assertNotFound();
    });
});

describe('update', function () {
    it('updates the note and redirects to the notes index', function () {
        $note = Note::factory()->create();
        $data = [
            'title' => 'An updated title',
            'content' => 'Updated content.',
        ];

        put(route('notes.update', $note), $data)
            ->assertRedirectToRoute('notes.index');

        $this->assertDatabaseHas('notes', ['id' => $note->id, ...$data]);
    });

    it('allows keeping the note title unchanged', function () {
        $note = Note::factory()->create();

        put(route('notes.update', $note), [
            'title' => $note->title,
            'content' => 'Updated content.',
        ])->assertRedirectToRoute('notes.index');

        $this->assertDatabaseHas('notes', ['id' => $note->id, 'content' => 'Updated content.']);
    });

    it('requires a unique title among other notes', function () {
        $note = Note::factory()->create();
        $otherNote = Note::factory()->create();

        put(route('notes.update', $note), [
            'title' => $otherNote->title,
            'content' => $note->content,
        ])->assertInvalid(['title' => 'El campo título ya ha sido registrado.']);

        $this->assertDatabaseHas('notes', ['id' => $note->id, 'title' => $note->title]);
    });

    it('rejects an empty payload with errors for every required field', function () {
        $note = Note::factory()->create();

        put(route('notes.update', $note), [
            'title' => '',
            'content' => '',
        ])->assertInvalid(['title', 'content']);
    });

    it('returns a 404 when updating a soft deleted note', function () {
        $note = Note::factory()->create();
        $note->delete();

        put(route('notes.update', $note), [
            'title' => 'An updated title',
            'content' => 'Updated content.',
        ])->assertNotFound();
    });
});

describe('destroy', function () {
    it('soft deletes the note and redirects to the notes index', function () {
        $note = Note::factory()->create();

        delete(route('notes.destroy', $note))
            ->assertRedirectToRoute('notes.index');

        $this->assertSoftDeleted($note);
    });

    it('soft deletes the note and returns no content for an ajax request', function () {
        $note = Note::factory()->create();

        delete(route('notes.destroy', $note), [], ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertNoContent();

        $this->assertSoftDeleted($note);
    });

    it('returns a 404 when deleting an already deleted note', function () {
        $note = Note::factory()->create();
        $note->delete();

        delete(route('notes.destroy', $note))
            ->assertNotFound();
    });
});
