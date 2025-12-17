# Componente Popover

Genera un botón disparador configurado para mostrar un popover (burbuja de información).

> **Nota**: Los popovers requieren inicialización JavaScript para funcionar. Asegúrate de ejecutar el código de inicialización de Bootstrap en tu página.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface\Popover;

$popover = new Popover([
    'trigger_text' => 'Haz clic aquí',
    'title' => 'Título del Popover',
    'content' => 'Aquí va la información detallada.',
    'placement' => 'right'
]);

echo $popover->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `trigger_text` | `string` | `'Popover'` | Texto visible del botón. |
| `title` | `string` | `''` | Título que aparece en la cabecera del popover. |
| `content` | `string` | `''` | Contenido principal del popover. |
| `placement` | `string` | `'right'` | Posición: `'top'`, `'bottom'`, `'left'`, `'right'`. |
| `variant` | `string` | `'secondary'` | Color del botón activador (ej. `'danger'`). |
| `attributes` | `array` | `[]` | Atributos adicionales (ej. custom triggers). |

## Inicialización JavaScript Requerida

Recuerda incluir este script en tu plantilla para activar todos los popovers:

```javascript
const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::popover([
    'trigger_text' => 'Click me',
    'content' => 'Info'
]);
```
