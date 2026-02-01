// ============================================
// FUNCIONES PRINCIPALES
// ============================================

/**
 * Filtra y muestra los destinos según la provincia y duración seleccionadas
 */
function filtrarDestinos() {
    const provinciaEl = document.getElementById('provincia');
    const provincia = provinciaEl ? provinciaEl.value : '';
    const startDate = document.getElementById('start_date') ? document.getElementById('start_date').value : '';
    const endDate = document.getElementById('end_date') ? document.getElementById('end_date').value : '';
    const resultados = document.getElementById('resultados');

    // Si la vista no tiene el contenedor de resultados o el select de provincia, salir silenciosamente
    if (!resultados || !provinciaEl) return;

    // Limpiar resultados previos
    resultados.innerHTML = '';

    // Validar selección: se requiere provincia y un rango de fechas completo
    if (!provincia || !(startDate && endDate)) {
        resultados.innerHTML = '<p class="placeholder-text">Por favor, selecciona una provincia y un rango de fechas (inicio y fin)</p>';
        return;
    }

    if ((startDate && !endDate) || (!startDate && endDate)) {
        resultados.innerHTML = '<p class="placeholder-text">Si seleccionas fechas, debes indicar fecha de inicio y fin.</p>';
        return;
    }

    let computedDays = null;
    if (startDate && endDate) {
        const s = new Date(startDate);
        const e = new Date(endDate);
        if (isNaN(s.getTime()) || isNaN(e.getTime())) {
            resultados.innerHTML = '<p class="placeholder-text">Formato de fecha inválido.</p>';
            return;
        }
        if (s > e) {
            resultados.innerHTML = '<p class="placeholder-text">La fecha de inicio no puede ser posterior a la fecha de fin.</p>';
            return;
        }
        computedDays = Math.round((e - s) / (24 * 60 * 60 * 1000)) + 1; // inclusive
    }

    // Obtener destinos de la provincia seleccionada
    const destinosSeleccionados = destinos[provincia];

    if (!destinosSeleccionados) {
        resultados.innerHTML = '<p class="placeholder-text">No hay destinos disponibles para esta provincia</p>';
        return;
    }


    // Crear tarjetas para cada tipo de atracción
    const fragmento = document.createDocumentFragment();

    // Wrap defensivo para evitar que un error no capturado bloquee la página
    // (Adicionalmente, al final del archivo envolvemos la función para capturar excepciones no previstas.)

    // Hoteles
    if (destinosSeleccionados.hoteles && destinosSeleccionados.hoteles.length > 0) {
        destinosSeleccionados.hoteles.forEach(hotel => {
            fragmento.appendChild(crearTarjetaDestino(hotel, computedDays));
        });
    }

    // Restaurantes
    if (destinosSeleccionados.restaurantes && destinosSeleccionados.restaurantes.length > 0) {
        destinosSeleccionados.restaurantes.forEach(restaurante => {
            fragmento.appendChild(crearTarjetaDestino(restaurante, computedDays));
        });
    }

    // Museos
    if (destinosSeleccionados.museos && destinosSeleccionados.museos.length > 0) {
        destinosSeleccionados.museos.forEach(museo => {
            fragmento.appendChild(crearTarjetaDestino(museo, computedDays));
        });
    }

    // Atracciones
    if (destinosSeleccionados.atracciones && destinosSeleccionados.atracciones.length > 0) {
        destinosSeleccionados.atracciones.forEach(atraccion => {
            fragmento.appendChild(crearTarjetaDestino(atraccion, computedDays));
        });
    }

    resultados.appendChild(fragmento);
}

/**
 * Crea una tarjeta HTML para mostrar un destino
 */
function crearTarjetaDestino(destino, dias) {
    const card = document.createElement('div');
    card.className = 'resultado-card';

    // Determinar el color del header según el tipo
    let colorGradient = 'linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%)';

    const iconoTipo = getIconoTipo(destino.tipo);

    card.innerHTML = `
        <div class="resultado-header" style="background: ${colorGradient}">
            <div class="resultado-tipo">${iconoTipo} ${destino.tipo}</div>
            <h3 class="resultado-nombre">${destino.nombre}</h3>
        </div>
        <div class="resultado-body">
            <div class="resultado-ubicacion">
                📍 ${destino.ubicacion}
            </div>
            <p class="resultado-descripcion">${destino.descripcion}</p>
            <div class="resultado-rating">
                <span class="resultado-stars">${generarEstrellas(destino.rating)}</span>
                <span>${destino.rating.toFixed(1)}/5.0</span>
            </div>
            <div class="resultado-footer">
                <span class="resultado-precio">${destino.precio}</span>
                <button class="btn-small" onclick="agregarAlPlan('${destino.nombre}', '${dias}')">
                    ➕ Agregar
                </button>
            </div>
        </div>
    `;

    return card;
}

