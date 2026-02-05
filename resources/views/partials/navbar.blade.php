<nav class="navbar">
    <div class="navbar-container">
        <div class="logo">✈️ MateCyL</div>
        <div class="hamburger" id="hamburger" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <ul class="nav-links" id="navLinks">
            <li><a href="{{ route('index') }}">Inicio</a></li>
            <li><a href="{{ route('destinos') }}">Destinos</a></li>
            @auth
                <li><a href="{{ route('planes') }}">Crear Plan</a></li>
                <li><a href="{{ route('mis-planes') }}">Mis Planes</a></li>
                <li><a href="{{ route('perfil') }}">Perfil</a></li>
                <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            @else
                <li><a href="#" onclick="openLoginModal(event)">Crear Plan</a></li>
                <li><a href="#" onclick="openLoginModal(event)">Mis Planes</a></li>
                <li><a href="#" onclick="openLoginModal(event)">Perfil</a></li>
                <li><a href="#" onclick="openLoginModal(event)">Iniciar Sesión</a></li>
            @endauth
        </ul>
    </div>
    <div class="mobile-menu" id="mobileMenu">
        <a href="{{ route('index') }}">Inicio</a>
        <a href="{{ route('destinos') }}">Destinos</a>
        @auth
            <a href="{{ route('planes') }}">Crear Plan</a>
            <a href="{{ route('mis-planes') }}">Mis Planes</a>
            <a href="{{ route('perfil') }}">Perfil</a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">Cerrar Sesión</a>
            <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        @else
            <a href="#" onclick="event.preventDefault(); openLoginModal(event); toggleMenu();">Crear Plan</a>
            <a href="#" onclick="event.preventDefault(); openLoginModal(event); toggleMenu();">Mis Planes</a>
            <a href="#" onclick="event.preventDefault(); openLoginModal(event); toggleMenu();">Perfil</a>
            <a href="#" onclick="event.preventDefault(); openLoginModal(event); toggleMenu();">Iniciar Sesión</a>
        @endauth
    </div>
</nav>
