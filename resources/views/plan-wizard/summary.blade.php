<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen del Plan - TravelPlus</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">✈️ TravelPlus</div>
            <ul class="nav-links">
                <li><a href="{{ route('index') }}">Inicio</a></li>
                <li><a href="{{ route('destinos') }}">Destinos</a></li>
                <li><a href="{{ route('planes') }}" class="active">Crear Plan</a></li>
                <li><a href="{{ route('mis-planes') }}">Mis Planes</a></li>
                <li><a href="{{ route('perfil') }}">Perfil</a></li>
            </ul>
        </div>
    </nav>

<div class="container">
    <h1>Resumen de tu plan</h1>

    <div style="margin-bottom:12px;">
        <strong>Provincia:</strong> {{ $draft['provincia'] }} — <strong>Municipio:</strong> {{ $draft['municipio'] }}
        <div><strong>Fechas:</strong> {{ $draft['start_date'] }} → {{ $draft['end_date'] }}</div>
    </div>

    <div style="margin-bottom:12px;">
        <h3>Selecciones</h3>
        <ul>
            <li><strong>Hotel:</strong> {{ $draft['hotel']['name'] ?? '— (no seleccionado)' }}</li>
            <li><strong>Restaurante:</strong> {{ $draft['restaurante']['name'] ?? '— (no seleccionado)' }}</li>
            <li><strong>Museo:</strong> {{ $draft['museo']['name'] ?? '— (no seleccionado)' }}</li>
            <li><strong>Fiesta:</strong> {{ $draft['fiesta']['name'] ?? '— (no seleccionado)' }}</li>
        </ul>
    </div>

    <form method="POST" action="{{ route('plan.wizard.finalize') }}">
        @csrf
        <div style="display:flex;gap:8px;">
            <a class="btn-secondary" href="{{ route('plan.wizard.fiestas') }}">Atrás</a>
            <button type="submit" class="btn-primary">Finalizar Plan</button>
        </div>
    </form>
</div>

    <footer>
        <p>&copy; 2026 TravelPlus - Todos los derechos reservados</p>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
