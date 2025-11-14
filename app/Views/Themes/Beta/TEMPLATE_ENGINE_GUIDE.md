# 🎨 Guía del Motor de Templates - Tema Beta

## 📋 Introducción

El tema Beta incluye un motor de templates personalizado (`BetaRenderer`) que procesa una sintaxis específica para
variables, condicionales e includes. Esta guía documenta toda la sintaxis disponible.

---

## 🔧 Sintaxis de Variables

### Variables Simples

```html
<!-- Sintaxis básica -->
${variable_name}

<!-- Ejemplos -->
<h1>${title}</h1>
<p>Bienvenido ${username}</p>
<div class="content">${main_content}</div>
```

### Variables con Valores por Defecto

```html
<!-- Si la variable no existe, se muestra vacío -->
${nonexistent_var}  <!-- Resultado: "" -->

<!-- Para valores por defecto, usar lógica condicional -->
{% if user_name %}
    <span>Hola ${user_name}</span>
{% else %}
    <span>Hola Invitado</span>
{% endif %}
```

### Variables en Atributos HTML

```html
<!-- En atributos de clase -->
<div class="sidebar ${sidebar_class}">

<!-- En IDs -->
<div id="${element_id}">

<!-- En URLs -->
<a href="${base_url}/users/${user_id}">

<!-- En estilos -->
<div style="background-color: ${theme_color};">
```

---

## 🔀 Sintaxis de Condicionales

### Condicional Simple (if/endif)

```html
{% if condition %}
    <p>Este contenido se muestra si condition es verdadero</p>
{% endif %}
```

### Condicional con Else

```html
{% if is_logged_in %}
    <div class="user-panel">Bienvenido usuario</div>
{% else %}
    <div class="login-form">Por favor inicia sesión</div>
{% endif %}
```

### Condicional con Múltiples Condiciones (elif)

```html
{% if user_role == 'admin' %}
    <div class="admin-panel">Panel de Administrador</div>
{% elif user_role == 'moderator' %}
    <div class="mod-panel">Panel de Moderador</div>
{% elif is_logged_in %}
    <div class="user-panel">Panel de Usuario</div>
{% else %}
    <div class="guest-panel">Panel de Invitado</div>
{% endif %}
```

### Condiciones con Variables

```html
<!-- Verificar si variable existe y es verdadera -->
{% if username %}
    <span>Usuario: ${username}</span>
{% endif %}

<!-- Comparaciones -->
{% if user_level > 5 %}
    <div class="advanced-features">Funciones avanzadas</div>
{% endif %}

<!-- Comparaciones de strings -->
{% if theme == 'dark' %}
    <link rel="stylesheet" href="dark-theme.css">
{% else %}
    <link rel="stylesheet" href="light-theme.css">
{% endif %}
```

---

## 📂 Sintaxis de Includes

### Include Básico

```html
<!-- Incluir otro template -->
{% include "partials/header.html" %}
{% include "partials/footer.html" %}
{% include "components/sidebar.html" %}
```

### Include con Variables Específicas

```html
<!-- Pasar variables específicas al include -->
{% include "partials/card.html" with title="Mi Título" content="Mi contenido" %}

<!-- Las variables se pueden usar dentro del archivo incluido -->
<!-- En partials/card.html: -->
<div class="card">
    <h3>${title}</h3>
    <p>${content}</p>
</div>
```

### Includes Condicionales

```html
<!-- Incluir diferentes templates según condición -->
{% if is_mobile %}
    {% include "partials/mobile-nav.html" %}
{% else %}
    {% include "partials/desktop-nav.html" %}
{% endif %}
```

---

## 🎯 Ejemplos Prácticos Completos

### Ejemplo 1: Sidebar Condicional

```html
<!-- partials/right-sidebar.html -->
{% if is_logged_in %}
    <div class="user-sidebar">
        <h3>Hola ${username}</h3>
        {% if user_role == 'admin' %}
            {% include "partials/admin-menu.html" %}
        {% else %}
            {% include "partials/user-menu.html" %}
        {% endif %}
        <div class="user-content">
            ${sidebar_content}
        </div>
    </div>
{% else %}
    {% include "partials/login-form.html" %}
{% endif %}
```

### Ejemplo 2: Lista Dinámica

```html
<!-- components/navigation.html -->
<nav class="main-nav ${nav_class}">
    {% if show_logo %}
        <div class="logo">
            <img src="${logo_url}" alt="${site_name}">
        </div>
    {% endif %}
    
    <ul class="nav-items">
        {% if is_logged_in %}
            <li><a href="${base_url}/dashboard">Dashboard</a></li>
            <li><a href="${base_url}/profile">Mi Perfil</a></li>
            {% if can_admin %}
                <li><a href="${base_url}/admin">Administración</a></li>
            {% endif %}
            <li><a href="${base_url}/logout">Cerrar Sesión</a></li>
        {% else %}
            <li><a href="${base_url}/login">Iniciar Sesión</a></li>
            <li><a href="${base_url}/register">Registrarse</a></li>
        {% endif %}
    </ul>
</nav>
```

