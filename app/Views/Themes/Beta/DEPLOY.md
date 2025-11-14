# Documentación de Despliegue Automático - Template Beta

## Descripción

El sistema de build del template Beta incluye funcionalidad de copia automática al directorio de producción. Cuando se
compila el template, automáticamente se crea una copia exacta del contenido generado en el directorio especificado.

## Configuración

### Archivo de Configuración: `src/data/config.json`

```json
{
  "name": "Beta Dashboard",
  "version": "1.0.0",
  "template_name": "Beta",
  "deploy": {
    "auto_copy": true,
    "destination": "../../public_html/themes/Beta"
  },
  "colors": {
    "primary": "#0d6efd",
    "secondary": "#6c757d",
    "background": "#f8f9fa",
    "card": "#fff"
  }
}
```

### Parámetros de Configuración

- **`template_name`**: Nombre del template que aparecerá en los mensajes de build
- **`deploy.auto_copy`**: Habilita/deshabilita la copia automática (true/false)
- **`deploy.destination`**: Ruta relativa o absoluta del directorio de destino

## Funcionamiento

### Proceso de Build y Despliegue

1. **Limpieza**: Se elimina el contenido anterior del directorio `dist/`
2. **Compilación**: Se procesan las plantillas y se genera el HTML
3. **Copia de Assets**: Se copian todos los archivos CSS, JS, imágenes, etc.
4. **Despliegue Automático**: Si está habilitado, se copia todo a producción

### Función `deploy_to_production(config)`

Esta función se ejecuta automáticamente después del build y realiza:

1. **Verificación de configuración**: Comprueba si `auto_copy` está habilitado
2. **Validación de rutas**: Verifica que exista el destino configurado
3. **Limpieza del destino**: Elimina contenido anterior del directorio de producción
4. **Copia completa**: Transfiere todos los archivos de `dist/` al destino
5. **Reporte de estado**: Informa el éxito o fallo del despliegue

## Uso

### Ejecutar Build con Despliegue

```bash
python build.py
```

### Salida Esperada

```
=== INICIANDO BUILD DEL TEMPLATE ===
Template: Beta v1.0.0
Eliminando archivos previos de dist/
Compilando páginas...
Copiando assets...
✓ Build completo. Archivos generados en dist/
Desplegando template "Beta" a producción...
Origen: C:\xampp\htdocs\app\Views\Themes\Beta\dist
Destino: C:\xampp\htdocs\public_html\themes\Beta
✓ Template "Beta" desplegado exitosamente
✓ Archivos copiados a: C:\xampp\htdocs\public_html\themes\Beta
=== PROCESO COMPLETADO ===
```

## Estructura de Directorios

```
Beta/
├── src/                    # Código fuente
├── dist/                   # Build generado
├── build.py               # Script de compilación
└── ../../public_html/
    └── themes/
        └── Beta/          # Copia automática del contenido de dist/
            ├── index.html
            └── assets/
```

## Configuraciones Avanzadas

### Deshabilitar Copia Automática

```json
{
  "deploy": {
    "auto_copy": false
  }
}
```

### Cambiar Directorio de Destino

```json
{
  "deploy": {
    "auto_copy": true,
    "destination": "/var/www/html/themes/Beta"
  }
}
```

## Manejo de Errores

- Si `auto_copy` es `false`, no se realiza copia y se muestra mensaje informativo
- Si no se especifica `destination`, se muestra error y continúa el build
- Si falla la copia, se reporta el error pero el build se considera exitoso
- Se crean directorios de destino automáticamente si no existen

## Beneficios

1. **Automatización completa**: Un solo comando compila y despliega
2. **Sincronización garantizada**: El contenido de producción siempre coincide con el build
3. **Configuración flexible**: Fácil cambio de destinos y habilitación/deshabilitación
4. **Manejo robusto de errores**: El proceso continúa aunque falle el despliegue
5. **Feedback detallado**: Mensajes claros sobre el progreso y resultados
