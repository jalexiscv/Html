# Clase Cards - Bootstrap 5

Esta clase permite crear tarjetas de Bootstrap 5 de manera fluida y orientada a objetos, utilizando la clase base `Html` para generar el HTML.

## Características

- Creación de tarjetas Bootstrap 5 con todos sus elementos
- Soporte para tarjetas horizontales y verticales
- Posicionamiento flexible de imágenes (superior, inferior, superpuesta)
- API fluida para encadenamiento de métodos
- Generación de HTML seguro usando la clase base `Html`
- Personalización completa de atributos y clases CSS

## Uso Básico

```php
use App\Libraries\Html\Bootstrap\Cards;

// Crear una tarjeta básica
$card = new Cards([
    'title' => 'Título de la Tarjeta',
    'text' => 'Contenido de la tarjeta'
]);

// Renderizar la tarjeta
echo $card;
```

HTML generado:
```html
<div class="card" id="card-5f3e2d1">
    <div class="card-body">
        <h1 class="card-title">Título de la Tarjeta</h1>
        <p class="card-text">Contenido de la tarjeta</p>
    </div>
</div>
```

## Métodos Disponibles

### Constructor

```php
$card = new Cards([
    'id' => 'mi-tarjeta',
    'class' => 'card custom-class',
    'title' => 'Título',
    'subtitle' => 'Subtítulo',
    'text' => 'Texto principal',
    'header' => 'Encabezado',
    'footer' => 'Pie',
    'image' => 'ruta/imagen.jpg',
    'imagePosition' => 'top', // top, bottom, overlay
    'horizontal' => false
]);
```

### Métodos de Configuración

```php
// Establecer título
$card->set_Title('Nuevo Título', ['class' => 'custom-title']);

// Establecer subtítulo
$card->set_Subtitle('Nuevo Subtítulo', ['class' => 'custom-subtitle']);

// Establecer texto
$card->set_Text('Nuevo texto para la tarjeta');

// Agregar imagen
$card->set_Image('ruta/imagen.jpg', 'Texto alternativo', 'top', ['class' => 'custom-img']);

// Establecer encabezado
$card->set_Header('Contenido del encabezado', ['class' => 'custom-header']);

// Establecer pie
$card->set_Footer('Contenido del pie', ['class' => 'custom-footer']);

// Hacer la tarjeta horizontal
$card->set_Horizontal(true);

// Agregar botones
$card->add_Button('Click Me', [
    'class' => 'btn btn-primary',
    'type' => 'button'
]);

// Agregar botones al encabezado
$card->add_HeaderButton('Editar', [
    'class' => 'btn btn-sm btn-secondary float-end'
]);
```

## Ejemplos

### Tarjeta Básica

```php
$card = new Cards([
    'title' => 'Título Simple',
    'text' => 'Contenido de ejemplo'
]);
echo $card;
```

HTML generado:
```html
<div class="card" id="card-5f3e2d1">
    <div class="card-body">
        <h1 class="card-title">Título Simple</h1>
        <p class="card-text">Contenido de ejemplo</p>
    </div>
</div>
```

### Tarjeta con Botones en el Encabezado

```php
$card = new Cards();
$card->set_Header('Gestión de Usuario')
     ->add_HeaderButton('Editar', ['class' => 'btn btn-sm btn-primary float-end'])
     ->add_HeaderButton('Eliminar', ['class' => 'btn btn-sm btn-danger float-end ms-1'])
     ->set_Title('Juan Pérez')
     ->set_Text('Información del perfil de usuario')
     ->add_Button('Ver Detalles');
echo $card;
```

HTML generado:
```html
<div class="card" id="card-5f3e2d6">
    <div class="card-header">
        Gestión de Usuario
        <button type="button" class="btn btn-sm btn-danger float-end ms-1">Eliminar</button>
        <button type="button" class="btn btn-sm btn-primary float-end">Editar</button>
    </div>
    <div class="card-body">
        <h1 class="card-title">Juan Pérez</h1>
        <p class="card-text">Información del perfil de usuario</p>
        <button type="button" class="btn btn-primary">Ver Detalles</button>
    </div>
</div>
```

### Tarjeta con Imagen

```php
$card = new Cards();
$card->set_Image('imagen.jpg', 'Descripción')
     ->set_Title('Título')
     ->set_Text('Contenido')
     ->add_Button('Leer más');
echo $card;
```

