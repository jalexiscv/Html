# 🗺️ Documentación Completa - Librería Maps.php

## 📋 Resumen Ejecutivo

La librería `Maps.php` es una clase PHP completa para la integración de Google Maps en aplicaciones web. Proporciona una
interfaz orientada a objetos para crear mapas interactivos con marcadores, polilíneas, polígonos y funcionalidades
avanzadas de geocodificación.

### Características Principales

- ✅ Integración completa con Google Maps API
- ✅ Soporte para marcadores personalizables
- ✅ Polilíneas y polígonos
- ✅ Geocodificación automática
- ✅ Controles de mapa configurables
- ✅ Generación automática de JavaScript
- ✅ Campos de latitud/longitud vinculados

---

## 🏗️ Arquitectura de la Clase

### Namespace y Ubicación

```php
namespace App\Libraries;
class Maps
```

### Dependencias

- **Google Maps JavaScript API**
- **Bootstrap** (para generación de HTML)
- **cURL o Sockets** (para geocodificación)

---

## 🔧 Constantes de la Clase

### API Keys

```php
const GOOGLE_API_KEY = 'AIzaSyB0TFdgpSaln2fHvlAjx78vdWbP5QCQuXk';
```

### Tipos de Mapa

```php
const MAP_TYPE_ID_HYBRID = 'HYBRID';      // Vista híbrida (satélite + calles)
const MAP_TYPE_ID_ROADMAP = 'ROADMAP';    // Vista de calles
const MAP_TYPE_ID_SATELLITE = 'SATELLITE'; // Vista satelital
const MAP_TYPE_ID_TERRAIN = 'TERRAIN';    // Vista de terreno
```

### Posiciones de Controles

```php
// Posiciones disponibles para controles del mapa
const CONTROL_POSITION_BOTTOM_CENTER = 'BOTTOM_CENTER';
const CONTROL_POSITION_BOTTOM_LEFT = 'BOTTOM_LEFT';
const CONTROL_POSITION_BOTTOM_RIGHT = 'BOTTOM_RIGHT';
const CONTROL_POSITION_LEFT_BOTTOM = 'LEFT_BOTTOM';
const CONTROL_POSITION_LEFT_CENTER = 'LEFT_CENTER';
const CONTROL_POSITION_LEFT_TOP = 'LEFT_TOP';
const CONTROL_POSITION_RIGHT_BOTTOM = 'RIGHT_BOTTOM';
const CONTROL_POSITION_RIGHT_CENTER = 'RIGHT_CENTER';
const CONTROL_POSITION_RIGHT_TOP = 'RIGHT_TOP';
const CONTROL_POSITION_TOP_CENTER = 'TOP_CENTER';
const CONTROL_POSITION_TOP_LEFT = 'TOP_LEFT';
const CONTROL_POSITION_TOP_RIGHT = 'TOP_RIGHT';
```

### Estilos de Controles

```php
// Estilos para control de tipo de mapa
const MAP_TYPE_CONTROL_STYLE_DEFAULT = 'DEFAULT';
const MAP_TYPE_CONTROL_STYLE_DROPDOWN_MENU = 'DROPDOWN_MENU';
const MAP_TYPE_CONTROL_STYLE_HORIZONTAL_BAR = 'HORIZONTAL_BAR';

// Estilos para control de zoom
const ZOOM_CONTROL_STYLE_DEFAULT = 'DEFAULT';
const ZOOM_CONTROL_STYLE_LARGE = 'LARGE';
const ZOOM_CONTROL_STYLE_SMALL = 'SMALL';

// Estilos para control de escala
const SCALE_CONTROL_STYLE_DEFAULT = 'DEFAULT';
```

### Métodos de Conexión

```php
const URL_FETCH_METHOD_CURL = 'curl';        // Usar cURL para peticiones HTTP
const URL_FETCH_METHOD_SOCKETS = 'sockets';  // Usar sockets para peticiones HTTP
```

### Animaciones de Marcadores

```php
const ANIMATION_BOUNCE = 'BOUNCE';  // Animación de rebote
const ANIMATION_DROP = 'DROP';      // Animación de caída
```

---

## 🎯 Propiedades Principales

### Configuración Básica del Mapa

```php
protected $_id = '';                    // ID único del mapa
protected $_width = 600;                // Ancho en píxeles
protected $_height = 600;               // Alto en píxeles
protected $_fullScreen = false;         // Modo pantalla completa
protected $_lat = 4.0633051;           // Latitud central (Bogotá, Colombia)
protected $_lng = -74.6633296;         // Longitud central (Bogotá, Colombia)
protected $_zoom = 6;                  // Nivel de zoom inicial
protected $_sensor = false;            // Detección de ubicación del usuario
```

