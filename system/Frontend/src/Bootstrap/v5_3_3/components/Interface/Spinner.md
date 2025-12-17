# Componente Spinner

Indicadores de estado de carga.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface\Spinner;

$spinner = new Spinner([
    'variant' => 'primary'
]);

echo $spinner->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `type` | `string` | `'border'` | Tipo de animación: `'border'` (círculo giratorio) o `'grow'` (punto pulsante). |
| `variant` | `string` | `null` | Color del spinner (`primary`, `success`, etc.). Usa clases `text-{color}`. |
| `small` | `bool` | `false` | Version pequeña para usar dentro de botones o textos. |
| `text` | `string` | `'Loading...'` | Texto oculto para lectores de pantalla. |
| `attributes` | `array` | `[]` | Atributos adicionales. |

## Ejemplo Spinner en Botón

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface\Button;

$spinner = new Spinner([
    'type' => 'border',
    'small' => true,
    'attributes' => ['aria-hidden' => 'true']
]);

$btn = new Button([
    'content' => $spinner->render() . ' Cargando...',
    'variant' => 'primary',
    'attributes' => ['disabled' => 'disabled']
]);

echo $btn->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::spinner([
    'type' => 'grow',
    'variant' => 'success'
]);
```