/**
 * Retorna el ícono según el tipo de destino
 */
function getIconoTipo(tipo) {
    const iconos = {
        'Hotel': '🏨',
        'Restaurante': '🍽️',
        'Museo': '🎨',
        'Atracción': '🎪'
    };
    return iconos[tipo] || '📍';
}

// Wrapper defensivo para filtrarDestinos: captura excepciones y evita que errores no controlados rompan la UX
if (typeof filtrarDestinos === 'function') {
    const _origFiltrar = filtrarDestinos;
    window.filtrarDestinos = function () {
        try {
            return _origFiltrar.apply(this, arguments);
        } catch (err) {
            console.warn('filtrarDestinos fallo capturado:', err);
            const resultados = document.getElementById('resultados');
            if (resultados) {
                resultados.innerHTML = '<p class="placeholder-text">No se han podido cargar los destinos en este momento. Intenta recargar la página.</p>';
            }
            return null;
        }
    };
}

/**
 * Genera las estrellas de rating
 */
function generarEstrellas(rating) {
    const estrellas = Math.round(rating);
    return '⭐'.repeat(estrellas);
}

/**
 * Agrega un destino al plan y lo guarda en localStorage
 */
function agregarAlPlan(nombre, dias) {
    try {
        const key = 'current_plan_items_v1';
        const raw = localStorage.getItem(key);
        const arr = raw ? JSON.parse(raw) : [];
        arr.push({ nombre, dias, added_at: new Date().toISOString() });
        localStorage.setItem(key, JSON.stringify(arr));

        // Notificar al usuario
        alert(`✅ "${nombre}" ha sido agregado a tu plan. Duración: ${dias} día(s)`);

        // habilitar botón de guardar si procede
        updateSaveButtonState();
    } catch (e) {
        console.warn('Error guardando item en plan:', e);
        alert('Error al agregar al plan. Inténtalo de nuevo.');
    }
}

function updateSaveButtonState() {
    const btn = document.getElementById('savePlanBtn');
    const wizardBtn = document.getElementById('wizardNextBtn');
    const provEl = document.getElementById('provincia');
    const munEl = document.getElementById('municipio');
    const start = document.getElementById('start_date') ? document.getElementById('start_date').value : '';
    const end = document.getElementById('end_date') ? document.getElementById('end_date').value : '';
    const prov = provEl ? provEl.value : '';
    const mun = munEl ? munEl.value : '';
    const items = JSON.parse(localStorage.getItem('current_plan_items_v1') || '[]');
    if (btn) {
        btn.disabled = !(prov && mun && start && end && items.length > 0);
    }
    if (wizardBtn) {
        // Para avanzar en el wizard solo necesitamos tener provincia/municipio y fechas
        wizardBtn.disabled = !(prov && mun && start && end);
    }
}

