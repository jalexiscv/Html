# Componente Figure

Muestra contenido relacionado con una imagen y una leyenda opcional.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Content\Figure;

$figure = new Figure([
    'src' => 'imagen.jpg',
    'caption' => 'Una descripción de la imagen.',
    'alt' => 'Texto alternativo'
]);

echo $figure->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `src` | `string` | `''` | URL de la imagen. |
| `caption` | `string` | `''` | Texto de la leyenda (`figcaption`). |
| `alt` | `string` | `''` | Texto alternativo de la imagen. |
| `align` | `string` | `'start'` | Alineación de la leyenda: `'start'`, `'center'`, `'end'`. |
| `attributes` | `array` | `['class' => 'figure']` | Atributos adicionales para `<figure>`. |

## Ejemplo Alineado a la Derecha

```php
$figure = new Figure([
    'src' => 'foto.jpg',
    'caption' => 'Foto tomada en 2024.',
    'align' => 'end'
]);

echo $figure->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::figure([
    'src' => 'image.jpg',
    'caption' => 'Caption'
]);
```
