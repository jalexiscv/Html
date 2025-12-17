# Componente Nav

Navegación base para crear pestañas (tabs), botones (pills) y menús de barra de navegación.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Navigation\Nav;

$nav = new Nav([
    'items' => [
        ['text' => 'Enlace Activo', 'url' => '#', 'active' => true],
        ['text' => 'Enlace', 'url' => '#'],
        ['text' => 'Deshabilitado', 'url' => '#', 'disabled' => true]
    ]
]);

echo $nav->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `items` | `array` | `[]` | Lista de enlaces. Ver estructura abajo. |
| `tabs` | `bool` | `false` | Estilo pestañas (`nav-tabs`). |
| `pills` | `bool` | `false` | Estilo píldoras (`nav-pills`). |
| `navbar` | `bool` | `false` | Si es `true`, usa clase `navbar-nav` (para usar dentro de Navbar). |
| `fill` | `bool` | `false` | Distribuye el contenido ocupando todo el ancho. |
| `justified` | `bool` | `false` | Igual el ancho de todos los items. |
| `vertical` | `bool` | `false` | Alineación vertical (`flex-column`). |
| `element` | `string` | `'ul'` | Elemento HTML base (`ul`, `nav`). |
| `attributes` | `array` | `[]` | Atributos adicionales. |

### Estructura de Items

| Clave | Tipo | Descripción |
| :--- | :--- | :--- |
| `text` | `string` | Texto del enlace. |
| `url` | `string` | Destino del enlace (`href`). |
| `active` | `bool` | Estilo activo. |
| `disabled` | `bool` | Estilo deshabilitado. |

## Ejemplo de Pestañas (Tabs)

```php
$tabs = new Nav([
    'tabs' => true,
    'items' => [
        ['text' => 'Perfil', 'url' => '#', 'active' => true],
        ['text' => 'Mensajes', 'url' => '#']
    ]
]);

echo $tabs->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::nav([
    'items' => [['text' => 'Link', 'url' => '#']]
]);
```
