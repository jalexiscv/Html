# Guía de Uso del Sistema de Plantillas Gamma

Esta guía explica cómo utilizar el sistema de plantillas Gamma desde un controlador de CodeIgniter 4 para renderizar
vistas complejas y personalizadas.

---

## 1. El Principio Fundamental: Punto de Entrada Único

La interacción con el tema Gamma siempre se realiza a través de una única llamada desde tu controlador al archivo
`Themes/Gamma/index.php`. En esta llamada, se pasa un array `$data` que contiene toda la información necesaria para
construir la página.

```php
// En tu controlador de CodeIgniter
public function miMetodo()
{
    $data = [
        // ... aquí va toda la configuración de la página ...
    ];
    
    return view('Themes/Gamma/index', $data);
}
```

---

## 2. El Poder de las Secciones

El layout principal del tema (`layouts/default.php`) está dividido en varias secciones predefinidas. Puedes inyectar
contenido en cualquiera de estas secciones directamente desde tu controlador.

Las secciones disponibles son:

- `headerLeft`
- `headerCenter`
- `headerRight`
- `sidebar`
- `main`
- `aside`

Para pasar contenido a estas secciones, utiliza la clave `'sections'` en tu array `$data`.

---

## 3. Ejemplos de Uso

### Ejemplo 1: Renderizar una Página de Contenido Principal

Este es el caso de uso más común. Quieres cargar una vista principal en el área de contenido (`main`).

```php
public function dashboard()
{
    $data = [
        'page_title' => 'Mi Dashboard',
        'sections'   => [
            'main' => 'pages/dashboard', // Carga el archivo /pages/dashboard.php en la sección 'main'
        ],
        // ... otros datos para la vista ...
        'username' => 'JohnDoe',
    ];

    return view('Themes/Gamma/index', $data);
}
```

**¿Qué sucede aquí?**

- `GammaRenderer` cargará la plantilla `pages/dashboard.php`.
- La renderizará y colocará el HTML resultante en la sección `${main_content}` del layout.
- Todas las demás secciones (`headerLeft`, `aside`, etc.) cargarán su contenido por defecto.

### Ejemplo 2: Personalizar Múltiples Secciones

Puedes sobrescribir el contenido de cualquier sección, por ejemplo, para tener una barra lateral (`aside`) personalizada
para una página específica.

```php
public function reportes()
{
    $data = [
        'page_title' => 'Reporte de Ventas',
        'sections'   => [
            'main'  => 'pages/reportes',      // Contenido principal
            'aside' => 'partials/filtros_reporte', // Contenido personalizado para la barra lateral
        ],
        'report_data' => ['ventas' => 5000, 'mes' => 'Octubre'],
    ];

    return view('Themes/Gamma/index', $data);
}
```

**¿Qué sucede aquí?**

- La sección `main` cargará `pages/reportes.php`.
- La sección `aside` cargará el archivo `partials/filtros_reporte.php` en lugar del contenido por defecto.
- El resto de las secciones (`header`, `sidebar`) mantendrán su contenido predeterminado.

---

## 4. Contenido por Defecto

Si no especificas una plantilla para una sección, Gamma cargará automáticamente una plantilla por defecto desde la
carpeta `partials/`. Esto asegura que el layout nunca se rompa.

- **`headerLeft`** carga `partials/default_header_left.php`
- **`headerCenter`** carga `partials/default_header_center.php`
- **`headerRight`** carga `partials/default_header_right.php`
- **`aside`** carga `partials/default_aside.php`
- **`sidebar`** es manejado por `SidebarGenerator.php` y no tiene un archivo por defecto.

---

## 5. Variables Globales Disponibles

Además de los datos que pasas desde el controlador, las siguientes variables están disponibles en **todas** las
plantillas (layouts, pages, partials):

- `${page_title}`: El título de la página.
- `${site_name}`: El nombre del sitio (configurado en `GammaTheme.php`).
- `${charset}`: El charset del documento (ej. 'UTF-8').
- `${theme_url}`: La URL base a la carpeta `assets` del tema.
- `${current_year}`: El año actual.
- `${is_logged_in}`: Booleano que indica si el usuario está autenticado.
- `${username}`, `${user_email}`, etc.: Cualquier otra variable que pases en el nivel superior del array `$data`.
