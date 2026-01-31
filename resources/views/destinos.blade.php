<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explorar Destinos - TravelPlus</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">✈️ TravelPlus</div>
            <ul class="nav-links">
                <li><a href="{{ route('index') }}">Inicio</a></li>
                @auth
                    <li><a href="{{ route('destinos') }}" class="active">Destinos</a></li>
                    <li><a href="{{ route('planes') }}">Crear Plan</a></li>
                    <li><a href="{{ route('mis-planes') }}">Mis Planes</a></li>
                    <li><a href="{{ route('perfil') }}">Perfil</a></li>
                    <li><a href="{{ route('logout') }}">Cerrar Sesión</a></li>
                @else
                    <li><a href="#" onclick="showLoginModal()">Iniciar Sesión</a></li>
                    <li><a href="#" onclick="showRegisterModal()">Registrarse</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    <section class="explore-section">
        <div class="explore-header">
            <h1>¡Explora Castilla y León!</h1>
            <p>Descubre lugares increíbles para tus próximas vacaciones o escapda</p>
        </div>

        <div class="explore-filters">
            <select class="filter-select" id="selector-provincias">
                <option value="">Todas las provincias</option>
            </select>
        </div>

        <div class="destinations-grid">
            <!-- Provincias de Castilla y León desde la API -->
            <div id="provincias-cyl-grid" class="destinations-grid"></div>
            <script>
            document.addEventListener('DOMContentLoaded', async function() {
                const grid = document.getElementById('provincias-cyl-grid');
                const selector = document.getElementById('selector-provincias');
                let provincias = [];
                const colores = [
                    '#A89B9B', '#9D8B7E', '#C0B5AA', '#8B7B7B', '#D4CCC4', '#B7A99A', '#B2A59B', '#C7B7A3', '#A89B7B'
                ];
                try {
                    const res = await fetch('/api/municipios');
                    const data = await res.json();
                    provincias = Object.keys(data).sort();
                    // Rellenar selector de provincias
                    provincias.forEach(prov => {
                        const opt = document.createElement('option');
                        opt.value = prov;
                        opt.textContent = prov;
                        selector.appendChild(opt);
                    });
                    renderProvincias(provincias);
                } catch (e) {
                    grid.innerHTML = '<p style="color:red">No se pudieron cargar las provincias de Castilla y León.</p>';
                }
                selector.addEventListener('change', function() {
                    if (!selector.value) {
                        renderProvincias(provincias);
                    } else {
                        renderProvincias([selector.value]);
                    }
                });
                function renderProvincias(lista) {
                    let html = '';
                    lista.forEach((prov, idx) => {
                        html += `
                        <div class="destination-card">
                            <div class="destination-image" style="background: linear-gradient(135deg, ${colores[idx%colores.length]}, #9D8B7E);">
                                🏞️
                            </div>
                            <div class="destination-content">
                                <h3>${prov}</h3>
                                <p class="destination-subtitle">Castilla y León</p>
                                <p class="destination-desc">Descubre los mejores destinos de la provincia de ${prov}.</p>
                                <div class="destination-meta">
                                    <span>⭐ 4.8</span>
                                    <span>👥 +1000 visitantes</span>
                                </div>
                                <a href="{{ route('planes') }}?provincia=${encodeURIComponent(prov)}" class="btn-small">Explorar</a>
                            </div>
                        </div>
                        `;
                    });
                    grid.innerHTML = html;
                }
            });
            </script>
        </div>

        <h2 style="text-align: center; margin-bottom: 2rem; font-size: 2rem; color: var(--text-dark);">Mejores Valorados</h2>
        <div class="featured-section">
            <h3>Alojamientos</h3>
            <div class="featured-grid">
                <div class="featured-card">
                </div>
            </div>
        </div>

        <div class="featured-section">
            <h3>Museos</h3>
            <div class="featured-grid">
                <div class="featured-card">
                </div>
            </div>
        </div>

        <div class="featured-section">
            <h3>Restaurantes</h3>
            <div class="featured-grid">
                <div class="featured-card">
                </div>
            </div>
        </div>

        <div class="featured-section">
            <h3>Eventos y fiestas</h3>
            <div class="featured-grid">
                <div class="featured-card">
                </div>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 TravelPlus - Todos los derechos reservados</p>
    </footer>

    <!-- Modal de Login -->
    <div id="loginModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" onclick="closeLoginModal()">&times;</span>
            <h2>Iniciar Sesión</h2>
            
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

    <script src="{{ asset('js/script.js') }}"></script>
    
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
    </script>
</body>
</html>
