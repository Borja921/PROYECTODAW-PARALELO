<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TravelPlus</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <header>
        <nav>
            <a href="{{ route('index') }}">Inicio</a> |
            <a href="{{ route('destinos') }}">Destinos</a> |
            <a href="{{ route('planes') }}">Planes</a> |
            <a href="{{ route('registro') }}">Registro</a>
        </nav>
    </header>

    <main>
        @if(session('success'))
            <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border: 1px solid #c3e6cb; border-radius: 4px;">
                {{ session('success') }}
            </div>
        @endif
        
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2026 TravelPlus - Todos los derechos reservados</p>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
