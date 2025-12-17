# Componente Card

Contenedor de contenido flexible y extensible con múltiples variantes y opciones.

## Uso Básico

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface\Card;

$card = new Card([
    'title' => 'Título de la Tarjeta',
    'content' => 'Este es un ejemplo de texto rápido para construir sobre el título de la tarjeta y componer el contenido principal.',
    'image' => 'https://via.placeholder.com/300x200',
    'attributes' => ['style' => 'width: 18rem;']
]);

echo $card->render();
```

## Opciones de Configuración

| Opción | Tipo | Default | Descripción |
| :--- | :--- | :--- | :--- |
| `title` | `string` | `null` | Título principal de la tarjeta. Se renderiza como `h5.card-title`. |
| `content` | `mixed` | `''` | Cuerpo de la tarjeta. Si es string, se envuelve en `p.card-text`. |
| `header` | `mixed` | `null` | Contenido de la cabecera (`.card-header`). |
| `footer` | `mixed` | `null` | Contenido del pie (`.card-footer`). |
| `image` | `string` | `null` | URL de la imagen principal. |
| `image_position` | `string` | `'top'` | Posición de la imagen: `'top'` o `'bottom'`. |
| `attributes` | `array` | `[]` | Atributos para el contenedor principal `.card`. |
| `body_attributes` | `array` | `[]` | Atributos para el contenedor `.card-body`. |

## Ejemplo Completo

```php
$card = new Card([
    'header' => 'Destacado',
    'title' => 'Tratamiento Especial',
    'content' => 'Con texto de soporte adicional a continuación como introducción natural a contenido adicional.',
    'footer' => 'Hace 2 días',
    'attributes' => ['class' => 'text-center']
]);

echo $card->render();
```

## Acceso desde el Framework

```php
use Higgs\Frontend\Bootstrap\v5_3_3\Bootstrap;

echo Bootstrap::card([
    'title' => 'Titulo',
    'content' => 'Contenido...'
]);
```
