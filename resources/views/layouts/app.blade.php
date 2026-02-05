<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'MateCyL')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script async defer src="https://cdn.jsdelivr.net/npm/altcha/dist/altcha.min.js" type="module"></script>
    @stack('styles')
</head>
<body>
    @include('partials.navbar')

    @include('partials.login-modal')

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2026 MateCyL - Todos los derechos reservados</p>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts')
</body>
</html>
