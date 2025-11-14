# BUILD.md - Proceso de Compilación del Tema Beta

## Descripción General

El tema Beta utiliza un sistema de compilación personalizado desarrollado en Python que transforma archivos fuente en
HTML estático optimizado. Este documento describe en detalle todo el proceso de build, desde los archivos fuente hasta
la distribución final.

## Arquitectura del Sistema

### Estructura de Directorios

```
Beta/
├── src/                    # ARCHIVOS FUENTE (modificar solo estos)
│   ├── assets/            # Recursos estáticos
│   │   ├── css/          # Hojas de estilo
│   │   ├── js/           # Scripts JavaScript
│   │   └── images/       # Imágenes e iconos
│   ├── data/             # Configuración
│   │   ├── config.json   # Configuración del tema
│   │   └── version.json  # Metadatos de versión (generado)
│   └── templates/        # Plantillas HTML
│       ├── layouts/      # Plantillas base
│       ├── partials/     # Componentes reutilizables
│       └── pages/        # Páginas completas
├── dist/                  # ARCHIVOS COMPILADOS (no modificar)
│   ├── assets/           # Recursos copiados y optimizados
│   └── *.html           # Páginas HTML generadas
├── php/                  # Sistema PHP (opcional)
│   ├── BetaRenderer.php  # Motor de plantillas PHP
│   ├── VersionManager.php # Gestor de versiones
│   └── autoload.php     # Carga automática
└── build.py             # Script de compilación principal
```

## Proceso de Compilación Detallado

### 1. Inicialización del Build

```python
def main():
    print('=== INICIANDO BUILD DEL TEMPLATE ===')
    
    # Carga configuración desde src/data/config.json
    config = load_config()
    template_name = config.get('template_name', 'Unknown')
    print(f'Template: {template_name} v{config.get("version", "1.0.0")}')
```

**Acciones:**

- Carga el archivo `src/data/config.json` con la configuración del tema
- Extrae información como nombre, versión y configuración de despliegue
- Muestra información del template que se va a compilar

### 2. Limpieza del Directorio de Distribución

```python
def clean_dist():
    if os.path.exists('dist'):
        print('Eliminando archivos previos de dist/')
        shutil.rmtree('dist')
    os.makedirs('dist', exist_ok=True)
```

**Acciones:**

- Elimina completamente el directorio `dist/` si existe
- Crea un directorio `dist/` limpio para la nueva compilación
- Garantiza que no queden archivos obsoletos de builds anteriores

### 3. Copia de Assets

```python
def copy_assets():
    if os.path.exists('dist/assets'):
        shutil.rmtree('dist/assets')
    shutil.copytree('src/assets', 'dist/assets')
```

**Acciones:**

- Copia recursivamente todo el contenido de `src/assets/` a `dist/assets/`
- Incluye archivos CSS, JavaScript, imágenes y documentación
- Mantiene la estructura de directorios original

### 4. Generación de Versiones de Assets

```python
def update_asset_versions():
    version_data = {
        'build_timestamp': int(time.time()),
        'version_hash': '',
        'assets': {'css': {}, 'js': {}, 'images': {}}
    }
```

**Proceso detallado:**

#### 4.1 Escaneo de Archivos

- Recorre recursivamente `dist/assets/`
- Clasifica archivos por tipo (CSS, JS, imágenes)
- Genera hash MD5 único para cada archivo basado en:
    - Contenido del archivo
    - Fecha de modificación

#### 4.2 Generación de Hashes

```python
def generate_file_hash(file_path):
    with open(file_path, 'rb') as f:
        content = f.read()
    file_time = os.path.getmtime(file_path)
    combined = content + str(file_time).encode()
    return hashlib.md5(combined).hexdigest()[:8]
```

#### 4.3 Hash General del Build

- Combina todos los hashes individuales
- Genera un hash maestro de 10 caracteres
- Almacena timestamp del build

