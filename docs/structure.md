# Estructura del Proyecto

A partir de la versión 2.4.0, **Higgs HTML** adopta una estructura de directorios moderna y compatible con PSR-4 estándar en la comunidad PHP.

## Directorios

### `src/` (Source)
Contiene todo el código fuente de la librería (Clases, Interfaces, Traits).
*   **Convención**: Los nombres de carpetas dentro de `src/` coinciden exactamente con el namespace (`PascalCase`).
*   **Ejemplo**: La clase `Higgs\Html\Tag\AbstractTag` se encuentra en `src/Tag/AbstractTag.php`.

### `examples/`
Contiene scripts PHP ejecutables que demuestran casos de uso reales de la librería.
*   Diseñado para que los nuevos desarrolladores copien y peguen código funcional.

### `docs/`
Documentación extendida en formato Markdown.

### `tests/`
Pruebas unitarias (PHPUnit) para asegurar la estabilidad del código.

### `vendor/`
Dependencias gestionadas por Composer (no se sube al repositorio).

## ¿Por qué este cambio?
Mantener el código fuente separado de la documentación y configuración de la raíz (`src/` vs raíz) mejora la organización, facilita la navegación y evita que el autoloader de Composer tenga que escanear archivos innecesarios.
