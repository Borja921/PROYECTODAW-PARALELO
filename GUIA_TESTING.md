# GUÍA DE TESTING - Validaciones de Formularios

## 🧪 Cómo Probar las Validaciones Implementadas

---

## 1️⃣ FORMULARIO LOGIN

### 📍 Ruta
```
http://localhost:8000/login
```

### ✅ Casos de Prueba

#### Test 1: Usuario vacío
```
Username/Email: [dejar vacío]
Password: password123
Resultado Esperado: ❌ Error "Ingresa tu usuario o correo (mín. 3 caracteres)."
```

#### Test 2: Usuario muy corto
```
Username/Email: ab
Password: password123
Resultado Esperado: ❌ Error "Ingresa tu usuario o correo (mín. 3 caracteres)."
```

#### Test 3: Email con formato inválido
```
Username/Email: correo@sin-punto
Password: password123
Resultado Esperado: ❌ Error "Formato de correo inválido."
```

#### Test 4: Contraseña vacía
```
Username/Email: usuario@ejemplo.com
Password: [dejar vacío]
Resultado Esperado: ❌ Error "Ingresa tu contraseña."
```

#### Test 5: Todo válido
```
Username/Email: usuario@ejemplo.com
Password: contraseña123
Resultado Esperado: ✅ Botón cambia a "Iniciando sesión..." (disabled)
```

#### Test 6: Limpiar error al escribir
```
1. Escribir email inválido: "correo@"
2. Ver error
3. Escribir más caracteres: "correo@ejemplo.com"
Resultado Esperado: ✅ Error desaparece automáticamente
```

---

## 2️⃣ FORMULARIO REGISTRO

### 📍 Ruta
```
http://localhost:8000/registro
```

### ✅ Casos de Prueba

#### Test 1: Nombre muy corto
```
Nombre: ab
Username: usuario123
Email: usuario@ejemplo.com
Fecha: 2000-01-01
Password: contraseña123
Password Confirm: contraseña123
Resultado Esperado: ❌ Error "El nombre debe tener al menos 3 caracteres."
```

#### Test 2: Username con caracteres inválidos
```
Nombre: Juan García
Username: usuario@123!
Email: usuario@ejemplo.com
Fecha: 2000-01-01
Password: contraseña123
Password Confirm: contraseña123
Resultado Esperado: ❌ Error "El usuario solo puede contener letras, números, guiones y guiones bajos."
```

#### Test 3: Username muy largo
```
Nombre: Juan García
Username: usuario1234567890123456
Email: usuario@ejemplo.com
Fecha: 2000-01-01
Password: contraseña123
Password Confirm: contraseña123
Resultado Esperado: ❌ Error "El usuario no puede exceder 20 caracteres."
```

#### Test 4: Email inválido
```
Nombre: Juan García
Username: usuario123
Email: correo@sin-punto
Fecha: 2000-01-01
Password: contraseña123
Password Confirm: contraseña123
Resultado Esperado: ❌ Error "El correo electrónico no tiene un formato válido"
```

#### Test 5: Menor de 18 años
```
Nombre: Juan García
Username: usuario123
Email: usuario@ejemplo.com
Fecha: 2010-01-01 (14 años)
Password: contraseña123
Password Confirm: contraseña123
Resultado Esperado: ❌ Error "Debes ser mayor o igual a 18 años."
```

#### Test 6: Contraseña muy corta
```
Nombre: Juan García
Username: usuario123
Email: usuario@ejemplo.com
Fecha: 2000-01-01
Password: paso123 (7 caracteres)
Password Confirm: paso123
Resultado Esperado: ❌ Error "La contraseña debe tener al menos 8 caracteres."
```

#### Test 7: Contraseñas no coinciden
```
Nombre: Juan García
Username: usuario123
Email: usuario@ejemplo.com
Fecha: 2000-01-01
Password: contraseña123
Password Confirm: contraseña456
Resultado Esperado: ❌ Error "Las contraseñas no coinciden."
```

#### Test 8: Todo válido
```
Nombre: Juan García López
Username: juangarcia
Email: juangarcia@ejemplo.com
Fecha: 2000-01-01
Password: contraseña123
Password Confirm: contraseña123
Resultado Esperado: ✅ Botón cambia a "Creando cuenta..." (disabled)
```

#### Test 9: Sin alerts (importante)
```
Llenar cualquier campo incorrectamente
Resultado Esperado: ✅ NO debe aparecer ningún alert()
                    ✅ Error mostrado en div rojo debajo del campo
```

