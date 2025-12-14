[![License](https://img.shields.io/packagist/l/Higgs/Html.svg?style=flat-square)](https://packagist.org/packages/codehiggs/html)
[![Say Thanks!](https://img.shields.io/badge/Say-thanks-brightgreen.svg?style=flat-square)](https://saythanks.io/to/jalexiscv)
[![Donate!](https://img.shields.io/badge/Donate-Paypal-brightgreen.svg?style=flat-square)](https://paypal.me/jalexiscv)

# Higgs HTML: Pure & Agnostic HTML Generator

> **[Leer en Español](README.md)** | **[Read in English](README.en.md)**

> **"Code purity begins with tool independence."**

**Higgs HTML** is a software engineering library for PHP designed for programmatic HTML markup generation. Unlike other helpers or builders that couple logic to specific CSS frameworks (like Bootstrap or Tailwind), Higgs HTML adheres strictly to an **agnostic** philosophy, offering a pure, safe, and high-performance abstraction layer.

---

## 💡 Philosophy & Design

The library was conceived under three fundamental pillars that guide its internal architecture:

### 1. Structural Agnosticism
The generated HTML must not assume classes, structures, or hierarchies imposed by a visual style library. `Higgs\Html` generates **Standard Semantic HTML (W3C)**. This guarantees:
- **Longevity:** Your PHP code doesn't break when you switch from Bootstrap 4 to 5, or from Tailwind to Bulma.
- **Flexibility:** You have total control over `class`, `id`, and `data-*` attributes.

### 2. Performance (Memory & CPU)
Under the hood, the library implements aggressive optimization patterns:
- **Instance Singleton (Cache):** When you request a common tag repeatedly, the library can clone a `prototype` instance previously stored in memory instead of rebuilding the object from scratch.
- **Lazy Rendering:** The HTML string is only assembled at the last possible millisecond (`__toString()`).

### 3. Default Security
Code injection (XSS) is actively mitigated.
- **Attribute Validation:** All attribute values are automatically escaped (`htmlspecialchars`).
- **Content Control:** Unsafe content inserted via standard methods is treated as plain text.

---

## 🏗️ Technical Architecture

The library follows **PSR-4** and **PSR-12** standards, using modern PHP 8.2+ features:

- **Fluent Interface (Builder Pattern):** Allows method chaining to configure the object in a readable and compact way.
- **Factory Pattern:** The core `Html::tag()` acts as a smart factory that decides whether to instantiate a new object or clone one from the cache.
- **Composition Traits:** `HtmlElementsTrait` injects semantic capabilities (methods like `div()`, `span()`) without rigid inheritance, allowing the `Html` class to remain lightweight (`final class`).

---

## 📋 System Requirements

- **PHP**: 8.2 or higher.
- **Extensions**: `json` (optional, for complex data attributes).

---

## 🚀 Installation

### Option A: Composer (Recommended)
For professional projects with dependency management:
```bash
composer require Higgs/Html
```

### Option B: Manual (Stand-alone)
If you don't use Composer, you can integrate the library directly thanks to our native autoloader:
1. Download/Clone this repository into your library folder (e.g. `system/Html`).
2. Require the loader file:
```php
require_once '/path/to/system/Html/autoload.php';
// The library is ready to use.
```

---

## 📖 Usage Guide

### 1. Fluent Interface
Forget about concatenating strings and manually opening/closing tags.

```php
use Higgs\Html\Html;

// Clean and readable generation
echo Html::button('Save Changes')
    ->type('submit')
    ->addClass('btn btn-primary shadow-sm')
    ->attr('data-action', 'save')
    ->attr('onclick', 'validate()');
```

**Output:**
```html
<button type="submit" class="btn btn-primary shadow-sm" data-action="save" onclick="validate()">Save Changes</button>
```

### 2. Nested Structures (DOM Trees)
You can build complex structures by nesting elements.

```php
$card = Html::div(['class' => 'card'])
    ->child(
        Html::div(['class' => 'card-header'], 'Panel Title')
    )
    ->child(
        Html::div(['class' => 'card-body'])
            ->child(Html::p([], 'Dynamic content...'))
            ->child(Html::a('/more', 'Read more', ['class' => 'btn-link']))
    );

echo $card;
```

### 3. Semantic Helpers
The library provides static methods for most standard HTML5 tags, improving IDE autocomplete and readability.

| Method | Generated HTML | Typical Usage |
|--------|---------------|------------|
| `Html::div()` | `<div>` | Generic containers |
| `Html::img()` | `<img>` | Images with alt text |
| `Html::a()` | `<a>` | Links and hyperlinks |
| `Html::ul()`, `Html::li()` | `<ul>`, `<li>` | Lists |
| `Html::input()` | `<input>` | Form fields |
| `Html::meta()` | `<meta>` | SEO and headers |

### 4. Advanced Form Helpers (v2.5)
Forget manual HTML for complex inputs.

```php
// Select with options
echo Html::select('country', ['CO' => 'Colombia', 'US' => 'USA'], 'CO', ['class' => 'form-select']);

// Checkbox
echo Html::checkbox('subscribe', 1, true); 

// Specific inputs
echo Html::email('user_email');
echo Html::password('user_password');
```

### 5. Table Generator (v2.5)
Render data tables in a single line.

```php
$headers = ['ID', 'Name', 'Role'];
$rows = [
    ['1', 'Ana', 'Admin'],
    ['2', 'Carlos', 'User'],
];

echo Html::table($headers, $rows, ['class' => 'table table-striped']);
```

### 6. Macro System (Extensibility)
Need a custom component? Register your own macro.

```php
Html::macro('alert', function($msg, $type = 'info') {
    return Html::div(['class' => "alert alert-$type"], $msg);
});

// Usage
echo Html::alert('Operation successful!', 'success');
```

### 7. Web Components (Custom HTML)
For modern applications using Custom Elements (JS), `Higgs\Html` validates and supports custom tags.

```php
// Automatically validated: must contain a hyphen '-'
echo Html::webComponent('user-avatar', ['src' => 'profile.jpg', 'size' => 'lg']);
```

---

## 📂 Executable Examples

We have prepared a suite of practical examples in the `examples/` directory to speed up your integration:

- **[01-basics.php](examples/01-basics.php)**: Fundamentals of creation, attributes, and rendering.
- **[02-forms.php](examples/02-forms.php)**: Advanced construction of validated forms.

To understand the project's PSR-4 file structure, consult **[docs/structure.en.md](docs/structure.en.md)**.

---

## 🤝 Support & Contributions

We welcome contributions to improve Higgs Html!

If you encounter any issues, please open an issue on GitHub.

---

## 👨‍💻 Author

**Jose Alexis Correa Valencia**  
*Full Stack Developer & Software Architect*

*   **GitHub**: [@jalexiscv](https://github.com/jalexiscv)
*   **Email**: jalexiscv@gmail.com
*   **Location**: Colombia

---

## ❤️ Donations

If this library has helped you or your business, please consider making a small donation to support its continued development and maintenance.

| Method | Details |
| :--- | :--- |
| **PayPal** | [jalexiscv@gmail.com](https://www.paypal.com/paypalme/anssible) |
| **Nequi (Colombia)** | `3117977281` |

*Thank you for your support!*

---

## 📜 License

Distributed under the **MIT** License. See [LICENSE](LICENSE) for more information.

---
*Developed with ❤️ for the PHP community by José Alexis Correa Valencia.*
