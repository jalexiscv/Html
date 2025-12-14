# Guía de Web Components con Higgs/Html

Los Web Components te permiten crear elementos HTML personalizados y reutilizables. Con nuestra biblioteca, puedes integrarlos fácilmente en tu aplicación PHP.

## Casos de Uso Comunes

1. **Tarjetas de Producto**
```php
<?php
use Higgs\Html\Html;

// Crear un componente de tarjeta de producto
$productCard = Html::webComponent('product-card', [
    'product-id' => '123',
    'price' => '99.99',
    'currency' => 'USD',
    'image-url' => '/images/product.jpg'
], '
    <img src="/images/product.jpg" alt="Producto">
    <h3>Nombre del Producto</h3>
    <p class="price">$99.99</p>
');

echo $productCard;
```

2. **Menú de Navegación Personalizado**
```php
<?php
// Crear un componente de navegación personalizado
$navMenu = Html::webComponent('nav-menu', [
    'theme' => 'dark',
    'position' => 'fixed'
], '
    <ul>
        <li><a href="/">Inicio</a></li>
        <li><a href="/productos">Productos</a></li>
        <li><a href="/contacto">Contacto</a></li>
    </ul>
');
```

3. **Formulario de Búsqueda Avanzada**
```php
<?php
$searchForm = Html::webComponent('search-form', [
    'endpoint' => '/api/search',
    'auto-complete' => 'true'
], '
    <input type="text" placeholder="Buscar...">
    <select name="category">
        <option value="">Todas las categorías</option>
        <option value="1">Electrónica</option>
        <option value="2">Ropa</option>
    </select>
    <button type="submit">Buscar</button>
');
```

## Integración con JavaScript

Para que los Web Components funcionen, necesitas registrar el componente en JavaScript:

```javascript
// product-card.js
class ProductCard extends HTMLElement {
    constructor() {
        super();
        
        // Acceder a los atributos definidos en PHP
        const productId = this.getAttribute('product-id');
        const price = this.getAttribute('price');
        
        // Implementar lógica del componente
        this.addEventListener('click', () => {
            this.addToCart(productId);
        });
    }
    
    addToCart(productId) {
        // Lógica para agregar al carrito
    }
}

customElements.define('product-card', ProductCard);
```

## Componentes Interactivos

1. **Modal Personalizado**
```php
<?php
$modal = Html::webComponent('custom-modal', [
    'title' => 'Confirmación',
    'closable' => 'true'
], '
    <h2 slot="header">¿Está seguro?</h2>
    <div slot="content">
        <p>Esta acción no se puede deshacer.</p>
    </div>
    <div slot="footer">
        <button class="confirm">Confirmar</button>
        <button class="cancel">Cancelar</button>
    </div>
');
```

2. **Selector de Fechas**
```php
<?php
$datePicker = Html::webComponent('date-picker', [
    'format' => 'YYYY-MM-DD',
    'min-date' => '2025-01-01',
    'max-date' => '2025-12-31'
], '
    <input type="text" readonly>
    <div class="calendar-container"></div>
');
```

## Mejores Prácticas

1. **Nombres de Componentes**
- Siempre usar guiones medios en los nombres (requisito de Web Components)
- Usar prefijos para evitar conflictos (ej: `app-header`, `ui-button`)

2. **Atributos**
- Usar atributos data- para información adicional
- Mantener los nombres de atributos en minúsculas
- Usar guiones para separar palabras en atributos

3. **Contenido**
- Utilizar slots para contenido dinámico
- Escapar correctamente el contenido HTML
- Considerar la accesibilidad

## Ejemplo Completo

```php
<?php
// Crear una página con múltiples componentes
$page = Html::tag('div', ['class' => 'container']);

// Agregar header personalizado
$header = Html::webComponent('app-header', [
    'user-logged' => 'true',
    'notifications' => '5'
]);

// Agregar barra lateral
$sidebar = Html::webComponent('app-sidebar', [
    'collapsed' => 'false'
]);

// Agregar contenido principal
$content = Html::webComponent('app-content', [
    'loading' => 'false'
]);

// Agregar footer
$footer = Html::webComponent('app-footer', [
    'show-social' => 'true'
]);

$page->content([$header, $sidebar, $content, $footer]);
echo $page;
```

## Consideraciones de Rendimiento

- Usar el sistema de caché para componentes frecuentes
- Minimizar el número de componentes por página
- Cargar los scripts de definición de componentes de manera eficiente

```php
<?php
// Usar caché para componentes frecuentes
$cachedButton = Html::webComponent('ui-button', [
    'type' => 'primary',
    'size' => 'large'
], 'Clic aquí', true); // El último parámetro activa el caché
```
