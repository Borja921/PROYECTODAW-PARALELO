@extends('layouts.app')

@section('title', 'Mi Perfil - MateCyL')

@section('content')

    <section class="profile-section">
        <div class="profile-container">
            <div class="profile-header">
                <div class="profile-avatar">
                    @if($user->profile_photo)
                        <img src="{{ asset($user->profile_photo) }}" alt="Foto de perfil">
                    @else
                        👤
                    @endif
                </div>
                <div class="profile-info">
                    <h1>{{ $user->nombre_apellidos }}</h1>
                    <p class="profile-email">{{ $user->email }}</p>
                    <p class="profile-location">📍 Castilla y León, España</p>
                </div>
                <button class="btn-primary" onclick="openEditProfileModal()">Editar Perfil</button>
            </div>

            <div class="profile-stats">
                <div class="stat-card">
                    <div class="stat-number">{{ $planesGuardados }}</div>
                    <div class="stat-label">Planes Guardados</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $planesFinalizados }}</div>
                    <div class="stat-label">Planes Finalizados</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $sitiosVisitados }}</div>
                    <div class="stat-label">Sitios Visitados</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $planesFavoritos }}</div>
                    <div class="stat-label">Planes Favoritos</div>
                </div>
            </div>

            <div class="profile-content">
                <div class="profile-section-box">
                    <h2>Información Personal</h2>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Nombre Completo</label>
                            <p>{{ $user->nombre_apellidos }}</p>
                        </div>
                        <div class="info-item">
                            <label>Nombre de Usuario</label>
                            <p>{{ $user->username }}</p>
                        </div>
                        <div class="info-item">
                            <label>Correo Electrónico</label>
                            <p>{{ $user->email }}</p>
                        </div>
                        <div class="info-item">
                            <label>Fecha de Nacimiento</label>
                            <p>{{ $user->fecha_nacimiento ? \Carbon\Carbon::parse($user->fecha_nacimiento)->format('d/m/Y') : 'No especificado' }}</p>
                        </div>
                        <div class="info-item">
                            <label>Fecha de Registro</label>
                            <p>{{ $user->created_at ? $user->created_at->format('d \d\e F, Y') : 'No disponible' }}</p>
                        </div>
                    </div>
                </div>

                <div class="profile-section-box">
                    <h2>Preferencias de Viaje</h2>
                    @php
                        $hospedajeMap = [
                            'hotel' => 'Hotel',
                            'apartamento' => 'Apartamento',
                            'hostal' => 'Hostal',
                        ];
                        $comidaMap = [
                            'tradicional' => 'Tradicional',
                            'internacional' => 'Internacional',
                            'vegetariana' => 'Vegetariana',
                        ];
                        $actividadesMap = [
                            'museos' => 'Museos',
                            'naturaleza' => 'Naturaleza',
                            'aventura' => 'Aventura',
                        ];
                        $viajeMap = [
                            'pareja' => 'En pareja',
                            'familia' => 'En familia',
                            'amigos' => 'Con amigos',
                        ];
                        $hospedajeValue = $hospedajeMap[$user->hospedaje_favorito] ?? 'No especificado';
                        $comidaValue = $comidaMap[$user->tipo_comida] ?? 'No especificado';
                        $actividadesValue = $actividadesMap[$user->actividades] ?? 'No especificado';
                        $viajeValue = $viajeMap[$user->tipo_viaje] ?? 'No especificado';
                    @endphp
                    <div class="preferences-list">
                        <div class="preference-item">
                            <span class="pref-icon">🏨</span>
                            <div>
                                <h4>Hospedaje Favorito</h4>
                                <p>{{ $hospedajeValue }}</p>
                            </div>
                        </div>
                        <div class="preference-item">
                            <span class="pref-icon">🍽️</span>
                            <div>
                                <h4>Tipo de Comida</h4>
                                <p>{{ $comidaValue }}</p>
                            </div>
                        </div>
                        <div class="preference-item">
                            <span class="pref-icon">🎨</span>
                            <div>
                                <h4>Actividades</h4>
                                <p>{{ $actividadesValue }}</p>
                            </div>
                        </div>
                        <div class="preference-item">
                            <span class="pref-icon">🏖️</span>
                            <div>
                                <h4>Tipo de Viaje</h4>
                                <p>{{ $viajeValue }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="profile-section-box" style="text-align: center; margin-top: 2rem;">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-secondary" style="background-color: #dc3545; border-color: #dc3545; color: white; padding: 0.75rem 2rem; font-size: 1rem;">
                            🚪 Cerrar Sesión
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>

    <!-- Modal de edición de perfil -->
    <div id="editProfileModal" class="modal-overlay">
        <div class="modal-content" style="max-width: 520px;">
            <button class="modal-close" onclick="closeEditProfileModal()">&times;</button>

            <div class="modal-body" style="padding-top: 0;">
                <h2 style="margin-bottom: 0.5rem;">Editar Perfil</h2>
                <p style="color: #666; margin-bottom: 1.5rem;">Actualiza tu información personal</p>

                <form method="POST" action="{{ route('perfil.update') }}" class="edit-profile-form" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="modal_nombre_apellidos">Nombre Completo</label>
                        <input
                            id="modal_nombre_apellidos"
                            name="nombre_apellidos"
                            type="text"
                            required
                            value="{{ old('nombre_apellidos', $user->nombre_apellidos) }}"
                            placeholder="Juan García López"
                        >
                        @error('nombre_apellidos')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="modal_username">Nombre de Usuario</label>
                        <input
                            id="modal_username"
                            name="username"
                            type="text"
                            required
                            value="{{ old('username', $user->username) }}"
                            placeholder="juangarcia"
                        >
                        @error('username')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="modal_email">Correo Electrónico</label>
                        <input
                            id="modal_email"
                            name="email"
                            type="email"
                            required
                            value="{{ old('email', $user->email) }}"
                            placeholder="juan@ejemplo.com"
                        >
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="modal_fecha_nacimiento">Fecha de Nacimiento</label>
                        <input
                            id="modal_fecha_nacimiento"
                            name="fecha_nacimiento"
                            type="date"
                            value="{{ old('fecha_nacimiento', $user->fecha_nacimiento) }}"
                        >
                        @error('fecha_nacimiento')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="modal_profile_photo">Foto de Perfil</label>
                        <input id="modal_profile_photo" name="profile_photo" type="file" accept="image/*">
                        @error('profile_photo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                        <h3 style="margin-bottom: 0.75rem;">Preferencias de Viaje</h3>

                        <div class="form-group">
                            <label for="modal_hospedaje_favorito">Hospedaje Favorito</label>
                            <select id="modal_hospedaje_favorito" name="hospedaje_favorito">
                                <option value="" {{ old('hospedaje_favorito', $user->hospedaje_favorito) ? '' : 'selected' }}>Selecciona una opción</option>
                                <option value="hotel" {{ old('hospedaje_favorito', $user->hospedaje_favorito) === 'hotel' ? 'selected' : '' }}>Hotel</option>
                                <option value="apartamento" {{ old('hospedaje_favorito', $user->hospedaje_favorito) === 'apartamento' ? 'selected' : '' }}>Apartamento</option>
                                <option value="hostal" {{ old('hospedaje_favorito', $user->hospedaje_favorito) === 'hostal' ? 'selected' : '' }}>Hostal</option>
                            </select>
                            @error('hospedaje_favorito')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="modal_tipo_comida">Tipo de Comida</label>
                            <select id="modal_tipo_comida" name="tipo_comida">
                                <option value="" {{ old('tipo_comida', $user->tipo_comida) ? '' : 'selected' }}>Selecciona una opción</option>
                                <option value="tradicional" {{ old('tipo_comida', $user->tipo_comida) === 'tradicional' ? 'selected' : '' }}>Tradicional</option>
                                <option value="internacional" {{ old('tipo_comida', $user->tipo_comida) === 'internacional' ? 'selected' : '' }}>Internacional</option>
                                <option value="vegetariana" {{ old('tipo_comida', $user->tipo_comida) === 'vegetariana' ? 'selected' : '' }}>Vegetariana</option>
                            </select>
                            @error('tipo_comida')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="modal_actividades">Actividades</label>
                            <select id="modal_actividades" name="actividades">
                                <option value="" {{ old('actividades', $user->actividades) ? '' : 'selected' }}>Selecciona una opción</option>
                                <option value="museos" {{ old('actividades', $user->actividades) === 'museos' ? 'selected' : '' }}>Museos</option>
                                <option value="naturaleza" {{ old('actividades', $user->actividades) === 'naturaleza' ? 'selected' : '' }}>Naturaleza</option>
                                <option value="aventura" {{ old('actividades', $user->actividades) === 'aventura' ? 'selected' : '' }}>Aventura</option>
                            </select>
                            @error('actividades')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="modal_tipo_viaje">Tipo de Viaje</label>
                            <select id="modal_tipo_viaje" name="tipo_viaje">
                                <option value="" {{ old('tipo_viaje', $user->tipo_viaje) ? '' : 'selected' }}>Selecciona una opción</option>
                                <option value="pareja" {{ old('tipo_viaje', $user->tipo_viaje) === 'pareja' ? 'selected' : '' }}>En pareja</option>
                                <option value="familia" {{ old('tipo_viaje', $user->tipo_viaje) === 'familia' ? 'selected' : '' }}>En familia</option>
                                <option value="amigos" {{ old('tipo_viaje', $user->tipo_viaje) === 'amigos' ? 'selected' : '' }}>Con amigos</option>
                            </select>
                            @error('tipo_viaje')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                        <h3 style="margin-bottom: 0.75rem;">Seguridad</h3>
                        <p style="color: #666; font-size: 0.9rem; margin-bottom: 0.75rem;">Deja estos campos vacíos si no deseas cambiar tu contraseña</p>

                        <div class="form-group">
                            <label for="modal_password">Nueva Contraseña</label>
                            <input
                                id="modal_password"
                                name="password"
                                type="password"
                                placeholder="••••••••"
                            >
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="modal_password_confirmation">Confirmar Contraseña</label>
                            <input
                                id="modal_password_confirmation"
                                name="password_confirmation"
                                type="password"
                                placeholder="••••••••"
                            >
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                        <button type="submit" class="btn-primary">Guardar Cambios</button>
                        <button type="submit" class="btn-danger" form="deleteAccountFormModal">Eliminar Cuenta</button>
                        <button type="button" class="btn-secondary" onclick="closeEditProfileModal()">Cancelar</button>
                    </div>
                </form>
                <form id="deleteAccountFormModal" method="POST" action="{{ route('perfil.destroy') }}" onsubmit="return confirm('¿Seguro que deseas eliminar tu cuenta? Esta acción no se puede deshacer.');" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function openEditProfileModal() {
        document.getElementById('editProfileModal').classList.add('active');
    }

    function closeEditProfileModal() {
        document.getElementById('editProfileModal').classList.remove('active');
    }

    window.addEventListener('load', function() {
        @if ($errors->any())
            openEditProfileModal();
        @endif
    });
</script>
@endpush
