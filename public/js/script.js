// ============================================
// BASE DE DATOS DE DESTINOS
// ============================================

const destinos = {
    Madrid: {
        hoteles: [
            {
                nombre: "Hotel Royal Elegance",
                ubicacion: "Centro Histórico",
                descripcion: "Hotel de lujo en pleno corazón de Madrid",
                precio: "€€€€",
                rating: 4.8,
                tipo: "Hotel"
            },
            {
                nombre: "Casa Serena Boutique",
                ubicacion: "Barrio de Salamanca",
                descripcion: "Acogedor hotel boutique con encanto",
                precio: "€€€",
                rating: 4.6,
                tipo: "Hotel"
            },
            {
                nombre: "Plaza Mayor Comfort",
                ubicacion: "Plaza Mayor",
                descripcion: "Hotel céntrico con vistas a la Plaza Mayor",
                precio: "€€",
                rating: 4.4,
                tipo: "Hotel"
            }
        ],
        restaurantes: [
            {
                nombre: "Mesón de Don Quixote",
                ubicacion: "Casco Antiguo",
                descripcion: "Cocina tradicional española de calidad",
                precio: "€€",
                rating: 4.7,
                tipo: "Restaurante"
            },
            {
                nombre: "El Jardín Gourmet",
                ubicacion: "Retiro",
                descripcion: "Gastronomía moderna con ingredientes locales",
                precio: "€€€",
                rating: 4.9,
                tipo: "Restaurante"
            },
            {
                nombre: "Tapas y Vinos Casa Sol",
                ubicacion: "La Latina",
                descripcion: "Deliciosas tapas españolas y vinos selectos",
                precio: "€€",
                rating: 4.5,
                tipo: "Restaurante"
            }
        ],
        museos: [
            {
                nombre: "Museo del Prado",
                ubicacion: "Avenida del Prado",
                descripcion: "Uno de los museos de arte más importantes del mundo",
                precio: "€",
                rating: 4.9,
                tipo: "Museo"
            },
            {
                nombre: "Reina Sofía",
                ubicacion: "Atocha",
                descripcion: "Arte moderno y contemporáneo español",
                precio: "€",
                rating: 4.8,
                tipo: "Museo"
            },
            {
                nombre: "Museo Thyssen-Bornemisza",
                ubicacion: "Paseo del Arte",
                descripcion: "Colección privada de arte europeo e hispanoamericano",
                precio: "€",
                rating: 4.7,
                tipo: "Museo"
            }
        ],
        atracciones: [
            {
                nombre: "Palacio Real de Madrid",
                ubicacion: "Centro",
                descripcion: "Espectacular palacio real con jardines",
                precio: "€€",
                rating: 4.6,
                tipo: "Atracción"
            },
            {
                nombre: "Parque Retiro",
                ubicacion: "Este de Madrid",
                descripcion: "Hermoso parque con lago y actividades",
                precio: "Gratis",
                rating: 4.8,
                tipo: "Atracción"
            }
        ]
    },
    Barcelona: {
        hoteles: [
            {
                nombre: "Barcelona Nights Luxury",
                ubicacion: "Paseo de Gracia",
                descripcion: "Lujo moderno con vistas a la ciudad",
                precio: "€€€€",
                rating: 4.9,
                tipo: "Hotel"
            },
            {
                nombre: "Sagrada Familia View",
                ubicacion: "Eixample",
                descripcion: "Hotel con vistas a la Sagrada Familia",
                precio: "€€€",
                rating: 4.7,
                tipo: "Hotel"
            },
            {
                nombre: "Gothic Quarter Charm",
                ubicacion: "Barrio Gótico",
                descripcion: "Hotel histórico en el corazón medieval",
                precio: "€€",
                rating: 4.5,
                tipo: "Hotel"
            }
        ],
        restaurantes: [
            {
                nombre: "Seafood Paradise",
                ubicacion: "Port Vell",
                descripcion: "Excelentes mariscos frescos",
                precio: "€€€",
                rating: 4.8,
                tipo: "Restaurante"
            },
            {
                nombre: "Catalan Kitchen",
                ubicacion: "Eixample",
                descripcion: "Auténtica cocina catalana",
                precio: "€€",
                rating: 4.6,
                tipo: "Restaurante"
            },
            {
                nombre: "Montjuïc Flavors",
                ubicacion: "Montjuïc",
                descripcion: "Gastronomía con vistas panorámicas",
                precio: "€€€",
                rating: 4.9,
                tipo: "Restaurante"
            }
        ],
        museos: [
            {
                nombre: "Museo Picasso Barcelona",
                ubicacion: "Barrio Gótico",
                descripcion: "Colección más importante de Picasso",
                precio: "€",
                rating: 4.8,
                tipo: "Museo"
            },
            {
                nombre: "MNAC (Museo Nacional de Cataluña)",
                ubicacion: "Montjuïc",
                descripcion: "Arte catalán desde el románico hasta hoy",
                precio: "€",
                rating: 4.7,
                tipo: "Museo"
            }
        ],
        atracciones: [
            {
                nombre: "Sagrada Familia",
                ubicacion: "Eixample",
                descripcion: "Basílica modernista de Gaudí - Patrimonio UNESCO",
                precio: "€€",
                rating: 5,
                tipo: "Atracción"
            },
            {
                nombre: "Park Güell",
                ubicacion: "Gràcia",
                descripcion: "Parque con mosaicos y vistas increíbles",
                precio: "€€",
                rating: 4.9,
                tipo: "Atracción"
            },
            {
                nombre: "Casa Batlló",
                ubicacion: "Paseo de Gracia",
                descripcion: "Casa modernista de Gaudí",
                precio: "€€",
                rating: 4.8,
                tipo: "Atracción"
            }
        ]
    },
    Valencia: {
        hoteles: [
            {
                nombre: "City of Arts Hotel",
                ubicacion: "Ciudad de las Artes",
                descripcion: "Hotel moderno junto a la Ciudad de las Artes",
                precio: "€€€",
                rating: 4.7,
                tipo: "Hotel"
            },
            {
                nombre: "Playa Valencia Resort",
                ubicacion: "Playa de la Malvarrosa",
                descripcion: "Resort con playa privada",
                precio: "€€€",
                rating: 4.6,
                tipo: "Hotel"
            },
            {
                nombre: "Old Town Valencia",
                ubicacion: "Centro Histórico",
                descripcion: "Hotel tradicional en la ciudad vieja",
                precio: "€€",
                rating: 4.4,
                tipo: "Hotel"
            }
        ],
        restaurantes: [
            {
                nombre: "La Paella Auténtica",
                ubicacion: "Albufera",
                descripcion: "Paella valenciana genuina",
                precio: "€€",
                rating: 4.8,
                tipo: "Restaurante"
            },
            {
                nombre: "Mar y Montaña",
                ubicacion: "Centro",
                descripcion: "Fusión de cocina de mar y montaña",
                precio: "€€€",
                rating: 4.7,
                tipo: "Restaurante"
            }
        ],
        museos: [
            {
                nombre: "Instituto Valenciano de Arte Moderno",
                ubicacion: "Centro",
                descripcion: "Arte contemporáneo español",
                precio: "€",
                rating: 4.6,
                tipo: "Museo"
            }
        ],
        atracciones: [
            {
                nombre: "Ciudad de las Artes y Ciencias",
                ubicacion: "Este de Valencia",
                descripcion: "Complejo futurista con museos y acuario",
                precio: "€€",
                rating: 4.9,
                tipo: "Atracción"
            },
            {
                nombre: "Playa de la Malvarrosa",
                ubicacion: "Este",
                descripcion: "Hermosa playa urbana",
                precio: "Gratis",
                rating: 4.5,
                tipo: "Atracción"
            }
        ]
    },
    Sevilla: {
        hoteles: [
            {
                nombre: "Andalusian Palace",
                ubicacion: "Santa Cruz",
                descripcion: "Palacio convertido en hotel",
                precio: "€€€€",
                rating: 4.8,
                tipo: "Hotel"
            },
            {
                nombre: "Barrio Santa Cruz",
                ubicacion: "Santa Cruz",
                descripcion: "Hotel en el barrio más pintoresco",
                precio: "€€",
                rating: 4.5,
                tipo: "Hotel"
            }
        ],
        restaurantes: [
            {
                nombre: "Gazpacho y Espetos",
                ubicacion: "Centro",
                descripcion: "Cocina andaluza tradicional",
                precio: "€€",
                rating: 4.7,
                tipo: "Restaurante"
            },
            {
                nombre: "Rincón Flamenco",
                ubicacion: "Triana",
                descripcion: "Comida con espectáculo flamenco",
                precio: "€€€",
                rating: 4.9,
                tipo: "Restaurante"
            }
        ],
        museos: [
            {
                nombre: "Museo de Bellas Artes",
                ubicacion: "Centro",
                descripcion: "Pintura sevillana de los siglos XV-XX",
                precio: "€",
                rating: 4.7,
                tipo: "Museo"
            }
        ],
        atracciones: [
            {
                nombre: "Catedral de Sevilla",
                ubicacion: "Centro",
                descripcion: "Catedral gótica con la Giralda",
                precio: "€",
                rating: 4.9,
                tipo: "Atracción"
            },
            {
                nombre: "Real Alcázar",
                ubicacion: "Santa Cruz",
                descripcion: "Palacio real con jardines orientales",
                precio: "€€",
                rating: 4.8,
                tipo: "Atracción"
            }
        ]
    },
    Bilbao: {
        hoteles: [
            {
                nombre: "Guggenheim View Luxury",
                ubicacion: "Abando",
                descripcion: "Vistas al Museo Guggenheim",
                precio: "€€€€",
                rating: 4.8,
                tipo: "Hotel"
            },
            {
                nombre: "Casco Viejo Traditional",
                ubicacion: "Casco Viejo",
                descripcion: "Hotel histórico en la zona antigua",
                precio: "€€",
                rating: 4.4,
                tipo: "Hotel"
            }
        ],
        restaurantes: [
            {
                nombre: "Pintxos Bilbaínos",
                ubicacion: "Casco Viejo",
                descripcion: "Gastronomía vasca de tapas",
                precio: "€€",
                rating: 4.8,
                tipo: "Restaurante"
            },
            {
                nombre: "Bacalao a la Vizcaína",
                ubicacion: "Centro",
                descripcion: "Platos vascos tradicionales",
                precio: "€€€",
                rating: 4.7,
                tipo: "Restaurante"
            }
        ],
        museos: [
            {
                nombre: "Museo Guggenheim Bilbao",
                ubicacion: "Abando",
                descripcion: "Arquitectura moderna y arte contemporáneo",
                precio: "€€",
                rating: 4.9,
                tipo: "Museo"
            }
        ],
        atracciones: [
            {
                nombre: "Puente Colgante",
                ubicacion: "Getxo",
                descripcion: "Patrimonio UNESCO del siglo XIX",
                precio: "€",
                rating: 4.7,
                tipo: "Atracción"
            }
        ]
    },
    Málaga: {
        hoteles: [
            {
                nombre: "Costa del Sol Luxury",
                ubicacion: "Benalmádena",
                descripcion: "Resort de playa con todos los servicios",
                precio: "€€€",
                rating: 4.7,
                tipo: "Hotel"
            },
            {
                nombre: "Centro Histórico Málaga",
                ubicacion: "Centro",
                descripcion: "Hotel en el corazón de Málaga",
                precio: "€€",
                rating: 4.5,
                tipo: "Hotel"
            }
        ],
        restaurantes: [
            {
                nombre: "Espetos de Playa",
                ubicacion: "Playa",
                descripcion: "Pescado a la brasa fresco del día",
                precio: "€€",
                rating: 4.8,
                tipo: "Restaurante"
            },
            {
                nombre: "Gazpachos Malagueños",
                ubicacion: "Centro",
                descripcion: "Especialidad local",
                precio: "€",
                rating: 4.6,
                tipo: "Restaurante"
            }
        ],
        museos: [
            {
                nombre: "Museo Picasso Málaga",
                ubicacion: "Centro",
                descripcion: "Colección de obras de Picasso",
                precio: "€€",
                rating: 4.8,
                tipo: "Museo"
            }
        ],
        atracciones: [
            {
                nombre: "Playas de Málaga",
                ubicacion: "Costa",
                descripcion: "Hermosas playas con aguas turquesas",
                precio: "Gratis",
                rating: 4.7,
                tipo: "Atracción"
            },
            {
                nombre: "Alcazaba de Málaga",
                ubicacion: "Centro",
                descripcion: "Fortaleza medieval con vistas",
                precio: "€",
                rating: 4.6,
                tipo: "Atracción"
            }
        ]
    }
};

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
                return;
            }

            // Validar coincidencia de contraseñas
            if (contraseña !== confirmar) {
                alert('⚠️ Las contraseñas no coinciden');
                return;
            }

            // Mostrar mensaje de éxito
            alert(`✅ ¡Bienvenido ${nombre}! Tu cuenta ha sido creada exitosamente.\n\nAhora puedes comenzar a planear tus viajes.`);

            // Limpiar formulario
            formulario.reset();

            // Redirigir a página de planes después de 1 segundo
            setTimeout(() => {
                window.location.href = 'planes.html';
            }, 1500);
        });
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
