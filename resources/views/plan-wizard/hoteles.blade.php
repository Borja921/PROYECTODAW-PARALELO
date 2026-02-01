<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alojamientos Hoteleros - TravelPlus</title>
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
    .btn-quitar-hotel {
        background: #e74c3c !important;
        color: #fff !important;
        border: none;
    }
</style>
<div class="hotels-section">
    <div class="hotels-container">
        <div class="hotels-header">
            <h1>Alojamientos Hoteleros</h1>
            <p class="subtitle">Explora los hoteles cerca de {{ $draft['municipio'] }}, {{ $draft['provincia'] }}</p>
        </div>

        <div class="hotels-filters">
            <div class="filter-group" style="width:100%;display:flex;flex-direction:column;align-items:center;gap:8px;">
                <a href="/plan/wizard/museos" class="btn-primary" style="width:auto;">Seleccionar museos</a>
                <a class="btn-secondary" href="{{ route('planes') }}" style="width:auto;">Atrás</a>
            </div>
        </div>

        <div id="hotels-grid" class="hotels-grid">
            @if($hotels->isEmpty())
                <div class="placeholder-container">
                    <p class="placeholder-text">No se han encontrado alojamientos para la localidad seleccionada.</p>
                </div>
            @else
                {{-- El JS rellenará las tarjetas dinámicamente usando todosHoteles --}}
            @endif
        </div>

        <div id="no-results" class="no-results-message" style="display: none;">
            <p>No se encontraron alojamientos para la localidad seleccionada.</p>
        </div>

        <div style="margin-top:16px;display:flex;gap:8px;">
            <!-- Botones de navegación eliminados -->
        </div>
    </div>
</div>

