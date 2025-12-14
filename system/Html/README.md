[![License](https://img.shields.io/packagist/l/Higgs/Html.svg?style=flat-square)](https://packagist.org/packages/codehiggs/html)
[![Say Thanks!](https://img.shields.io/badge/Say-thanks-brightgreen.svg?style=flat-square)](https://saythanks.io/to/jalexiscv)
[![Donate!](https://img.shields.io/badge/Donate-Paypal-brightgreen.svg?style=flat-square)](https://paypal.me/jalexiscv)

# Higgs HTML

## Descripción

Biblioteca PHP moderna, ligera y agnóstica para la generación de HTML puro. Diseñada con un enfoque en la seguridad, rendimiento y flexibilidad, sin dependencias de frameworks CSS específicos.

## Características Principales

- **Agnóstico**: Genera HTML limpio sin ataduras a Bootstrap, Tailwind ni otros frameworks.
- **Tipado Estricto**: Compatible con PHP 8.0+.
- **Fluido**: API encadenable para una escritura de código limpia y legible.
- **Seguro**: Escape automático de contenido para prevenir XSS.
- **Extensible**: Fácil de extender para crear tus propios sistemas de componentes.
- **Caché**: Sistema de caché integrado para rendimiento.

## Requisitos

* PHP 8.0 o superior

## Instalación

```bash
composer require Higgs/Html
```

## Uso Básico

```php
<?php
declare(strict_types=1);

use Higgs\Html\Html;

// Crear elementos HTML básicos
$div = Html::div(['class' => 'container'], 'Hola Mundo');

// Encadenamiento fluido
$button = Html::button('Click me')
    ->attr('class', 'btn btn-primary')
    ->attr('data-id', '123')
    ->id('my-button');

echo $button; 
// <button type="button" class="btn btn-primary" data-id="123" id="my-button">Click me</button>

// Listas
$list = Html::ul(['class' => 'list-group'])
    ->child(Html::li(['class' => 'list-item'], 'Item 1'))
    ->child(Html::li(['class' => 'list-item'], 'Item 2'));

// Imágenes
$img = Html::img('path/to/image.jpg', 'Descripción');

// Componentes Web Personalizados
$custom = Html::webComponent('user-card', ['user-id' => '42']);
```

## API

### Métodos Estáticos (Html)

La clase `Higgs\Html\Html` provee helpers estáticos para las etiquetas más comunes:

- `Html::div(array $attributes = [], mixed $content = null)`
- `Html::span(...)`
- `Html::p(...)`
- `Html::a(string $href, ...)`
- `Html::img(string $src, string $alt, ...)`
- `Html::button(...)`
- `Html::input(...)`
- `Html::tag(string $name, ...)` - Para cualquier otra etiqueta.

### Métodos de Instancia (TagInterface)

Todos los objetos retornados implementan `TagInterface` y soportan encadenamiento:

- `->attr(string $name, string $value)`: Establece un atributo.
- `->addClass(string $class)`: Agrega una clase CSS.
- `->id(string $id)`: Establece el ID.
- `->content(mixed $content)`: Establece el contenido.
- `->child(TagInterface $child)`: Agrega un elemento hijo.
- `->render()`: Retorna el string HTML final.

## Contribuir

1. Fork el repositorio
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## Licencia

Este proyecto está licenciado bajo la Licencia MIT - ver el archivo [LICENSE](LICENSE) para más detalles.