HTML generado:
```html
<div class="card" id="card-5f3e2d2">
    <img src="imagen.jpg" alt="Descripción" class="card-img-top">
    <div class="card-body">
        <h1 class="card-title">Título</h1>
        <p class="card-text">Contenido</p>
        <button type="button" class="btn btn-primary">Leer más</button>
    </div>
</div>
```

### Tarjeta Horizontal

```php
$card = new Cards();
$card->set_Horizontal(true)
     ->set_Image('imagen.jpg', 'Descripción')
     ->set_Title('Título')
     ->set_Text('Contenido')
     ->add_Button('Ver detalles');
echo $card;
```

HTML generado:
```html
<div class="card card-horizontal" id="card-5f3e2d3">
    <div class="row g-0">
        <div class="col-md-4">
            <img src="imagen.jpg" alt="Descripción" class="card-img-top">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h1 class="card-title">Título</h1>
                <p class="card-text">Contenido</p>
                <button type="button" class="btn btn-primary">Ver detalles</button>
            </div>
        </div>
    </div>
</div>
```

### Tarjeta Completa con Encabezado y Pie

```php
$card = new Cards();
$card->set_Header('Encabezado')
     ->set_Image('imagen.jpg', 'Descripción')
     ->set_Title('Título Principal')
     ->set_Subtitle('Subtítulo')
     ->set_Text('Contenido detallado de la tarjeta')
     ->add_Button('Acción Principal', ['class' => 'btn btn-primary'])
     ->add_Button('Acción Secundaria', ['class' => 'btn btn-secondary'])
     ->set_Footer('Pie de la tarjeta');
echo $card;
```

HTML generado:
```html
<div class="card" id="card-5f3e2d4">
    <div class="card-header">Encabezado</div>
    <img src="imagen.jpg" alt="Descripción" class="card-img-top">
    <div class="card-body">
        <h1 class="card-title">Título Principal</h1>
        <h1 class="card-subtitle mb-2 text-muted">Subtítulo</h1>
        <p class="card-text">Contenido detallado de la tarjeta</p>
        <button type="button" class="btn btn-primary">Acción Principal</button>
        <button type="button" class="btn btn-secondary">Acción Secundaria</button>
    </div>
    <div class="card-footer">Pie de la tarjeta</div>
</div>
```

### Tarjeta con Imagen Superpuesta

```php
$card = new Cards();
$card->set_Image('imagen.jpg', 'Descripción', 'overlay')
     ->set_Title('Título sobre Imagen')
     ->set_Text('Texto sobre imagen');
echo $card;
```

HTML generado:
```html
<div class="card text-white" id="card-5f3e2d5">
    <img src="imagen.jpg" alt="Descripción" class="card-img-overlay">
    <div class="card-img-overlay">
        <h1 class="card-title">Título sobre Imagen</h1>
        <p class="card-text">Texto sobre imagen</p>
    </div>
</div>
```

## Notas

- La clase utiliza la clase base `Html` para generar HTML seguro
- Todos los métodos de configuración son encadenables
- Los atributos HTML y clases CSS son completamente personalizables
- Compatible con todas las variantes de tarjetas de Bootstrap 5

### Consideraciones de Seguridad

- Todo el contenido HTML es escapado automáticamente para prevenir XSS
- Los atributos son validados y sanitizados
- Las clases CSS son filtradas para prevenir inyección de código malicioso

### Requisitos

- PHP 5.6 o superior
- Bootstrap 5.x
- Clase base `Html` del framework

### Mejores Prácticas

1. **Imágenes**:
   - Usar imágenes optimizadas para web
   - Especificar siempre el atributo `alt`
   - Considerar el ratio de aspecto según el diseño

2. **Contenido**:
   - Mantener títulos concisos
   - Usar subtítulos para información complementaria
   - Limitar el texto a lo esencial

3. **Botones**:
   - Usar verbos de acción en las etiquetas
   - Mantener consistencia en los estilos
   - Limitar el número de botones por tarjeta

4. **Diseño Responsivo**:
   - Probar las tarjetas en diferentes tamaños de pantalla
   - Usar clases Bootstrap para control responsivo
   - Considerar el modo horizontal solo cuando sea necesario
