@extends('layouts.app')

@section('title', 'Explorar Destinos - MateCyL')

@section('content')

    <section class="explore-section">
        <div class="explore-header">
            <h1>Explora Nuestros Destinos</h1>
            <p>Descubre lugares increíbles para tus próximas vacaciones</p>
        </div>



        <div class="destinations-grid">
            <!-- Ávila -->
            <div class="destination-card">
                <div class="destination-image" style="background: linear-gradient(135deg, #A89B9B, #9D8B7E);">
                    <img src="{{ asset('img/avila_imagen.jpg') }}" alt="Ávila" class="destination-photo">
                </div>
                <div class="destination-content">
                    <h3>Ávila</h3>
                    <p class="destination-subtitle">Castilla y León</p>
                    <p class="destination-desc">Murallas medievales, patrimonio histórico y arquitectura antigua</p>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 10px;">
                        <a href="{{ route('hoteles') }}?provincia=Ávila" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Hoteles</a>
                        <a href="{{ route('restaurantes') }}?provincia=Ávila" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Restaurantes</a>
                        <a href="{{ route('museos') }}?provincia=Ávila" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Museos</a>
                        <a href="{{ route('fiestas') }}?provincia=Ávila" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Fiestas</a>
                    </div>
                </div>
            </div>

            <!-- Burgos -->
            <div class="destination-card">
                <div class="destination-image" style="background: linear-gradient(135deg, #9D8B7E, #8B7B7B);">
                    <img src="{{ asset('img/burgos_imagen.jpg') }}" alt="Burgos" class="destination-photo">
                </div>
                <div class="destination-content">
                    <h3>Burgos</h3>
                    <p class="destination-subtitle">Castilla y León</p>
                    <p class="destination-desc">Catedral gótica, caminos de peregrinación y tradición medieval</p>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 10px;">
                        <a href="{{ route('hoteles') }}?provincia=Burgos" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Hoteles</a>
                        <a href="{{ route('restaurantes') }}?provincia=Burgos" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Restaurantes</a>
                        <a href="{{ route('museos') }}?provincia=Burgos" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Museos</a>
                        <a href="{{ route('fiestas') }}?provincia=Burgos" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Fiestas</a>
                    </div>
                </div>
            </div>

            <!-- León -->
            <div class="destination-card">
                <div class="destination-image" style="background: linear-gradient(135deg, #C0B5AA, #A89B9B);">
                    <img src="{{ asset('img/leon_imagen.jpg') }}" alt="León" class="destination-photo">
                </div>
                <div class="destination-content">
                    <h3>León</h3>
                    <p class="destination-subtitle">Castilla y León</p>
                    <p class="destination-desc">Camino de Santiago, basílica románica y rica historia medieval</p>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 10px;">
                        <a href="{{ route('hoteles') }}?provincia=León" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Hoteles</a>
                        <a href="{{ route('restaurantes') }}?provincia=León" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Restaurantes</a>
                        <a href="{{ route('museos') }}?provincia=León" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Museos</a>
                        <a href="{{ route('fiestas') }}?provincia=León" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Fiestas</a>
                    </div>
                </div>
            </div>

            <!-- Palencia -->
            <div class="destination-card">
                <div class="destination-image" style="background: linear-gradient(135deg, #8B7B7B, #D4CCC4);">
                    <img src="{{ asset('img/palencia_imagen.jpg') }}" alt="Palencia" class="destination-photo">
                </div>
                <div class="destination-content">
                    <h3>Palencia</h3>
                    <p class="destination-subtitle">Castilla y León</p>
                    <p class="destination-desc">Catedral románica, paisajes rurales y patrimonio agrario</p>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 10px;">
                        <a href="{{ route('hoteles') }}?provincia=Palencia" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Hoteles</a>
                        <a href="{{ route('restaurantes') }}?provincia=Palencia" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Restaurantes</a>
                        <a href="{{ route('museos') }}?provincia=Palencia" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Museos</a>
                        <a href="{{ route('fiestas') }}?provincia=Palencia" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Fiestas</a>
                    </div>
                </div>
            </div>

            <!-- Segovia -->
            <div class="destination-card">
                <div class="destination-image" style="background: linear-gradient(135deg, #A89B9B, #C0B5AA);">
                    <img src="{{ asset('img/segovia_imagen.jpg') }}" alt="Segovia" class="destination-photo">
                </div>
                <div class="destination-content">
                    <h3>Segovia</h3>
                    <p class="destination-subtitle">Castilla y León</p>
                    <p class="destination-desc">Alcázar de cuento de hadas, acueducto romano y gastronomía</p>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 10px;">
                        <a href="{{ route('hoteles') }}?provincia=Segovia" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Hoteles</a>
                        <a href="{{ route('restaurantes') }}?provincia=Segovia" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Restaurantes</a>
                        <a href="{{ route('museos') }}?provincia=Segovia" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Museos</a>
                        <a href="{{ route('fiestas') }}?provincia=Segovia" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Fiestas</a>
                    </div>
                </div>
            </div>

            <!-- Soria -->
            <div class="destination-card">
                <div class="destination-image" style="background: linear-gradient(135deg, #9D8B7E, #A89B9B);">
                    <img src="{{ asset('img/soria_imagen.jpg') }}" alt="Soria" class="destination-photo">
                </div>
                <div class="destination-content">
                    <h3>Soria</h3>
                    <p class="destination-subtitle">Castilla y León</p>
                    <p class="destination-desc">Naturaleza salvaje, monasterio de San Juan de Duero</p>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 10px;">
                        <a href="{{ route('hoteles') }}?provincia=Soria" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Hoteles</a>
                        <a href="{{ route('restaurantes') }}?provincia=Soria" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Restaurantes</a>
                        <a href="{{ route('museos') }}?provincia=Soria" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Museos</a>
                        <a href="{{ route('fiestas') }}?provincia=Soria" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Fiestas</a>
                    </div>
                </div>
            </div>

            <!-- Valladolid -->
            <div class="destination-card">
                <div class="destination-image" style="background: linear-gradient(135deg, #C0B5AA, #9D8B7E);">
                    <img src="{{ asset('img/valladolid_imagen.jpg') }}" alt="Valladolid" class="destination-photo">
                </div>
                <div class="destination-content">
                    <h3>Valladolid</h3>
                    <p class="destination-subtitle">Castilla y León</p>
                    <p class="destination-desc">Capital cultural, museos excepcionales y vida urbana moderna</p>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 10px;">
                        <a href="{{ route('hoteles') }}?provincia=Valladolid" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Hoteles</a>
                        <a href="{{ route('restaurantes') }}?provincia=Valladolid" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Restaurantes</a>
                        <a href="{{ route('museos') }}?provincia=Valladolid" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Museos</a>
                        <a href="{{ route('fiestas') }}?provincia=Valladolid" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Fiestas</a>
                    </div>
                </div>
            </div>

            <!-- Zamora -->
            <div class="destination-card">
                <div class="destination-image" style="background: linear-gradient(135deg, #8B7B7B, #A89B9B);">
                    <img src="{{ asset('img/zamora_imagen.jpg') }}" alt="Zamora" class="destination-photo">
                </div>
                <div class="destination-content">
                    <h3>Zamora</h3>
                    <p class="destination-subtitle">Castilla y León</p>
                    <p class="destination-desc">Catedral románica, fortaleza histórica y tradición medieval</p>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 10px;">
                        <a href="{{ route('hoteles') }}?provincia=Zamora" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Hoteles</a>
                        <a href="{{ route('restaurantes') }}?provincia=Zamora" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Restaurantes</a>
                        <a href="{{ route('museos') }}?provincia=Zamora" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Museos</a>
                        <a href="{{ route('fiestas') }}?provincia=Zamora" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Fiestas</a>
                    </div>
                </div>
            </div>

            <!-- Salamanca -->
            <div class="destination-card">
                <div class="destination-image" style="background: linear-gradient(135deg, #D4CCC4, #A89B9B);">
                    <img src="{{ asset('img/salamanca_imagen.jpg') }}" alt="Salamanca" class="destination-photo">
                </div>
                <div class="destination-content">
                    <h3>Salamanca</h3>
                    <p class="destination-subtitle">Castilla y León</p>
                    <p class="destination-desc">Universidad histórica, Plaza Mayor dorada y arquitectura renacentista</p>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 10px;">
                        <a href="{{ route('hoteles') }}?provincia=Salamanca" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Hoteles</a>
                        <a href="{{ route('restaurantes') }}?provincia=Salamanca" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Restaurantes</a>
                        <a href="{{ route('museos') }}?provincia=Salamanca" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Museos</a>
                        <a href="{{ route('fiestas') }}?provincia=Salamanca" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Fiestas</a>
                    </div>
                </div>
            </div>
        </div>


    </section>
@endsection
