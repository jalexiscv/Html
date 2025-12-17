# Componente Form

Contenedor para formularios HTML.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Form\Form;
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Form\Input;
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface\Button;

$input = new Input(['name' => 'email', 'label' => 'Email', 'type' => 'email']);
$btn = new Button(['content' => 'Enviar', 'type' => 'submit']);

$form = new Form([
    'action' => '/login',
    'content' => $input->render() . $btn->render()
]);

echo $form->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `content` | `mixed` | `''` | Contenido interno del formulario. |
| `action` | `string` | `''` | URL a donde se envía el formulario. |
| `method` | `string` | `'POST'` | Método HTTP (`POST`, `GET`, etc). |
| `multipart` | `bool` | `false` | Si es `true`, añade `enctype="multipart/form-data"` (para subir archivos). |
| `attributes` | `array` | `[]` | Atributos adicionales. |

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::form([
    'action' => '/save',
    'content' => '...'
]);
```
