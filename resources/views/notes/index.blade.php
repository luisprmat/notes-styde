<x-app-layout>
    <x-slot:title>Listado de notas</x-slot>

    <main class="content">
        <div class="cards">
            @forelse ($notes as $note)
                <div class="card card-small">
                    <div class="card-body">
                        <h4>{{ $note }}</h4>

                        <p>
                            {{ $note }}
                        </p>
                    </div>

                    <footer class="card-footer">
                        <a href="{{ route('notes.edit', ['id' => $loop->iteration]) }}" class="action-link action-edit">
                            <i class="icon icon-pen"></i>
                        </a>
                        <a class="action-link action-delete">
                            <i class="icon icon-trash"></i>
                        </a>
                    </footer>
                </div>
            @empty
                <p>No tenemos notas</p>
            @endforelse
        </div>
    </main>
</x-app-layout>
