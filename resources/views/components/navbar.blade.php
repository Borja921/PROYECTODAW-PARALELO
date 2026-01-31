@props(['active' => ''])

<nav class="navbar">
    <div class="navbar-container">
        <div class="logo">✈️ TravelPlus</div>
        <ul class="nav-links">
            <li><a href="{{ route('index') }}" class="{{ $active === 'index' ? 'active' : '' }}">Inicio</a></li>
            @auth
                <li><a href="{{ route('destinos') }}" class="{{ $active === 'destinos' ? 'active' : '' }}">Destinos</a></li>
                <li><a href="{{ route('hoteles') }}" class="{{ $active === 'hoteles' ? 'active' : '' }}">Hoteles</a></li>
                <li><a href="{{ route('planes') }}" class="{{ $active === 'planes' ? 'active' : '' }}">Crear Plan</a></li>
                <li><a href="{{ route('mis-planes') }}" class="{{ $active === 'mis-planes' ? 'active' : '' }}">Mis Planes</a></li>
                <li><a href="{{ route('perfil') }}" class="{{ $active === 'perfil' ? 'active' : '' }}">Perfil</a></li>
                <li><a href="{{ route('logout') }}">Cerrar Sesión</a></li>
            @else
                <li><a href="#" onclick="showLoginModal()">Iniciar Sesión</a></li>
                <li><a href="#" onclick="showRegisterModal()">Registrarse</a></li>
            @endauth
        </ul>
    </div>
</nav>