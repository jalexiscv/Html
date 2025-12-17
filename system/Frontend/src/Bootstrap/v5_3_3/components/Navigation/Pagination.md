# Componente Pagination

Navegación entre páginas para dividir contenido extenso.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Navigation\Pagination;

$pagination = new Pagination([
    'total' => 50,
    'current' => 1,
    'perPage' => 10,
    'url_pattern' => '/usuarios?page=(:num)'
]);

echo $pagination->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `total` | `int` | `0` | Número total de registros. |
| `current` | `int` | `1` | Página actual. |
| `perPage` | `int` | `10` | Registros por página. |
| `url_pattern` | `string` | `'?page=(:num)'` | Patrón de URL. `(:num)` será reemplazado por el número de página. |
| `size` | `string` | `null` | Tamaño: `'sm'`, `'lg'`. |
| `alignment` | `string` | `null` | Alineación: `'center'`, `'end'`. |
| `attributes` | `array` | `['aria-label' => '...']` | Atributos adicionales. |

## Ejemplo Alineado y Grande

```php
$pagination = new Pagination([
    'total' => 100,
    'perPage' => 5,
    'size' => 'lg',
    'alignment' => 'center', // justify-content-center
    'url_pattern' => '/blog/page/(:num)'
]);

echo $pagination->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::pagination([
    'total' => 100,
    'current' => 1
]);
```
