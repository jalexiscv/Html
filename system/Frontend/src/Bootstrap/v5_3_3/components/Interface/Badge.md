# Componente Badge

Componente `Badge` (insignia) para etiquetas, conteos y más.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface\Badge;

$badge = new Badge([
    'content' => 'Nuevo',
    'variant' => 'success'
]);

echo $badge->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `content` | `string` | `''` | Texto o contenido HTML dentro del badge. |
| `variant` | `string` | `'primary'` | Define el color de fondo. Utiliza las clases `text-bg-{variant}`. |
| `rounded` | `bool` | `false` | Si es `true`, aplica bordes completamente redondeados (`rounded-pill`). |
| `pill` | `bool` | `false` | Alias de `rounded`. |
| `attributes` | `array` | `[]` | Atributos adicionales para el elemento `<span>`. |

## Ejemplo de Badge en Botón

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface\Button;
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface\Badge;

$badge = new Badge([
    'content' => '4',
    'variant' => 'light',
    'rounded' => true
]);

$button = new Button([
    'content' => 'Notificaciones ' . $badge->render(),
    'variant' => 'primary'
]);

echo $button->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::badge([
    'content' => 'New',
    'variant' => 'info'
]);
```
