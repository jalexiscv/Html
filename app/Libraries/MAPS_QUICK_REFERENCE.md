# 🗺️ Maps.php - Guía de Referencia Rápida

## 🚀 Inicio Rápido

### Instalación Básica

```php
use App\Libraries\Maps;

// Crear mapa
$map = new Maps('mi_mapa');
$map->set_Size(800, 600);
$map->set_Center(4.0633051, -74.6633296);
echo $map;
```

### Configuración Esencial

```php
$map->set_Size($width, $height);           // Dimensiones
$map->set_Center($lat, $lng);              // Centro del mapa
$map->set_Zoom($level);                    // Nivel de zoom (1-20)
$map->set_MapTypeId($type);                // ROADMAP, SATELLITE, HYBRID, TERRAIN
```

---

## 📍 Marcadores

### Agregar Marcador Simple

```php
$map->add_Marker($lat, $lng, [
    'title' => 'Mi Marcador',
    'html' => '<h3>Contenido del InfoWindow</h3>'
]);
```

### Marcador con Opciones Avanzadas

```php
$map->add_Marker($lat, $lng, [
    'title' => 'Título',
    'html' => '<div>Contenido HTML</div>',
    'icon' => 'https://ejemplo.com/icono.png',
    'animation' => 'BOUNCE',  // BOUNCE, DROP
    'draggable' => true,
    'clickable' => true,
    'defColor' => 'FF0000',   // Color hex para marcador por defecto
    'defSymbol' => 'A'        // Símbolo para marcador por defecto
]);
```

### Gestión de Marcadores

```php
$map->removeMarker($index);    // Eliminar marcador específico
$map->clearMarkers();          // Eliminar todos los marcadores
```

---

## 📏 Líneas y Polígonos

### Polilínea (Ruta)

```php
$path = [
    ['lat' => 4.0, 'lng' => -74.0],
    ['lat' => 4.1, 'lng' => -74.1],
    ['lat' => 4.2, 'lng' => -74.2]
];
$map->addPolyline($path, '#FF0000', 3, 0.8);  // color, grosor, opacidad
```

### Polígono (Área)

```php
$area = [
    ['lat' => 4.0, 'lng' => -74.0],
    ['lat' => 4.1, 'lng' => -74.0],
    ['lat' => 4.1, 'lng' => -74.1],
    ['lat' => 4.0, 'lng' => -74.1]
];
$map->addPolygon($area, '#000000', '#FF0000', 2, 1.0, 0.35);
// strokeColor, fillColor, strokeWeight, strokeOpacity, fillOpacity
```

---

## 🔍 Geocodificación

### Obtener Coordenadas de Dirección

