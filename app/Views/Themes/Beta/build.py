# build.py: Script para compilar el dashboard Beta usando solo la biblioteca estándar de Python
# Incluye funcionalidad de copia automática al directorio de producción y versionado automático
import os
import shutil
import json
import re
import hashlib
import time
from pathlib import Path
from string import Template

def load_config():
    with open('src/data/config.json', 'r', encoding='utf-8') as f:
        return json.load(f)

def read_file(path):
    with open(path, 'r', encoding='utf-8') as f:
        return f.read()

def write_file(path, content):
    os.makedirs(os.path.dirname(path), exist_ok=True)
    with open(path, 'w', encoding='utf-8') as f:
        f.write(content)

def process_template(template_path, context):
    content = read_file(template_path)
    return Template(content).safe_substitute(context)

def process_asset_functions(content, version_data):
    """
    Procesa las funciones de assets y las convierte en HTML puro
    """
    # Procesa asset_css('ruta/archivo.css')
    def replace_css(match):
        css_path = match.group(1)
        # Obtiene el hash del archivo si existe
        file_hash = version_data.get('assets', {}).get('css', {}).get(css_path, '')
        if file_hash:
            versioned_url = f'assets/{css_path}?v={file_hash}'
        else:
            versioned_url = f'assets/{css_path}'
        return f'<link href="{versioned_url}" rel="stylesheet">'
    
    # Procesa asset_js('ruta/archivo.js')
    def replace_js(match):
        js_path = match.group(1)
        # Obtiene el hash del archivo si existe
        file_hash = version_data.get('assets', {}).get('js', {}).get(js_path, '')
        if file_hash:
            versioned_url = f'assets/{js_path}?v={file_hash}'
        else:
            versioned_url = f'assets/{js_path}'
        return f'<script src="{versioned_url}"></script>'
    
    # Procesa asset_url('ruta/archivo')
    def replace_url(match):
        asset_path = match.group(1)
        # Determina el tipo de archivo por extensión
        extension = asset_path.split('.')[-1].lower() if '.' in asset_path else ''
        asset_type = 'css' if extension == 'css' else 'js' if extension == 'js' else 'images'
        
        file_hash = version_data.get('assets', {}).get(asset_type, {}).get(asset_path, '')
        if file_hash:
            return f'assets/{asset_path}?v={file_hash}'
        else:
            return f'assets/{asset_path}'
    
    # Procesa asset_img('ruta/imagen')
    def replace_img(match):
        img_path = match.group(1)
        file_hash = version_data.get('assets', {}).get('images', {}).get(img_path, '')
        if file_hash:
            return f'assets/{img_path}?v={file_hash}'
        else:
            return f'assets/{img_path}'
    
    # Aplica las sustituciones
    import re
    content = re.sub(r"asset_css\(['\"]([^'\"]+)['\"]\)", replace_css, content)
    content = re.sub(r"asset_js\(['\"]([^'\"]+)['\"]\)", replace_js, content)
    content = re.sub(r"asset_url\(['\"]([^'\"]+)['\"]\)", replace_url, content)
    content = re.sub(r"asset_img\(['\"]([^'\"]+)['\"]\)", replace_img, content)
    
    return content

def process_includes(content):
    # Patrón para {% include "archivo" %}
    include_pattern = re.compile(r'{% include "([^"]+)"(?: with ([^%]+))? %}')
    # Patrón para ${include('archivo')}
    include_pattern2 = re.compile(r'\$\{include\([\'"]([^\'"]+)[\'"]\)\}')
    
    def include_repl(match):
        path = match.group(1)
        vars_str = match.group(2) if match.lastindex >= 2 else None
        vars_dict = {}
        if vars_str:
            for pair in vars_str.strip().split():
                if '=' in pair:
                    k, v = pair.split('=', 1)
                    vars_dict[k] = v.strip('"')
        include_content = read_file(f'src/templates/{path}')
        # Sustituye variables simples en el include
        for k, v in vars_dict.items():
            include_content = include_content.replace(f'${{{k}}}', v)
        return include_content
    
    def include_repl2(match):
        path = match.group(1)
        include_content = read_file(f'src/templates/{path}')
        return include_content
    
    # Procesa recursivamente los includes
    while include_pattern.search(content) or include_pattern2.search(content):
        content = include_pattern.sub(include_repl, content)
        content = include_pattern2.sub(include_repl2, content)
    return content

