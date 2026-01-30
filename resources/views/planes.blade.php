<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planear Viaje - TravelPlus</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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

    <section class="planes-section">
        <div class="planes-container">
            <h1>Planifica tu próximo viaje</h1>

            @if(session('success'))
                <div class="alert alert-success" style="margin-bottom:12px;padding:10px;border-radius:6px;background:#d4edda;color:#155724;">{{ session('success') }}</div>
            @endif

            <div class="filters-box">
                <div class="filter-group">
                    <label for="provincia">Selecciona la Provincia</label>
                    <select id="provincia">
                        <option value="">-- Elige una provincia --</option>
                        @foreach(($provinces ?? []) as $prov)
                            <option value="{{ $prov }}">{{ $prov }}</option>
                        @endforeach
                    </select>
                    <div id="provinciaError" style="display:none;color:#dc3545;font-size:0.9rem;"></div>
                </div>

                <div class="filter-group">
                    <label for="municipio">Selecciona el Municipio</label>
                    <select id="municipio" disabled>
                        <option value="">-- Selecciona una provincia primero --</option>
                    </select>
                    <div id="municipioError" style="display:none;color:#dc3545;font-size:0.9rem;"></div>
                </div>

                <script>
                    // Datos inyectados desde el servidor para evitar fetch y problemas de CORS
                    window.__MUNICIPIOS__ = @json($municipios_map ?? (object)[]);
                </script>

                <div class="filter-group">
                    <label>Fechas</label>
                    <div style="display:flex;gap:8px;align-items:center;">
                        <input type="text" id="start_date" placeholder="Fecha inicio" readonly style="padding:8px;border:1px solid #ccc;border-radius:4px;">
                        <span style="font-size:1.1rem;color:#666;">→</span>
                        <input type="text" id="end_date" placeholder="Fecha fin" readonly style="padding:8px;border:1px solid #ccc;border-radius:4px;">
                    </div>
                    <div id="dateError" style="display:none;color:#dc3545;font-size:0.9rem;margin-top:6px;"></div>
                    <div id="dateWarning" style="display:none;color:#856404;background:#fff3cd;border-radius:4px;padding:6px;font-size:0.85rem;margin-top:6px;"></div>
                </div>

                <!-- Form para guardar plan -->
                <form id="savePlanForm" method="POST" action="{{ route('planes.store') }}" style="margin-top:12px;">
                    @csrf
                    <input type="hidden" name="provincia" id="form_provincia">
                    <input type="hidden" name="municipio" id="form_municipio">
                    <input type="hidden" name="start_date" id="form_start_date">
                    <input type="hidden" name="end_date" id="form_end_date">
                    <input type="hidden" name="items" id="form_items">
                    <button id="savePlanBtn" type="submit" class="btn-secondary" disabled>Guardar Plan</button>
                </form>

                <button class="btn-primary" onclick="filtrarDestinos()">Buscar</button>

                <!-- include flatpickr and date helper -->
                <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                <script src="{{ asset('js/planes-dates.js') }}" defer></script>
            </div>

            <div id="resultados" class="resultados-container">
                <p class="placeholder-text">Selecciona una provincia y un rango de fechas para ver opciones disponibles</p>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 TravelPlus - Todos los derechos reservados</p>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/planes-municipios.js') }}" defer></script>
</body>
</html>
