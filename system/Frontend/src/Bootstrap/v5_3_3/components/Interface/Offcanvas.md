# Componente Offcanvas

Barras laterales ocultas en su proyecto para navegación, carritos de compra, etc.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface\Offcanvas;
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface\Button;

// Botón disparador
$btn = new Button([
    'content' => 'Abrir Menú',
    'attributes' => [
        'data-bs-toggle' => 'offcanvas',
        'data-bs-target' => '#menuOffcanvas',
        'aria-controls' => 'menuOffcanvas'
    ]
]);

// Componente Offcanvas
$offcanvas = new Offcanvas([
    'id' => 'menuOffcanvas',
    'title' => 'Menú Principal',
    'content' => '<ul><li>Inicio</li><li>Perfil</li></ul>',
    'placement' => 'start'
]);

echo $btn->render() . $offcanvas->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `id` | `string` | `uniqid()` | ID único requerido para vincular con el disparador. |
| `title` | `string` | `''` | Título en la cabecera. |
| `content` | `mixed` | `''` | Contenido del cuerpo. |
| `placement` | `string` | `'start'` | Posición: `'start'` (izq), `'end'` (der), `'top'`, `'bottom'`. |
| `backdrop` | `bool/string` | `true` | `'static'` (no cierra al clickear fuera), `true` (default), `false` (sin fondo oscuro). |
| `scroll` | `bool` | `false` | Permite scroll en el `<body>` principal mientras el offcanvas está abierto. |
| `attributes` | `array` | `[]` | Atributos adicionales. |

## Ejemplo Offcanvas con Scroll

Permite hacer scroll en la página con el offcanvas abierto.

```php
$offcanvas = new Offcanvas([
    'id' => 'offcanvasScroll',
    'title' => 'Con Scroll',
    'content' => 'Prueba a hacer scroll en el fondo.',
    'scroll' => true,
    'backdrop' => false
]);

echo $offcanvas->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::offcanvas([
    'title' => 'Menu',
    'content' => 'Lorem ipsum'
]);
```
