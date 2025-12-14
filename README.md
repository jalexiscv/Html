[![License](https://img.shields.io/packagist/l/Higgs/Html.svg?style=flat-square)](https://packagist.org/packages/codehiggs/html)
[![Say Thanks!](https://img.shields.io/badge/Say-thanks-brightgreen.svg?style=flat-square)](https://saythanks.io/to/jalexiscv)
[![Donate!](https://img.shields.io/badge/Donate-Paypal-brightgreen.svg?style=flat-square)](https://paypal.me/jalexiscv)

# HTML

## Descripción

Biblioteca PHP moderna para la generación de HTML con implementación completa de Bootstrap 5. Diseñada con un enfoque en la seguridad, accesibilidad y mantenibilidad del código.

## Características Principales

- Implementación completa de Bootstrap 5 con tipado estricto
- Sistema de componentes extensible y personalizable
- Validación automática de opciones y atributos
- Soporte completo para ARIA y accesibilidad
- Integración con JavaScript y eventos
- Generación segura de HTML con escape automático
- Caché de componentes para mejor rendimiento

## Requisitos

* PHP 8.0 o superior
* Composer 2.6 o superior
* Bootstrap 5.x (vía CDN)

## Instalación

```bash
composer require Higgs/Html
```

Incluye Bootstrap en tu HTML:
```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Tu contenido aquí -->

    <!-- JavaScript de Bootstrap (al final del body) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```

## Uso Básico

```php
<?php
declare(strict_types=1);

use Higgs\Html\Html;
use Higgs\Html\Components\Bootstrap5\Bootstrap as BS5;

// Crear elementos HTML básicos
$div = Html::tag('div', ['class' => 'container']);
$h1 = Html::tag('h1', ['class' => 'mt-4'], 'Bienvenido');

// Alerta con botón de cierre
$alert = BS5::alert(
    '¡Operación exitosa!', 
    'success',
    true
)->render();

// Formulario con validación
$form = BS5::form([
    'action' => '/procesar',
    'method' => 'POST'
])
->content([
    BS5::input('text', 'nombre', [
        'class' => 'form-control',
        'required' => true,
        'pattern' => '[A-Za-z\s]+'
    ])->render(),
    
    BS5::button('Enviar', 'primary', [
        'type' => 'submit'
    ])->render()
])
->render();

// Modal con eventos
$modal = BS5::modal('ejemploModal', [
    'class' => 'fade',
    'tabindex' => '-1'
])
->setTitle('Título del Modal')
->setBody('Contenido del modal...')
->setFooter([
    BS5::button('Cerrar', 'secondary', [
        'data-bs-dismiss' => 'modal'
    ])->render()
])
->render();

$trigger = BS5::button('Abrir Modal', 'primary', [
    'data-bs-toggle' => 'modal',
    'data-bs-target' => '#ejemploModal'
])->render();
```

## Componentes Disponibles

### Layout
- Container
- Grid (Row/Col)
- Breakpoints

### Contenido
- Typography
- Tables
- Images

### Formularios
- Input
- Select
- Check/Radio
- File
- Textarea
- Range

### Navegación
- Navbar
- Nav
- Breadcrumb
- Pagination
- Tabs

### Componentes UI
- Alert
- Badge
- Button
- Card
- Dropdown
- ListGroup

### Componentes Interactivos
- Modal
- Tooltip
- Popover
- Collapse
- Accordion
- Carousel

## Documentación Detallada

La documentación completa está disponible en el directorio `docs/`:

- [01-instalacion.md](docs/01-instalacion.md) - Guía de instalación
- [02-componentes.md](docs/02-componentes.md) - Componentes básicos
- [03-formularios.md](docs/03-formularios.md) - Formularios y validación
- [04-navegacion.md](docs/04-navegacion.md) - Componentes de navegación
- [05-layout.md](docs/05-layout.md) - Sistema de grid y layout
- [06-contenido.md](docs/06-contenido.md) - Componentes de contenido
- [07-javascript.md](docs/07-javascript.md) - Integración con JavaScript
- [08-extras.md](docs/08-extras.md) - Características adicionales

## Contribuir

1. Fork el repositorio
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## Licencia

Este proyecto está licenciado bajo la Licencia MIT - ver el archivo [LICENSE](LICENSE) para más detalles.

## Agradecimientos

- Bootstrap Team por su excelente framework
- Contribuidores y usuarios de la biblioteca
