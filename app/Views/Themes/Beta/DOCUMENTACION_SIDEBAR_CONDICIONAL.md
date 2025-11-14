# Documentación: Sistema de Sidebar Derecho Condicional - Tema Beta

## 📋 Resumen del Problema y Solución

### Problema Original

El archivo `right-sidebar.html` contenía código PHP mixto con sintaxis de template engine, causando que el PHP no se
ejecutara porque:

- Los archivos `.html` no son procesados como PHP por el servidor web
- Se mezclaba sintaxis PHP (`<?php`, `<?=`) con sintaxis de template (`{% include %}`, `${}`)

### Solución Implementada

Se creó un sistema de sidebar condicional que usa únicamente la sintaxis del motor de templates Beta, separando
correctamente la lógica de presentación.

---

## 🏗️ Arquitectura del Sistema

### Componentes Principales

1. **BetaRenderer.php** - Motor de templates
2. **index.php** - Controlador principal del tema
3. **right-sidebar.html** - Template condicional principal
4. **partials/right/signin.html** - Formulario de login
5. **partials/right/default.html** - Contenido para usuarios logueados

---

## 📁 Estructura de Archivos

```
app/Views/Themes/Beta/
├── index.php                          # Controlador principal
├── php/
│   ├── BetaRenderer.php               # Motor de templates
│   ├── layouts/
│   │   └── base.html                  # Layout principal
│   └── partials/
│       ├── right-sidebar.html         # Sidebar condicional
│       └── right/
│           ├── signin.html            # Login para no logueados
│           └── default.html           # Contenido para logueados
```

---

## 🔧 Implementación Detallada

### 1. Motor de Templates (BetaRenderer.php)

**Cambio realizado:**

```php
// En el método render(), línea ~84
// Procesa condicionales
$content = $this->processConditionals($content);

// Reemplaza variables
$content = $this->replaceVars($content);
```

**Funcionalidad:**

- Procesa automáticamente la sintaxis `{% if %}...{% else %}...{% endif %}`
- Evalúa condiciones usando variables del contexto
- Mantiene compatibilidad con includes y variables

### 2. Controlador Principal (index.php)

**Variables del sistema agregadas:**

```php
// Líneas ~135-141
$systemVars = [
    'is_logged_in' => get_LoggedIn(),
    'right_sidebar_header' => $contentBlocks['right_sidebar_header'],
    'right_sidebar_content' => $contentBlocks['right_sidebar_content'],
];
```

**Procesamiento de datos del sidebar:**

```php
// Líneas ~64-68
if (isset($data['right'])) {
    $contentBlocks['right_sidebar_header'] = $data['right-header'];
    $contentBlocks['right_sidebar_content'] = $data['right'];
}
```

### 3. Template Condicional (right-sidebar.html)

**Sintaxis del template:**

```html
{% if is_logged_in %}
    {% include "partials/right/default.html" %}
{% else %}
    {% include "partials/right/signin.html" %}
{% endif %}
```

**Lógica:**

- Si `is_logged_in` es `true` → Muestra contenido personalizado
- Si `is_logged_in` es `false` → Muestra formulario de login

### 4. Template para Usuarios Logueados (partials/right/default.html)

**Estructura:**

```html
<div class="right-sidebar bg-light" id="rightSidebar">
    <div class="section-header">
        ${right_sidebar_title}
    </div>
    <div class="container-fluid p-4" style="max-width: 400px;">
        ${right_sidebar_content}
    </div>
</div>
```

**Variables disponibles:**

- `${right_sidebar_title}` - Título del sidebar
- `${right_sidebar_content}` - Contenido principal

---

## 🎯 Cómo Usar el Sistema

### Para Desarrolladores

**1. Desde un Controlador de CodeIgniter:**

```php
// En tu controlador
$data = [
    'right' => '<p>Contenido personalizado del usuario</p>',
    'right-header' => 'Panel de Usuario',
    // ... otros datos
];

// Renderizar con tema Beta
return view('themes/beta/index', $data);
```

**2. Variables disponibles en templates:**