def extract_blocks(content):
    """
    Extrae todos los bloques {% block nombre %} ... {% endblock %} en un dict.
    """
    blocks = {}
    for match in re.finditer(r'{% block ([^ ]+) %}(.*?){% endblock %}', content, re.DOTALL):
        blocks[match.group(1).strip()] = match.group(2).strip()
    return blocks

def build_page(page, config, version_data):
    # Cargar contenido de página
    page_content = read_file(f'src/templates/pages/{page}.html')
    page_content = process_includes(page_content)
    blocks = extract_blocks(page_content)
    # Cargar base
    base_tpl = read_file('src/templates/layouts/base.html')
    # Procesar includes en la base
    base_tpl = process_includes(base_tpl)
    # Renderizar sustituyendo los bloques
    context = {
        'title': blocks.get('title', config['name'] if page == 'dashboard' else 'Beta Dashboard'),
        'navbar': blocks.get('navbar', ''),
        'sidebar': blocks.get('sidebar', ''),
        'right_sidebar': blocks.get('right_sidebar', ''),
        'breadcrumb': blocks.get('breadcrumb', ''),
        'content': blocks.get('content', ''),
        'version': version_data.get('version_hash', '')  # Añadir hash de versión
    }
    html = Template(base_tpl).safe_substitute(context)
    
    # Procesar funciones de assets para convertirlas en HTML puro
    html = process_asset_functions(html, version_data)
    
    write_file(f'dist/{page}.html', html)

def compile_all_pages(config, version_data):
    """
    Compila automáticamente todas las páginas encontradas en src/templates/pages/
    """
    pages_dir = 'src/templates/pages'
    
    if not os.path.exists(pages_dir):
        print('No se encontró directorio src/templates/pages')
        return
    
    # Buscar todos los archivos HTML en el directorio de páginas
    page_files = []
    for file in os.listdir(pages_dir):
        if file.endswith('.html'):
            page_name = file[:-5]  # Remover extensión .html
            page_files.append(page_name)
    
    page_files.sort()  # Orden alfabético
    
    print(f'Encontradas {len(page_files)} páginas para compilar:')
    
    for page_name in page_files:
        print(f'  - Compilando {page_name}.html')
        try:
            build_page(page_name, config, version_data)
            print(f'    ✓ {page_name}.html generado')
        except Exception as e:
            print(f'    ✗ Error compilando {page_name}.html: {str(e)}')
    
    print(f'✓ {len(page_files)} páginas compiladas exitosamente')

def combine_css_files():
    """
    Combina todos los archivos CSS de src/assets/css en uno solo
    """
    css_dir = 'src/assets/css'
    combined_css = ''
    
    if not os.path.exists(css_dir):
        print('No se encontró directorio src/assets/css')
        return
    
    # Lista todos los archivos CSS
    css_files = []
    for file in os.listdir(css_dir):
        if file.endswith('.css'):
            css_files.append(file)
    
    css_files.sort()  # Orden alfabético para consistencia
    
    print(f'Combinando {len(css_files)} archivos CSS...')
    
    for css_file in css_files:
        file_path = os.path.join(css_dir, css_file)
        print(f'  - {css_file}')
        
        # Agregar comentario de separación
        combined_css += f'\n/* ========== {css_file} ========== */\n'
        
        # Leer y agregar contenido del archivo
        with open(file_path, 'r', encoding='utf-8') as f:
            content = f.read().strip()
            combined_css += content + '\n\n'
    
    # Crear directorio de destino
    os.makedirs('dist/assets/css', exist_ok=True)
    
    # Escribir archivo combinado
    combined_path = 'dist/assets/css/combined.css'
    with open(combined_path, 'w', encoding='utf-8') as f:
        f.write(combined_css)
    
    print(f'✓ CSS combinado guardado en: {combined_path}')
    return combined_path

