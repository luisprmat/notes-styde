<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'App de Notas' }}</title>
    @vite(['resources/scss/app.scss'])
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="wrap">
        <header class="head">
            <a href="{{ route('home') }}" class="logo"></a>

            <nav class="main-nav">
                <ul class="main-nav-list">
                    <li @class([
                        'main-nav-item',
                        'active' => request()->routeIs('notes.index')
                    ])>
                        <a href="{{ route('notes.index') }}" class="main-nav-link">
                            <i class="icon icon-th-list"></i>
                            <span>Ver notas</span>
                        </a>
                    </li>
                    <li @class([
                        'main-nav-item',
                        'active' => request()->routeIs('notes.create')
                    ])>
                        <a href="{{ route('notes.create') }}" class="main-nav-link">
                            <i class="icon icon-pen"></i>
                            <span>Nueva nota</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </header>

        {{ $slot }}

        <footer class="foot">
            <div class="ad">
                <p>
                    Esta aplicación es desarrollada en el curso
                    <a href="https://styde.net/curso-de-laravel-10">Curso de Laravel 10 desde cero</a>.
                </p>
            </div>
            <div class="license">
                <p>© {{ $currentYear }} Derechos Reservados - Styde Limited</p>
            </div>
        </footer>
    </div>
</body>
</html>