```php
try {
    $coords = $map->get_LatLng('Carrera 7 #32-16, Bogotá, Colombia');
    echo "Lat: " . $coords['lat'] . ", Lng: " . $coords['lng'];
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

### Configurar Campos de Geocodificación

```php
$map->set_GeocoderFields([
    'country' => 'select_pais',
    'region' => 'select_departamento', 
    'town' => 'select_ciudad',
    'address' => 'input_direccion'
]);
```

### Vincular Campos de Coordenadas

```php
$map->set_LatAndLngFields('input_latitud', 'input_longitud');
```

---

## ⚙️ Controles del Mapa

### Configuración de Controles

```php
$map->set_DisableDefaultUI(false);          // UI por defecto
$map->set_DisableDoubleClickZoom(false);    // Zoom con doble click
$map->set_Draggable(true);                  // Arrastrar mapa
$map->set_MapTypeControl(true);             // Control de tipo de mapa
$map->set_PanControl(true);                 // Control de panorámica
$map->set_ScaleControl(true);               // Control de escala
$map->set_StreetViewControl(true);          // Control de Street View
$map->set_ZoomControl(true);                // Control de zoom
```

### Posiciones de Controles

```php
$map->set_MapTypeControlPosition('TOP_RIGHT');
$map->set_ZoomControlPosition('RIGHT_CENTER');
$map->set_PanControlPosition('LEFT_TOP');
```

**Posiciones disponibles:**
`TOP_LEFT`, `TOP_CENTER`, `TOP_RIGHT`, `LEFT_TOP`, `LEFT_CENTER`, `LEFT_BOTTOM`, `RIGHT_TOP`, `RIGHT_CENTER`,
`RIGHT_BOTTOM`, `BOTTOM_LEFT`, `BOTTOM_CENTER`, `BOTTOM_RIGHT`

### Estilos de Controles

```php
$map->set_MapTypeControlStyle('HORIZONTAL_BAR');  // DEFAULT, DROPDOWN_MENU, HORIZONTAL_BAR
$map->set_ZoomControlStyle('LARGE');              // DEFAULT, LARGE, SMALL
$map->set_ScaleControlStyle('DEFAULT');           // DEFAULT
```

---

## 🎨 Constantes Útiles

### Tipos de Mapa

```php
Maps::MAP_TYPE_ID_ROADMAP     // Vista de calles
Maps::MAP_TYPE_ID_SATELLITE   // Vista satelital
Maps::MAP_TYPE_ID_HYBRID      // Híbrida (satélite + calles)
Maps::MAP_TYPE_ID_TERRAIN     // Vista de terreno
```

### Animaciones

```php
Maps::ANIMATION_BOUNCE        // Rebote
Maps::ANIMATION_DROP          // Caída
```

### Métodos de Conexión

```php
Maps::URL_FETCH_METHOD_CURL     // Usar cURL
Maps::URL_FETCH_METHOD_SOCKETS  // Usar sockets
```

---

## 🔧 Métodos Getter

### Obtener Configuración Actual

```php
$map->get_Id();               // ID del mapa
$map->get_Width();            // Ancho
$map->get_Height();           // Alto
$map->get_Lat();              // Latitud central
$map->get_Lng();              // Longitud central
$map->get_Zoom();             // Nivel de zoom
$map->get_MapTypeId();        // Tipo de mapa
```

### Obtener Elementos

```php
$map->get_Markers();          // Array de marcadores
$map->get_Polylines();        // Array de polilíneas
$map->get_Polygons();         // Array de polígonos
```

---

## 🐛 Debugging y Troubleshooting

### Problemas Comunes

**1. Mapa no se muestra**

```php
// Verificar que el contenedor tenga dimensiones
<div id="mi_mapa" style="width: 800px; height: 600px;"></div>
```

**2. API Key inválida**

```php
// Verificar en consola del navegador errores de API
// Actualizar la constante GOOGLE_API_KEY
```

**3. Marcadores no aparecen**

```php
// Verificar coordenadas válidas
if ($lat >= -90 && $lat <= 90 && $lng >= -180 && $lng <= 180) {
    $map->add_Marker($lat, $lng);
}
```

**4. Geocodificación falla**

```php
// Usar try-catch para manejar errores
try {
    $coords = $map->get_LatLng($address, Maps::URL_FETCH_METHOD_CURL);
} catch (Exception $e) {
    // Manejar error
}
```

### Validación de Datos

```php
// Validar coordenadas antes de usar
function validarCoordenadas($lat, $lng) {
    return is_numeric($lat) && is_numeric($lng) && 
           $lat >= -90 && $lat <= 90 && 
           $lng >= -180 && $lng <= 180;
}
```

---

## 📋 Checklist de Implementación

### ✅ Configuración Inicial

- [ ] Instanciar clase Maps
- [ ] Establecer dimensiones con `set_Size()`
- [ ] Definir centro con `set_Center()`
- [ ] Configurar zoom con `set_Zoom()`

### ✅ Contenido del Mapa

- [ ] Agregar marcadores con `add_Marker()`
- [ ] Configurar polilíneas si es necesario
- [ ] Configurar polígonos si es necesario

### ✅ Controles y UX

- [ ] Configurar controles visibles
- [ ] Establecer posiciones de controles
- [ ] Configurar estilos de controles

### ✅ Funcionalidad Avanzada

- [ ] Configurar geocodificación si es necesario
- [ ] Vincular campos de coordenadas
- [ ] Implementar manejo de errores

### ✅ Testing

- [ ] Verificar que el mapa se renderiza
- [ ] Probar funcionalidad de marcadores
- [ ] Validar geocodificación
- [ ] Verificar responsividad

---

## 🚨 Advertencias Importantes

### Seguridad

- **No exponer API keys** en código cliente
- **Validar todas las entradas** del usuario
- **Usar HTTPS** para todas las conexiones

### Rendimiento

- **Limitar número de marcadores** (usar clustering para >100)
- **Optimizar imágenes** de iconos personalizados
- **Implementar lazy loading** para mapas grandes

### Compatibilidad

- **Verificar soporte del navegador** para JavaScript
- **Probar en dispositivos móviles**
- **Considerar fallbacks** para conexiones lentas

---

*Referencia rápida para Maps.php v1.0*  
*Última actualización: 2025-01-09*