def copy_assets():
    if os.path.exists('dist/assets'):
        shutil.rmtree('dist/assets')
    
    # Copiar todos los assets excepto CSS
    shutil.copytree('src/assets', 'dist/assets')
    
    # Combinar archivos CSS
    combine_css_files()

def clean_dist():
    """Limpia el directorio de distribución"""
    # Elimina todos los archivos del directorio dist si existe
    if os.path.exists('dist'):
        print('Eliminando archivos previos de dist/')
        shutil.rmtree('dist')
    # Crea el directorio dist vacío
    os.makedirs('dist', exist_ok=True)

def generate_file_hash(file_path):
    """
    Genera un hash único basado en el contenido y tiempo de modificación de un archivo
    """
    if not os.path.exists(file_path):
        return None  # Devolver None para que se pueda manejar el error
    
    with open(file_path, 'rb') as f:
        content = f.read()
    
    file_time = os.path.getmtime(file_path)
    combined = content + str(file_time).encode()
    
    # Añadir el cálculo y retorno del hash
    file_hash = hashlib.md5(combined).hexdigest()
    return file_hash[:10]  # Retornar los primeros 10 caracteres

def update_asset_versions():
    """
    Actualiza las versiones de todos los archivos estáticos en dist/assets
    Prioriza el archivo CSS combinado sobre archivos individuales
    """
    version_data = {
        'build_timestamp': int(time.time()),
        'version_hash': '',
        'assets': {
            'css': {},
            'js': {},
            'images': {}
        }
    }
    
    # Lista de archivos CSS a combinar (en orden de importancia)
    css_files = [
        'buttons.css',
        'cards.css', 
        'dashboard.css',
        'shortcuts.css',
        'sidebar-icons.css',
        'tables.css',
        'theme-php-only.css'
    ]
    
    assets_dir = 'dist/assets'
    if not os.path.exists(assets_dir):
        return version_data
    
    # Extensiones por tipo
    extensions_map = {
        'css': ['.css'],
        'js': ['.js'],
        'images': ['.jpg', '.jpeg', '.png', '.gif', '.svg', '.webp', '.ico']
    }
    
    # Escanea todos los archivos en assets
    for root, dirs, files in os.walk(assets_dir):
        for file in files:
            file_path = os.path.join(root, file)
            relative_path = os.path.relpath(file_path, assets_dir).replace('\\', '/')
            
            # Determina el tipo de archivo
            file_ext = os.path.splitext(file)[1].lower()
            asset_type = 'css'  # default
            
            for type_name, extensions in extensions_map.items():
                if file_ext in extensions:
                    asset_type = type_name
                    break
            
            # Para CSS, solo versionar el archivo combinado
            if asset_type == 'css' and file != 'combined.css':
                continue
            
            # Genera hash del archivo
            file_hash = generate_file_hash(file_path)
            version_data['assets'][asset_type][relative_path] = file_hash
    
    # Genera hash general del build
    all_hashes = ''
    for asset_type in version_data['assets'].values():
        for file_hash in asset_type.values():
            if file_hash:  # Asegurarse de que el hash no sea None
                all_hashes += file_hash
    
    version_data['version_hash'] = hashlib.md5(
        (all_hashes + str(version_data['build_timestamp'])).encode()
    ).hexdigest()[:10]
    
    # Guarda el archivo de versiones
    os.makedirs('src/data', exist_ok=True)
    with open('src/data/version.json', 'w', encoding='utf-8') as f:
        json.dump(version_data, f, indent=2, ensure_ascii=False)
    
    print(f'✓ Versiones de assets actualizadas (hash: {version_data["version_hash"]})')
    return version_data

