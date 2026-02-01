<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Museos - TravelPlus</title>
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

<style>
    .btn-quitar-museo {
        background: #e74c3c !important;
        color: #fff !important;
        border: none;
    }
</style>
<div class="hotels-section">
    <div class="hotels-container">
        <div class="hotels-header">
            <h1>Museos</h1>
            <p class="subtitle">Explora los museos cerca de {{ $draft['municipio'] }}, {{ $draft['provincia'] }}</p>
        </div>

        <div class="hotels-filters">
            <div class="filter-group" style="width:100%;display:flex;flex-direction:column;align-items:center;gap:8px;">
                <a href="/plan/wizard/restaurantes" class="btn-primary" style="width:auto;">Seleccionar restaurantes</a>
                <a class="btn-secondary" href="{{ route('plan.wizard.hoteles') }}" style="width:auto;">Atrás</a>
            </div>
        </div>

        <div id="museos-grid" class="hotels-grid">
            @if($museums->isEmpty())
                <div class="placeholder-container">
                    <p class="placeholder-text">No se han encontrado museos para la localidad seleccionada.</p>
                </div>
            @endif
        </div>

        <div id="no-results" class="no-results-message" style="display: none;">
            <p>No se encontraron museos para la localidad seleccionada.</p>
        </div>

        <div style="margin-top:16px;display:flex;gap:8px;">
            <!-- Botones de navegación eliminados -->
        </div>
    </div>
</div>

<script>
    const todosMuseos = @json($museums);

    function mostrarMuseos(museos) {
        const museosGrid = document.getElementById('museos-grid');
        const noResults = document.getElementById('no-results');
        if (museos.length === 0) {
            museosGrid.innerHTML = '<div class="placeholder-container"><p class="placeholder-text">No hay museos disponibles</p></div>';
            noResults.style.display = 'none';
            return;
        }
        noResults.style.display = 'none';
        let html = '';
        museos.forEach(museo => {
            const phoneLink = museo.phone ? `<p><strong>📞 Teléfono:</strong> <a href="tel:${museo.phone}">${museo.phone}</a></p>` : '';
            const emailLink = museo.email ? `<p><strong>📧 Email:</strong> <a href="mailto:${museo.email}">${museo.email}</a></p>` : '';
            const website = museo.website ? `<p><strong>🌐 Sitio Web:</strong> <a href="${museo.website}" target="_blank">Visitar web</a></p>` : '';

            html += `
                <div class="hotel-card">
                    <div class="hotel-header">
                        <div class="hotel-title">
                            <h3>${museo.name}</h3>
                            <p class="hotel-location">📍 ${museo.locality ?? ''}, ${museo.province ?? ''}</p>
                        </div>
                    </div>
                    <div class="hotel-body">
                        ${museo.address ? `<p class="hotel-address"><strong>Dirección:</strong> ${museo.address}</p>` : ''}
                        
                        <div class="hotel-contact">
                            ${phoneLink}
                            ${emailLink}
                            ${website}
                        </div>

                        ${museo.description ? `<p class="hotel-description">${museo.description}</p>` : ''}
                    </div>
                    <div class="hotel-footer">
                        <button class="btn-small btn-guardar-museo" data-museo-id="${museo.id}">Guardar</button>
                    </div>
                </div>
            `;
        });
        museosGrid.innerHTML = html;
        document.querySelectorAll('.hotel-card').forEach((card, idx) => {
            card.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-guardar-museo')) return;
                document.querySelectorAll('.hotel-card.selected').forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                const museoId = todosMuseos[idx].id;
                document.getElementById('selected_museo_id').value = museoId;
            });
        });
        document.querySelectorAll('.btn-guardar-museo').forEach((btn, idx) => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const museo = todosMuseos[idx];
                
                if (btn.textContent === 'Guardar') {
                    btn.textContent = 'Quitar';
                    btn.classList.add('btn-quitar-museo');
                    // Guardar en sessionStorage
                    let savedMuseos = JSON.parse(sessionStorage.getItem('savedMuseos') || '[]');
                    savedMuseos.push(museo);
                    sessionStorage.setItem('savedMuseos', JSON.stringify(savedMuseos));
                } else {
                    btn.textContent = 'Guardar';
                    btn.classList.remove('btn-quitar-museo');
                    // Quitar de sessionStorage
                    let savedMuseos = JSON.parse(sessionStorage.getItem('savedMuseos') || '[]');
                    savedMuseos = savedMuseos.filter(m => m.id !== museo.id);
                    sessionStorage.setItem('savedMuseos', JSON.stringify(savedMuseos));
                }
            });
        });
    }
    document.addEventListener('DOMContentLoaded', function() {
        mostrarMuseos(todosMuseos);
        @if(isset($draft['museo']) && $draft['museo']['id'])
            setTimeout(() => {
                const id = '{{ $draft['museo']['id'] }}';
                document.querySelectorAll('.hotel-card').forEach(card => {
                    if (card.innerHTML.includes(id)) {
                        card.classList.add('selected');
                        document.getElementById('selected_museo_id').value = id;
                    }
                });
            }, 50);
        @endif

        // Marcar museos previamente guardados
        setTimeout(() => {
            const savedMuseos = JSON.parse(sessionStorage.getItem('savedMuseos') || '[]');
            document.querySelectorAll('.btn-guardar-museo').forEach(btn => {
                const museoId = btn.getAttribute('data-museo-id');
                const isGuardado = savedMuseos.some(m => m.id == museoId);
                if (isGuardado) {
                    btn.textContent = 'Quitar';
                    btn.classList.add('btn-quitar-museo');
                }
            });
        }, 100);
    });
</script>

    <footer>
        <p>&copy; 2026 TravelPlus - Todos los derechos reservados</p>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