// Al cargar la página, sincronizar estado del botón
window.addEventListener('DOMContentLoaded', function () {
    updateSaveButtonState();

    const saveForm = document.getElementById('savePlanForm');
    if (saveForm) {
        saveForm.addEventListener('submit', function (e) {
            // Rellenar inputs hidden antes de enviar
            const prov = document.getElementById('provincia') ? document.getElementById('provincia').value : '';
            const mun = document.getElementById('municipio') ? document.getElementById('municipio').value : '';
            const start = document.getElementById('start_date') ? document.getElementById('start_date').value : '';
            const end = document.getElementById('end_date') ? document.getElementById('end_date').value : '';
            const items = localStorage.getItem('current_plan_items_v1') || '[]';

            document.getElementById('form_provincia').value = prov;
            document.getElementById('form_municipio').value = mun;
            document.getElementById('form_start_date').value = start;
            document.getElementById('form_end_date').value = end;
            document.getElementById('form_items').value = items;

            // limpiar cache local (opc.) -> dejar a decisión del servidor
            localStorage.removeItem('current_plan_items_v1');
        });
    }

    // Manejo del wizard: rellenar y enviar paso1 (Siguiente)
    const wizardForm = document.getElementById('wizardStep1Form');
    const wizardBtn = document.getElementById('wizardNextBtn');

    // Watch inputs and update the save/wizard buttons when they change
    const provEl = document.getElementById('provincia');
    const munEl = document.getElementById('municipio');
    const startEl = document.getElementById('start_date');
    const endEl = document.getElementById('end_date');

    const watchAndUpdate = () => {
        try { updateSaveButtonState(); } catch (e) { /* noop */ }
        // enable/disable wizard button explicitly
        if (wizardBtn) {
            const prov = provEl ? provEl.value : '';
            const mun = munEl ? munEl.value : '';
            const start = startEl ? startEl.value : '';
            const end = endEl ? endEl.value : '';
            wizardBtn.disabled = !(prov && mun && start && end);
        }
    };

    if (provEl) provEl.addEventListener('change', watchAndUpdate);
    if (munEl) munEl.addEventListener('change', watchAndUpdate);
    if (startEl) startEl.addEventListener('change', watchAndUpdate);
    if (endEl) endEl.addEventListener('change', watchAndUpdate);

    if (wizardForm) {
        wizardForm.addEventListener('submit', function (e) {
            const prov = provEl ? provEl.value : '';
            const mun = munEl ? munEl.value : '';
            const start = startEl ? startEl.value : '';
            const end = endEl ? endEl.value : '';

            // Logging/debug (visible alerta para facilitar depuración en entorno local)
            console.log('Wizard submit attempt', { prov, mun, start, end });

            // Validación cliente mínima
            if (!prov || !mun || !start || !end) {
                e.preventDefault();
                alert('Completa provincia, municipio y rango de fechas antes de continuar.');
                return false;
            }

            // Poner valores en inputs hidden
            document.getElementById('wizard_provincia').value = prov;
            document.getElementById('wizard_municipio').value = mun;
            document.getElementById('wizard_start_date').value = start;
            document.getElementById('wizard_end_date').value = end;

            // El envío procederá al endpoint protegido por auth (redirigirá a login si procede)
        });

        // Además, escuchar click en el botón para depuración/forzar submit
        if (wizardBtn) {
            wizardBtn.addEventListener('click', function (e) {
                const prov = provEl ? provEl.value : '';
                const mun = munEl ? munEl.value : '';
                const start = startEl ? startEl.value : '';
                const end = endEl ? endEl.value : '';
                console.log('Wizard button clicked', { prov, mun, start, end, disabled: wizardBtn.disabled });
                if (wizardBtn.disabled) {
                    e.preventDefault();
                    alert('Botón deshabilitado. Rellena provincia, municipio y fecha inicio/fin.\n' +
                          `provincia=${prov}\nmunicipio=${mun}\nstart=${start}\nend=${end}`);
                } else {
                    // Forzar envío como fallback (algunos navegadores podrían bloquear submit si JS previene)
                    // Aquí no prevenimos y dejamos que el formulario se envíe normalmente.
                    // Pero añadimos un pequeño timeout para asegurar que los valores hidden se hayan copiado.
                    setTimeout(() => {
                        try {
                            wizardForm.submit();
                        } catch (err) {
                            console.warn('Error al forzar submit del wizard:', err);
                        }
                    }, 50);
                }
            });
        }
    }

    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const nombre = document.getElementById('nombre').value;
            const asunto = document.getElementById('asunto').value;

            alert(`✅ Mensaje enviado correctamente, ${nombre}!\n\nNos pondremos en contacto pronto.`);
            contactForm.reset();
        });
    }

    // Toggle FAQ items
    const faqQuestions = document.querySelectorAll('.faq-question');
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const toggle = this.querySelector('.faq-toggle');

            answer.classList.toggle('active');
            toggle.textContent = answer.classList.contains('active') ? '−' : '+';
        });
    });
});

/**
 * Edita el perfil del usuario
 */
function editarPerfil() {
    alert('Función de edición de perfil - Próximamente disponible');
}

/**
 * Filtra planes por estado
 */
function filtrarPorEstado(estado) {
    const buttons = document.querySelectorAll('.tab-button');
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');

    alert(`Filtrando planes por estado: ${estado}`);
}

/**
 * Edita un plan existente
 */
function editarPlan(id) {
    alert(`Editando plan #${id}`);
}

/**
 * Abre el chat de soporte
 */
function abrirChat() {
    alert('Chat en vivo - Próximamente disponible para usuarios Premium');
}

/**
 * Comparte el plan
 */
function compartirPlan() {
    alert('Compartir plan - Próximamente disponible');
}

/**
 * Descarga el plan en PDF
 */
function descargarPlan() {
    alert('📥 Descargando plan en formato PDF...');
}
