# 📊 TABLA RÁPIDA - PROBLEMAS DE LIMPIEZA DE CÓDIGO

## Formato: Tipo | Ubicación | Severidad | Recomendación Breve

---

## CÓDIGO DUPLICADO

| # | Problema | Archivos | Líneas | Sev. | Solución |
|---|----------|----------|--------|------|----------|
| 1 | `normalizeString()` x3 | PlanWizardController.php | 57-62, 180-185, 249-254 | 🔴 | Extraer a Helper o método privado |
| 2 | `byLocality()` x4 | PublicHotel, Restaurant, Museum, Festival | 41-48, 28-35, 27-34, 30-37 | 🟠 | Crear PublicResourceTrait |
| 3 | `getLocalitiesWithCount()` x4 | Idem (4 modelos) | Var. | 🟠 | Idem. Trait |
| 4 | `getProvinces()` x4 | Idem (4 modelos) | Var. | 🟠 | Idem. Trait |
| 5 | `normalizeProvince()` x5 | ImportHotels, ImportRestaurants, ImportMuseums, ImportFestivals, HotelsController | 130, 200, 315, 211, 53 | 🟠 | Centralizar en StringHelper |
| 6 | Plan::userColumn check x5 | PlanesController (2x), PerfilController (2x), PlanWizardController | 24, 56, 88, 20, 122 | 🟠 | Método privado getUserColumn() |
| 7 | Auth check x3 | PlanesController::show, finalize, destroy | 87-92, 136-141, 168-173 | 🟠 | Método Plan::isOwnedBy() |

---

## REDUNDANCIA / SOBRECOMPLEJIDAD

| # | Problema | Archivo | Líneas | Sev. | Impacto | Solución |
|---|----------|---------|--------|------|---------|----------|
| 8 | Controller structure 70% igual x4 | HotelsController, RestaurantsController, MuseumsController, FestivalsController | All | 🟠 | Cambios en 4 lugares | BasePublicResourceController |
| 9 | Filtrado hoteles sobrecomplicado | PlanWizardController::hoteles() | 82-102 | 🔴 | 20 líneas complejas, N+1 | Usar SQL LIKE, método privado |
| 10 | N+1 query pattern | PlanesController::show() | 109-126 | 🟠 | 4 queries separadas | Consolidar o eager loading |
| 11 | Estructura Blade 70% igual x4 | hoteles.blade.php, restaurantes.blade.php, museos.blade.php, fiestas.blade.php | All (~240 líneas c/u) | 🟠 | Cambios requieren 4 edits | Blade component reutilizable |
| 12 | Jobs idénticos x3 | ImportHotelsJob, ImportMuseumsJob, ImportMunicipiosJob | All | 🟠 | Solo varía comando | BaseImportJob abstracto |

---

## CÓDIGO NO UTILIZADO

| # | Problema | Archivo | Líneas | Sev. | Descripción |
|---|----------|---------|--------|------|-------------|
| 13 | Ruta `/planes/{id}` duplicada | routes/web.php | 78, 110 | 🔵 | Dos definiciones de mismo path, segunda sin auth |
| 14 | Variables debug en view | PlanWizardController::hoteles() | 106-129 | 🔵 | $debugHotels, $hotelsInProvince, etc. no usadas |

---

## CÓDIGO OBSOLETO / INCOMPLETITUD

| # | Problema | Archivo | Línea | Sev. | Descripción |
|---|----------|---------|-------|------|-------------|
| 15 | Endpoint sin protección auth | MunicipioController::refresh() | 35 | 🔵 | Comentario dice "no protegido", debería tener middleware |
| 16 | Comentarios vagos | plan-wizard/hoteles.blade.php | 88 | 🔵 | "Primera fila: Todos los selectores" - no específico |

---

## RESUMEN POR CATEGORÍA

### Código Duplicado: 7 issues
- 3 niveles: Alta (normalizeString x3), Media (4x métodos en modelos, 5x normalizeMethods)

### Redundancia/Complejidad: 5 issues  
- Controllers similares, filtrado complejo, N+1 queries, Blade templates, Jobs

### No Utilizado: 2 issues
- Rutas duplicadas, variables debug

### Obsoleto: 2 issues
- Falta de auth, comentarios vagos

---

## MÉTRICA DE IMPACTO

**Código Duplicado Identificado:** ~120 líneas  
**Modelos/Métodos Duplicados:** 12+ ocurrencias  
**Archivos Afectados:** 16 archivos  
**Controllers Sobreredundantes:** 4 (Hotels, Restaurants, Museums, Festivals)  

**Estimación de Ahorro si se refactoriza:**
- Lines of Code: -200 líneas (~20% reducción)
- Archivos a mantener: -2 archivos (consolidación)
- Cambios futuros: -40% esfuerzo en modificaciones comunes

---

## 🎯 QUICK WINS (Fáciles de implementar)

1. **Extraer normalizeString()** - 30 min, elimina 18 líneas
2. **Consolidar rutas /planes/{id}** - 10 min, elimina confusión
3. **Remover variables debug** - 5 min, limpia código
4. **Centralizar normalizeProvince()** - 30 min, 5 en 1
5. **Crear Plan::isOwnedBy()** - 20 min, elimina 3 dups

---

*Tabla de referencia rápida - Ver AUDITORIA_LIMPIEZA_CODIGO.md para detalles completos*
