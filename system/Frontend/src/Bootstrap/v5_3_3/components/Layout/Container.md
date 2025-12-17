# Componente Container

El elemento de diseño más básico en Bootstrap, requerido para usar el sistema de cuadrícula por defecto.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Layout\Container;

$container = new Container([
    'content' => '<h1>Hola Mundo</h1>'
]);

echo $container->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `content` | `mixed` | `''` | Contenido interno. |
| `type` | `string` | `''` | Sufijo del tipo de contenedor (`fluid`, `sm`, `md`, `lg`, `xl`, `xxl`). Si está vacío, usa `container`. |
| `attributes` | `array` | `[]` | Atributos adicionales. |

## Ejemplo Container Fluid

```php
$fluid = new Container([
    'type' => 'fluid',
    'content' => 'Ancho completo 100%.'
]);

echo $fluid->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::container([
    'content' => 'Full width',
    'type' => 'fluid'
]);
```
