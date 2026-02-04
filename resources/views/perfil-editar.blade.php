@extends('layouts.app')

@section('title', 'Editar Perfil - TravelPlus')

@section('content')

    <section class="profile-section">
        <div class="profile-container">
            <div class="profile-header">
                <div>
                    <h1>Editar Perfil</h1>
                    <p class="profile-email">Actualiza tu información personal</p>
                </div>
                <a class="btn-secondary" href="{{ route('perfil') }}">← Volver</a>
            </div>

            <div class="profile-content">
                <div class="profile-section-box">
                    <h2>Información Personal</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger" style="margin-bottom: 1rem; padding: 1rem; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 6px; color: #721c24;">
                            <ul style="margin: 0; padding-left: 1.5rem;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('perfil.update') }}" class="edit-profile-form">
                        @csrf

                        <div class="form-group">
                            <label for="nombre_apellidos">Nombre Completo</label>
                            <input 
                                id="nombre_apellidos" 
                                name="nombre_apellidos" 
                                type="text" 
                                required 
                                value="{{ old('nombre_apellidos', $user->nombre_apellidos) }}"
                                placeholder="Juan García López"
                            >
                            @error('nombre_apellidos')
                                <span class="text-danger" style="color: #721c24; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="username">Nombre de Usuario</label>
                            <input 
                                id="username" 
                                name="username" 
                                type="text" 
                                required 
                                value="{{ old('username', $user->username) }}"
                                placeholder="juangarcia"
                            >
                            @error('username')
                                <span class="text-danger" style="color: #721c24; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input 
                                id="email" 
                                name="email" 
                                type="email" 
                                required 
                                value="{{ old('email', $user->email) }}"
                                placeholder="juan@ejemplo.com"
                            >
                            @error('email')
                                <span class="text-danger" style="color: #721c24; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                            <input 
                                id="fecha_nacimiento" 
                                name="fecha_nacimiento" 
                                type="date" 
                                value="{{ old('fecha_nacimiento', $user->fecha_nacimiento) }}"
                            >
                            @error('fecha_nacimiento')
                                <span class="text-danger" style="color: #721c24; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
                            <h3 style="margin-bottom: 1rem;">Preferencias de Viaje</h3>

                            <div class="form-group">
                                <label for="hospedaje_favorito">Hospedaje Favorito</label>
                                <select id="hospedaje_favorito" name="hospedaje_favorito">
                                    <option value="" {{ old('hospedaje_favorito', $user->hospedaje_favorito) ? '' : 'selected' }}>Selecciona una opción</option>
                                    <option value="hotel" {{ old('hospedaje_favorito', $user->hospedaje_favorito) === 'hotel' ? 'selected' : '' }}>Hotel</option>
                                    <option value="apartamento" {{ old('hospedaje_favorito', $user->hospedaje_favorito) === 'apartamento' ? 'selected' : '' }}>Apartamento</option>
                                    <option value="hostal" {{ old('hospedaje_favorito', $user->hospedaje_favorito) === 'hostal' ? 'selected' : '' }}>Hostal</option>
                                </select>
                                @error('hospedaje_favorito')
                                    <span class="text-danger" style="color: #721c24; font-size: 0.875rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tipo_comida">Tipo de Comida</label>
                                <select id="tipo_comida" name="tipo_comida">
                                    <option value="" {{ old('tipo_comida', $user->tipo_comida) ? '' : 'selected' }}>Selecciona una opción</option>
                                    <option value="tradicional" {{ old('tipo_comida', $user->tipo_comida) === 'tradicional' ? 'selected' : '' }}>Tradicional</option>
                                    <option value="internacional" {{ old('tipo_comida', $user->tipo_comida) === 'internacional' ? 'selected' : '' }}>Internacional</option>
                                    <option value="vegetariana" {{ old('tipo_comida', $user->tipo_comida) === 'vegetariana' ? 'selected' : '' }}>Vegetariana</option>
                                </select>
                                @error('tipo_comida')
                                    <span class="text-danger" style="color: #721c24; font-size: 0.875rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="actividades">Actividades</label>
                                <select id="actividades" name="actividades">
                                    <option value="" {{ old('actividades', $user->actividades) ? '' : 'selected' }}>Selecciona una opción</option>
                                    <option value="museos" {{ old('actividades', $user->actividades) === 'museos' ? 'selected' : '' }}>Museos</option>
                                    <option value="naturaleza" {{ old('actividades', $user->actividades) === 'naturaleza' ? 'selected' : '' }}>Naturaleza</option>
                                    <option value="aventura" {{ old('actividades', $user->actividades) === 'aventura' ? 'selected' : '' }}>Aventura</option>
                                </select>
                                @error('actividades')
                                    <span class="text-danger" style="color: #721c24; font-size: 0.875rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tipo_viaje">Tipo de Viaje</label>
                                <select id="tipo_viaje" name="tipo_viaje">
                                    <option value="" {{ old('tipo_viaje', $user->tipo_viaje) ? '' : 'selected' }}>Selecciona una opción</option>
                                    <option value="pareja" {{ old('tipo_viaje', $user->tipo_viaje) === 'pareja' ? 'selected' : '' }}>En pareja</option>
                                    <option value="familia" {{ old('tipo_viaje', $user->tipo_viaje) === 'familia' ? 'selected' : '' }}>En familia</option>
                                    <option value="amigos" {{ old('tipo_viaje', $user->tipo_viaje) === 'amigos' ? 'selected' : '' }}>Con amigos</option>
                                </select>
                                @error('tipo_viaje')
                                    <span class="text-danger" style="color: #721c24; font-size: 0.875rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
                            <h3 style="margin-bottom: 1rem;">Seguridad</h3>
                            <p style="color: #666; font-size: 0.9rem; margin-bottom: 1rem;">Deja estos campos vacíos si no deseas cambiar tu contraseña</p>

                            <div class="form-group">
                                <label for="password">Nueva Contraseña</label>
                                <input 
                                    id="password" 
                                    name="password" 
                                    type="password" 
                                    placeholder="••••••••"
                                >
                                @error('password')
                                    <span class="text-danger" style="color: #721c24; font-size: 0.875rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirmar Contraseña</label>
                                <input 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    type="password" 
                                    placeholder="••••••••"
                                >
                            </div>
                        </div>

                        <div style="margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                            <button type="submit" class="btn-primary">Guardar Cambios</button>
                            <button type="submit" class="btn-danger" form="deleteAccountForm">Eliminar Cuenta</button>
                            <a href="{{ route('perfil') }}" class="btn-secondary">Cancelar</a>
                        </div>
                    </form>
                    <form id="deleteAccountForm" method="POST" action="{{ route('perfil.destroy') }}" onsubmit="return confirm('¿Seguro que deseas eliminar tu cuenta? Esta acción no se puede deshacer.');" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
