# 🚀 Cheat Sheet - Motor de Templates Beta

## Variables

```html
${variable_name}           <!-- Variable simple -->
${user.name}              <!-- NO soportado - usar ${user_name} -->
<div class="${css_class}"> <!-- En atributos -->
```

## Condicionales

```html
<!-- Simple -->
{% if condition %}...{% endif %}

<!-- Con else -->
{% if condition %}...{% else %}...{% endif %}

<!-- Múltiple -->
{% if cond1 %}...{% elif cond2 %}...{% else %}...{% endif %}
```

## Operadores

```html
{% if var == 'value' %}     <!-- Igual -->
{% if var != 'value' %}     <!-- Diferente -->
{% if num > 5 %}            <!-- Mayor -->
{% if num < 10 %}           <!-- Menor -->
{% if var %}                <!-- Existe y es verdadero -->
```

## Includes

```html
{% include "partials/file.html" %}
{% include "partials/file.html" with var1="value1" var2="value2" %}
```

## Ejemplos Rápidos

```html
<!-- Sidebar condicional -->
{% if is_logged_in %}
    <div>Bienvenido ${username}</div>
{% else %}
    {% include "partials/login.html" %}
{% endif %}

<!-- Menú por rol -->
{% if user_role == 'admin' %}
    {% include "partials/admin-menu.html" %}
{% elif user_role == 'user' %}
    {% include "partials/user-menu.html" %}
{% endif %}

<!-- Contenido opcional -->
{% if show_sidebar %}
    <aside>${sidebar_content}</aside>
{% endif %}
```

## ❌ NO Hacer

```html
<?php if ($var): ?>         <!-- NO - Sintaxis PHP -->
<?= $variable ?>            <!-- NO - Sintaxis PHP -->
${var.property}             <!-- NO - Notación punto -->
{% if $var %}               <!-- NO - Signo $ -->
```

## ✅ Hacer

```html
{% if var %}                <!-- SÍ - Variable simple -->
${variable}                 <!-- SÍ - Sintaxis correcta -->
{% include "path.html" %}   <!-- SÍ - Ruta desde php/ -->
```
