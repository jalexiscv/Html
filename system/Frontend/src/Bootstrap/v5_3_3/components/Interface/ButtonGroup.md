# Componente ButtonGroup

Agrupa una serie de botones en una sola línea o columna.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface\ButtonGroup;
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface\Button;

$btn1 = new Button(['content' => 'Izquierda']);
$btn2 = new Button(['content' => 'Centro']);
$btn3 = new Button(['content' => 'Derecha']);

$group = new ButtonGroup([
    'buttons' => [$btn1, $btn2, $btn3],
    'attributes' => ['aria-label' => 'Grupo de ejemplo']
]);

echo $group->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `buttons` | `array` | `[]` | Array de instancias `Button` o cualquier `TagInterface`. |
| `vertical` | `bool` | `false` | Si es `true`, apila los botones verticalmente. |
| `size` | `string|null` | `null` | Tamaño del grupo: `'sm'` o `'lg'`. Aplica a todos los botones. |
| `attributes` | `array` | `[]` | Atributos adicionales para el contenedor `div`. |

## Ejemplo Vertical

```php
$group = new ButtonGroup([
    'buttons' => [$btn1, $btn2],
    'vertical' => true
]);

echo $group->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::buttonGroup([
    'buttons' => [$btn1, $btn2]
]);
```
