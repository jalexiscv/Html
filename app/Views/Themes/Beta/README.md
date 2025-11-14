# Tema Beta - Sistema de Templates Avanzado

## 🚀 Introducción

El tema Beta es un sistema de templates moderno para CodeIgniter 4 que implementa un motor de plantillas personalizado
con soporte para:

- ✅ Sintaxis de variables `${variable}`
- ✅ Condicionales `{% if %}...{% endif %}`
- ✅ Includes `{% include "archivo.html" %}`
- ✅ Bloques y herencia de templates
- ✅ Sidebar condicional basado en autenticación
- ✅ Renderizado directo sin archivos intermedios

## 📦 Instalación y Configuración

### Requisitos

- CodeIgniter 4.x
- PHP 8.0+
- Función `get_LoggedIn()` disponible globalmente

### Uso Básico

```php
// En tu controlador
public function index() {
    $data = [
        'title' => 'Mi Página',
        'main' => '<h1>Contenido principal</h1>',
        'right' => '<p>Sidebar personalizado</p>',
        'right-header' => 'Panel Usuario'
    ];
    
    return view('themes/beta/index', $data);
}
```

## 🎨 Componentes del Sidebar Derecho

### Estados Automáticos

| Estado          | Condición                | Template Usado                | Descripción             |
|-----------------|--------------------------|-------------------------------|-------------------------|
| **No Logueado** | `get_LoggedIn() = false` | `partials/right/signin.html`  | Formulario de login     |
| **Logueado**    | `get_LoggedIn() = true`  | `partials/right/default.html` | Contenido personalizado |

### Variables Disponibles

| Variable                   | Tipo    | Descripción             | Ejemplo               |
|----------------------------|---------|-------------------------|-----------------------|
| `${is_logged_in}`          | Boolean | Estado de autenticación | `true/false`          |
| `${right_sidebar_title}`   | String  | Título del sidebar      | `"Panel de Usuario"`  |
| `${right_sidebar_content}` | HTML    | Contenido del sidebar   | `"<p>Bienvenido</p>"` |

## 🔧 Personalización

### Crear Nuevo Template de Sidebar

```html
<!-- partials/right/custom.html -->
<div class="right-sidebar bg-info" id="rightSidebar">
    <div class="section-header text-white">
        ${right_sidebar_title}
    </div>
    <div class="container-fluid p-4">
        ${right_sidebar_content}
        <!-- Tu contenido personalizado aquí -->
    </div>
</div>
```

### Modificar Lógica Condicional

```html
<!-- right-sidebar.html -->
{% if user_type == 'admin' %}
    {% include "partials/right/admin.html" %}
{% elif is_logged_in %}
    {% include "partials/right/default.html" %}
{% else %}
    {% include "partials/right/signin.html" %}
{% endif %}
```

## 📚 Documentación Completa

Para documentación detallada, consulta:

- **[DOCUMENTACION_SIDEBAR_CONDICIONAL.md](./DOCUMENTACION_SIDEBAR_CONDICIONAL.md)** - Guía completa del sistema

## 🐛 Solución de Problemas Comunes

### El sidebar no cambia

```bash
# Verificar función de autenticación
php spark tinker
>>> get_LoggedIn();
```

### Variables no se muestran

```php
// Verificar en index.php que las variables estén en $systemVars
error_log("Variables: " . print_r($systemVars, true));
```

### Includes no funcionan

```html
<!-- Verificar ruta relativa desde php/ -->
{% include "partials/right/signin.html" %}  ✅ Correcto
{% include "/partials/right/signin.html" %} ❌ Incorrecto
```

## 🤝 Contribución

1. Mantener sintaxis consistente del motor de templates
2. No mezclar PHP directo en archivos `.html`
3. Documentar nuevas funcionalidades
4. Probar en diferentes estados de autenticación

---

**Versión:** 1.0  
**Última actualización:** 2025-01-09  
**Compatibilidad:** CodeIgniter 4.x
