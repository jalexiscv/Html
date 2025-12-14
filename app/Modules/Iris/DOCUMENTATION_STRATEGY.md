# Estrategia de Documentación del Módulo IRIS

Este documento define las políticas y directrices para la documentación continua del módulo **IRIS**. Su propósito es guiar a desarrolladores y agentes de Inteligencia Artificial (IA) para mantener la consistencia, integridad y utilidad de la documentación técnica.

## 1. Principios Fundamentales

*   **Modularidad**: La documentación no debe ser un monolito. Debe dividirse en componentes lógicos y manejables.
*   **Estandarización**: Toda documentación técnica debe referenciar los estándares médicos aplicables (principalmente **HL7** y **DICOM**).
*   **Centralización**: Toda la documentación detallada reside en el directorio `Docs/`. La raíz del módulo debe permanecer limpia.
*   **Veracidad**: La documentación debe reflejar fielmente el código. Si el código cambia, la documentación debe actualizarse inmediatamente.

## 2. Estructura de Directorios

La estructura oficial para la documentación es la siguiente:

```
app/Modules/Iris/
├── DOCUMENTATION_STRATEGY.md  <-- Este archivo (Política General)
├── README.md                  <-- Punto de entrada (Visión general y enlaces rápidos)
├── Docs/                      <-- Directorio PRINCIPAL de documentación
│   ├── STANDARDS.md           <-- Índice maestro de estándares y componentes
│   ├── Standards/             <-- Detalles técnicos de implementación de estándares
│   │   ├── PATIENTS.md        <-- Componente específico (ej. Gestión de Pacientes)
│   │   ├── PROFESSIONALS.md   <-- Componente específico (ej. Gestión de Staff)
│   │   └── ...
│   ├── API/                   <-- (Futuro) Documentación de Endpoints y Servicios
│   └── Manuals/               <-- (Futuro) Guías de usuario y despliegue
```

## 3. Flujo de Trabajo para Documentar (Instrucciones para IA)

Al documentar una nueva funcionalidad o componente, sigue estos pasos estrictos:

### Paso 1: Identificar el Componente
Determina si la funcionalidad pertenece a un componente existente (ej. Pacientes) o requiere uno nuevo.
*   *Si existe*: Edita el archivo correspondiente en `Docs/Standards/`.
*   *Si es nuevo*: Crea un nuevo archivo `.md` en `Docs/Standards/` con un nombre descriptivo en MAYÚSCULAS (ej. `BILLING.md`).

### Paso 2: Estructura del Archivo de Componente
Cada archivo de componente debe seguir esta plantilla:
1.  **Título**: Nombre del componente y estándar relacionado (ej. `# Gestión de Citas (HL7 SIU)`).
2.  **Descripción**: Breve explicación de la funcionalidad en el contexto de IRIS.
3.  **Alineación con Estándares**: Explica qué segmentos o mensajes HL7/DICOM se utilizan.
4.  **Estructura de Datos**: Detalla los campos clave, tablas o clases involucradas.
5.  **Flujos**: Describe los procesos principales (creación, actualización, etc.).

### Paso 3: Actualizar el Índice
**CRÍTICO**: Si creas un archivo nuevo, DEBES actualizar `Docs/STANDARDS.md` para incluir el enlace al nuevo archivo. Un archivo huérfano (no enlazado) es un error de documentación.

### Paso 4: Referencias Cruzadas
Si la documentación afecta la visión general del módulo, actualiza la sección de "Documentación" en `README.md`.

## 4. Convenciones de Estilo

*   **Idioma**: Español (Técnico y formal).
*   **Formato**: Markdown estándar (GitHub Flavored).
*   **Código**: Usa bloques de código con resaltado de sintaxis (```php, ```json).
*   **Enlaces**: Usa rutas relativas para enlazar archivos (ej. `[Ver Pacientes](Standards/PATIENTS.md)`).

## 5. Mantenimiento
Antes de modificar cualquier documentación, lee `Docs/STANDARDS.md` para entender el contexto actual. No dupliques información; enlaza a la fuente de verdad existente.