#### 4.4 Persistencia

- Guarda toda la información en `src/data/version.json`
- Estructura del archivo:

```json
{
  "build_timestamp": 1756670783,
  "version_hash": "daf172ae74",
  "assets": {
    "css": {
      "css/dashboard.css": "e71d4b79"
    },
    "js": {
      "js/dashboard.js": "f85f1dc2"
    },
    "images": {
      "img/logo.png": "0c7138c3"
    }
  }
}
```

### 5. Compilación de Páginas

#### 5.1 Carga de Plantillas

```python
def build_page(page, config, version_data):
    # Carga contenido de página
    page_content = read_file(f'src/templates/pages/{page}.html')
    page_content = process_includes(page_content)
    blocks = extract_blocks(page_content)
```

#### 5.2 Procesamiento de Includes

```python
def process_includes(content):
    # Procesa {% include "archivo.html" %}
    # Soporta variables: {% include "archivo.html" with var="valor" %}
```

**Funcionalidades:**

- Incluye archivos de `src/templates/partials/`
- Soporta variables específicas por include
- Procesamiento recursivo de includes anidados

#### 5.3 Extracción de Bloques

```python
def extract_blocks(content):
    # Extrae {% block nombre %}...{% endblock %}
    blocks = {}
    for match in re.finditer(r'{% block ([^ ]+) %}(.*?){% endblock %}', content, re.DOTALL):
        blocks[match.group(1).strip()] = match.group(2).strip()
    return blocks
```

#### 5.4 Renderizado de Plantilla Base

```python
# Carga plantilla base
base_tpl = read_file('src/templates/layouts/base.html')
base_tpl = process_includes(base_tpl)

# Contexto para sustitución
context = {
    'title': blocks.get('title', 'Beta Dashboard'),
    'content': blocks.get('content', ''),
    # ... otros bloques
}

html = Template(base_tpl).safe_substitute(context)
```

#### 5.5 Procesamiento de Funciones de Assets

```python
def process_asset_functions(content, version_data):
    # Convierte asset_css('css/file.css') en HTML puro
    # Convierte asset_js('js/file.js') en HTML puro
    # Incluye parámetros de versión automáticamente
```

**Transformaciones:**

- `asset_css('css/dashboard.css')` → `<link href="assets/css/dashboard.css?v=e71d4b79" rel="stylesheet">`
- `asset_js('js/dashboard.js')` → `<script src="assets/js/dashboard.js?v=f85f1dc2"></script>`
- `asset_url('images/logo.png')` → `assets/images/logo.png?v=0c7138c3`
- `asset_img('images/logo.png')` → `assets/images/logo.png?v=0c7138c3`

#### 5.6 Generación de HTML Final

- Aplica todas las transformaciones
- Genera HTML estático puro (sin dependencias PHP)
- Guarda el archivo en `dist/{page}.html`

### 6. Despliegue Automático (Opcional)

```python
def deploy_to_production(config):
    if not config.get('deploy', {}).get('auto_copy', False):
        return
    
    destination = config.get('deploy', {}).get('destination')
    # Copia dist/ al directorio de producción
    # Incluye archivo de versiones para PHP
```

**Acciones:**

- Verifica configuración de despliegue en `config.json`
- Copia todo el contenido de `dist/` al directorio de producción
- Copia `version.json` al directorio PHP para compatibilidad
- Limpia archivos anteriores antes de copiar

## Tecnologías y Dependencias

### Bibliotecas Python Utilizadas

- **os, shutil**: Manipulación de archivos y directorios
- **json**: Procesamiento de archivos de configuración
- **re**: Expresiones regulares para procesamiento de plantillas
- **hashlib**: Generación de hashes MD5
- **time**: Timestamps para versionado
- **pathlib**: Manipulación avanzada de rutas
- **string.Template**: Motor de plantillas básico

### Características del Sistema

#### Motor de Plantillas Personalizado

