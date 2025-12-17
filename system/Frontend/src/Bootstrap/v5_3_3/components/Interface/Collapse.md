# Componente Collapse

Alterna la visibilidad de contenido.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface\Collapse;
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface\Button;

$collapseId = 'myCollapse';

// Botón disparador
$btn = new Button([
    'content' => 'Toggle Content',
    'attributes' => [
        'data-bs-toggle' => 'collapse',
        'data-bs-target' => '#' . $collapseId,
        'aria-expanded' => 'false',
        'aria-controls' => $collapseId
    ]
]);

// Contenido colapsable
$collapse = new Collapse([
    'id' => $collapseId,
    'content' => '<div class="card card-body">Animación suave y ligera.</div>'
]);

echo $btn->render() . $collapse->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `id` | `string` | `uniqid()` | ID único requerido para vincular con el disparador. |
| `content` | `mixed` | `''` | Contenido interno a mostrar/ocultar. |
| `horizontal` | `bool` | `false` | Activa la animación de ancho en lugar de altura. Nota: El contenido interno debe tener un ancho definido. |
| `visible` | `bool` | `false` | Si es `true`, el contenido se muestra inicialmente (`.show`). |
| `attributes` | `array` | `[]` | Atributos adicionales para el div contenedor. |

## Collapse Horizontal

Para usar collapse horizontal, asegúrate de que el contenido inmediato tenga un ancho específico.

```php
$collapse = new Collapse([
    'horizontal' => true,
    'content' => '<div style="min-height: 120px;"><div class="card card-body" style="width: 300px;">Contenido horizontal</div></div>'
]);
echo $collapse->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::collapse([
    'content' => 'Contenido colapsable'
]);
```
