# Componente Progress

Barras de progreso personalizables.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface\Progress;

$progress = new Progress([
    'value' => 50,
    'variant' => 'success'
]);

echo $progress->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `value` | `int` | `0` | Valor actual. |
| `min` | `int` | `0` | Valor mínimo. |
| `max` | `int` | `100` | Valor máximo. |
| `label` | `string` | `''` | Texto dentro de la barra. |
| `striped` | `bool` | `false` | Aplica rayas diagonales al fondo. |
| `animated` | `bool` | `false` | Anima las rayas (requiere `striped` o funciona igual modernamente). |
| `variant` | `string` | `null` | Color de la barra (`success`, `info`, `warning`, `danger`). |
| `height` | `int/string` | `null` | Altura en píxeles de la barra. |
| `attributes` | `array` | `[]` | Atributos adicionales. |

## Ejemplo Completo

```php
$progress = new Progress([
    'value' => 75,
    'label' => '75%',
    'striped' => true,
    'animated' => true,
    'variant' => 'info',
    'height' => 20
]);

echo $progress->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::progress([
    'value' => 75,
    'variant' => 'warning'
]);
```