### Configuración de Controles

```php
protected $_disableDefaultUI = null;           // Deshabilitar UI por defecto
protected $_disableDoubleClickZoom = null;    // Deshabilitar zoom con doble click
protected $_draggable = null;                 // Permitir arrastrar el mapa
protected $_mapTypeControl = null;            // Mostrar control de tipo de mapa
protected $_panControl = null;                // Mostrar control de panorámica
protected $_scaleControl = null;              // Mostrar control de escala
protected $_streetViewControl = null;         // Mostrar control de Street View
protected $_zoomControl = null;               // Mostrar control de zoom
```

### Elementos del Mapa

```php
protected $_markers = array();         // Array de marcadores
protected $_polylines = array();       // Array de polilíneas
protected $_polygons = array();        // Array de polígonos
```

### Campos Vinculados

```php
protected $_latField = null;           // Campo HTML para mostrar latitud
protected $_lngField = null;           // Campo HTML para mostrar longitud
protected $_geocoderfields = null;     // Campos para geocodificación
```

---

## 🛠️ Métodos Principales

### Constructor y Configuración Básica

#### `__construct($id = '', $apiKey = '...')`

```php
public function __construct($id = '', $apiKey = 'AIzaSyApWZ9BWHUO8-HZrP5qla87kCEVEqix6YE&callback')
```

**Propósito:** Inicializa una nueva instancia del mapa
**Parámetros:**

- `$id`: ID único para el mapa (se genera automáticamente si está vacío)
- `$apiKey`: Clave de API de Google Maps

#### `set_Size($width, $height)`

```php
public function set_Size($width, $height)
```

**Propósito:** Establece las dimensiones del mapa
**Parámetros:**

- `$width`: Ancho en píxeles
- `$height`: Alto en píxeles

#### `set_Center($lat, $lng)`

```php
public function set_Center($lat, $lng)
```

**Propósito:** Establece el centro del mapa
**Parámetros:**

- `$lat`: Latitud del centro
- `$lng`: Longitud del centro

### Gestión de Marcadores

#### `add_Marker($lat, $lng, $options = array())`

```php
public function add_Marker($lat, $lng, $options = array())
```

**Propósito:** Agrega un marcador al mapa
**Parámetros:**

- `$lat`: Latitud del marcador
- `$lng`: Longitud del marcador
- `$options`: Array de opciones del marcador

**Opciones disponibles:**

```php
$options = [
    'animation' => 'BOUNCE|DROP',           // Animación del marcador
    'clickable' => true|false,              // Si es clickeable
    'cursor' => 'pointer',                  // Cursor al pasar sobre el marcador
    'draggable' => true|false,              // Si se puede arrastrar
    'icon' => 'url_del_icono',             // URL del icono personalizado
    'title' => 'Título del marcador',      // Tooltip del marcador
    'html' => '<div>Contenido</div>',      // Contenido del InfoWindow
    'visible' => true|false,                // Visibilidad del marcador
    'zIndex' => 100,                       // Orden de apilamiento
    'defColor' => 'FF0000',                // Color por defecto (hex)
    'defSymbol' => 'A',                    // Símbolo por defecto
];
```

#### `removeMarker($index)`

```php
public function removeMarker($index)
```

**Propósito:** Elimina un marcador específico
**Retorna:** `true` si se eliminó, `false` si no existe

#### `clearMarkers()`

```php
public function clearMarkers()
```

**Propósito:** Elimina todos los marcadores del mapa

### Gestión de Polilíneas

#### `addPolyline($path, $color = '#000000', $weight = 1, $opacity = 1.0)`

```php
public function addPolyline($path, $color = '#000000', $weight = 1, $opacity = 1.0)
```

**Propósito:** Agrega una polilínea al mapa
**Parámetros:**

- `$path`: Array de coordenadas `[['lat' => 4.0, 'lng' => -74.0], ...]`
- `$color`: Color de la línea (hex)
- `$weight`: Grosor de la línea
- `$opacity`: Opacidad (0.0 a 1.0)

### Gestión de Polígonos

#### `addPolygon($path, $strokeColor, $fillColor, $strokeWeight, $strokeOpacity, $fillOpacity)`

