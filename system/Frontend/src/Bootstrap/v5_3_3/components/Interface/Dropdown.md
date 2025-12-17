# Componente Dropdown

Menús desplegables con diversas opciones y configuraciones.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface\Dropdown;

$dropdown = new Dropdown([
    'toggle' => 'Opciones',
    'variant' => 'success',
    'items' => [
        ['text' => 'Acción', 'url' => '#'],
        ['text' => 'Otra acción', 'url' => '#'],
        ['divider' => true],
        ['text' => 'Algo más', 'url' => '#']
    ]
]);

echo $dropdown->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `toggle` | `string/mixed` | `'Dropdown'` | Texto o contenido del botón disparador. |
| `items` | `array` | `[]` | Lista de elementos del menú. Ver estructura abajo. |
| `variant` | `string` | `'secondary'` | Estilo del botón (e.g., `primary`, `outline-danger`). |
| `direction` | `string` | `'dropdown'` | Dirección del menú: `'dropdown'`, `'dropup'`, `'dropend'`, `'dropstart'`, `'center'`. |
| `split` | `bool` | `false` | Crea un botón dividido (split button). |
| `size` | `string|null` | `null` | Tamaño del botón: `'sm'` o `'lg'`. |
| `dark` | `bool` | `false` | Estilo oscuro para el menú desplegable. |
| `attributes` | `array` | `[]` | Atributos adicionales para el contenedor. |

### Estructura de Items

Cada elemento del array `items` puede tener las siguientes claves:

| Clave | Tipo | Descripción |
| :--- | :--- | :--- |
| `text` | `string` | Texto del item. |
| `url` | `string` | URL del enlace (`href`). Default: `'#'`. |
| `divider` | `bool` | Si es `true`, inserta un separador horizontal. Ignora `text` y `url`. |
| `header` | `bool` | Si es `true`, renderiza un encabezado (`dropdown-header`). |
| `active` | `bool` | Marca el item como activo. |
| `disabled` | `bool` | Deshabilita el item. |

## Ejemplo Split Button y Dropup

```php
$dropdown = new Dropdown([
    'toggle' => 'Subir',
    'split' => true,
    'direction' => 'dropup',
    'items' => [
        ['text' => 'Opción 1', 'url' => '#'],
        ['text' => 'Opción 2', 'url' => '#']
    ]
]);

echo $dropdown->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::dropdown([
    'toggle' => 'Menu',
    'items' => [['text' => 'Item 1', 'url' => '#']]
]);
```
