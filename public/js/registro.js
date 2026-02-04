document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('registroForm');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        // obtener elementos
        const emailInput = document.getElementById('email');
        const fechaInput = document.getElementById('fecha_nacimiento');
        const passwordInput = document.getElementById('password');
        const passwordConfirmInput = document.getElementById('password_confirmation');

        const emailErrorDiv = document.getElementById('emailError');
        const fechaErrorDiv = document.getElementById('fechaError');

        // limpiar mensajes previos
        emailErrorDiv.style.display = 'none';
        emailErrorDiv.textContent = '';
        fechaErrorDiv.style.display = 'none';
        fechaErrorDiv.textContent = '';

        let hasError = false;

        // Validar email con regex simple
        const email = emailInput.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            emailErrorDiv.textContent = 'El correo electrónico no tiene un formato válido (ejemplo: correo@ejemplo.com).';
            emailErrorDiv.style.display = 'block';
            hasError = true;
        }

        // Validar fecha
        const fecha = fechaInput.value;
        const dob = new Date(fecha);
        if (!fecha || isNaN(dob.getTime())) {
            fechaErrorDiv.textContent = 'Debe ingresar una fecha de nacimiento válida.';
            fechaErrorDiv.style.display = 'block';
            hasError = true;
        } else {
            // calcular edad
            const today = new Date();
            let age = today.getFullYear() - dob.getFullYear();
            const m = today.getMonth() - dob.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                age--;
            }
            if (age < 18) {
                fechaErrorDiv.textContent = 'Debes ser mayor o igual a 18 años.';
                fechaErrorDiv.style.display = 'block';
                hasError = true;
            }
        }

        // Validar contraseña cliente (mejor retroalimentación rápida)
        if (passwordInput.value.length < 8) {
            alert('⚠️ La contraseña debe tener al menos 8 caracteres');
            hasError = true;
        }
        if (passwordInput.value !== passwordConfirmInput.value) {
            alert('⚠️ Las contraseñas no coinciden');
            hasError = true;
        }

        if (hasError) {
            e.preventDefault();
            // enfocar primer campo con error
            if (emailErrorDiv.style.display === 'block') emailInput.focus();
            else if (fechaErrorDiv.style.display === 'block') fechaInput.focus();
            return false;
        }

        // Si pasa validación cliente, permitir envío al servidor (que hará validación final)
    });
});