```php
public function addPolygon($path, $strokeColor = '#000000', $fillColor = '#FF0000', 
                          $strokeWeight = 1, $strokeOpacity = 1.0, $fillOpacity = 0.35)
```

**Propósito:** Agrega un polígono al mapa
**Parámetros:**

- `$path`: Array de coordenadas que forman el polígono
- `$strokeColor`: Color del borde
- `$fillColor`: Color de relleno
- `$strokeWeight`: Grosor del borde
- `$strokeOpacity`: Opacidad del borde
- `$fillOpacity`: Opacidad del relleno

### Geocodificación

#### `get_LatLng($address, $urlFetchMethod = 'sockets')`

```php
public function get_LatLng($address, $urlFetchMethod = self::URL_FETCH_METHOD_SOCKETS)
```

**Propósito:** Convierte una dirección en coordenadas lat/lng
**Parámetros:**

- `$address`: Dirección a geocodificar
- `$urlFetchMethod`: Método de conexión ('curl' o 'sockets')
  **Retorna:** Array con 'lat' y 'lng' o lanza excepción

### Campos Vinculados

#### `set_LatAndLngFields($latfid, $lngfid)`

```php
public function set_LatAndLngFields($latfid, $lngfid)
```

**Propósito:** Vincula campos HTML para mostrar coordenadas
**Parámetros:**

- `$latfid`: ID del campo para latitud
- `$lngfid`: ID del campo para longitud

#### `set_GeocoderFields($fields = array())`

```php
public function set_GeocoderFields($fields = array())
```

**Propósito:** Configura campos para geocodificación automática
**Parámetros:**

```php
$fields = [
    'country' => 'id_campo_pais',
    'region' => 'id_campo_region', 
    'town' => 'id_campo_ciudad',
    'address' => 'id_campo_direccion'
];
```

### Renderizado

#### `render()` y `__toString()`

```php
private function render()
public function __toString()
```

**Propósito:** Genera el HTML y JavaScript necesarios para mostrar el mapa
**Retorna:** String con el código HTML/JS completo

---

## 🎨 Ejemplos de Uso

### Ejemplo Básico

```php
// Crear instancia del mapa
$map = new Maps('mi_mapa');

// Configurar tamaño y centro
$map->set_Size(800, 600);
$map->set_Center(4.0633051, -74.6633296); // Bogotá
$map->set_Zoom(10);

// Agregar marcador
$map->add_Marker(4.0633051, -74.6633296, [
    'title' => 'Bogotá, Colombia',
    'html' => '<h3>Bogotá</h3><p>Capital de Colombia</p>',
    'icon' => 'https://maps.google.com/mapfiles/ms/icons/red-dot.png'
]);

// Mostrar el mapa
echo $map;
```

### Ejemplo con Polilínea

```php
$map = new Maps('mapa_ruta');
$map->set_Size(800, 400);

// Definir ruta
$ruta = [
    ['lat' => 4.0633051, 'lng' => -74.6633296],
    ['lat' => 4.1533051, 'lng' => -74.7633296],
    ['lat' => 4.2433051, 'lng' => -74.8633296]
];

// Agregar polilínea
$map->addPolyline($ruta, '#FF0000', 3, 0.8);

echo $map;
```

### Ejemplo con Geocodificación

```php
$map = new Maps('mapa_geocoder');

// Configurar campos de geocodificación
$map->set_GeocoderFields([
    'country' => 'select_pais',
    'region' => 'select_departamento',
    'town' => 'select_ciudad',
    'address' => 'input_direccion'
]);

// Vincular campos de coordenadas
$map->set_LatAndLngFields('input_latitud', 'input_longitud');

echo $map;
```

### Ejemplo con Múltiples Marcadores

```php
$map = new Maps('mapa_multiple');
$map->set_Size(1000, 600);
$map->set_Center(4.0633051, -74.6633296);

// Marcadores con diferentes estilos
$ubicaciones = [
    ['lat' => 4.0633051, 'lng' => -74.6633296, 'titulo' => 'Bogotá', 'color' => 'red'],
    ['lat' => 6.2442, 'lng' => -75.5812, 'titulo' => 'Medellín', 'color' => 'blue'],
    ['lat' => 3.4516, 'lng' => -76.5320, 'titulo' => 'Cali', 'color' => 'green']
];

foreach ($ubicaciones as $ubicacion) {
    $map->add_Marker($ubicacion['lat'], $ubicacion['lng'], [
        'title' => $ubicacion['titulo'],
        'defColor' => $ubicacion['color'],
        'html' => "<h4>{$ubicacion['titulo']}</h4>",
        'animation' => 'DROP'
    ]);
}

echo $map;
```

