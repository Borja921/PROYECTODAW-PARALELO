<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Planes - TravelPlus</title>
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
                    <li><a href="{{ route('mis-planes') }}" class="active">Mis Planes</a></li>
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

    <section class="planes-list-section">
        <div class="planes-list-container">
            <div class="planes-header">
                <h1>Mis Viajes Planificados</h1>
                <a href="{{ route('planes') }}" class="btn-primary">+ Nuevo Plan</a>
            </div>

            @if(session('success'))
                <div class="alert alert-success" style="margin: 12px 0; padding: 10px; border-radius: 6px; background: #d4edda; color: #155724;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="filter-tabs">
                <button class="tab-button active" onclick="filtrarPorEstado('todos')">Todos ({{ $totalPlans }})</button>
                <button class="tab-button" onclick="filtrarPorEstado('finalizados')">Finalizados ({{ $finalizados }})</button>
                <button class="tab-button" onclick="filtrarPorEstado('sinFinalizar')">Sin Finalizar ({{ $sinFinalizar }})</button>
            </div>

            <div class="my-plans-grid">
                @if($plans->isEmpty())
                    <p>No tienes planes guardados.</p>
                @else
                    @foreach($plans as $p)
                        <div class="plan-card" data-status="{{ $p->status ?? 'planificando' }}">
                            <h3>{{ $p->name ?? ($p->provincia . ' — ' . $p->municipio) }}</h3>
                            <div class="plan-details">
                                <p>📍 {{ $p->provincia }}, {{ $p->municipio }}</p>
                                <p>📅 {{ $p->start_date->format('Y-m-d') }} → {{ $p->end_date->format('Y-m-d') }}</p>
                                <p>⏱️ {{ $p->days }} día(s)</p>
                            </div>
                            <div class="plan-card-buttons">
                                <a href="{{ route('mis-planes.show', $p->id) }}" class="btn-small">Ver Detalles</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 TravelPlus - Todos los derechos reservados</p>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
