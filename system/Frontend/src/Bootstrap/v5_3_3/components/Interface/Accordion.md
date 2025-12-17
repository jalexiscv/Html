# Componente Accordion

El componente `Accordion` permite crear listas de elementos colapsables, útiles para organizar grandes cantidades de contenido en un espacio reducido.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface\Accordion;

$accordion = new Accordion([
    'items' => [
        [
            'title' => 'Elemento #1',
            'content' => 'Contenido del primer elemento.',
            'expanded' => true
        ],
        [
            'title' => 'Elemento #2',
            'content' => 'Contenido del segundo elemento.'
        ]
    ]
]);

echo $accordion->render();
```

## Opciones de Configuración

El constructor acepta un array de opciones:

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `items` | `array` | `[]` | Lista de elementos del acordeón. Ver estructura de items abajo. |
| `flush` | `bool` | `false` | Si es `true`, elimina los bordes y esquinas redondeadas para usar dentro de otros contenedores. |
| `always_open` | `bool` | `false` | Si es `true`, permite que múltiples items estén abiertos simultáneamente. Si es `false`, al abrir uno se cierran los demás. |
| `id` | `string` | `uniqid()` | ID único del contenedor principal. |
| `attributes` | `array` | `[]` | Atributos HTML adicionales para el contenedor principal. |

### Estructura de Items

Cada elemento en el array `items` debe ser un array asociativo con las siguientes claves:

| Clave | Tipo | Requerido | Descripción |
| :--- | :--- | :--- | :--- |
| `title` | `string` | Sí | Texto del encabezado del item (botón). |
| `content` | `string/html` | Sí | Contenido del cuerpo del item. |
| `expanded` | `bool` | No | Si `true`, el item aparecerá desplegado inicialmente. |

## Ejemplo Avanzado (Accordion Flush & Always Open)

```php
$accordion = new Accordion([
    'flush' => true,
    'always_open' => true,
    'items' => [
        [
            'title' => 'Sección A',
            'content' => 'Contenido A'
        ],
        [
            'title' => 'Sección B',
            'content' => 'Contenido B'
        ]
    ],
    'attributes' => ['class' => 'my-custom-accordion']
]);

echo $accordion->render();
```

## Acceso desde el Framework

Puedes acceder a este componente directamente desde la clase principal `Bootstrap`:

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::accordion([
    'items' => [
        ['title' => 'Item 1', 'content' => 'Contenido']
    ]
]);
```
