@extends('layouts.app')

@section('title', 'MateCyL - Planifica tus viajes')

@section('content')
<!-- Sección: Qué es MateCyL -->
<section class="about-section">
    <div class="about-container">
        <h1>Descubre Castilla y León como nunca antes</h1>
        <p class="about-lead">
            MateCyL es tu compañero perfecto para explorar los rincones más fascinantes de Castilla y León.
            Creamos itinerarios personalizados que te conectan con el patrimonio histórico, la gastronomía excepcional
            y las experiencias únicas que solo esta tierra milenaria puede ofrecer.
        </p>
        <div class="about-highlights">
            <div class="highlight-item">
                <img src="{{ asset('/img/alcazar_imagen.jpg') }}" alt="Patrimonio Mundial" class="highlight-image">
                <h3>Patrimonio Mundial</h3>
                <p>Castillos, catedrales y monumentos declarados Patrimonio de la Humanidad te esperan en cada provincia</p>
            </div>
            <div class="highlight-item">
                <img src="{{ asset('img/vinos_imagen.jpg') }}" alt="Gastronomía de Excelencia" class="highlight-image">
                <h3>Gastronomía de Excelencia</h3>
                <p>Degusta los mejores vinos de Ribera del Duero, el lechazo asado y productos con Denominación de Origen</p>
            </div>
            <div class="highlight-item">
                <img src="{{ asset('img/parque_imagen.jpg') }}" alt="Naturaleza Virgen" class="highlight-image">
                <h3>Naturaleza Virgen</h3>
                <p>Desde los Picos de Europa hasta las Hoces del Duratón, paisajes que te dejarán sin aliento. Adelante ;)</p>
            </div>
        </div>
    </div>
</section>

<!-- Sección: Por qué usar MateCyL -->
<section class="features">
    <h2>¿Por qué usar MateCyL?</h2>
    <div class="features-grid">
        <div class="feature-card">
            <img src="{{ asset('img/hotel_imagen.jpg') }}" alt="Hoteles" class="feature-image">
            <h3>Hoteles</h3>
            <p>Encuentra los mejores hospedajes en cualquier destino</p>
        </div>
        <div class="feature-card">
            <img src="{{ asset('img/comida_imagen.jpg') }}" alt="Restaurantes" class="feature-image">
            <h3>Restaurantes</h3>
            <p>Descubre la gastronomía local de cada región</p>
        </div>
        <div class="feature-card">
            <img src="{{ asset('img/museo_imagen.jpg') }}" alt="Museos" class="feature-image">
            <h3>Museos</h3>
            <p>Explora la cultura y arte de cada lugar</p>
        </div>
        <div class="feature-card">
            <img src="{{ asset('img/fiesta_imagen.jpg') }}" alt="Eventos y fiestas locales" class="feature-image">
            <h3>Eventos y fiestas locales</h3>
            <p>Disfruta de eventos y fiestas locales de cada localidad</p>
        </div>
    </div>
</section>

<!-- Sección: Descubre tu próximo destino -->
<section class="hero">
    <div class="hero-content">
        <h1>Descubre tu próximo destino</h1>
        <p>Planifica viajes inolvidables por Castilla y León en minutos</p>
        <a href="{{ route('destinos') }}" class="btn-primary">Explorar Destinos</a>
    </div>
</section>
@endsection
