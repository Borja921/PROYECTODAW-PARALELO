@extends('layouts.app')

@section('title', 'Iniciar Sesión - MateCyL')

@push('styles')
<script async defer src="https://cdn.jsdelivr.net/npm/altcha/dist/altcha.min.js" type="module"></script>
@endpush

@section('content')
<section class="auth-section">
        <div class="auth-container">
            <div class="auth-card">
                <h1>Iniciar Sesión</h1>
                <p class="auth-subtitle">Accede a tu cuenta MateCyL</p>

                @if ($errors->any())
                    <div class="alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="loginForm" method="POST" action="{{ route('login.post') }}" class="auth-form" novalidate>
                    @csrf

                    <div class="form-group">
                        <label for="login">Nombre de usuario o correo</label>
                        <input id="login" name="login" type="text" required value="{{ old('login') }}" placeholder="usuario@ejemplo.com" minlength="3">
                        <div id="loginError" style="display:none;color:#dc3545;font-size:0.9rem;margin-top:0.3rem;"></div>
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input id="password" name="password" type="password" required placeholder="••••••••" minlength="1">
                        <div id="passwordError" style="display:none;color:#dc3545;font-size:0.9rem;margin-top:0.3rem;"></div>
                    </div>

                    <div class="form-group checkbox">
                        <label><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recuérdame</label>
                    </div>

                    <div class="form-group">
                        <label>Verificación</label>
                        <altcha-widget test></altcha-widget>
                    </div>

                    <button id="loginBtn" type="submit" class="btn-primary">Iniciar Sesión</button>

                    <div class="auth-footer">
                        <p>¿No tienes cuenta? <a href="{{ route('registro') }}">Regístrate aquí</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    const loginInput = document.getElementById('login');
    const passwordInput = document.getElementById('password');
    const loginBtn = document.getElementById('loginBtn');
    const loginError = document.getElementById('loginError');
    const passwordError = document.getElementById('passwordError');

    // Limpiar errores cuando el usuario escribe
    loginInput.addEventListener('input', () => {
        loginError.style.display = 'none';
        loginError.textContent = '';
    });
    passwordInput.addEventListener('input', () => {
        passwordError.style.display = 'none';
        passwordError.textContent = '';
    });

    // Validación al enviar
    form.addEventListener('submit', function(e) {
        let hasError = false;

        // Validar login (username o email)
        const login = loginInput.value.trim();
        if (!login || login.length < 3) {
            loginError.textContent = 'Ingresa tu usuario o correo (mín. 3 caracteres).';
            loginError.style.display = 'block';
            hasError = true;
        } else if (login.includes('@')) {
            // Si parece email, validar formato
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(login)) {
                loginError.textContent = 'Formato de correo inválido.';
                loginError.style.display = 'block';
                hasError = true;
            }
        }

        // Validar password
        const password = passwordInput.value;
        if (!password || password.length < 1) {
            passwordError.textContent = 'Ingresa tu contraseña.';
            passwordError.style.display = 'block';
            hasError = true;
        }

        if (hasError) {
            e.preventDefault();
            loginInput.focus();
            return false;
        }

        // Si pasa validación, deshabilitar botón para evitar double-submit
        loginBtn.disabled = true;
        loginBtn.textContent = 'Iniciando sesión...';
    });
});
</script>
@endpush
