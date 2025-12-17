# Componente Check

Crea casillas de verificación (checkboxes) y botones de opción (radios) consistentes cross-browser.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Form\Check;

$check = new Check([
    'name' => 'terminos',
    'label' => 'Acepto los términos y condiciones',
    'value' => 'si'
]);

echo $check->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `name` | `string` | `''` | Atributo `name` del input. |
| `type` | `string` | `'checkbox'` | Tipo de input: `'checkbox'` o `'radio'`. |
| `label` | `string` | `''` | Texto asociado al input. |
| `value` | `string` | `'1'` | Valor del input. |
| `checked` | `bool` | `false` | Si está seleccioando por defecto. |
| `switch` | `bool` | `false` | Activa el estilo "interruptor" (solo para checkbox). |
| `inline` | `bool` | `false` | Alinea el control en la misma línea que otros controles inline. |
| `attributes` | `array` | `[]` | Atributos adicionales para el input. |

## Ejemplo Switch

```php
$switch = new Check([
    'name' => 'notificaciones',
    'label' => 'Recibir notificaciones',
    'switch' => true,
    'checked' => true
]);

echo $switch->render();
```

## Ejemplo Radio Inline

```php
$radio1 = new Check([
    'name' => 'genero',
    'type' => 'radio',
    'label' => 'Masculino',
    'value' => 'm',
    'inline' => true
]);

$radio2 = new Check([
    'name' => 'genero',
    'type' => 'radio',
    'label' => 'Femenino',
    'value' => 'f',
    'inline' => true
]);

echo $radio1->render() . $radio2->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::check([
    'name' => 'agree',
    'label' => 'Terms'
]);
```
