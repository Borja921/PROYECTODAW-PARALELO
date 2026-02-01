<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Planes - TravelPlus</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        .plan-elements-detailed {
            margin-top: 12px;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 6px;
            border-left: 4px solid #007bff;
        }
        
        .element-section {
            margin-bottom: 12px;
        }
        
        .element-section:last-child {
            margin-bottom: 0;
        }
        
        .element-section h5 {
            margin: 0 0 6px 0;
            font-size: 0.9em;
            font-weight: 600;
            color: #495057;
        }
        
        .element-list {
            margin: 0;
            padding-left: 16px;
            list-style-type: disc;
        }
        
        .element-list li {
            margin-bottom: 3px;
            font-size: 0.85em;
            color: #6c757d;
            line-height: 1.3;
        }
        
        .date-info {
            color: #28a745;
            font-weight: 500;
            font-size: 0.8em;
        }
        
        .plan-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: box-shadow 0.3s ease;
        }
        
        .plan-card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .plan-status {
            display: inline-block;
            background: #28a745;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75em;
            font-weight: 500;
            margin-bottom: 8px;
        }
        
        .plan-card h3 {
            margin: 0 0 8px 0;
            color: #2c3e50;
            font-size: 1.2em;
        }
        
        .plan-details p {
            margin: 4px 0;
            color: #6c757d;
            font-size: 0.9em;
        }
        
        .no-plans-message {
            text-align: center;
            padding: 40px 20px;
            background: #f8f9fa;
            border-radius: 12px;
            border: 2px dashed #dee2e6;
        }
        
        .no-plans-icon {
            font-size: 3em;
            margin-bottom: 16px;
        }
        
        .no-plans-message h3 {
            color: #495057;
            margin-bottom: 8px;
        }
        
        .no-plans-message p {
            color: #6c757d;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">✈️ TravelPlus</div>
            <ul class="nav-links">
                <li><a href="{{ route('index') }}">Inicio</a></li>
                <li><a href="{{ route('destinos') }}">Destinos</a></li>
                <li><a href="{{ route('planes') }}">Crear Plan</a></li>
                <li><a href="{{ route('mis-planes') }}" class="active">Mis Planes</a></li>
                <li><a href="{{ route('perfil') }}">Perfil</a></li>
            </ul>
        </div>
    </nav>

    <section class="planes-list-section">
        <div class="planes-list-container">
            <div class="planes-header">
                <h1>Mis Viajes Planificados</h1>
                <a href="{{ route('planes') }}" class="btn-primary">+ Nuevo Plan</a>
            </div>

            <div class="filter-tabs">
                <button class="tab-button active" onclick="filtrarPorEstado('todos')">Todos ({{ $plans->count() }})</button>
                <button class="tab-button" onclick="filtrarPorEstado('confirmado')">Confirmado ({{ $plans->count() }})</button>
                <button class="tab-button" onclick="filtrarPorEstado('completado')">Completado (0)</button>
            </div>

            <div class="my-plans-grid">
                @if($plans->isEmpty())
                    <div class="no-plans-message">
                        <div class="no-plans-icon">✈️</div>
                        <h3>¡Aún no tienes planes de viaje!</h3>
                        <p>Crea tu primer plan y comienza a planificar tu próxima aventura.</p>
                        <a href="{{ route('planes') }}" class="btn-primary">Crear Mi Primer Plan</a>
                    </div>
                @else
                    @foreach($plans as $p)
                        <div class="plan-card">
                            <div class="plan-status">Guardado</div>
                            <h3>{{ $p->nombre_plan ?? ($p->provincia . ' — ' . $p->municipio) }}</h3>
                            <div class="plan-details">
                                <p>📍 {{ $p->provincia }}, {{ $p->municipio }}</p>
                                <p>📅 {{ $p->start_date->format('d/m/Y') }} → {{ $p->end_date->format('d/m/Y') }}</p>
                                <p>⏱️ {{ $p->days }} día(s)</p>
                                
                                @if($p->listado_hoteles || $p->listado_museos || $p->listado_restaurantes || $p->listado_fiestas)
                                    <div class="plan-elements-detailed">
                                        @if($p->listado_hoteles && count($p->listado_hoteles) > 0)
                                            <div class="element-section">
                                                <h5>🏨 Hoteles:</h5>
                                                <ul class="element-list">
                                                    @foreach($p->listado_hoteles as $hotel)
                                                        <li>{{ $hotel['name'] ?? 'Hotel sin nombre' }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        
                                        @if($p->listado_museos && count($p->listado_museos) > 0)
                                            <div class="element-section">
                                                <h5>🎨 Museos:</h5>
                                                <ul class="element-list">
                                                    @foreach($p->listado_museos as $museo)
                                                        <li>{{ $museo['name'] ?? 'Museo sin nombre' }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        
                                        @if($p->listado_restaurantes && count($p->listado_restaurantes) > 0)
                                            <div class="element-section">
                                                <h5>🍽️ Restaurantes:</h5>
                                                <ul class="element-list">
                                                    @foreach($p->listado_restaurantes as $restaurante)
                                                        <li>{{ $restaurante['name'] ?? 'Restaurante sin nombre' }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        
                                        @if($p->listado_fiestas && count($p->listado_fiestas) > 0)
                                            <div class="element-section">
                                                <h5>🎪 Fiestas:</h5>
                                                <ul class="element-list">
                                                    @foreach($p->listado_fiestas as $fiesta)
                                                        <li>{{ $fiesta['name'] ?? 'Fiesta sin nombre' }}
                                                            @if(isset($fiesta['start_date']))
                                                                <span class="date-info">({{ $fiesta['start_date'] }})</span>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                @endif
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
