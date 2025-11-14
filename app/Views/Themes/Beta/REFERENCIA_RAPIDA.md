# 🚀 Referencia Rápida - Tema Beta Sidebar Condicional

## ⚡ Uso Inmediato

### En tu Controlador

```php
$data = [
    'right' => '<div>Contenido personalizado</div>',
    'right-header' => 'Mi Panel'
];
return view('themes/beta/index', $data);
```

### Resultado Automático

- **Usuario NO logueado** → Muestra formulario de login
- **Usuario logueado** → Muestra tu contenido personalizado

## 🎯 Archivos Clave

| Archivo                           | Propósito                                   |
|-----------------------------------|---------------------------------------------|
| `index.php`                       | Controlador principal - configura variables |
| `php/BetaRenderer.php`            | Motor de templates - procesa condicionales  |
| `php/partials/right-sidebar.html` | Lógica condicional principal                |
| `php/partials/right/signin.html`  | Login para no logueados                     |
| `php/partials/right/default.html` | Contenido para logueados                    |

## 🔧 Sintaxis del Template Engine

```html
<!-- Variables -->
${variable_name}

<!-- Condicionales -->
{% if condition %}
    contenido verdadero
{% else %}
    contenido falso
{% endif %}

<!-- Includes -->
{% include "partials/archivo.html" %}
```

## 🛠️ Variables Disponibles

| Variable                   | Valor        | Uso                     |
|----------------------------|--------------|-------------------------|
| `${is_logged_in}`          | `true/false` | Estado de autenticación |
| `${right_sidebar_title}`   | String       | Título del sidebar      |
| `${right_sidebar_content}` | HTML         | Contenido del sidebar   |

## 🔍 Debug Rápido

```php
// En index.php - línea ~100
error_log("DEBUG: " . print_r($data, true));

// En template HTML
<div style="display:none;">DEBUG: ${is_logged_in}</div>
```

## ⚠️ Reglas Importantes

1. **NO mezclar PHP en archivos .html**
2. **Usar sintaxis del template engine únicamente**
3. **Rutas de include relativas desde php/**
4. **Variables deben estar en $systemVars**

## 🚨 Solución de Problemas

| Problema              | Solución                                 |
|-----------------------|------------------------------------------|
| Sidebar no cambia     | Verificar `get_LoggedIn()`               |
| Variables vacías      | Revisar `$systemVars` en index.php       |
| Include no funciona   | Verificar ruta desde `php/`              |
| Condicional no evalúa | Verificar `processConditionals()` activo |

---
**Creado:** 2025-01-09 | **Versión:** 1.0