#### Test 10: Focus automático en error
```
1. Dejar nombre vacío
2. Intentar enviar
3. Observar qué campo recibe el foco
Resultado Esperado: ✅ Cursor se posiciona en nombre_apellidos (primer error)
```

---

## 3️⃣ FORMULARIO EDITAR PERFIL

### 📍 Ruta
```
http://localhost:8000/perfil/editar
```

### ✅ Casos de Prueba

#### Test 1: Nombre válido pero corto
```
Nombre: ab
Username: usuario123
Email: usuario@ejemplo.com
Fecha: [sin cambiar]
Foto: [sin cambiar]
Resultado Esperado: ❌ Error "El nombre debe tener al menos 3 caracteres."
```

#### Test 2: Username con caracteres inválidos
```
Nombre: Juan García
Username: usuario@123
Email: usuario@ejemplo.com
Foto: [sin cambiar]
Resultado Esperado: ❌ Error "El usuario solo puede contener letras, números, guiones y guiones bajos."
```

#### Test 3: Email inválido
```
Nombre: Juan García
Username: usuario123
Email: correo@inválido
Foto: [sin cambiar]
Resultado Esperado: ❌ Error "Formato de correo electrónico inválido."
```

#### Test 4: Foto demasiado grande (> 2MB)
```
Nombre: [válido]
Username: [válido]
Email: [válido]
Foto: [Seleccionar archivo > 2MB]
Resultado Esperado: ❌ Error "El archivo es demasiado grande. Máximo 2MB."
                    ✅ Campo foto se limpia
```

#### Test 5: Foto con formato no permitido
```
Nombre: [válido]
Username: [válido]
Email: [válido]
Foto: [Seleccionar archivo .txt o .pdf]
Resultado Esperado: ❌ Error "Formato de imagen no permitido. Usa JPG, PNG, GIF o WebP."
                    ✅ Campo foto se limpia
```

#### Test 6: Foto válida (JPG < 2MB)
```
Nombre: [válido]
Username: [válido]
Email: [válido]
Foto: [Seleccionar imagen JPG válida, 1MB]
Resultado Esperado: ✅ No hay error
                    ✅ Campo listo para envío
```

#### Test 7: Foto con extensión correcta pero contenido inválido
```
Nombre: [válido]
Username: [válido]
Email: [válido]
Foto: [Archivo .jpg renombrado de .txt]
Resultado Esperado: ❌ Error "El archivo no es una imagen válida."
                    ✅ Campo foto se limpia
```

#### Test 8: Todo válido
```
Nombre: Juan García López
Username: juangarcia
Email: juangarcia@ejemplo.com
Foto: [Imagen válida JPG 500KB]
Resultado Esperado: ✅ Botón cambia a "Guardando..." (disabled)
```

#### Test 9: Limpiar errores al escribir
```
1. Escribir nombre inválido: "ab"
2. Ver error
3. Escribir más caracteres
Resultado Esperado: ✅ Error desaparece automáticamente
```

#### Test 10: Validación de foto desaparece al cambiar
```
1. Seleccionar archivo > 2MB
2. Ver error
3. Seleccionar archivo válido
Resultado Esperado: ✅ Error desaparece automáticamente
```

---

## 4️⃣ VALIDACIONES GLOBALES

### ✅ Test Transversal 1: Sin librerías externas
```
1. Abrir DevTools (F12)
2. Ver Sources → Buscar "jQuery" o "validator"
3. Buscar en Network → scripts externos
Resultado Esperado: ✅ NO hay jQuery
                    ✅ NO hay vendor/validators.js
                    ✅ Solo HTML5 + JavaScript nativo
```

### ✅ Test Transversal 2: Consistencia visual
```
1. Ir a Login y ver error
2. Ir a Registro y ver error
3. Ir a Perfil y ver error
Resultado Esperado: ✅ Color rojo igual (#dc3545)
                    ✅ Tamaño fuente igual (0.9rem)
                    ✅ Posición igual (debajo del input)
```

### ✅ Test Transversal 3: Deshabilitación de botón
```
1. Validación pasa ✅
2. Click en "Enviar"
3. Observar botón
Resultado Esperado: ✅ Botón se deshabilita
                    ✅ Texto cambia ("Enviando...", "Guardando...", etc)
                    ✅ Usuario no puede hacer click nuevamente
```

### ✅ Test Transversal 4: HTML5 attributes funcionan
```
1. En navegador antiguo (sin soporte minlength)
2. Ir a Registro
3. Escribir nombre: "ab" (solo 2 caracteres)
Resultado Esperado: ✅ JavaScript valida (no depende de HTML5)
                    ✅ Error se muestra igual
```

