# Componente Tooltip

Genera un elemento configurado para mostrar información sobre herramientas al pasar el cursor.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface\Tooltip;

$tooltip = new Tooltip([
    'trigger_text' => 'Pasa el mouse aquí',
    'title' => 'Información extra',
    'placement' => 'top',
    'attributes' => ['class' => 'btn btn-secondary']
]);

echo $tooltip->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `trigger_text` | `string` | `''` | Texto del elemento activador. |
| `title` | `string` | `''` | Texto a mostrar dentro del tooltip. |
| `placement` | `string` | `'top'` | Posición: `'top'`, `'bottom'`, `'left'`, `'right'`. |
| `attributes` | `array` | `[]` | Atributos adicionales. Si incluye `href`, renderiza un `<a>`. |

## Inicialización JavaScript Requerida

```javascript
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::tooltip([
    'trigger_text' => 'Hover me',
    'title' => 'Tooltip info'
]);
```