<script>
    const todosHoteles = @json($hotels);

    function filtrarPorProvincia() {
        const provinceSelect = document.getElementById('province-select');
        const localitySelect = document.getElementById('locality-select');
        const provinciaSeleccionada = provinceSelect.value;

        // Limpiar selector de localidades
        localitySelect.innerHTML = '<option value="">-- Todas las localidades --</option>';
        localitySelect.disabled = !provinciaSeleccionada;

        if (!provinciaSeleccionada) {
            // Mostrar todos los hoteles si no hay provincia seleccionada
            mostrarTodos();
            return;
        }

        // Obtener localidades de la provincia seleccionada
        const localidadesUnicas = {};
        todosHoteles.forEach(hotel => {
            if (hotel.province === provinciaSeleccionada && hotel.locality) {
                if (!localidadesUnicas[hotel.locality]) {
                    localidadesUnicas[hotel.locality] = 0;
                }
                localidadesUnicas[hotel.locality]++;
            }
        });

        // Agregar localidades al selector
        const localidadesOrdenadas = Object.keys(localidadesUnicas).sort();
        localidadesOrdenadas.forEach(localidad => {
            const option = document.createElement('option');
            option.value = localidad;
            option.textContent = `${localidad} (${localidadesUnicas[localidad]} hoteles)`;
            localitySelect.appendChild(option);
        });

        // Mostrar hoteles de la provincia (todas las localidades)
        const hotelesProvincia = todosHoteles.filter(hotel => hotel.province === provinciaSeleccionada);
        mostrarHoteles(hotelesProvincia);
    }

    function filtrarHotelesPorLocalidad() {
        const provinceSelect = document.getElementById('province-select');
        const localitySelect = document.getElementById('locality-select');
        const provinciaSeleccionada = provinceSelect.value;
        const localidadSeleccionada = localitySelect.value;

        if (!provinciaSeleccionada) {
            // Si no hay provincia seleccionada, no hacer nada
            return;
        }

        if (!localidadSeleccionada) {
            // Mostrar todos los hoteles de la provincia
            const hotelesProvincia = todosHoteles.filter(hotel => hotel.province === provinciaSeleccionada);
            mostrarHoteles(hotelesProvincia);
            return;
        }

        // Filtrar por provincia Y localidad
        const hotelesFiltrados = todosHoteles.filter(hotel =>
            hotel.province === provinciaSeleccionada &&
            hotel.locality === localidadSeleccionada
        );

        if (hotelesFiltrados.length === 0) {
            const noResults = document.getElementById('no-results');
            document.getElementById('hotels-grid').innerHTML = '';
            noResults.style.display = 'block';
            return;
        }

        document.getElementById('no-results').style.display = 'none';
        mostrarHoteles(hotelesFiltrados);
    }

    function mostrarTodos() {
        const hotelsGrid = document.getElementById('hotels-grid');
        const noResults = document.getElementById('no-results');

        if (todosHoteles.length === 0) {
            hotelsGrid.innerHTML = '<div class="placeholder-container"><p class="placeholder-text">No hay hoteles disponibles</p></div>';
            noResults.style.display = 'none';
            return;
        }

        noResults.style.display = 'none';
        mostrarHoteles(todosHoteles);
    }

    function mostrarHoteles(hoteles) {
        const hotelsGrid = document.getElementById('hotels-grid');
        const noResults = document.getElementById('no-results');

        if (hoteles.length === 0) {
            hotelsGrid.innerHTML = '<div class="placeholder-container"><p class="placeholder-text">No hay hoteles disponibles para los filtros seleccionados</p></div>';
            noResults.style.display = 'none';
            return;
        }

        noResults.style.display = 'none';
        let html = '';

        hoteles.forEach(hotel => {
            const phoneLink = hotel.phone ? `<p><strong>📞 Teléfono:</strong> <a href="tel:${hotel.phone}">${hotel.phone}</a></p>` : '';
            const emailLink = hotel.email ? `<p><strong>📧 Email:</strong> <a href="mailto:${hotel.email}">${hotel.email}</a></p>` : '';
            const website = hotel.website ? `<p><strong>🌐 Sitio Web:</strong> <a href="${hotel.website}" target="_blank">Visitar web</a></p>` : '';

            html += `
                <div class="hotel-card">
                    <div class="hotel-header">
                        <div class="hotel-title">
                            <h3>${hotel.name}</h3>
                            <p class="hotel-location">📍 ${hotel.locality}, ${hotel.province}</p>
                        </div>
                    </div>

                    <div class="hotel-body">
                        ${hotel.classification ? `<p class="hotel-classification"><strong>Clasificación:</strong> ${hotel.classification}</p>` : ''}
                        ${hotel.address ? `<p class="hotel-address"><strong>Dirección:</strong> ${hotel.address}</p>` : ''}
                        ${hotel.postal_code ? `<p class="hotel-postal"><strong>Código Postal:</strong> ${hotel.postal_code}</p>` : ''}

                        <div class="hotel-contact">
                            ${phoneLink}
                            ${emailLink}
                            ${website}
                        </div>
                    </div>

                    <div class="hotel-footer">
                        <button class="btn-small btn-guardar-hotel" data-hotel-id="${hotel.id}">Guardar</button>
                    </div>
                </div>
            `;
        });

        hotelsGrid.innerHTML = html;

        // After rendering, attach click handlers to hotel cards to select
        document.querySelectorAll('.hotel-card').forEach((card, idx) => {
            card.addEventListener('click', function(e) {
                // Si se hace click en el botón guardar/quitar, no seleccionar la tarjeta
                if (e.target.classList.contains('btn-guardar-hotel')) return;
                document.querySelectorAll('.hotel-card.selected').forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                const hotelId = hoteles[idx].id;
                document.getElementById('selected_hotel_id').value = hotelId;
            });
        });

        // Botón guardar/quitar
        document.querySelectorAll('.btn-guardar-hotel').forEach((btn, idx) => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const hotel = hoteles[idx];
                
                if (btn.textContent === 'Guardar') {
                    btn.textContent = 'Quitar';
                    btn.classList.add('btn-quitar-hotel');
                    // Guardar en sessionStorage
                    let savedHotels = JSON.parse(sessionStorage.getItem('savedHotels') || '[]');
                    savedHotels.push(hotel);
                    sessionStorage.setItem('savedHotels', JSON.stringify(savedHotels));
                } else {
                    btn.textContent = 'Guardar';
                    btn.classList.remove('btn-quitar-hotel');
                    // Quitar de sessionStorage
                    let savedHotels = JSON.parse(sessionStorage.getItem('savedHotels') || '[]');
                    savedHotels = savedHotels.filter(h => h.id !== hotel.id);
                    sessionStorage.setItem('savedHotels', JSON.stringify(savedHotels));
                }
            });
        });
    }

    // Inicializar en carga: preseleccionar los valores del draft
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar todos inicialmente y luego filtrar por la provincia del draft
        mostrarTodos();

        const provinceSelect = document.getElementById('province-select');
        const localitySelect = document.getElementById('locality-select');

        if (provinceSelect) {
            provinceSelect.value = '{{ $draft['provincia'] }}';
            filtrarPorProvincia();

            // Si hay un municipio en el draft, seleccionar
            const draftMunicipio = '{{ $draft['municipio'] }}';
            if (draftMunicipio) {
                // Esperar pequeño tick para que opciones se carguen
                setTimeout(() => {
                    localitySelect.value = draftMicipio;
                    filtrarHotelesPorLocalidad();
                }, 10);
            }
        }

        // Si hay hotel seleccionado en draft, marcarlo
        @if(isset($draft['hotel']) && $draft['hotel']['id'])
            setTimeout(() => {
                const id = '{{ $draft['hotel']['id'] }}';
                // find hotel in rendered list and mark selected
                document.querySelectorAll('.hotel-card').forEach(card => {
                    if (card.innerHTML.includes(id)) {
                        card.classList.add('selected');
                        document.getElementById('selected_hotel_id').value = id;
                    }
                });
            }, 50);
        @endif

        // Marcar hoteles previamente guardados
        setTimeout(() => {
            const savedHotels = JSON.parse(sessionStorage.getItem('savedHotels') || '[]');
            document.querySelectorAll('.btn-guardar-hotel').forEach(btn => {
                const hotelId = btn.getAttribute('data-hotel-id');
                const isGuardado = savedHotels.some(h => h.id == hotelId);
                if (isGuardado) {
                    btn.textContent = 'Quitar';
                    btn.classList.add('btn-quitar-hotel');
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
