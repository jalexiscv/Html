# Componente Navbar

Encabezado de navegación responsivo para su sitio o aplicación.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Navigation\Navbar;
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Navigation\Nav;

// Contenido del navbar (links)
$nav = new Nav([
    'navbar' => true,
    'items' => [
        ['text' => 'Inicio', 'url' => '/', 'active' => true],
        ['text' => 'Características', 'url' => '/features']
    ]
]);

// Navbar principal
$navbar = new Navbar([
    'brand' => ['text' => 'MiMarca', 'url' => '/'],
    'variant' => 'dark',
    'bgBackground' => 'bg-dark',
    'content' => $nav->render()
]);

echo $navbar->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `brand` | `array` | `null` | Configuración de la marca. Ver abajo. |
| `expand` | `string` | `'lg'` | Punto de ruptura para colapsar (`sm`, `md`, `lg`, `xl`, `xxl`). |
| `variant` | `string` | `'light'` | Tema de color (`light`, `dark`). Afecta color de texto. |
| `bgBackground` | `string` | `'bg-light'` | Clase CSS para el fondo (`bg-primary`, `bg-dark`, etc). |
| `content` | `mixed` | `''` | Contenido interno (usualmente un componente `Nav` o formularios). |
| `container` | `bool` | `true` | Si envuelve el contenido en un contenedor. |
| `container_type` | `string` | `'container-fluid'` | Tipo de contenedor si `container` es true. |
| `attributes` | `array` | `[]` | Atributos adicionales. |

### Configuración de Marca (Brand)

```php
'brand' => [
    'text' => 'Nombre',
    'url' => '/',
    'image' => '/logo.png' // Opcional
]
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::navbar([
    'brand' => ['text' => 'MyBrand'],
    'variant' => 'dark'
]);
```
