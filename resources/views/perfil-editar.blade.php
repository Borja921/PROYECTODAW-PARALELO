@extends('layouts.app')

@section('title', 'Editar Perfil - MateCyL')

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

                    <form id="editProfileForm" method="POST" action="{{ route('perfil.update') }}" class="edit-profile-form" enctype="multipart/form-data" novalidate>
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
                                minlength="3"
                                maxlength="100"
                            >
                            <div id="nombreError" style="display:none;color:#dc3545;font-size:0.9rem;margin-top:0.3rem;"></div>
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
                                minlength="3"
                                maxlength="20"
                                pattern="[a-zA-Z0-9_-]+"
                                title="Solo letras, números, guiones y guiones bajos"
                            >
                            <div id="usernameError" style="display:none;color:#dc3545;font-size:0.9rem;margin-top:0.3rem;"></div>
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
                            <div id="emailError" style="display:none;color:#dc3545;font-size:0.9rem;margin-top:0.3rem;"></div>
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

                        <div class="form-group">
                            <label for="profile_photo">Foto de Perfil</label>
                            <input id="profile_photo" name="profile_photo" type="file" accept="image/*" data-max-size="2097152">
                            <div id="photoError" style="display:none;color:#dc3545;font-size:0.9rem;margin-top:0.3rem;"></div>
                            <small style="display: block; margin-top: 0.5rem; color: #666;">Máximo 2MB. Formatos: JPG, PNG, GIF</small>
                            @error('profile_photo')
                                <span class="text-danger" style="color: #721c24; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                            @if($user->profile_photo)
                                <div style="margin-top: 0.75rem;">
                                    <img src="{{ asset($user->profile_photo) }}" alt="Foto de perfil" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">
                                </div>
                            @endif
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
                            <button id="submitBtn" type="submit" class="btn-primary">Guardar Cambios</button>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editProfileForm');
    const nombreInput = document.getElementById('nombre_apellidos');
    const usernameInput = document.getElementById('username');
    const emailInput = document.getElementById('email');
    const photoInput = document.getElementById('profile_photo');
    const submitBtn = document.getElementById('submitBtn');
    
    const nombreError = document.getElementById('nombreError');
    const usernameError = document.getElementById('usernameError');
    const emailError = document.getElementById('emailError');
    const photoError = document.getElementById('photoError');

    // Limpiar errores cuando el usuario escribe
    nombreInput.addEventListener('input', () => {
        nombreError.style.display = 'none';
        nombreError.textContent = '';
    });
    usernameInput.addEventListener('input', () => {
        usernameError.style.display = 'none';
        usernameError.textContent = '';
    });
    emailInput.addEventListener('input', () => {
        emailError.style.display = 'none';
        emailError.textContent = '';
    });
    photoInput.addEventListener('change', () => {
        photoError.style.display = 'none';
        photoError.textContent = '';
    });

    // Validación de archivo al cambiar
    photoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;

        const maxSize = parseInt(this.dataset.maxSize);
        const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

        // Validar tamaño
        if (file.size > maxSize) {
            photoError.textContent = 'El archivo es demasiado grande. Máximo 2MB.';
            photoError.style.display = 'block';
            this.value = '';
            return;
        }

        // Validar tipo MIME
        if (!validTypes.includes(file.type)) {
            photoError.textContent = 'Formato de imagen no permitido. Usa JPG, PNG, GIF o WebP.';
            photoError.style.display = 'block';
            this.value = '';
            return;
        }

        // Validar que sea realmente una imagen usando FileReader
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = new Image();
            img.onload = function() {
                // Es una imagen válida
                photoError.style.display = 'none';
                photoError.textContent = '';
            };
            img.onerror = function() {
                photoError.textContent = 'El archivo no es una imagen válida.';
                photoError.style.display = 'block';
                photoInput.value = '';
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });

    // Validación al enviar
    form.addEventListener('submit', function(e) {
        let hasError = false;

        // Validar nombre completo
        const nombre = nombreInput.value.trim();
        if (!nombre || nombre.length < 3) {
            nombreError.textContent = 'El nombre debe tener al menos 3 caracteres.';
            nombreError.style.display = 'block';
            hasError = true;
        } else if (nombre.length > 100) {
            nombreError.textContent = 'El nombre no puede exceder 100 caracteres.';
            nombreError.style.display = 'block';
            hasError = true;
        }

        // Validar username
        const username = usernameInput.value.trim();
        const usernameRegex = /^[a-zA-Z0-9_-]+$/;
        if (!username || username.length < 3) {
            usernameError.textContent = 'El usuario debe tener al menos 3 caracteres.';
            usernameError.style.display = 'block';
            hasError = true;
        } else if (username.length > 20) {
            usernameError.textContent = 'El usuario no puede exceder 20 caracteres.';
            usernameError.style.display = 'block';
            hasError = true;
        } else if (!usernameRegex.test(username)) {
            usernameError.textContent = 'El usuario solo puede contener letras, números, guiones y guiones bajos.';
            usernameError.style.display = 'block';
            hasError = true;
        }

        // Validar email
        const email = emailInput.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email) {
            emailError.textContent = 'El correo electrónico es requerido.';
            emailError.style.display = 'block';
            hasError = true;
        } else if (!emailRegex.test(email)) {
            emailError.textContent = 'Formato de correo electrónico inválido.';
            emailError.style.display = 'block';
            hasError = true;
        }

        if (hasError) {
            e.preventDefault();
            nombreInput.focus();
            return false;
        }

        // Si pasa validación, deshabilitar botón
        submitBtn.disabled = true;
        submitBtn.textContent = 'Guardando...';
    });
});
</script>
@endpush
