document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('registroForm');
    if (!form) return;

    const nombreInput = document.getElementById('nombre_apellidos');
    const usernameInput = document.getElementById('username');
    const emailInput = document.getElementById('email');
    const fechaInput = document.getElementById('fecha_nacimiento');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const registroBtn = document.getElementById('registroBtn');

    const nombreErrorDiv = document.getElementById('nombreError');
    const usernameErrorDiv = document.getElementById('usernameError');
    const emailErrorDiv = document.getElementById('emailError');
    const fechaErrorDiv = document.getElementById('fechaError');
    const passwordErrorDiv = document.getElementById('passwordError');
    const passwordConfirmErrorDiv = document.getElementById('passwordConfirmError');

    // Limpiar errores cuando el usuario escribe
    nombreInput.addEventListener('input', () => {
        nombreErrorDiv.style.display = 'none';
        nombreErrorDiv.textContent = '';
    });
    usernameInput.addEventListener('input', () => {
        usernameErrorDiv.style.display = 'none';
        usernameErrorDiv.textContent = '';
    });
    emailInput.addEventListener('input', () => {
        emailErrorDiv.style.display = 'none';
        emailErrorDiv.textContent = '';
    });
    fechaInput.addEventListener('input', () => {
        fechaErrorDiv.style.display = 'none';
        fechaErrorDiv.textContent = '';
    });
    passwordInput.addEventListener('input', () => {
        passwordErrorDiv.style.display = 'none';
        passwordErrorDiv.textContent = '';
    });
    passwordConfirmInput.addEventListener('input', () => {
        passwordConfirmErrorDiv.style.display = 'none';
        passwordConfirmErrorDiv.textContent = '';
    });

    form.addEventListener('submit', function (e) {
        // Limpiar mensajes previos
        nombreErrorDiv.style.display = 'none';
        nombreErrorDiv.textContent = '';
        usernameErrorDiv.style.display = 'none';
        usernameErrorDiv.textContent = '';
        emailErrorDiv.style.display = 'none';
        emailErrorDiv.textContent = '';
        fechaErrorDiv.style.display = 'none';
        fechaErrorDiv.textContent = '';
        passwordErrorDiv.style.display = 'none';
        passwordErrorDiv.textContent = '';
        passwordConfirmErrorDiv.style.display = 'none';
        passwordConfirmErrorDiv.textContent = '';

        let hasError = false;

        // Validar nombre completo
        const nombre = nombreInput.value.trim();
        if (!nombre || nombre.length < 3) {
            nombreErrorDiv.textContent = 'El nombre debe tener al menos 3 caracteres.';
            nombreErrorDiv.style.display = 'block';
            hasError = true;
        } else if (nombre.length > 100) {
            nombreErrorDiv.textContent = 'El nombre no puede exceder 100 caracteres.';
            nombreErrorDiv.style.display = 'block';
            hasError = true;
        }

        // Validar username
        const username = usernameInput.value.trim();
        const usernameRegex = /^[a-zA-Z0-9_-]+$/;
        if (!username || username.length < 3) {
            usernameErrorDiv.textContent = 'El usuario debe tener al menos 3 caracteres.';
            usernameErrorDiv.style.display = 'block';
            hasError = true;
        } else if (username.length > 20) {
            usernameErrorDiv.textContent = 'El usuario no puede exceder 20 caracteres.';
            usernameErrorDiv.style.display = 'block';
            hasError = true;
        } else if (!usernameRegex.test(username)) {
            usernameErrorDiv.textContent = 'El usuario solo puede contener letras, números, guiones y guiones bajos.';
            usernameErrorDiv.style.display = 'block';
            hasError = true;
        }

        // Validar email
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
            // Calcular edad
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

        // Validar contraseña
        const password = passwordInput.value;
        if (password.length < 8) {
            passwordErrorDiv.textContent = 'La contraseña debe tener al menos 8 caracteres.';
            passwordErrorDiv.style.display = 'block';
            hasError = true;
        }

        // Validar confirmación de contraseña
        const passwordConfirm = passwordConfirmInput.value;
        if (password !== passwordConfirm) {
            passwordConfirmErrorDiv.textContent = 'Las contraseñas no coinciden.';
            passwordConfirmErrorDiv.style.display = 'block';
            hasError = true;
        }

        if (hasError) {
            e.preventDefault();
            // Enfocar primer campo con error
            if (nombreErrorDiv.style.display === 'block') nombreInput.focus();
            else if (usernameErrorDiv.style.display === 'block') usernameInput.focus();
            else if (emailErrorDiv.style.display === 'block') emailInput.focus();
            else if (fechaErrorDiv.style.display === 'block') fechaInput.focus();
            else if (passwordErrorDiv.style.display === 'block') passwordInput.focus();
            else if (passwordConfirmErrorDiv.style.display === 'block') passwordConfirmInput.focus();
            return false;
        }

        // Si pasa validación cliente, deshabilitar botón y permitir envío al servidor
        registroBtn.disabled = true;
        registroBtn.textContent = 'Creando cuenta...';
    });
});

