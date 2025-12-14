# Documentación del Tema Beta: Guía de Referencia

## Índice
1. [Estructura del Proyecto](#estructura-del-proyecto)
2. [Flujo de Trabajo](#flujo-de-trabajo)
3. [Sistema de Compilación](#sistema-de-compilación)
4. [Componentes Principales](#componentes-principales)
5. [Modificaciones Realizadas](#modificaciones-realizadas)

## Estructura del Proyecto

El tema Beta sigue una estructura clara con separación entre archivos fuente y compilados:

```
c:\xampp\htdocs\public\themes\Beta\
├── src/               # ARCHIVOS FUENTE (MODIFICAR SOLO ESTOS)
│   ├── assets/        # Recursos estáticos (CSS, JS, imágenes)
│   │   ├── css/       # Estilos separados por funcionalidad
│   │   ├── js/        # Scripts JavaScript
│   │   └── images/    # Imágenes e iconos
│   ├── data/          # Archivos de configuración JSON
│   └── templates/     # Plantillas HTML
│       ├── layouts/   # Plantillas base
│       ├── partials/  # Componentes reutilizables
│       └── pages/     # Páginas completas
├── dist/              # ARCHIVOS COMPILADOS (NO MODIFICAR DIRECTAMENTE)
│   ├── assets/        # Versión compilada de los recursos
│   └── *.html         # Archivos HTML generados
└── build.py           # Script de compilación en Python
```

## Flujo de Trabajo

### Regla fundamental: NUNCA modificar archivos en la carpeta `dist`

El flujo de trabajo correcto para este proyecto es:

1. **Modificar únicamente los archivos en la carpeta `src`**
   - Ejemplo: `src/assets/css/dashboard.css` para estilos
   - Ejemplo: `src/assets/js/dashboard.js` para funcionalidad

2. **Ejecutar el compilador después de cada modificación**
   ```bash
   cd c:\xampp\htdocs\public\themes\Beta
   python build.py
   ```

3. **Verificar los cambios en el navegador**
   - Los archivos generados estarán en la carpeta `dist`
   - El sistema se encarga de copiar todos los assets y compilar las plantillas

## Sistema de Compilación

El proyecto utiliza un script personalizado en Python (`build.py`) que se encarga de:

1. **Limpiar la carpeta `dist`** para evitar archivos obsoletos
2. **Procesar plantillas HTML** con un sistema de templates básico
3. **Copiar todos los assets** de `src/assets` a `dist/assets`
4. **Generar las páginas finales** combinando plantillas y bloques

### Funcionamiento del compilador

El script `build.py` utiliza solo la biblioteca estándar de Python y realiza:

```python
# Limpieza de la carpeta dist
def clean_dist():
    if os.path.exists('dist'):
        shutil.rmtree('dist')
    os.makedirs('dist', exist_ok=True)

# Copia de assets (CSS, JS, imágenes)
def copy_assets():
    if os.path.exists('dist/assets'):
        shutil.rmtree('dist/assets')
    shutil.copytree('src/assets', 'dist/assets')

# Compilación de páginas
def build_page(page, config):
    # Carga contenido y procesa plantillas
    # Combina con la plantilla base
    # Escribe el resultado en dist/
```

## Componentes Principales

### Sistema de Sidebars

El tema incluye un sistema de sidebars a la izquierda y derecha que pueden ocultarse:

1. **Elementos HTML**:
   - `leftSidebar`: Menú lateral izquierdo
   - `rightSidebar`: Panel lateral derecho
   - `mainContent`: Contenido principal que debe adaptarse

2. **Botones de control**:
   - `toggleLeftSidebar`: Oculta/muestra el sidebar izquierdo
   - `toggleRightSidebar`: Oculta/muestra el sidebar derecho

3. **Clases CSS**:
   - `.collapsed`: Aplicada a los sidebars cuando están ocultos
   - `.expanded-left` y `.expanded-right`: Aplicadas al contenido principal para ocupar el espacio de los sidebars ocultos

### Estilos CSS y Variables

El tema utiliza variables CSS (custom properties) para mantener consistencia:

```css
:root {
  --sidebar-width: 280px;
  --header-height: 60px;
  
  /* Colores y variables adicionales */
  --primary-color: #5C6B8B;
  /* ... */
}
```

### Sistema JavaScript

El archivo `dashboard.js` contiene la lógica interactiva, organizada en secciones:

- Gestión de sidebars (desktop)
- Gestión de sidebars (móvil)
- Gráficos y visualizaciones
- Funcionalidad de SQL Editor (si aplica)

## Modificaciones Realizadas

### Comportamiento de los Sidebars (2025-06-07)

**Problema**: Al ocultar los sidebars, el contenido principal (`mainContent`) no ocupaba el 100% del espacio disponible, manteniendo los márgenes.

**Solución implementada**:
1. Modificado el archivo `src/assets/css/dashboard.css`
2. Actualizado las clases `.main-content.expanded-left` y `.main-content.expanded-right`
3. Añadido `width: 100%` y `flex-grow: 1` para que el contenido ocupe el espacio disponible
4. Añadido transiciones para que el cambio sea suave

```css
/* Cuando el sidebar izquierdo está oculto, el contenido principal ocupa todo el espacio disponible */
.main-content.expanded-left {
  margin-left: 0;
  width: 100%;
  flex-grow: 1;
  transition: margin-left 0.3s ease, width 0.3s ease;
}

/* Cuando el sidebar derecho está oculto, el contenido principal ocupa todo el espacio disponible */
.main-content.expanded-right {
  margin-right: 0;
  width: 100%;
  flex-grow: 1;
  transition: margin-right 0.3s ease, width 0.3s ease;
}
```

**Compilación**: Después de realizar esta modificación, se ejecutó `python build.py` para regenerar los archivos en la carpeta `dist`.

---

## Notas Importantes

1. **Nunca hacer modificaciones directas en la carpeta `dist`**
2. **Siempre ejecutar `python build.py` después de cualquier cambio**
3. **Documentar los cambios realizados en este archivo para referencia futura**

Este proyecto está desarrollado con nuestras propias herramientas y no depende de bibliotecas o frameworks de terceros, siguiendo nuestras prácticas establecidas.

## 🔄 Sistema de Versionado Automático

### Problema Resuelto
Cuando actualizas archivos CSS o JavaScript, los navegadores pueden mostrar versiones cacheadas antiguas. El sistema de versionado automático resuelve esto agregando parámetros únicos a las URLs de los assets.

### Cómo Funciona
1. **Generación de Hash**: Cada archivo recibe un hash único basado en su contenido y fecha de modificación
2. **URLs Versionadas**: Los archivos se cargan con parámetros `?v=hash` (ej: `dashboard.css?v=a1b2c3d4`)
3. **Actualización Automática**: Cuando cambias un archivo, su hash cambia automáticamente
4. **Cache-Busting**: El navegador detecta el nuevo hash y descarga la versión actualizada

### Archivos del Sistema
- `php/VersionManager.php` - Clase principal para gestión de versiones
- `php/autoload.php` - Carga automática y funciones helper
- `src/data/version.json` - Almacena hashes y metadatos de versión
- `build.py` - Script actualizado con generación de versiones

### Uso en Plantillas HTML
```html
<!-- En lugar de -->
<link href="assets/css/dashboard.css" rel="stylesheet">
<script src="assets/js/dashboard.js"></script>

<!-- Usa -->
asset_css('css/dashboard.css')
asset_js('js/dashboard.js')
```

### Funciones Disponibles
- `asset_css('css/archivo.css')` - Genera etiqueta `<link>` con versión
- `asset_js('js/archivo.js')` - Genera etiqueta `<script>` con versión  
- `asset_url('ruta/archivo')` - Retorna URL versionada
- `asset_img('images/imagen.png')` - URL versionada para imágenes

### Uso en PHP
```php
// Carga el autoloader
require_once 'php/autoload.php';

// Crear renderer con versionado
$renderer = createBetaRenderer();

// Usar funciones helper directamente
echo asset_css('css/dashboard.css');
echo asset_js('js/dashboard.js');
```

### Proceso de Build Actualizado
```bash
python build.py
```

El script ahora:
1. Compila las plantillas
2. Copia los assets
3. **Genera hashes únicos para cada archivo**
4. **Actualiza el archivo version.json**
5. Despliega a producción (si está configurado)

### Ejemplo de Uso
Consulta el archivo `test_versioning.php` para ver una demostración completa del sistema de versionado en funcionamiento.
