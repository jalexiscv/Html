# Componente File

Entrada para selección de archivos.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Form\File;

$fileInput = new File([
    'name' => 'documento',
    'label' => 'Subir documento'
]);

echo $fileInput->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `name` | `string` | `''` | Atributo `name` del input. |
| `label` | `string` | `null` | Etiqueta del campo. Si existe, envuelve todo en un `div.mb-3`. |
| `multiple` | `bool` | `false` | Permite seleccionar múltiples archivos. |
| `attributes` | `array` | `[]` | Atributos adicionales (ej. `accept`). |

## Ejemplo Múltiple con Restricción de Tipo

```php
$fileInput = new File([
    'name' => 'imagenes[]',
    'label' => 'Galería de fotos',
    'multiple' => true,
    'attributes' => ['accept' => 'image/*']
]);

echo $fileInput->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::file([
    'name' => 'avatar',
    'label' => 'Subir Avatar'
]);
```
