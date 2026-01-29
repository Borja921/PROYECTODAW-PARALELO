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
    const provincia = document.getElementById('provincia').value;
    const dias = document.getElementById('dias').value;
    const resultados = document.getElementById('resultados');

    // Limpiar resultados previos
    resultados.innerHTML = '';

    // Validar selección
    if (!provincia || !dias) {
        resultados.innerHTML = '<p class="placeholder-text">Por favor, selecciona una provincia y una duración</p>';
        return;
    }

    // Obtener destinos de la provincia seleccionada
    const destinosSeleccionados = destinos[provincia];

    if (!destinosSeleccionados) {
        resultados.innerHTML = '<p class="placeholder-text">No hay destinos disponibles para esta provincia</p>';
        return;
    }

    // Crear tarjetas para cada tipo de atracción
    const fragmento = document.createDocumentFragment();

    // Hoteles
    if (destinosSeleccionados.hoteles && destinosSeleccionados.hoteles.length > 0) {
        destinosSeleccionados.hoteles.forEach(hotel => {
            fragmento.appendChild(crearTarjetaDestino(hotel, dias));
        });
    }

    // Restaurantes
    if (destinosSeleccionados.restaurantes && destinosSeleccionados.restaurantes.length > 0) {
        destinosSeleccionados.restaurantes.forEach(restaurante => {
            fragmento.appendChild(crearTarjetaDestino(restaurante, dias));
        });
    }

    // Museos
    if (destinosSeleccionados.museos && destinosSeleccionados.museos.length > 0) {
        destinosSeleccionados.museos.forEach(museo => {
            fragmento.appendChild(crearTarjetaDestino(museo, dias));
        });
    }

    // Atracciones
    if (destinosSeleccionados.atracciones && destinosSeleccionados.atracciones.length > 0) {
        destinosSeleccionados.atracciones.forEach(atraccion => {
            fragmento.appendChild(crearTarjetaDestino(atraccion, dias));
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

/**
 * Genera las estrellas de rating
 */
function generarEstrellas(rating) {
    const estrellas = Math.round(rating);
    return '⭐'.repeat(estrellas);
}

/**
 * Agrega un destino al plan (simulado)
 */
function agregarAlPlan(nombre, dias) {
    alert(`✅ "${nombre}" ha sido agregado a tu plan de ${dias} día(s)`);
    // Aquí se podría guardar en localStorage o enviar a un servidor
}

/**
 * Maneja el envío del formulario de registro
 */
document.addEventListener('DOMContentLoaded', function() {
    const formulario = document.getElementById('registroForm');
    const contactForm = document.getElementById('contactForm');
    
    if (formulario) {
        formulario.addEventListener('submit', function(e) {
            e.preventDefault();

            // Validaciones
            const nombre = document.getElementById('nombre').value;
            const email = document.getElementById('email').value;
            const contraseña = document.getElementById('contraseña').value;
            const confirmar = document.getElementById('confirmar').value;
            const provincia = document.getElementById('provincia').value;

            // Validar contraseña
            if (contraseña.length < 8) {
                alert('⚠️ La contraseña debe tener al menos 8 caracteres');
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
