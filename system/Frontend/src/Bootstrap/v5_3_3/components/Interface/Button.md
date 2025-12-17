# Componente Button

Componente para crear botones estilizados con Bootstrap.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface\Button;

$button = new Button([
    'content' => 'Hacer Clic',
    'variant' => 'primary',
    'size' => 'lg'
]);

echo $button->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `content` | `string/mixed` | `''` | Texto o HTML interno del botón. |
| `variant` | `string` | `'primary'` | Color del botón (e.g., `primary`, `success`, `danger`). |
| `size` | `string|null` | `null` | Tamaño del botón: `'sm'` (pequeño) o `'lg'` (grande). |
| `type` | `string` | `'button'` | Atributo `type` HTML (`button`, `submit`, `reset`). |
| `outline` | `bool` | `false` | Si es `true`, aplica el estilo de contorno (`btn-outline-primary`). |
| `attributes` | `array` | `[]` | Atributos adicionales (e.g., `id`, `onclick`, `disabled`). |

## Ejemplo de Botón Outline y Deshabilitado

```php
$button = new Button([
    'content' => 'Cancelar',
    'variant' => 'secondary',
    'outline' => true,
    'attributes' => ['disabled' => 'disabled']
]);

echo $button->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::button([
    'content' => 'Guardar',
    'variant' => 'success'
]);
```
