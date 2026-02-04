@extends('layouts.app')

@section('title', 'Detalle del Plan - MateCyL')

@push('styles')
<style>
    .summary-card {
        background: linear-gradient(135deg, #ffffff 0%, #f9f6f2 100%);
        border: 1px solid #e7e1db;
        border-radius: 22px;
        padding: 24px;
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.10);
        position: relative;
        overflow: hidden;
        margin-top: 20px;
    }

    .summary-card::before {
        content: "";
        position: absolute;
        top: -60px;
        right: -60px;
        width: 160px;
        height: 160px;
        background: radial-gradient(circle, rgba(139, 123, 123, 0.18) 0%, rgba(139, 123, 123, 0) 70%);
        pointer-events: none;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 14px;
        margin-top: 18px;
    }

    .summary-item {
        background: #ffffff;
        border: 1px solid #eee6de;
        border-radius: 14px;
        padding: 14px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
        position: relative;
    }

    .summary-item strong {
        display: block;
        color: #333;
        margin-bottom: 12px;
        font-size: 1.1rem;
    }

    .summary-item .item-icon {
        position: absolute;
        top: 12px;
        right: 12px;
        font-size: 1.3rem;
        opacity: 0.7;
    }

    .item-container {
        background: #f8f6f3;
        padding: 12px 14px;
        border-radius: 8px;
        margin-bottom: 10px;
        border-left: 3px solid #8b7b7b;
    }

    .item-container h4 {
        margin: 0 0 8px 0;
        font-size: 1.05rem;
        color: #2f2a26;
    }

    .item-container p {
        margin: 4px 0;
        font-size: 0.9rem;
        color: #5b4f48;
    }

    .badge-empty {
        display: inline-block;
        background: #fff1f1;
        color: #b15a5a;
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 999px;
        border: 1px dashed #e7b3b3;
        margin-top: 6px;
    }

    .summary-header {
        background: linear-gradient(135deg, rgba(139, 123, 123, 0.12), rgba(192, 181, 170, 0.12));
        border: 1px solid #f0e3d9;
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 20px;
    }

    .summary-title {
        font-weight: 700;
        color: #4b3f37;
        font-size: 1.05rem;
        margin-bottom: 12px;
    }

    .summary-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        background: #ffffff;
        border: 1px solid #eddccf;
        font-weight: 600;
        color: #5b4f48;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04);
        margin-right: 8px;
        margin-bottom: 8px;
    }
</style>
@endpush

@section('content')

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
                    <h1>{{ $plan->name ?? ($plan->provincia . ' — ' . $plan->municipio) }}</h1>
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
                    <button type="button" class="btn-danger" onclick="showDeleteModal()">🗑️ Eliminar Plan</button>
                    <form id="deletePlanForm" method="POST" action="{{ route('mis-planes.destroy', $plan->id) }}" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-header">
                    <div class="summary-title">🧭 Resumen de tu viaje</div>
                    <div style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;">
                        <span class="summary-chip">📍 {{ $plan->provincia }}, {{ $plan->municipio }}</span>
                        <span class="summary-chip">📅 {{ $plan->start_date->format('d/m/Y') }} → {{ $plan->end_date->format('d/m/Y') }}</span>
                        <span class="summary-chip">⏱️ {{ $plan->days }} día(s)</span>
                        <span class="summary-chip">📝 Creado: {{ $plan->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>

                <div class="summary-grid">
                    <!-- HOTELES -->
                    <div class="summary-item" style="grid-column: 1/-1;">
                        <span class="item-icon">🏨</span>
                        <strong>Hoteles Seleccionados</strong>
                        @if($selectedHotels->isNotEmpty())
                            <div style="margin-top: 12px;">
                                @foreach($selectedHotels as $hotel)
                                    <div class="item-container">
                                        <h4>{{ $hotel->name }}</h4>
                                        <p>📍 {{ $hotel->locality }}, {{ $hotel->province }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <span class="badge-empty">No seleccionados</span>
                        @endif
                    </div>

                    <!-- RESTAURANTES -->
                    <div class="summary-item" style="grid-column: 1/-1;">
                        <span class="item-icon">🍽️</span>
                        <strong>Restaurantes Seleccionados</strong>
                        @if($selectedRestaurants->isNotEmpty())
                            <div style="margin-top: 12px;">
                                @foreach($selectedRestaurants as $restaurant)
                                    <div class="item-container">
                                        <h4>{{ $restaurant->name }}</h4>
                                        <p>📍 {{ $restaurant->locality }}, {{ $restaurant->province }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <span class="badge-empty">No seleccionados</span>
                        @endif
                    </div>

                    <!-- MUSEOS -->
                    <div class="summary-item" style="grid-column: 1/-1;">
                        <span class="item-icon">🎨</span>
                        <strong>Museos Seleccionados</strong>
                        @if($selectedMuseums->isNotEmpty())
                            <div style="margin-top: 12px;">
                                @foreach($selectedMuseums as $museum)
                                    <div class="item-container">
                                        <h4>{{ $museum->name }}</h4>
                                        <p>📍 {{ $museum->locality }}, {{ $museum->province }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <span class="badge-empty">No seleccionados</span>
                        @endif
                    </div>

                    <!-- FIESTAS -->
                    <div class="summary-item" style="grid-column: 1/-1;">
                        <span class="item-icon">🎉</span>
                        <strong>Fiestas Seleccionadas</strong>
                        @if($selectedFestivals->isNotEmpty())
                            <div style="margin-top: 12px;">
                                @foreach($selectedFestivals as $festival)
                                    <div class="item-container">
                                        <h4>{{ $festival->name }}</h4>
                                        <p>📍 {{ $festival->locality }}, {{ $festival->province }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <span class="badge-empty">No seleccionadas</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal de confirmación para finalizar -->
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

    <!-- Modal de confirmación para eliminar -->
    <div id="deleteModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2>🗑️ ¿Eliminar Plan?</h2>
                <button type="button" class="modal-close" onclick="closeDeleteModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p style="color: #dc3545; font-weight: 600;">⚠️ Esta acción no se puede deshacer.</p>
                <p>¿Estás seguro de que quieres eliminar este plan permanentemente?</p>
                <p style="color: #666; font-size: 0.9rem; margin-top: 1rem;">Se perderán todos los datos del plan: hoteles, restaurantes, museos y fiestas seleccionados.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeDeleteModal()">Cancelar</button>
                <button type="button" class="btn-danger" onclick="confirmDelete()" style="background: #dc3545; border-color: #dc3545;">Eliminar Plan</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function showConfirmModal() {
        document.getElementById('confirmModal').classList.add('active');
    }

    function closeConfirmModal() {
        document.getElementById('confirmModal').classList.remove('active');
    }

    function confirmFinalize() {
        closeConfirmModal();
        const alert = document.getElementById('successAlert');
        if (alert) {
            alert.style.display = 'none';
        }
        document.getElementById('finalizePlanForm').submit();
    }

    function showDeleteModal() {
        document.getElementById('deleteModal').classList.add('active');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('active');
    }

    function confirmDelete() {
        closeDeleteModal();
        document.getElementById('deletePlanForm').submit();
    }

    window.addEventListener('load', function() {
        const alert = document.getElementById('successAlert');
        if (alert) {
            setTimeout(function() {
                alert.classList.add('show');
            }, 100);
        }
    });
</script>
@endpush
