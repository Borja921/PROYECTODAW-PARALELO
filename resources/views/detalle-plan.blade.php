<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Plan - TravelPlus</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">✈️ TravelPlus</div>
            <ul class="nav-links">
                <li><a href="{{ route('index') }}">Inicio</a></li>
                <li><a href="{{ route('destinos') }}">Destinos</a></li>
                <li><a href="{{ route('planes') }}">Crear Plan</a></li>
                <li><a href="{{ route('mis-planes') }}">Mis Planes</a></li>
                <li><a href="{{ route('perfil') }}">Perfil</a></li>
            </ul>
        </div>
    </nav>

    <section class="plan-detail-section">
        <div class="plan-detail-container">
            <div class="plan-detail-header">
                <div>
                    <h1>{{ $plan->provincia }} — {{ $plan->municipio }}</h1>
                    <p class="plan-location">📍 {{ $plan->provincia }}, {{ $plan->municipio }}</p>
                </div>
                <div class="plan-actions">
                    <a class="btn-secondary" href="{{ route('mis-planes') }}">← Volver</a>
                </div>
            </div>

            <div class="plan-overview">
                <div class="overview-item">
                    <span class="overview-icon">📅</span>
                    <div>
                        <h4>Fechas</h4>
                        <p>{{ $plan->start_date->format('Y-m-d') }} → {{ $plan->end_date->format('Y-m-d') }}</p>
                    </div>
                </div>
                <div class="overview-item">
                    <span class="overview-icon">⏱️</span>
                    <div>
                        <h4>Duración</h4>
                        <p>{{ $plan->days }} día(s)</p>
                    </div>
                </div>
                <div class="overview-item">
                    <span class="overview-icon">📝</span>
                    <div>
                        <h4>Creado</h4>
                        <p>{{ $plan->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="plan-details-content">
                <div class="detail-column">
                    <h2>Selecciones</h2>
                    <ul>
                        <li><strong>Hotel:</strong> {{ $plan->items['hotel']['name'] ?? '— (no seleccionado)' }}</li>
                        <li><strong>Restaurante:</strong> {{ $plan->items['restaurante']['name'] ?? '— (no seleccionado)' }}</li>
                        <li><strong>Museo:</strong> {{ $plan->items['museo']['name'] ?? '— (no seleccionado)' }}</li>
                        <li><strong>Fiesta:</strong> {{ $plan->items['fiesta']['name'] ?? '— (no seleccionado)' }}</li>
                    </ul>
                </div>

                <div class="detail-column">
                    <h2>Metadatos</h2>
                    <p><strong>ID:</strong> {{ $plan->id }}</p>
                    <p><strong>Usuario:</strong> {{ $plan->user_id ? 'Usuario #' . $plan->user_id : 'Anónimo' }}</p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 TravelPlus - Todos los derechos reservados</p>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
