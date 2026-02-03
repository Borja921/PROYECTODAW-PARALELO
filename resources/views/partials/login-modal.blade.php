<!-- Modal de Login -->
@guest
<script async defer src="https://cdn.jsdelivr.net/npm/altcha/dist/altcha.min.js" type="module"></script>
<div id="loginModal" class="modal-overlay">
    <div class="modal-content">
        <button class="modal-close" onclick="closeLoginModal()">&times;</button>
        
        <!-- Tabs -->
        <div class="auth-tabs">
            <button class="auth-tab active" onclick="switchTab('login')">Iniciar Sesión</button>
            <button class="auth-tab" onclick="switchTab('registro')">Registrarse</button>
        </div>

        <!-- Formulario de Login -->
        <div id="loginForm" class="auth-tab-content active">
            <h2>Bienvenido</h2>
            <p class="auth-subtitle">Accede a tu cuenta TravelPlus</p>

            @if ($errors->any())
                <div class="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="auth-form">
                @csrf

                <div class="form-group">
                    <label for="login">Nombre de usuario o correo</label>
                    <input id="login" name="login" type="text" required value="{{ old('login') }}" placeholder="usuario@ejemplo.com">
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input id="password" name="password" type="password" required placeholder="••••••••">
                </div>

                <div class="form-group checkbox">
                    <label><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recuérdame</label>
                </div>

                <div class="form-group">
                    <label>Verificación</label>
                    <altcha-widget test></altcha-widget>
                </div>

                <button type="submit" class="btn-primary">Iniciar Sesión</button>
            </form>
        </div>

        <!-- Formulario de Registro -->
        <div id="registroForm" class="auth-tab-content">
            <h2>Crear Cuenta</h2>
            <p class="auth-subtitle">Únete a TravelPlus</p>

            <form method="POST" action="{{ route('registro.store') }}" class="auth-form">
                @csrf

                <h3>Datos personales</h3>
                <div class="form-group">
                    <label for="nombre_apellidos">Nombre y apellido</label>
                    <input id="nombre_apellidos" name="nombre_apellidos" type="text" required value="{{ old('nombre_apellidos') }}" placeholder="Juan García">
                </div>

                <div class="form-group">
                    <label for="username">Nombre de usuario</label>
                    <input id="username" name="username" type="text" required value="{{ old('username') }}" placeholder="juangarcia">
                </div>

                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input id="email" name="email" type="email" required value="{{ old('email') }}" placeholder="juan@ejemplo.com">
                </div>

                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de nacimiento</label>
                    <input id="fecha_nacimiento" name="fecha_nacimiento" type="date" required value="{{ old('fecha_nacimiento') }}">
                </div>

                <h3>Preferencias de viaje</h3>
                <div class="form-group">
                    <label for="hospedaje_favorito">Hospedaje favorito</label>
                    <select id="hospedaje_favorito" name="hospedaje_favorito" required>
                        <option value="">Selecciona una opción</option>
                        <option value="hotel">Hotel</option>
                        <option value="apartamento">Apartamento</option>
                        <option value="hostal">Hostal</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tipo_comida">Tipo de comida</label>
                    <select id="tipo_comida" name="tipo_comida" required>
                        <option value="">Selecciona una opción</option>
                        <option value="tradicional">Tradicional</option>
                        <option value="internacional">Internacional</option>
                        <option value="vegetariana">Vegetariana</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="actividades">Actividades</label>
                    <select id="actividades" name="actividades" required>
                        <option value="">Selecciona una opción</option>
                        <option value="museos">Museos</option>
                        <option value="naturaleza">Naturaleza</option>
                        <option value="aventura">Aventura</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tipo_viaje">Tipo de viaje</label>
                    <select id="tipo_viaje" name="tipo_viaje" required>
                        <option value="">Selecciona una opción</option>
                        <option value="pareja">En pareja</option>
                        <option value="familia">En familia</option>
                        <option value="amigos">Con amigos</option>
                    </select>
                </div>

                <h3>Seguridad</h3>
                <div class="form-group">
                    <label for="reg_password">Contraseña</label>
                    <input id="reg_password" name="password" type="password" required placeholder="••••••••">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required placeholder="••••••••">
                </div>

                <div class="form-group">
                    <label>Verificación</label>
                    <altcha-widget test></altcha-widget>
                </div>

                <button type="submit" class="btn-primary">Crear Cuenta</button>
            </form>
        </div>
    </div>
</div>
@endguest
