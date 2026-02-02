<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TravelPlus</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">✈️ TravelPlus</div>
            <ul class="nav-links">
                <li><a href="{{ route('index') }}">Inicio</a></li>
                <li><a href="{{ route('destinos') }}">Destinos</a></li>
                @auth
                    <li><a href="{{ route('planes') }}">Crear Plan</a></li>
                    <li><a href="{{ route('mis-planes') }}">Mis Planes</a></li>
                    <li><a href="{{ route('perfil') }}">Perfil</a></li>
                    <li><a href="{{ route('perfil') }}">Hola, {{ Auth::user()->nombre_apellidos }}</a></li>
                @else
                    <li><a href="#" onclick="openLoginModal(event)">Crear Plan</a></li>
                    <li><a href="#" onclick="openLoginModal(event)">Mis Planes</a></li>
                    <li><a href="#" onclick="openLoginModal(event)">Perfil</a></li>
                    <li><a href="#" onclick="openLoginModal(event)">Iniciar Sesión</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2026 TravelPlus - Todos los derechos reservados</p>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