- Sintaxis similar a Jinja2/Django
- Bloques: `{% block nombre %}...{% endblock %}`
- Includes: `{% include "archivo.html" %}`
- Variables: `${variable}`
- Includes con variables: `{% include "archivo.html" with var="valor" %}`

#### Sistema de Versionado

- **Cache-busting automático**: Evita problemas de caché del navegador
- **Hashes únicos**: Basados en contenido y fecha de modificación
- **Versionado granular**: Hash individual por archivo
- **Hash maestro**: Identificador único del build completo

#### Compatibilidad Dual

- **HTML estático**: Funciona sin servidor web
- **PHP dinámico**: Integración opcional con BetaRenderer.php
- **Fallbacks**: Sistema robusto con degradación elegante

## Comandos y Uso

### Compilación Básica

```bash
cd /ruta/al/tema/Beta
python build.py
```

### Estructura de Salida

```
dist/
├── assets/
│   ├── css/
│   │   └── dashboard.css
│   ├── js/
│   │   └── dashboard.js
│   └── images/
│       └── logo.png
└── index.html                # HTML puro funcional
```

### Verificación del Build

- **Timestamp**: Verificar `version.json` para confirmar build reciente
- **Hashes**: Cada archivo debe tener hash único de 8 caracteres
- **HTML**: Verificar que no contenga funciones sin procesar

## Flujo de Trabajo Recomendado

### 1. Desarrollo

```bash
# Modificar archivos en src/
nano src/assets/css/dashboard.css
nano src/templates/pages/index.html
```

### 2. Compilación

```bash
python build.py
```

### 3. Verificación

```bash
# Verificar archivos generados
ls -la dist/
cat dist/index.html | grep "assets.*?v="
```

### 4. Despliegue

- Automático si `config.json` tiene `"auto_copy": true`
- Manual: copiar contenido de `dist/` al servidor web

## Resolución de Problemas

### Errores Comunes

#### "Archivo no encontrado"

- Verificar que los archivos existen en `src/templates/`
- Revisar rutas en includes y extends

#### "Funciones sin procesar en HTML"

- Verificar que `process_asset_functions()` se ejecuta
- Confirmar que `version_data` se pasa correctamente

#### "Assets sin versionar"

- Verificar que `copy_assets()` se ejecuta antes de `update_asset_versions()`
- Confirmar que los archivos existen en `dist/assets/`

### Debugging

```python
# Agregar prints para debugging
print(f"Processing: {file_path}")
print(f"Generated hash: {file_hash}")
print(f"Version data: {version_data}")
```

## Extensibilidad

### Agregar Nuevos Tipos de Assets

```python
# En update_asset_versions()
extensions_map = {
    'css': ['.css'],
    'js': ['.js'],
    'images': ['.jpg', '.jpeg', '.png', '.gif', '.svg', '.webp', '.ico'],
    'fonts': ['.woff', '.woff2', '.ttf', '.otf']  # Nuevo tipo
}
```

### Nuevas Funciones de Assets

```python
# En process_asset_functions()
def replace_font(match):
    font_path = match.group(1)
    file_hash = version_data.get('assets', {}).get('fonts', {}).get(font_path, '')
    if file_hash:
        return f'assets/{font_path}?v={file_hash}'
    else:
        return f'assets/{font_path}'

# Agregar regex
content = re.sub(r"asset_font\(['\"]([^'\"]+)['\"]\)", replace_font, content)
```

## Conclusión

El sistema de build del tema Beta proporciona:

- **Compilación automatizada** de plantillas a HTML estático
- **Versionado automático** para evitar problemas de caché
- **Compatibilidad dual** HTML/PHP
- **Despliegue automático** configurable
- **Extensibilidad** para nuevos tipos de assets y funcionalidades

Este enfoque garantiza que el tema funcione tanto como HTML estático puro como con interpretación PHP dinámica,
manteniendo siempre la compatibilidad y optimización para producción.