### Ejemplo 3: Card Reutilizable

```html
<!-- components/card.html -->
<div class="card ${card_class}">
    {% if card_image %}
        <div class="card-image">
            <img src="${card_image}" alt="${card_title}">
        </div>
    {% endif %}
    
    <div class="card-content">
        {% if card_title %}
            <h3 class="card-title">${card_title}</h3>
        {% endif %}
        
        {% if card_description %}
            <p class="card-description">${card_description}</p>
        {% endif %}
        
        ${card_body}
        
        {% if card_actions %}
            <div class="card-actions">
                ${card_actions}
            </div>
        {% endif %}
    </div>
</div>
```

---

## 🔧 Configuración de Variables desde PHP

### En el Controlador

```php
// En tu controlador CodeIgniter
public function index() {
    $data = [
        // Variables básicas
        'title' => 'Mi Página',
        'username' => 'Juan Pérez',
        'is_logged_in' => true,
        'user_role' => 'admin',
        
        // Variables para includes
        'sidebar_content' => '<p>Contenido personalizado</p>',
        'nav_class' => 'navbar-dark',
        
        // Variables condicionales
        'show_logo' => true,
        'can_admin' => $this->checkAdminPermission(),
        'theme' => $this->getUserTheme(),
        
        // URLs y paths
        'base_url' => base_url(),
        'logo_url' => base_url('assets/img/logo.png'),
    ];
    
    return view('themes/beta/index', $data);
}
```

### En el Tema Beta (index.php)

```php
// Variables del sistema automáticas
$systemVars = [
    'is_logged_in' => get_LoggedIn(),
    'current_user' => get_CurrentUser(),
    'user_role' => get_UserRole(),
    'base_url' => base_url(),
    'site_name' => setting('App.siteName'),
];

// Combinar con datos del controlador
$renderer->setVars($data);
$renderer->setVars($systemVars);
```

---

## ⚠️ Reglas y Limitaciones

### Variables

- ✅ Usar `${variable_name}` para variables
- ❌ NO usar `<?= $variable ?>` (sintaxis PHP)
- ✅ Variables no definidas se muestran como cadena vacía
- ✅ Variables pueden contener HTML

### Condicionales

- ✅ Usar `{% if condition %}...{% endif %}`
- ❌ NO usar `<?php if(): ?>...<?php endif; ?>`
- ✅ Soporta `if`, `elif`, `else`
- ✅ Comparaciones: `==`, `!=`, `>`, `<`, `>=`, `<=`
- ⚠️ Variables en condiciones deben estar definidas en el contexto

### Includes

- ✅ Rutas relativas desde el directorio `php/`
- ✅ Extensión `.html` requerida
- ✅ Variables del contexto padre disponibles en includes
- ✅ Variables específicas con `with`

---

## 🔍 Debug y Troubleshooting

### Mostrar Variables para Debug

```html
<!-- Mostrar valor de variable -->
<div style="display:none;">
    DEBUG: is_logged_in = ${is_logged_in}
    DEBUG: username = ${username}
</div>

<!-- Mostrar en consola del navegador -->
<script>
    console.log('Template vars:', {
        is_logged_in: '${is_logged_in}',
        username: '${username}'
    });
</script>
```

### Verificar Condiciones

```html
<!-- Test de condiciones -->
{% if is_logged_in %}
    <div class="debug">✅ Usuario está logueado</div>
{% else %}
    <div class="debug">❌ Usuario NO está logueado</div>
{% endif %}
```

### Problemas Comunes

| Problema                | Causa                          | Solución                          |
|-------------------------|--------------------------------|-----------------------------------|
| Variable no se muestra  | Variable no definida en PHP    | Agregar a `$data` o `$systemVars` |
| Condicional no funciona | Variable no existe en contexto | Verificar que esté en el renderer |
| Include no carga        | Ruta incorrecta                | Verificar ruta desde `php/`       |
| Sintaxis no procesa     | Mezclando PHP con template     | Usar solo sintaxis del template   |

---

## 📚 Referencia Rápida

### Sintaxis Completa

```html
<!-- Variables -->
${variable}

<!-- Condicionales -->
{% if condition %}...{% elif other %}...{% else %}...{% endif %}

<!-- Includes -->
{% include "path/file.html" %}
{% include "path/file.html" with var1="value1" var2="value2" %}

<!-- Bloques (herencia) -->
{% block name %}...{% endblock %}
{% extends "layout.html" %}
```

### Operadores en Condicionales

- `==` - Igual
- `!=` - Diferente
- `>` - Mayor que
- `<` - Menor que
- `>=` - Mayor o igual
- `<=` - Menor o igual

---

*Guía del Motor de Templates - Tema Beta*  
*Versión: 1.0 | Fecha: 2025-01-09*