---

## ⚠️ Problemas Identificados y Mejoras Sugeridas

### 🚨 Problemas Críticos

1. **API Key Hardcodeada**
   ```php
   const GOOGLE_API_KEY = 'AIzaSyB0TFdgpSaln2fHvlAjx78vdWbP5QCQuXk';
   ```
   **Problema:** Clave API expuesta en código fuente
   **Solución:** Mover a variables de entorno o configuración

2. **Error en `js_LatAndLngFields()`**
   ```php
   // Línea 752-753: Bug - usa LngField dos veces
   $nfLat = $this->get_LngField();  // ❌ Debería ser get_LatField()
   $nfLng = $this->get_LngField();  // ✅ Correcto
   ```

3. **Geocodificación Insegura**
   ```php
   // Línea 480: Usa HTTP en lugar de HTTPS
   $url = 'http://maps.googleapis.com/maps/api/geocode/json?...';
   ```
   **Problema:** Conexión no segura
   **Solución:** Cambiar a HTTPS

### ⚡ Mejoras de Rendimiento

1. **Validación de Parámetros**
    - Agregar validación de coordenadas (lat: -90 a 90, lng: -180 a 180)
    - Validar tipos de datos en métodos setter

2. **Manejo de Errores**
    - Implementar try-catch en geocodificación
    - Agregar logs de errores detallados

3. **Optimización de JavaScript**
    - Minificar código JavaScript generado
    - Lazy loading de marcadores para mapas con muchos puntos

### 🔧 Mejoras de Funcionalidad

1. **Soporte para Clusters de Marcadores**
2. **Integración con Street View**
3. **Soporte para KML/GPX**
4. **Eventos de JavaScript personalizables**
5. **Temas de mapa personalizados**

---

## 🔒 Consideraciones de Seguridad

### API Key Management

```php
// ❌ Actual (inseguro)
const GOOGLE_API_KEY = 'clave_expuesta';

// ✅ Recomendado
private function getApiKey() {
    return $_ENV['GOOGLE_MAPS_API_KEY'] ?? config('maps.api_key');
}
```

### Validación de Entrada

```php
// Ejemplo de validación recomendada
public function set_Center($lat, $lng) {
    if (!is_numeric($lat) || $lat < -90 || $lat > 90) {
        throw new InvalidArgumentException('Latitud inválida');
    }
    if (!is_numeric($lng) || $lng < -180 || $lng > 180) {
        throw new InvalidArgumentException('Longitud inválida');
    }
    $this->_lat = (float)$lat;
    $this->_lng = (float)$lng;
}
```

### Sanitización de Datos

```php
// Para contenido HTML en marcadores
public function add_Marker($lat, $lng, $options = array()) {
    if (isset($options['html'])) {
        $options['html'] = htmlspecialchars($options['html'], ENT_QUOTES, 'UTF-8');
    }
    // ... resto del método
}
```

---

## 📚 Referencias y Recursos

### Documentación Oficial

- [Google Maps JavaScript API](https://developers.google.com/maps/documentation/javascript)
- [Google Geocoding API](https://developers.google.com/maps/documentation/geocoding)

### Ejemplos Avanzados

- [Clusters de Marcadores](https://developers.google.com/maps/documentation/javascript/marker-clustering)
- [Estilos de Mapa Personalizados](https://developers.google.com/maps/documentation/javascript/styling)

### Herramientas Útiles

- [Google Maps Platform Pricing](https://developers.google.com/maps/pricing-and-plans)
- [API Key Restrictions](https://developers.google.com/maps/api-key-best-practices)

---

## 🚀 Migración y Actualizaciones

### Versión Actual vs Recomendada

**Actual:**

- Google Maps JavaScript API v3 (legacy)
- HTTP para geocodificación
- API key hardcodeada

**Recomendado:**

- Google Maps JavaScript API v3 (current)
- HTTPS para todas las conexiones
- API key desde configuración
- Validación robusta de parámetros

### Plan de Migración

1. **Fase 1:** Mover API key a configuración
2. **Fase 2:** Corregir bugs identificados
3. **Fase 3:** Agregar validaciones
4. **Fase 4:** Implementar mejoras de funcionalidad

---

*Documentación generada: 2025-01-09*  
*Versión de la librería: 1.0*  
*Autor: Sistema de documentación automática*
