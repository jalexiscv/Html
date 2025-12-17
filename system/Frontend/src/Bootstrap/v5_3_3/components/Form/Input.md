# Componente Input

Campos de entrada de texto versátiles, incluyendo soporte para etiquetas flotantes.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Form\Input;

$input = new Input([
    'name' => 'username',
    'label' => 'Nombre de usuario',
    'placeholder' => 'Ej. usuario123'
]);

echo $input->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `name` | `string` | `''` | Nombre del campo. |
| `type` | `string` | `'text'` | Tipo de input (`text`, `password`, `email`, `number`, `color`, etc). |
| `value` | `string` | `null` | Valor inicial. |
| `label` | `string` | `null` | Texto de la etiqueta. Si está presente, envuelve el input. |
| `floating` | `bool` | `false` | Activa el estilo "Floating Labels" de Bootstrap. |
| `placeholder` | `string` | `null` | Texto placeholder. Requerido visualmente para floating labels. |
| `help_text` | `string` | `null` | Texto de ayuda debajo del input. |
| `id` | `string` | `null` | ID manual. Si no, se autogenera. |
| `attributes` | `array` | `[]` | Atributos adicionales (ej. `readonly`, `required`). |

## Ejemplo Floating Label y Ayuda

```php
$email = new Input([
    'type' => 'email',
    'name' => 'email',
    'label' => 'Correo Electrónico',
    'floating' => true,
    'help_text' => 'Nunca compartiremos tu correo con nadie más.',
    'attributes' => ['required' => 'required']
]);

echo $email->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::input([
    'name' => 'email',
    'type' => 'email'
]);
```