def preprocess_js_assets(version_data):
    """
    Recorre los archivos JS en dist/assets/js y reemplaza ${version}
    """
    js_dir = 'dist/assets/js'
    version_hash = version_data.get('version_hash', '')
    
    if not os.path.exists(js_dir):
        print('Directorio JS no encontrado, omitiendo pre-procesamiento.')
        return
        
    for filename in os.listdir(js_dir):
        if filename.endswith('.js'):
            file_path = os.path.join(js_dir, filename)
            try:
                content = read_file(file_path)
                if '${version}' in content:
                    content = content.replace('${version}', version_hash)
                    write_file(file_path, content)
                    print(f'  - Procesado: {filename}')
            except Exception as e:
                print(f'  - ✗ Error procesando {filename}: {e}')
    print('✓ Pre-procesamiento de JavaScript completado.')

def deploy_to_production(config):
    """
    Copia automáticamente el contenido compilado al directorio de producción
    según la configuración del template
    """
    # Verifica si la copia automática está habilitada
    if not config.get('deploy', {}).get('auto_copy', False):
        print('Copia automática deshabilitada en la configuración')
        return
    
    template_name = config.get('template_name', 'Unknown')
    destination = config.get('deploy', {}).get('destination')
    
    if not destination:
        print('Error: No se especificó destino en la configuración')
        return
    
    # Construye la ruta de destino completa
    dest_path = os.path.abspath(destination)
    source_path = os.path.abspath('dist')
    
    print(f'Desplegando template "{template_name}" a producción...')
    print(f'Origen: {source_path}')
    print(f'Destino: {dest_path}')
    
    try:
        # Crea el directorio de destino si no existe
        os.makedirs(dest_path, exist_ok=True)
        
        # Elimina el contenido anterior del destino
        if os.path.exists(dest_path):
            for item in os.listdir(dest_path):
                item_path = os.path.join(dest_path, item)
                if os.path.isdir(item_path):
                    shutil.rmtree(item_path)
                else:
                    os.remove(item_path)
        
        # Copia todo el contenido de dist/ al destino
        for item in os.listdir(source_path):
            source_item = os.path.join(source_path, item)
            dest_item = os.path.join(dest_path, item)
            
            if os.path.isdir(source_item):
                shutil.copytree(source_item, dest_item)
            else:
                shutil.copy2(source_item, dest_item)
        
        # Copia también el archivo de versiones al directorio PHP
        version_source = 'src/data/version.json'
        version_dest = os.path.join(dest_path, 'php/data/version.json')
        if os.path.exists(version_source):
            os.makedirs(os.path.dirname(version_dest), exist_ok=True)
            shutil.copy2(version_source, version_dest)
        
        print(f'✓ Template "{template_name}" desplegado exitosamente')
        print(f'✓ Archivos copiados a: {dest_path}')
        
    except Exception as e:
        print(f'Error durante el despliegue: {str(e)}')
        print('El build se completó pero falló la copia a producción')

def main():
    """Función principal que ejecuta todo el proceso de build y despliegue"""
    print('=== INICIANDO BUILD DEL TEMPLATE ===')
    
    # Cargar configuración
    config = load_config()
    template_name = config.get('template_name', 'Unknown')
    print(f'Template: {template_name} v{config.get("version", "1.0.0")}')
    
    # Limpiar directorio de distribución
    clean_dist()
    
    # Copiar assets
    print('Copiando assets...')
    copy_assets()
    
    # Actualizar versiones de assets
    print('Actualizando versiones de assets...')
    version_data = update_asset_versions()
    
    # Pre-procesar assets JS para reemplazar la variable de versión
    print('Pre-procesando archivos JavaScript...')
    preprocess_js_assets(version_data)
    
    # Compilar páginas (después de generar versiones)
    print('Compilando páginas...')
    compile_all_pages(config, version_data)
    
    print('✓ Build completo. Archivos generados en dist/')
    
    # Desplegar automáticamente a producción si está configurado
    deploy_to_production(config)
    
    print('=== PROCESO COMPLETADO ===')

if __name__ == '__main__':
    main()
