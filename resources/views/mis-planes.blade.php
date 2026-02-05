@extends('layouts.app')

@section('title', 'Mis Planes - MateCyL')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')

    <section class="planes-list-section">
        <div class="planes-list-container">
            <div class="planes-header">
                <h1>Mis Viajes Planificados</h1>
                <form method="POST" action="{{ route('plan.wizard.reset') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-primary">+ Nuevo Plan</button>
                </form>
            </div>

            @if(session('success'))
                <div class="alert alert-success" style="margin: 12px 0; padding: 10px; border-radius: 6px; background: #d4edda; color: #155724;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="filter-tabs">
                <button class="tab-button active" onclick="filtrarPorEstado('todos')">Todos ({{ $totalPlans }})</button>
                <button class="tab-button" onclick="filtrarPorEstado('favoritos')">Favoritos ({{ $favoritos }})</button>
                <button class="tab-button" onclick="filtrarPorEstado('finalizados')">Finalizados ({{ $finalizados }})</button>
                <button class="tab-button" onclick="filtrarPorEstado('sinFinalizar')">Sin Finalizar ({{ $sinFinalizar }})</button>
            </div>

            <div class="my-plans-grid">
                @if($plans->isEmpty())
                    <p>No tienes planes guardados.</p>
                @else
                    @foreach($plans as $p)
                        <div class="plan-card" data-status="{{ $p->status ?? 'planificando' }}" data-favorite="{{ $p->is_favorite ? 'true' : 'false' }}">
                            <div class="plan-card-header">
                                <h3>{{ $p->name ?? ($p->provincia . ' — ' . $p->municipio) }}</h3>
                                <button type="button" class="btn-favorite" onclick="toggleFavorite({{ $p->id }}, this)" data-id="{{ $p->id }}" title="Agregar a favoritos">
                                    <span class="favorite-icon">{{ $p->is_favorite ? '★' : '☆' }}</span>
                                </button>
                            </div>
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
@endsection

@push('scripts')
<script>
    function toggleFavorite(planId, button) {
        // Guardar estado original por si hay error
        const originalIcon = button.querySelector('.favorite-icon').textContent;
        const originalTitle = button.title;
        
        fetch(`/mis-planes/${planId}/toggle-favorite`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => {
            // ✅ Verificar que la respuesta HTTP fue exitosa
            if (!response.ok) {
                throw new Error(`Error HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            // ✅ Verificar que el servidor devolvió success = true
            if (data.success) {
                const icon = button.querySelector('.favorite-icon');
                icon.textContent = data.is_favorite ? '★' : '☆';
                button.title = data.is_favorite ? 'Remover de favoritos' : 'Agregar a favoritos';
                
                // Actualizar el atributo data-favorite en la tarjeta
                const card = button.closest('.plan-card');
                card.setAttribute('data-favorite', data.is_favorite ? 'true' : 'false');
                
                // Animar el botón
                button.classList.add('favorite-animate');
                setTimeout(() => button.classList.remove('favorite-animate'), 300);
            } else {
                // ✅ El servidor rechazó la operación
                alert('No se pudo guardar los cambios: ' + (data.message || 'Error desconocido'));
                // Revertir estado visual
                button.classList.remove('favorite-animate');
            }
        })
        .catch(error => {
            // ✅ Mostrar error al usuario
            console.error('Error en toggleFavorite:', error);
            alert('Error al guardar: ' + error.message);
            
            // Revertir estado visual
            const icon = button.querySelector('.favorite-icon');
            icon.textContent = originalIcon;
            button.title = originalTitle;
            button.classList.remove('favorite-animate');
        });
    }

    function filtrarPorEstado(estado) {
        const cards = document.querySelectorAll('.plan-card');
        const buttons = document.querySelectorAll('.tab-button');

        // Actualizar botón activo
        buttons.forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');

        // Filtrar cards
        cards.forEach(card => {
            const cardStatus = card.getAttribute('data-status');
            const isFavorite = card.getAttribute('data-favorite') === 'true';
            let mostrar = false;

            if (estado === 'todos') {
                mostrar = true;
            } else if (estado === 'favoritos') {
                mostrar = isFavorite;
            } else if (estado === 'finalizados') {
                mostrar = cardStatus === 'completado';
            } else if (estado === 'sinFinalizar') {
                mostrar = cardStatus !== 'completado';
            }

            card.style.display = mostrar ? 'block' : 'none';
        });
    }
</script>
@endpush
