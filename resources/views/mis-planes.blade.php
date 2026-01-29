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
                <button class="tab-button active" onclick="filtrarPorEstado('todos')">Todos (5)</button>
                <button class="tab-button" onclick="filtrarPorEstado('planificando')">Planificando (2)</button>
                <button class="tab-button" onclick="filtrarPorEstado('confirmado')">Confirmado (2)</button>
                <button class="tab-button" onclick="filtrarPorEstado('completado')">Completado (1)</button>
            </div>

            <div class="my-plans-grid">
                <!-- Plan 1 -->
                <div class="plan-card">
                    <div class="plan-status">Planificando</div>
                    <h3>Fin de Semana en Barcelona</h3>
                    <div class="plan-details">
                        <p>📍 Barcelona, Cataluña</p>
                        <p>📅 15 - 17 Febrero, 2026</p>
                        <p>⏱️ 3 días</p>
                        <p>👥 2 personas</p>
                    </div>
                    <div class="plan-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 60%"></div>
                        </div>
                        <small>60% completado</small>
                    </div>
                    <div class="plan-card-buttons">
                        <a href="{{ route('detalle-plan', ['id' => 1]) }}" class="btn-small">Ver Detalles</a>
                        <button class="btn-secondary-small" onclick="editarPlan(1)">Editar</button>
                    </div>
                </div>

                <!-- Plan 2 -->
                <div class="plan-card">
                    <div class="plan-status confirmed">Confirmado</div>
                    <h3>Escapada Romántica a Sevilla</h3>
                    <div class="plan-details">
                        <p>📍 Sevilla, Andalucía</p>
                        <p>📅 22 - 24 Marzo, 2026</p>
                        <p>⏱️ 3 días</p>
                        <p>👥 2 personas</p>
                    </div>
                    <div class="plan-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 100%"></div>
                        </div>
                        <small>100% completado</small>
                    </div>
                    <div class="plan-card-buttons">
                        <a href="{{ route('detalle-plan', ['id' => 2]) }}" class="btn-small">Ver Detalles</a>
                        <button class="btn-secondary-small" onclick="editarPlan(2)">Editar</button>
                    </div>
                </div>

                <!-- Plan 3 -->
                <div class="plan-card">
                    <div class="plan-status">Planificando</div>
                    <h3>Aventura en Valencia</h3>
                    <div class="plan-details">
                        <p>📍 Valencia, Comunidad Valenciana</p>
                        <p>📅 10 - 13 Abril, 2026</p>
                        <p>⏱️ 4 días</p>
                        <p>👥 1 persona</p>
                    </div>
                    <div class="plan-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 40%"></div>
                        </div>
                        <small>40% completado</small>
                    </div>
                    <div class="plan-card-buttons">
                        <a href="{{ route('detalle-plan', ['id' => 3]) }}" class="btn-small">Ver Detalles</a>
                        <button class="btn-secondary-small" onclick="editarPlan(3)">Editar</button>
                    </div>
                </div>

                <!-- Plan 4 -->
                <div class="plan-card">
                    <div class="plan-status confirmed">Confirmado</div>
                    <h3>Viaje Familiar a Madrid</h3>
                    <div class="plan-details">
                        <p>📍 Madrid, Comunidad de Madrid</p>
                        <p>📅 5 - 9 Mayo, 2026</p>
                        <p>⏱️ 5 días</p>
                        <p>👥 4 personas</p>
                    </div>
                    <div class="plan-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 85%"></div>
                        </div>
                        <small>85% completado</small>
                    </div>
                    <div class="plan-card-buttons">
                        <a href="{{ route('detalle-plan', ['id' => 4]) }}" class="btn-small">Ver Detalles</a>
                        <button class="btn-secondary-small" onclick="editarPlan(4)">Editar</button>
                    </div>
                </div>

                <!-- Plan 5 -->
                <div class="plan-card">
                    <div class="plan-status completed">Completado</div>
                    <h3>Bilbao y el País Vasco</h3>
                    <div class="plan-details">
                        <p>📍 Bilbao, País Vasco</p>
                        <p>📅 8 - 10 Enero, 2026</p>
                        <p>⏱️ 3 días</p>
                        <p>👥 2 personas</p>
                    </div>
                    <div class="plan-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 100%"></div>
                        </div>
                        <small>100% completado</small>
                    </div>
                    <div class="plan-card-buttons">
                        <a href="{{ route('detalle-plan', ['id' => 5]) }}" class="btn-small">Ver Detalles</a>
                        <button class="btn-secondary-small" onclick="editarPlan(5)">Editar</button>
                    </div>
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
