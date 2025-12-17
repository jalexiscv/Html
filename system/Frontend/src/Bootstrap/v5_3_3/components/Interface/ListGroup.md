# Componente ListGroup

Muestra una serie de contenido en listas, con clases y estilos flexibles.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface\ListGroup;

$list = new ListGroup([
    'items' => [
        ['text' => 'Primer elemento'],
        ['text' => 'Segundo elemento'],
        ['text' => 'Tercer elemento']
    ]
]);

echo $list->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `items` | `array` | `[]` | Lista de elementos. Ver estructura abajo. |
| `flush` | `bool` | `false` | Elimina bordes externos para usar en tarjetas. |
| `numbered` | `bool` | `false` | Crea una lista ordenada (`ol`) con números. |
| `horizontal` | `bool` | `false` | Cambia la orientación a horizontal. |
| `attributes` | `array` | `[]` | Atributos adicionales. |

### Estructura de Items

| Clave | Tipo | Descripción |
| :--- | :--- | :--- |
| `text` | `string` | Contenido del elemento. |
| `url` | `string` | Si se especifica, el elemento será un enlace (`a`). |
| `active` | `bool` | Marca el elemento como activo. |
| `disabled` | `bool` | Deshabilita el elemento. |
| `type` | `string` | Si es `'button'`, se renderiza como `<button>`. |

## Ejemplo con Enlaces (Actionable List Group)

```php
$list = new ListGroup([
    'items' => [
        ['text' => 'Inicio', 'url' => '/', 'active' => true],
        ['text' => 'Perfil', 'url' => '/profile'],
        ['text' => 'Ajustes', 'url' => '/settings', 'disabled' => true]
    ]
]);

echo $list->render();
```

## Ejemplo Numerado

```php
$list = new ListGroup([
    'numbered' => true,
    'items' => [
        ['text' => 'Cras justo odio'],
        ['text' => 'Dapibus ac facilisis in']
    ]
]);

echo $list->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::listGroup([
    'items' => [['text' => 'Item 1']]
]);
```