- `${is_logged_in}` - Boolean del estado de autenticación
- `${right_sidebar_title}` - Título del sidebar derecho
- `${right_sidebar_content}` - Contenido del sidebar derecho

### Para Diseñadores de Templates

**Sintaxis del motor de templates Beta:**

```html
<!-- Variables -->
${variable_name}

<!-- Condicionales -->
{% if condition %}
    contenido si verdadero
{% else %}
    contenido si falso
{% endif %}

<!-- Includes -->
{% include "ruta/archivo.html" %}

<!-- Bloques -->
{% block nombre_bloque %}
    contenido del bloque
{% endblock %}
```

---

## 🔄 Flujo de Funcionamiento

### 1. Usuario No Logueado

```
Solicitud → index.php → get_LoggedIn() = false → right-sidebar.html 
→ {% if is_logged_in %} = false → {% include "partials/right/signin.html" %}
→ Muestra formulario de login
```

### 2. Usuario Logueado

```
Solicitud → index.php → get_LoggedIn() = true → right-sidebar.html 
→ {% if is_logged_in %} = true → {% include "partials/right/default.html" %}
→ Muestra contenido personalizado
```

---

## 🛠️ Mantenimiento y Extensión

### Agregar Nuevos Estados del Sidebar

**1. Crear nuevo template:**

```html
<!-- partials/right/admin.html -->
<div class="right-sidebar bg-primary" id="rightSidebar">
    <div class="section-header text-white">
        Panel de Administrador
    </div>
    <!-- contenido específico -->
</div>
```

**2. Actualizar lógica condicional:**

```html
<!-- right-sidebar.html -->
{% if is_admin %}
    {% include "partials/right/admin.html" %}
{% elif is_logged_in %}
    {% include "partials/right/default.html" %}
{% else %}
    {% include "partials/right/signin.html" %}
{% endif %}
```

**3. Agregar variable al controlador:**

```php
// index.php
$systemVars = [
    'is_logged_in' => get_LoggedIn(),
    'is_admin' => get_UserRole() === 'admin',
    // ...
];
```

### Debugging

**Variables de debug disponibles:**

```php
// En index.php, líneas ~99-133
error_log("DEBUG - Datos recibidos: " . print_r($data, true));
```

**Verificar variables del template:**

```html
<!-- En cualquier template -->
<div style="display:none;">
    DEBUG: is_logged_in = ${is_logged_in}
    DEBUG: right_sidebar_content = ${right_sidebar_content}
</div>
```

---

## ⚠️ Consideraciones Importantes

### Seguridad

- La función `get_LoggedIn()` debe estar correctamente implementada
- Validar siempre los datos de entrada en `$data['right']`
- No incluir información sensible en variables de template

### Performance

- El motor de templates procesa includes recursivamente
- Evitar includes circulares
- Las variables se evalúan en cada renderizado

### Compatibilidad

- Mantener sintaxis consistente del motor de templates
- No mezclar PHP directo en archivos `.html`
- Usar el controlador para lógica compleja

---

## 🔍 Troubleshooting

### Problema: El sidebar no cambia según el estado de login

**Solución:** Verificar que `get_LoggedIn()` esté funcionando correctamente

### Problema: Variables no se reemplazan

**Solución:** Verificar que las variables estén en `$systemVars` en `index.php`

### Problema: Include no funciona

**Solución:** Verificar la ruta relativa desde `php/` como base

### Problema: Condicionales no se evalúan

**Solución:** Verificar que `processConditionals()` esté activado en `BetaRenderer.php`

---

## 📚 Referencias

- **Función de autenticación:** `app/Helpers/Application_helper.php` → `get_LoggedIn()`
- **Motor de templates:** `app/Views/Themes/Beta/php/BetaRenderer.php`
- **Layout base:** `app/Views/Themes/Beta/php/layouts/base.html`
- **Documentación CodeIgniter 4:** [https://codeigniter.com/user_guide/](https://codeigniter.com/user_guide/)

---

*Documentación creada: 2025-01-09*  
*Versión: 1.0*  
*Autor: Sistema de documentación automática*
