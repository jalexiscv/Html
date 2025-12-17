# Componente Radio

Botón de opción (radio button) para seleccionar una única opción de un grupo.

> **Nota**: Esta clase es una extensión directa de [Check](Check.md) forzando el tipo `radio`.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Form\Radio;

$radio = new Radio([
    'name' => 'opciones_envio',
    'value' => 'express',
    'label' => 'Envío Express'
]);

echo $radio->render();
```

## Opciones

Hereda todas las opciones de `Check`, excepto `type` (fijado a `'radio'`) y `switch` (no aplica visualmente estándar a radios).

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `name` | `string` | `''` | Nombre del grupo de radios. |
| `label` | `string` | `''` | Etiqueta visible. |
| `value` | `string` | `'1'` | Valor al enviar el formulario. |
| `checked` | `bool` | `false` | Si está seleccionado. |
| `inline` | `bool` | `false` | Alineación en línea. |

## Ejemplo Grupo de Radios

```php
$r1 = new Radio(['name' => 'color', 'value' => 'rojo', 'label' => 'Rojo', 'inline' => true]);
$r2 = new Radio(['name' => 'color', 'value' => 'azul', 'label' => 'Azul', 'inline' => true, 'checked' => true]);

echo $r1->render() . $r2->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::radio([
    'name' => 'color',
    'value' => 'red',
    'label' => 'Red'
]);
```
