<x-app-layout>
    <x-slot:title>Listado de notas</x-slot>

    <main class="content">
        <div class="cards">
            @forelse ($notes as $note)
                <x-note-card :note="$note" />
            @empty
                <p>No tenemos notas</p>
            @endforelse
        </div>
    </main>
</x-app-layout>