---

## 🧪 Pruebas Automatizadas (Opcional)

### Login Form Tests
```javascript
// En DevTools Console
const loginInput = document.getElementById('login');
const form = document.getElementById('loginForm');

// Test: Usuario vacío
loginInput.value = '';
form.dispatchEvent(new Event('submit'));
// Debe mostrar error

// Test: Email válido
loginInput.value = 'usuario@ejemplo.com';
loginInput.dispatchEvent(new Event('input'));
// Debe limpiar error
```

### Validación de archivo
```javascript
// En DevTools Console
const photoInput = document.getElementById('profile_photo');

// Simular archivo > 2MB
const largeFile = new File(
    [new ArrayBuffer(3000000)], 
    'foto.jpg', 
    { type: 'image/jpeg' }
);

// Asignar y disparar evento
Object.defineProperty(photoInput, 'files', {
    value: [largeFile]
});
photoInput.dispatchEvent(new Event('change'));
// Debe mostrar error de tamaño
```

---

## 📋 Checklist de Validación

### Login Form
- [ ] Error cuando username está vacío
- [ ] Error cuando username tiene < 3 caracteres
- [ ] Error cuando email tiene formato inválido
- [ ] Error cuando password está vacío
- [ ] Sin error cuando todo es válido
- [ ] Botón se deshabilita al enviar
- [ ] Error desaparece al escribir

### Registro Form
- [ ] Error nombre < 3 caracteres
- [ ] Error username con caracteres inválidos
- [ ] Error email formato inválido
- [ ] Error menor de 18 años
- [ ] Error contraseña < 8 caracteres
- [ ] Error contraseñas no coinciden
- [ ] Sin alerts (uso de divs)
- [ ] Botón se deshabilita al enviar
- [ ] Focus automático en primer error

### Editar Perfil Form
- [ ] Error nombre < 3 caracteres
- [ ] Error username con caracteres inválidos
- [ ] Error email formato inválido
- [ ] Error foto > 2MB
- [ ] Error foto formato no permitido
- [ ] Error foto contenido inválido
- [ ] Botón se deshabilita al enviar
- [ ] Error desaparece al cambiar foto

### Global
- [ ] No hay alerts (solo divs)
- [ ] Errores consistentes en color/tamaño
- [ ] HTML5 attributes presentes
- [ ] Trim en valores
- [ ] Sin librerías externas

---

## 🐛 Troubleshooting

### Problema: Error no desaparece
**Solución:** Verificar que haya event listener 'input' en el campo

### Problema: Foto acepta formato inválido
**Solución:** Verificar que haya validación de FileReader (Image onload)

### Problema: Botón no se deshabilita
**Solución:** Verificar que form tenga id correcto y haya event listener 'submit'

### Problema: Validación no funciona en navegador antiguo
**Solución:** Es esperado - fallback es validación server-side

---

## 📊 Matriz de Cobertura de Testing

```
┌────────────────┬──────┬──────┬────────┬───────┐
│ Validación     │Login │Reg   │Perfil  │Plan   │
├────────────────┼──────┼──────┼────────┼───────┤
│Minlength       │ ✅   │ ✅   │ ✅     │ ✅    │
│Maxlength       │ ❌   │ ✅   │ ✅     │ ❌    │
│Pattern         │ ❌   │ ✅   │ ✅     │ ❌    │
│Email regex     │ ✅   │ ✅   │ ✅     │ ❌    │
│Archivo (size)  │ ❌   │ ❌   │ ✅     │ ❌    │
│Archivo (MIME)  │ ❌   │ ❌   │ ✅     │ ❌    │
│Edad 18+        │ ❌   │ ✅   │ ❌     │ ❌    │
│Divs error      │ ✅   │ ✅   │ ✅     │ ✅    │
│Deshab botón    │ ✅   │ ✅   │ ✅     │ ✅    │
│Focus error     │ ❌   │ ✅   │ ✅     │ ❌    │
└────────────────┴──────┴──────┴────────┴───────┘
```

---

## ✅ Aprobación de Testing

Una vez completados todos los tests:

```
Date: 28/01/2025
Tester: [Nombre]
Forms Tested:
  - [x] Login
  - [x] Registro
  - [x] Editar Perfil
  
All Tests: PASSED ✅
Browser: Chrome/Firefox/Safari/Edge
No errors in console: YES
No alerts: YES
No external dependencies: YES

Signed: _______________
```

