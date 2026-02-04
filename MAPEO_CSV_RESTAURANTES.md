# Análisis Estructura CSV Restaurantes

## Información General
- **Archivo**: `restaurantes.csv`
- **Total de columnas**: 22
- **Separador**: Punto y coma (`;`)
- **Formato de comillas**: Campos delimitados con comillas dobles (`"`)
- **Total de registros**: ~1.3 MB de datos

---

## Mapeo de Campos (Índice 0-21)

| Índice | Campo | Descripción |
|--------|-------|-------------|
| 0 | `N.Registro` | Número de registro único |
| 1 | `Tipo` | Tipo de establecimiento (Restaurante, Bar, etc.) |
| 2 | `Categoría` | Categoría/Estrellas (ej: 3ª - 2 Tenedores) |
| 3 | `Especialidades` | Especialidades culinarias |
| **4** | **`Nombre`** | **NOMBRE DEL RESTAURANTE** ✓ |
| **5** | **`Dirección`** | **DIRECCIÓN** ✓ |
| **6** | **`C.Postal`** | **CÓDIGO POSTAL** ✓ |
| **7** | **`Provincia`** | **PROVINCIA** ✓ |
| 8 | `Municipio` | Municipio |
| **9** | **`Localidad`** | **LOCALIDAD** ✓ |
| 10 | `Nucleo` | Núcleo (población pequeña) |
| **11** | **`Teléfono 1`** | **TELÉFONO (principal)** ✓ |
| 12 | `Teléfono 2` | Teléfono secundario |
| 13 | `Teléfono 3` | Teléfono terciario |
| **14** | **`Email`** | **EMAIL** ✓ |
| **15** | **`web`** | **SITIO WEB** ✓ |
| 16 | `Q Calidad` | Calidad/Plazas |
| 17 | `Plazas` | Número de plazas |
| 18 | `GPS.Longitud` | Coordenada GPS (Longitud) |
| 19 | `GPS.Latitud` | Coordenada GPS (Latitud) |
| 20 | `accesible a personas con discapacidad` | Accesibilidad (Si/No/vacío) |
| 21 | (vacío) | Campo sin utilizar |

---

## Campos Solicitados - Ubicación

| Campo Solicitado | Índice | Mapeo CSV |
|------------------|--------|-----------|
| ✓ Nombre del restaurante | **4** | `Nombre` |
| ✓ Localidad | **9** | `Localidad` |
| ✓ Provincia | **7** | `Provincia` |
| ✓ Dirección | **5** | `Dirección` |
| ✓ Código postal | **6** | `C.Postal` |
| ✓ Teléfono | **11** | `Teléfono 1` |
| ✓ Email | **14** | `Email` |
| ✓ Sitio web | **15** | `web` |
| ⚠ Tipo de cocina | **3** | `Especialidades` (campo relacionado) |
| ⚠ Nivel de precio | **2** | `Categoría` (contiene información de nivel) |
| ❌ Horario | — | **NO DISPONIBLE** en este CSV |

---

## Ejemplos de Registros

### Registro 1
```
N.Registro: 05/000006
Tipo: Restaurante
Categoría: 3ª - 2 Tenedores
Especialidades: (vacío)
Nombre: EL TORREON
Dirección: C/ EL TOSTADO, Nº 1
C.Postal: 05001
Provincia: Ávila
Municipio: Ávila
Localidad: AVILA
Teléfono 1: 920213171
Email: (vacío)
web: (vacío)
```

### Registro 2
```
N.Registro: 05/000007
Tipo: Restaurante / Bar
Categoría: 3ª - 2 Tenedores
Especialidades: (vacío)
Nombre: ESTACION DE AVILA
Dirección: Paseo DE LA ESTACION S/N
C.Postal: 05001
Provincia: Ávila
Municipio: Ávila
Localidad: AVILA
Teléfono 1: 606325644
Email: chalao2007@hotmail.com
web: (vacío)
```

---

## Notas Importantes para la Importación

1. **Muchos campos vacíos**: Email, web, especialidades y otros campos frecuentemente están vacíos
2. **Teléfonos múltiples**: Usa Teléfono 1 como principal; 2 y 3 como alternos
3. **Horario NO disponible**: Este CSV no contiene información de horario
4. **Tipo de cocina**: Se debe extraer de `Especialidades` (campo 3) cuando está disponible
5. **Nivel de precio**: Se puede extraer de `Categoría` (campo 2, ej: "2 Tenedores")
6. **Ubicación**: Localidad (9) es más específica que Municipio (8)
7. **Codificación**: El archivo está en UTF-8 (contiene caracteres como á, é, ñ)

---

## Cómo Parsear en PHP

```php
$file = fopen('restaurantes.csv', 'r');
$header = fgetcsv($file, 0, ';'); // Ignorar encabezado

while (($row = fgetcsv($file, 0, ';')) !== false) {
    // Acceso a campos específicos:
    $nombre = trim($row[4], '"');           // Nombre
    $direccion = trim($row[5], '"');        // Dirección
    $codigoPostal = trim($row[6], '"');     // Código Postal
    $provincia = trim($row[7], '"');        // Provincia
    $localidad = trim($row[9], '"');        // Localidad
    $telefono = trim($row[11], '"');        // Teléfono
    $email = trim($row[14], '"');           // Email
    $web = trim($row[15], '"');             // Sitio Web
    
    // Procesar registro...
}
fclose($file);
```
