# Componente Carousel

Componente de presentación de diapositivas para recorrer una serie de contenido.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface\Carousel;

$carousel = new Carousel([
    'slides' => [
        ['src' => 'img1.jpg', 'alt' => 'Primera imagen'],
        ['src' => 'img2.jpg', 'alt' => 'Segunda imagen'],
        ['src' => 'img3.jpg', 'alt' => 'Tercera imagen']
    ]
]);

echo $carousel->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `slides` | `array` | `[]` | Lista de diapositivas. Ver estructura abajo. |
| `controls` | `bool` | `true` | Muestra botones de Anterior/Siguiente. |
| `indicators` | `bool` | `true` | Muestra los indicadores (puntos) inferiores. |
| `fade` | `bool` | `false` | Usa una transición de desvanecimiento en lugar de deslizamiento. |
| `ride` | `bool/string` | `'carousel'` | Autoplay (`true`, `'carousel'` o `false`). |
| `id` | `string` | `uniqid()` | ID único del carrusel. |
| `attributes` | `array` | `[]` | Atributos adicionales para el contenedor principal. |

### Estructura de Slides

Cada elemento en `slides` es un array con:

| Clave | Tipo | Requerido | Descripción |
| :--- | :--- | :--- | :--- |
| `src` | `string` | Sí | URL de la imagen. |
| `alt` | `string` | No | Texto alternativo de la imagen. |
| `active` | `bool` | No | Si es la diapositiva inicial. Default: 1ra slide. |
| `caption_title` | `string` | No | Título de la leyenda. |
| `caption_text` | `string` | No | Texto descriptivo de la leyenda. |
| `interval` | `int` | No | Tiempo en ms para esta diapositiva específica (ej. 2000). |

## Ejemplo Completo con Leyendas (Captions)

```php
$carousel = new Carousel([
    'id' => 'myCarousel',
    'fade' => true,
    'slides' => [
        [
            'src' => 'landscape.jpg',
            'caption_title' => 'Naturaleza',
            'caption_text' => 'Una vista hermosa.',
            'interval' => 10000
        ],
        [
            'src' => 'city.jpg',
            'caption_title' => 'Ciudad',
            'caption_text' => 'Luces nocturnas.'
        ]
    ]
]);

echo $carousel->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::carousel([
    'slides' => [['src' => 'image.jpg']]
]);
```
