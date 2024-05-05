<x-app-layout>
    <x-slot:title>Editar nota</x-slot>

    <main class="content">
        <div class="cards">
            <div class="card card-center">
                <div class="card-body">
                    <h1>Editar nota</h1>

                    @if ($errors->any())
                        <div class="errors">
                            <p><strong>El formulario contiene errores, por favor corrígelos e intenta nuevamente:</strong></p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('notes.update', $note) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <label for="title" class="field-label">Título: </label>
                        <input type="text" name="title" id="title" value="{{ old('title', $note->title) }}" @class(['field-input', 'field-error' => $errors->has('title')])>
                        @error('title')
                            <p class="error-message">{{ $message }}</p>
                        @enderror

                        <label for="content" class="field-label">Contenido:</label>
                        <textarea name="content" id="content" rows="10" @class(['field-textarea', 'field-error' => $errors->has('content')])>{{ old('content', $note->content) }}</textarea>
                        @error('content')
                            <p class="error-message">{{ $message }}</p>
                        @enderror

                        <button type="submit" class="btn btn-primary">Actualizar nota</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
