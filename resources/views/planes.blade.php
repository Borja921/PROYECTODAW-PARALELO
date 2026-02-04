@extends('layouts.app')

@section('title', 'Planear Viaje - MateCyL')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@section('content')

    <section class="planes-section">
        <div class="planes-container">
            <h1>Planifica tu próximo viaje</h1>

            @if(session('success'))
                <div class="alert alert-success" style="margin-bottom:12px;padding:10px;border-radius:6px;background:#d4edda;color:#155724;">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger" style="margin-bottom:12px;padding:10px;border-radius:6px;background:#f8d7da;color:#721c24;">{{ session('error') }}</div>
            @endif

            <script>
                // Limpiar la sesión del plan anterior al cargar esta página
                document.addEventListener('DOMContentLoaded', function() {
                    // Resetear los campos del formulario
                    document.getElementById('provincia').value = '';
                    document.getElementById('municipio').value = '';
                    document.getElementById('start_date').value = '';
                    document.getElementById('end_date').value = '';
                });
            </script>

            <div class="filters-box">
                <!-- Primera fila: Todos los selectores -->
                <form id="wizardStep1Form" method="POST" action="{{ route('plan.wizard.step1.save') }}" style="width: 100%;">
                    @csrf
                    <input type="hidden" name="provincia" id="wizard_provincia">
                    <input type="hidden" name="municipio" id="wizard_municipio">
                    <input type="hidden" name="start_date" id="wizard_start_date">
                    <input type="hidden" name="end_date" id="wizard_end_date">
                    
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem; align-items: end;">
                        <div class="filter-group">
                            <label for="provincia">Provincia</label>
                            <select id="provincia">
                                <option value="">-- Elige una provincia --</option>
                                @foreach(($provinces ?? []) as $prov)
                                    <option value="{{ $prov }}">{{ $prov }}</option>
                                @endforeach
                            </select>
                            <div id="provinciaError" style="display:none;color:#dc3545;font-size:0.9rem;"></div>
                        </div>

                        <div class="filter-group">
                            <label for="municipio">Municipio</label>
                            <select id="municipio" disabled>
                                <option value="">-- Selecciona provincia --</option>
                            </select>
                            <div id="municipioError" style="display:none;color:#dc3545;font-size:0.9rem;"></div>
                        </div>

                        <div class="filter-group">
                            <label for="start_date">Fecha Inicio</label>
                            <input type="text" id="start_date" placeholder="Seleccionar" readonly style="padding:8px;border:1px solid #ccc;border-radius:8px;width:100%;">
                            <div id="dateError" style="display:none;color:#dc3545;font-size:0.9rem;margin-top:6px;"></div>
                        </div>

                        <div class="filter-group">
                            <label for="end_date">Fecha Fin</label>
                            <input type="text" id="end_date" placeholder="Seleccionar" readonly style="padding:8px;border:1px solid #ccc;border-radius:8px;width:100%;">
                            <div id="dateWarning" style="display:none;color:#856404;background:#fff3cd;border-radius:4px;padding:6px;font-size:0.85rem;margin-top:6px;"></div>
                        </div>
                    </div>

                    <!-- Segunda fila: Botón centrado -->
                    <div style="text-align: center; margin-bottom: 2rem;">
                        <button id="wizardNextBtn" type="submit" class="btn-primary" disabled style="padding: 0.75rem 3rem;">Siguiente</button>
                    </div>
                    
                    <script>
                        // Datos inyectados desde el servidor para evitar fetch y problemas de CORS
                        window.__MUNICIPIOS__ = @json($municipios_map ?? (object)[]);
                    </script>
                </form>

                <!-- Tercera fila: Mapa y Tiempo lado a lado -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1rem;">
                    <!-- Mapa Interactivo -->
                    <div id="mapContainer" style="display:none;">
                        <label style="display:block;margin-bottom:0.5rem;font-weight:600;font-size:1.1rem;">📍 Ubicación Seleccionada</label>
                        <div id="map" style="height: 400px; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);"></div>
                    </div>

                    <!-- Pronóstico del Tiempo -->
                    <div id="weatherContainer" style="display:none;">
                        <label style="display:block;margin-bottom:0.5rem;font-weight:600;font-size:1.1rem;">🌤️ Pronóstico del Tiempo</label>
                        <div id="weatherInfo" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 1.5rem; border-radius: 12px; color: white; box-shadow: 0 4px 12px rgba(0,0,0,0.1); height: 400px; overflow-y: auto;">
                            <div style="text-align: center;">
                                <p style="margin: 0; font-size: 0.9rem; opacity: 0.9;">Cargando información del clima...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- include flatpickr and date helper -->
                <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                <script src="{{ asset('js/planes-dates.js') }}" defer></script>
                <script src="{{ asset('js/planes-map-weather.js') }}" defer></script>
            </div>

            <div id="resultados" class="resultados-container">
                <p class="placeholder-text">Selecciona una provincia y un rango de fechas para ver opciones disponibles</p>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset('js/planes-dates.js') }}" defer></script>
<script src="{{ asset('js/planes-map-weather.js') }}" defer></script>
<script src="{{ asset('js/planes-municipios.js') }}" defer></script>
@endpush
