[![License](https://img.shields.io/packagist/l/Higgs/Html.svg?style=flat-square)](https://packagist.org/packages/codehiggs/html)
[![Say Thanks!](https://img.shields.io/badge/Say-thanks-brightgreen.svg?style=flat-square)](https://saythanks.io/to/jalexiscv)
[![Donate!](https://img.shields.io/badge/Donate-Paypal-brightgreen.svg?style=flat-square)](https://paypal.me/jalexiscv)

# Higgs HTML: Generador de HTML Puro y Agnóstico

> **[Leer en Español](README.md)** | **[Read in English](README.en.md)**

> **"La pureza del código comienza con la independencia de las herramientas."**

**Higgs HTML** es una biblioteca de ingeniería de software para PHP diseñada para la generación programática de marcado HTML. A diferencia de otros helpers o builders que acoplan la lógica a frameworks CSS específicos (como Bootstrap o Tailwind), Higgs HTML se adhiere estrictamente a una filosofía **agnóstica**, ofreciendo una capa de abstracción pura, segura y de alto rendimiento.

---

## 💡 Filosofía y Diseño

La librería fue concebida bajo tres pilares fundamentales que guían su arquitectura interna:

### 1. Agnosticismo Estructural
El HTML generado no debe suponer clases, estructuras o jerarquías impuestas por una librería de estilos visuales. `Higgs\Html` genera **HTML Semántico Estándar (W3C)**. Esto garantiza:
- **Longevidad:** Tu código PHP no se rompe cuando cambias de Bootstrap 4 a 5, o de Tailwind a Bulma.
- **Flexibilidad:** Tú tienes el control total de los atributos `class`, `id` y `data-*`.

### 2. Rendimiento (Memory & CPU)
Bajo el capó, la librería implementa patrones de optimización agresivos:
- **Singleton de Instancias (Caché):** Cuando solicitas una etiqueta común repetidamente, la librería puede clonar una instancia `prototype` previamente almacenada en memoria en lugar de reconstruir el objeto desde cero.
- **Lazy Rendering:** La cadena de texto HTML solo se ensambla en el último milisegundo posible (`__toString()`).

### 3. Seguridad por Defecto
La inyección de código (XSS) es mitigada activamente.
- **Validación de Atributos:** Todos los valores de atributos son escapados automáticamente (`htmlspecialchars`).
- **Control de Contenido:** El contenido inseguro insertado via métodos estándar es tratado como texto plano.

---

## 🏗️ Arquitectura Técnica

La librería sigue los estándares **PSR-4** y **PSR-12**, utilizando características modernas de PHP 8.2+:

- **Fluent Interface (Builder Pattern):** Permite encadenar métodos para configurar el objeto de manera legible y compacta.
- **Factory Pattern:** El núcleo `Html::tag()` actúa como una fábrica inteligente que decide si instanciar un nuevo objeto o clonar uno de la caché.
- **Traits de Composición:** `HtmlElementsTrait` inyecta capacidades semánticas (métodos como `div()`, `span()`) sin herencia rígida, permitiendo que la clase `Html` permanezca ligera (`final class`).

---

## 📋 Requisitos del Sistema

- **PHP**: 8.2 o superior.
- **Extensiones**: `json` (opcional, para atributos de datos complejos).

---

## 🚀 Instalación

### Opción A: Composer (Recomendada)
Para proyectos profesionales con gestión de dependencias:
```bash
composer require Higgs/Html
```

### Opción B: Manual (Stand-alone)
Si no utilizas Composer, puedes integrar la librería directamente gracias a nuestro autoloader nativo:
1. Descarga/Clona este repositorio en tu carpeta de librerías (ej. `system/Html`).
2. Requiere el archivo de carga:
```php
require_once '/path/to/system/Html/autoload.php';
// La librería está lista para usar.
```

---

## 📖 Guía de Uso

### 1. La Interfaz Fluida
Olvídate de concatenar strings y abrir/cerrar etiquetas manualmente.

```php
use Higgs\Html\Html;

// Generación limpia y legible
echo Html::button('Guardar Cambios')
    ->type('submit')
    ->addClass('btn btn-primary shadow-sm')
    ->attr('data-action', 'save')
    ->attr('onclick', 'validate()');
```

**Salida:**
```html
<button type="submit" class="btn btn-primary shadow-sm" data-action="save" onclick="validate()">Guardar Cambios</button>
```

### 2. Estructuras Anidadas (Árboles DOM)
Puedes construir estructuras complejas anidando elementos.

```php
$card = Html::div(['class' => 'card'])
    ->child(
        Html::div(['class' => 'card-header'], 'Título del Panel')
    )
    ->child(
        Html::div(['class' => 'card-body'])
            ->child(Html::p([], 'Contenido dinámico...'))
            ->child(Html::a('/more', 'Leer más', ['class' => 'btn-link']))
    );

echo $card;
```

### 3. Helpers Semánticos
La librería provee métodos estáticos para la mayoría de etiquetas HTML5 estándar, mejorando el autocompletado del IDE y la legibilidad.

| Método | HTML Generado | Uso Típico |
|--------|---------------|------------|
| `Html::div()` | `<div>` | Contenedores genéricos |
| `Html::img()` | `<img>` | Imágenes con alt text |
| `Html::a()` | `<a>` | Enlaces e hipervínculos |
| `Html::ul()`, `Html::li()` | `<ul>`, `<li>` | Listas |
| `Html::input()` | `<input>` | Campos de formulario |
| `Html::meta()` | `<meta>` | SEO y cabeceras |

### 4. Helpers de Formularios Avanzados (v2.5)
Olvida el HTML manual para inputs complejos.

```php
// Select con opciones
echo Html::select('country', ['CO' => 'Colombia', 'US' => 'USA'], 'CO', ['class' => 'form-select']);

// Checkbox con label
echo Html::checkbox('subscribe', 1, true); 

// Inputs específicos
echo Html::email('user_email');
echo Html::password('user_password');
```

### 5. Generador de Tablas (v2.5)
Renderiza tablas de datos en una sola línea.

```php
$headers = ['ID', 'Nombre', 'Rol'];
$rows = [
    ['1', 'Ana', 'Admin'],
    ['2', 'Carlos', 'User'],
];

echo Html::table($headers, $rows, ['class' => 'table table-striped']);
```

### 6. Sistema de Macros (Extensibilidad)
¿Necesitas un componente personalizado? Registra tu propia macro.

```php
Html::macro('alert', function($msg, $type = 'info') {
    return Html::div(['class' => "alert alert-$type"], $msg);
});

// Uso
echo Html::alert('¡Operación exitosa!', 'success');
```

### 7. Clases Condicionales (Smart Classes) (v2.6)
Olvídate de concatenar ternarios para tus clases CSS.

```php
$isActive = true;
echo Html::div(['class' => [
    'btn',
    'btn-primary', 
    'active' => $isActive,    // Se agrega solo si es true
    'disabled' => !$isActive  // Lógica condicional limpia
]]);
```

### 8. Multimedia (v2.6)
Soporte nativo para audio y video.

```php
// Audio simple
echo Html::audio('song.mp3', ['controls' => true]);

// Video con múltiples fuentes
echo Html::video([
    ['src' => 'video.mp4', 'type' => 'video/mp4'],
    ['src' => 'video.webm', 'type' => 'video/webm']
], 'poster.jpg', ['controls' => true]);
```

### 9. Web Components (HTML Personalizado)
Para aplicaciones modernas que usan Custom Elements (JS), `Higgs\Html` valida y soporta etiquetas personalizadas.

```php
// Validado automáticamente: debe contener un guión '-'
echo Html::webComponent('user-avatar', ['src' => 'profile.jpg', 'size' => 'lg']);
```

---

## 📂 Ejemplos Ejecutables

Hemos preparado una suite de ejemplos prácticos en el directorio `examples/` para acelerar tu integración:

- **[01-basics.php](examples/01-basics.php)**: Fundamentos de creación, atributos y renderizado.
- **[02-forms.php](examples/02-forms.php)**: Construcción avanzada de formularios validados.

Para entender la estructura de archivos PSR-4 del proyecto, consulta **[docs/structure.md](docs/structure.md)**.

---

## 🤝 Contribución

Este proyecto es Open Source y vive gracias a la comunidad.
1. Haz Fork del repositorio.
2. Crea tu rama (`git checkout -b feature/AmazingFeature`).
3. Asegúrate de ejecutar los tests (`composer test`).
4. Haz Commit (`git commit -m 'Add: New global helper'`).
5. Abre un Pull Request.

---

## 📜 Licencia

Distribuido bajo la Licencia **MIT**. Ver [LICENSE](LICENSE) para más información.

---
*Desarrollado con ❤️ para la comunidad PHP por José Alexis Correa Valencia.*

---

## 🤝 Soporte y Contribuciones

¡Damos la bienvenida a las contribuciones para mejorar Higgs Html!

Si encuentras algún problema, por favor abre un issue en GitHub.

---

## 👨‍💻 Autor

**Jose Alexis Correa Valencia**
*Full Stack Developer & Software Architect*

*   **GitHub**: [@jalexiscv](https://github.com/jalexiscv)
*   **Email**: jalexiscv@gmail.com
*   **Ubicación**: Colombia

---

## ❤️ Donaciones

Si esta librería te ha ayudado a ti o a tu negocio, por favor considera hacer una pequeña donación para apoyar su desarrollo continuo y mantenimiento.

| Método | Detalles |
| :--- | :--- |
| **PayPal** | [jalexiscv@gmail.com](https://www.paypal.com/paypalme/anssible) |
| **Nequi (Colombia)** | `3117977281` |

*¡Gracias por tu apoyo!*
