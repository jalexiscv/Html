# Gamma Template System for CodeIgniter 4

![Gamma Logo](assets/images/logo.png)

**Gamma** is a powerful, self-contained, and modular template system designed exclusively for CodeIgniter 4. Its primary
goal is to provide a clean, organized, and maintainable way to manage the entire presentation layer (frontend) of a web
application, keeping it completely separate from the core business logic.

---

## Core Philosophy: Single Entry Point & Multi-Section Layout

Gamma's architecture is built on two key principles:

1. **Single Entry Point**: A CodeIgniter controller makes only **one** call to the theme's `index.php` file, passing all
   necessary data. This keeps the integration clean and simple.

2. **Multi-Section Layout**: The main layout is divided into distinct, customizable sections (`headerLeft`,
   `headerCenter`, `main`, `aside`, etc.). This allows you to inject content into specific parts of the page, offering
   maximum flexibility with minimal code.

```php
// In your CodeIgniter Controller
public function dashboard()
{
    $data = [
        'page_title' => 'User Dashboard',
        'sections'   => [
            'main'  => 'pages/dashboard',      // Load dashboard into the main content area
            'aside' => 'partials/latest_news'  // Load a custom widget into the aside bar
        ],
        // ... any other data for the view
        'username' => 'JohnDoe',
    ];
    
    // The ONLY interaction point with the theme
    return view('Themes/Gamma/index', $data);
}
```

The `index.php` file acts as a front-controller for the theme, initializing the `GammaRenderer`. This powerful
orchestrator intelligently assembles the final HTML page by populating the layout's sections with the templates you
specify, or with default content if none is provided.

---

## Key Features

- **Fully Encapsulated**: The entire theme lives within the `Themes/Gamma/` directory. It doesn't modify or interact
  with CodeIgniter's core in any way.
- **Clean Separation of Concerns**: Strictly separates PHP logic (`Libraries`), HTML structure (`layouts`, `pages`),
  reusable components (`partials`), and static resources (`assets`).
- **Multi-Section Layout**: Inject content into predefined areas of the layout (`headerLeft`, `main`, `aside`, etc.) for
  ultimate flexibility.
- **Smart Defaults**: If you don't specify content for a section, a sensible default is loaded automatically, ensuring
  the layout is always complete.
- **Conditional Sidebars**: Automatically displays the correct sidebar (`guest`, `user`, or `admin`) based on the user's
  role.
- **Simple Template Syntax**: Uses a clean `${variable}` and `{% include %}` syntax, keeping your HTML readable.
- **Fully Encapsulated**: The entire theme is self-contained, promoting clean separation of concerns.

---

## Quickstart Guide

For a detailed explanation of how to use the section-based system and practical examples, please refer to the *
*[User Guide](Instructions/INSTRUCCIONES_USO.md)**.

---


