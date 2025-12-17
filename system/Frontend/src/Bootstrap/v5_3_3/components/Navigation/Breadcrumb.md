# Componente Breadcrumb

Indica la ubicación de la página actual dentro de una jerarquía de navegación.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Navigation\Breadcrumb;

$breadcrumb = new Breadcrumb([
    'items' => [
        ['text' => 'Inicio', 'url' => '/'],
        ['text' => 'Librería', 'url' => '/library'],
        ['text' => 'Datos', 'active' => true]
    ]
]);

echo $breadcrumb->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `items` | `array` | `[]` | Lista de items de navegación. Ver estructura abajo. |
| `divider` | `string` | `null` | Carácter separador personalizado (ej. `'>'`). |
| `attributes` | `array` | `['aria-label' => 'breadcrumb']` | Atributos del contenedor `<nav>`. |

### Estructura de Items

| Clave | Tipo | Descripción |
| :--- | :--- | :--- |
| `text` | `string` | Texto visible. |
| `url` | `string` | URL del enlace. Omitido si está activo. |
| `active` | `bool` | Marca el item como la página actual (sin enlace). |

## Ejemplo Separador Personalizado

```php
$breadcrumb = new Breadcrumb([
    'divider' => '>',
    'items' => [
        ['text' => 'Home', 'url' => '#'],
        ['text' => 'Library', 'active' => true]
    ]
]);

echo $breadcrumb->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::breadcrumb([
    'items' => [['text' => 'Home', 'url' => '/']]
]);
```
