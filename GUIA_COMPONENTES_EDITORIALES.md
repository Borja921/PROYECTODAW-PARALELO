# 🚀 Guía de Uso - Nuevos Componentes Editoriales

## Estructura HTML de Heroes Épicos

Cada vista principal ahora sigue este patrón:

### Patrón Hero Estándar

```blade
<!-- HERO ESPECÍFICO -->
<section class="hero-[tipo]">
    <div class="hero-[tipo]-content">
        <span class="hero-label">[CATEGORÍA]</span>
        <h1>[TÍTULO PRINCIPAL]</h1>
        <p>[Subtítulo descriptivo]</p>
        <!-- Opcional: CTA buttons -->
        <div class="hero-cta">
            <a href="#" class="btn-primary btn-lg">ACCIÓN PRIMARIA</a>
            <a href="#" class="btn-secondary btn-lg">ACCIÓN SECUNDARIA</a>
        </div>
    </div>
</section>
```

### Tipos de Heroes Implementados

```
hero-epic           → index.blade.php (Landing Page)
hero-destinations   → destinos.blade.php
hero-hotels        → hoteles.blade.php
hero-restaurants   → restaurantes.blade.php
hero-museums       → museos.blade.php
hero-festivals     → fiestas.blade.php
```

---

## Estructura de Features Editoriales

```blade
<section class="features-editorial" id="features">
    <div class="features-container">
        <div class="features-header">
            <h2>SECCIÓN PRINCIPAL</h2>
            <p>Descripción breve</p>
        </div>

        <div class="features-grid-4">
            <article class="feature-editorial">
                <div class="feature-icon-box">🎨</div>
                <h3>TÍTULO Feature</h3>
                <p>Descripción corta del feature</p>
            </article>
            <!-- Repetir para cada feature -->
        </div>
    </div>
</section>
```

---

## Estructura de Highlights

```blade
<section class="highlights-section">
    <div class="highlights-container">
        <h2>SECCIÓN DE HIGHLIGHTS</h2>
        
        <div class="highlights-grid">
            <article class="highlight-card">
                <div class="highlight-number">01</div>
                <h3>Título</h3>
                <p>Descripción del highlight</p>
            </article>
            <!-- Repetir para cada highlight -->
        </div>
    </div>
</section>
```

---

## Clases CSS Disponibles

### Buttons

```css
.btn-primary        /* Botón rojo/amarillo gradient */
.btn-secondary      /* Botón outline amarillo */
.btn-lg             /* Tamaño grande (1.25rem padding) */
.btn-xl             /* Tamaño extra large (1.5rem padding) */
```

**Ejemplo**:
```blade
<a href="#" class="btn-primary btn-lg">EXPLORAR AHORA</a>
<a href="#" class="btn-secondary btn-lg">CONOCER MÁS</a>
```

### Typography

```css
.hero-label         /* Label pequeño con border */
.hero-title         /* Título hero principal */
.hero-subtitle      /* Subtítulo hero */
```

### Containers

```css
.features-container    /* Ancho máx 1280px */
.hotels-container      /* Ancho máx 1200px */
.destinations-container
.highlights-container
```

---

## Colores y Gradients Disponibles

### Variables CSS (Root)

```css
--primary: #C8102E           (Rojo Castilla y León)
--secondary: #F2C200         (Amarillo dorado)
--ink: #0B0B0F              (Negro profundo)
--ink-2: #14141A            (Negro menos profundo)

--gradient-primary: linear-gradient(135deg, #C8102E 0%, #E33A52 100%)
--gradient-secondary: linear-gradient(135deg, #F2C200 0%, #FFD45A 100%)
--gradient-accent: linear-gradient(135deg, #C8102E 0%, #F2C200 100%)
```

### Uso en CSS Personalizado

```css
.mi-elemento {
    background: var(--gradient-primary);
    color: var(--secondary);
    border: 1px solid rgba(242, 194, 0, 0.25);
}
```

---

## Animaciones Disponibles

### Fade In Down
```css
animation: fadeInDown 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
```
*Útil para títulos y elementos superiores*

### Fade In Up
```css
animation: fadeInUp 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
```
*Útil para botones y elementos inferiores*

