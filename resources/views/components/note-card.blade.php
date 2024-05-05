<div class="card card-small">
    <div class="card-body">
        <h4>{{ $note->title }}</h4>

        <div>
            {{ $renderContent }}
        </div>
    </div>

    <footer class="card-footer">
        <a href="{{ route('notes.edit', $note) }}" class="action-link action-edit">
            <i class="icon icon-pen"></i>
        </a>
        <a class="action-link action-delete" data-js-delete-note="{{ $note->id }}">
            <i class="icon icon-trash"></i>
        </a>
    </footer>
</div>

@pushOnce('scripts')
<script>
    const deleteUrlPlaceholder = @js(route('notes.destroy', ':id'));
    const csrfToken = @js(csrf_token())

    document.querySelectorAll('a[data-js-delete-note]').forEach(link => {
        link.addEventListener('click', (event) => {
            deleteNote(event.target.closest('a'))
        })
    })

    const deleteNote = (deleteNoteLink) => {
        if (!confirm('¿Está seguro de eliminar esta nota?')) return

        const noteCard = deleteNoteLink.closest('.card')
        const noteId = deleteNoteLink.dataset.jsDeleteNote
        const deleteNoteUrl = deleteUrlPlaceholder.replace(':id', noteId)

        noteCard.style.display = 'none'

        fetch(deleteNoteUrl, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                _token: csrfToken
            })
        })
        .then(response => {
            if (response.status !== 204) {
                restoreNote(noteCard)
                return
            }

            noteCard.remove()
        })
        .catch(error => {
            restoreNote(noteCard)
        })
    }

    const restoreNote = (noteCard) => {
        alert('Ocurrió un error eliminando la nota.')
        noteCard.style.display = 'flex'
    }
</script>
@endpushOnce
