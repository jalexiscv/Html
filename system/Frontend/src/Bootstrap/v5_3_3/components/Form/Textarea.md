# Componente Textarea

Área de texto de múltiples líneas.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Form\Textarea;

$textarea = new Textarea([
    'name' => 'comentarios',
    'label' => 'Comentarios',
    'rows' => 4
]);

echo $textarea->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `name` | `string` | `''` | Nombre del campo. |
| `value` | `string` | `''` | Contenido inicial. |
| `label` | `string` | `null` | Etiqueta del campo. |
| `floating` | `bool` | `false` | Estilo Floating Label. |
| `rows` | `int` | `3` | Número de filas visibles. |
| `attributes` | `array` | `[]` | Atributos adicionales. |

## Ejemplo Floating Textarea

```php
$textarea = new Textarea([
    'name' => 'mensaje',
    'label' => 'Deja tu mensaje aquí',
    'floating' => true,
    'attributes' => ['style' => 'height: 100px']
]);

echo $textarea->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::textarea([
    'name' => 'message',
    'rows' => 4
]);
```