### Slide In Up
```css
animation: slideInUp 1s cubic-bezier(0.34, 1.56, 0.64, 1);
```
*Usada en heroes para movimiento suave*

### Float Background
```css
animation: floatBg 20s ease-in-out infinite;
```
*Usada para elementos decorativos de fondo*

---

## Responsive Breakpoints

### Desktop (> 1100px)
- Tamaños completos
- Grids multi-columna
- Padding generoso

### Tablet (768px - 1100px)
- Tamaños reducidos
- Grids 2 columnas
- Padding moderado

```css
@media (max-width: 768px) {
    .hero-epic { min-height: 70vh; }
    .features-grid-4 { grid-template-columns: 1fr; }
}
```

### Mobile (< 480px)
- Tamaños mínimos
- Grids 1 columna
- Botones fullwidth

```css
@media (max-width: 480px) {
    .btn-lg { width: 100%; max-width: 300px; }
    .features-grid-4 { grid-template-columns: 1fr; }
}
```

---

## Ejemplos de Customización

### Cambiar el Label de un Hero

```blade
<!-- Antes -->
<span class="hero-label">ALOJAMIENTOS</span>

<!-- Después -->
<span class="hero-label">MI CATEGORÍA CUSTOM</span>
```

### Agregar Feature Editorial Adicional

```blade
<article class="feature-editorial">
    <div class="feature-icon-box">🌟</div>
    <h3>MI FEATURE</h3>
    <p>Descripción de mi feature personalizado</p>
</article>
```

### Crear Highlight Personalizado

```blade
<article class="highlight-card">
    <div class="highlight-number">05</div>
    <h3>Mi Highlight</h3>
    <p>Descripción con datos relevantes</p>
</article>
```

---

## Patrones de Hover

### Feature Editorial
```css
.feature-editorial:hover {
    border-color: #F2C200;          /* Borde amarillo */
    transform: translateY(-8px);    /* Sube 8px */
    box-shadow: ...;                /* Sombra aumenta */
}
```

### Highlight Card
```css
.highlight-card:hover {
    border-color: #F2C200;          /* Borde amarillo */
    transform: translateY(-12px);   /* Sube 12px */
    box-shadow: ...;
}
```

---

## Mejores Prácticas

### 1. Tipografía
- ✅ Usar UPPERCASE para títulos
- ✅ Letter-spacing: 0.5px a 1.5px
- ✅ Fuente: Inter (Google Fonts)

### 2. Espaciado
- ✅ Gap grid: 2-2.5rem
- ✅ Padding container: 6rem 2rem
- ✅ Margin secciones: 8rem auto

### 3. Colores
- ✅ Fondo oscuro: rgba(11, 11, 15, 0.92)
- ✅ Borde: rgba(242, 194, 0, 0.25)
- ✅ Texto: rgba(255, 255, 255, 0.85)

### 4. Animaciones
- ✅ Transiciones: 0.3-0.4s
- ✅ Easing: cubic-bezier personalizado
- ✅ GPU-aceleradas con transform

### 5. Accesibilidad
- ✅ Contraste texto/fondo ≥ 4.5:1
- ✅ Font-size mínimo: 0.95rem
- ✅ Line-height: 1.6+

---

## Troubleshooting

### Hero no aparece correctamente
```bash
# Verificar:
1. Clase section: class="hero-[tipo]"
2. Contenido wrapper: class="hero-[tipo]-content"
3. CSS cargado: <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
```

### Features no están en grid
```bash
# Verificar:
1. Contenedor: <div class="features-grid-4">
2. Items: <article class="feature-editorial">
3. Media query activa (revisar ancho viewport)
```

### Botones no responden a hover
```bash
# Verificar:
1. Clase correcta: class="btn-primary btn-lg"
2. Link válido: href="#" o href="{{ route(...) }}"
3. Z-index: puede estar debajo de otro elemento
```

---

## Referencias Externas

- [Google Fonts Inter](https://fonts.google.com/specimen/Inter)
- [CSS Gradients](https://developer.mozilla.org/en-US/docs/Web/CSS/gradient)
- [Cubic Bezier](https://cubic-bezier.com/)

---

**Última actualización**: Febrero 2026
**Versión**: 1.0
**Autor**: GitHub Copilot
