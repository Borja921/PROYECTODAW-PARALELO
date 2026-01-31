<!-- Modal de Login -->
<div id="loginModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeLoginModal()">&times;</span>
        <h2>Iniciar Sesión</h2>
        
        @if(session('showLoginModal'))
            <div class="alert alert-info" style="background-color: #d1ecf1; color: #0c5460; padding: 10px; margin: 10px 0; border: 1px solid #bee5eb; border-radius: 4px;">
                Debes iniciar sesión para acceder a tu perfil
            </div>
        @endif

        @if($errors->has('login'))
            <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 10px; margin: 10px 0; border: 1px solid #f5c6cb; border-radius: 4px;">
                {{ $errors->first('login') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" id="loginForm">
            @csrf
            <input type="hidden" name="redirect_to" id="redirect_to" value="">
            <div class="form-group">
                <label for="login">Nombre de usuario o correo</label>
                <input id="login" name="login" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input id="password" name="password" type="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label><input type="checkbox" name="remember"> Recuérdame</label>
            </div>
            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
        
        <p style="margin-top: 15px;">¿No tienes cuenta? <a href="#" onclick="switchToRegister()">Regístrate aquí</a></p>
    </div>
</div>

<!-- Modal de Registro -->
<div id="registerModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeRegisterModal()">&times;</span>
        <h2>Registrarse</h2>
        
        @if($errors->any() && !$errors->has('login'))
            <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 10px; margin: 10px 0; border: 1px solid #f5c6cb; border-radius: 4px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form method="POST" action="{{ route('registro.store') }}" id="registerForm">
            @csrf
            <div class="form-group">
                <label for="reg_nombre_apellidos">Nombre completo</label>
                <input id="reg_nombre_apellidos" name="nombre_apellidos" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="reg_username">Nombre de usuario</label>
                <input id="reg_username" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="reg_email">Correo electrónico</label>
                <input id="reg_email" name="email" type="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="reg_fecha_nacimiento">Fecha de nacimiento</label>
                <input id="reg_fecha_nacimiento" name="fecha_nacimiento" type="date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="reg_password">Contraseña</label>
                <input id="reg_password" name="password" type="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="reg_password_confirmation">Confirmar contraseña</label>
                <input id="reg_password_confirmation" name="password_confirmation" type="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrarse</button>
        </form>
        
        <p style="margin-top: 15px;">¿Ya tienes cuenta? <a href="#" onclick="switchToLogin()">Inicia sesión aquí</a></p>
    </div>
</div>

<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
    }
    
    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 30px;
        border: none;
        border-radius: 10px;
        width: 90%;
        max-width: 400px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.2);
        position: relative;
        animation: modalFadeIn 0.3s;
    }
    
    @keyframes modalFadeIn {
        from { transform: translateY(-40px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        position: absolute;
        top: 10px;
        right: 20px;
        cursor: pointer;
    }
    
    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
    }
    
    .form-group {
        margin-bottom: 15px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    
    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        box-sizing: border-box;
    }
    
    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-primary {
        background-color: #007bff;
        color: white;
        width: 100%;
    }
    
    .btn-primary:hover {
        background-color: #0056b3;
    }
    
    .alert {
        padding: 10px;
        margin: 10px 0;
        border-radius: 4px;
    }
    
    .alert-info {
        background-color: #d1ecf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>

<script>
    function showLoginModal(redirectTo = '') {
        document.getElementById('loginModal').style.display = 'block';
        document.getElementById('redirect_to').value = redirectTo;
    }
    
    function closeLoginModal() {
        document.getElementById('loginModal').style.display = 'none';
        document.getElementById('redirect_to').value = '';
    }
    
    function showRegisterModal() {
        document.getElementById('registerModal').style.display = 'block';
    }
    
    function closeRegisterModal() {
        document.getElementById('registerModal').style.display = 'none';
    }
    
    function switchToRegister() {
        closeLoginModal();
        showRegisterModal();
    }
    
    function switchToLogin() {
        closeRegisterModal();
        showLoginModal();
    }
    
    // Cerrar modal al hacer click fuera del contenido
    window.onclick = function(event) {
        var loginModal = document.getElementById('loginModal');
        var registerModal = document.getElementById('registerModal');
        
        if (event.target === loginModal) {
            closeLoginModal();
        }
        if (event.target === registerModal) {
            closeRegisterModal();
        }
    }
    
    // Mostrar modal de login automáticamente si viene de perfil sin autenticar
    @if(session('showLoginModal'))
        document.addEventListener('DOMContentLoaded', function() {
            showLoginModal();
        });
    @endif

    // Mostrar modal de registro automáticamente si viene de la ruta /registro
    @if(session('showRegisterModal'))
        document.addEventListener('DOMContentLoaded', function() {
            showRegisterModal();
        });
    @endif

    // Mostrar modal de login si hay errores de login
    @if($errors->has('login'))
        document.addEventListener('DOMContentLoaded', function() {
            showLoginModal();
        });
    @endif

    // Mostrar modal de registro si hay errores de registro
    @if($errors->any() && !$errors->has('login'))
        document.addEventListener('DOMContentLoaded', function() {
            showRegisterModal();
        });
    @endif
</script>