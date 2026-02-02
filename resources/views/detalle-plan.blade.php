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
            @if(session('success'))
                <div class="alert-success-visual" id="successAlert">
                    <div class="success-content">
                        <div class="success-icon">✓</div>
                        <div class="success-text">
                            <h3>¡Plan Finalizado!</h3>
                            <p>Tu viaje ha sido completado exitosamente</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="plan-detail-header">
                <div>
                    <h1>{{ $plan->provincia }} — {{ $plan->municipio }}</h1>
                    <p class="plan-location">📍 {{ $plan->provincia }}, {{ $plan->municipio }}</p>
                </div>
                <div class="plan-actions">
                    <a class="btn-secondary" href="{{ route('mis-planes') }}">← Volver</a>
                    @if($plan->status !== 'completado')
                        <button type="button" class="btn-primary" onclick="showConfirmModal()">✓ Finalizar Plan</button>
                        <form id="finalizePlanForm" method="POST" action="{{ route('mis-planes.finalize', $plan->id) }}" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <span class="badge-completado">✓ Plan Finalizado</span>
                    @endif
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
                    <p><strong>Usuario:</strong> {{ auth()->check() ? auth()->user()->nombre_apellidos : 'Anónimo' }}</p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 TravelPlus - Todos los derechos reservados</p>
    </footer>

    <!-- Modal de confirmación -->
    <div id="confirmModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2>¿Finalizar Plan?</h2>
                <button type="button" class="modal-close" onclick="closeConfirmModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que quieres marcar este plan como finalizado?</p>
                <p style="color: #666; font-size: 0.9rem; margin-top: 1rem;">Una vez finalizado, el plan se mostrará como completado en tu lista de viajes.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-primary" onclick="closeConfirmModal()">Cancelar</button>
                <button type="button" class="btn-primary" onclick="confirmFinalize()">Finalizar Plan</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        function showConfirmModal() {
            document.getElementById('confirmModal').classList.add('active');
        }

        function closeConfirmModal() {
            document.getElementById('confirmModal').classList.remove('active');
        }

        function confirmFinalize() {
            closeConfirmModal();
            // Mostrar animación de carga
            const alert = document.getElementById('successAlert');
            if (alert) {
                alert.style.display = 'none';
            }
            // Enviar formulario
            document.getElementById('finalizePlanForm').submit();
        }

        // Mostrar alerta con animación si existe
        window.addEventListener('load', function() {
            const alert = document.getElementById('successAlert');
            if (alert) {
                setTimeout(function() {
                    alert.classList.add('show');
                }, 100);
            }
        });
    </script>
</body>
</html>
