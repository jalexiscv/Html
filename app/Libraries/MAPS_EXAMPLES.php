<?php

/**
 * Ejemplos Prácticos de Uso - Librería Maps.php
 *
 * Este archivo contiene ejemplos completos y funcionales de cómo usar
 * la librería Maps.php en diferentes escenarios.
 *
 * @author Sistema de Documentación
 * @version 1.0
 * @date 2025-01-09
 */

namespace App\Libraries;

require_once 'Maps.php';

class MapsExamples
{
    /**
     * Ejemplo 1: Mapa Básico con Marcador Simple
     *
     * Crea un mapa básico centrado en Bogotá con un marcador simple
     */
    public static function ejemploBasico()
    {
        $map = new Maps('mapa_basico');

        // Configuración básica
        $map->set_Size(800, 600);
        $map->set_Center(4.0633051, -74.6633296); // Bogotá, Colombia
        $map->set_Zoom(12);
        $map->set_MapTypeId(Maps::MAP_TYPE_ID_ROADMAP);

        // Agregar marcador simple
        $map->add_Marker(4.0633051, -74.6633296, [
            'title' => 'Bogotá, Colombia',
            'html' => '<h3>Bogotá</h3><p>Capital de Colombia</p>',
            'animation' => Maps::ANIMATION_DROP
        ]);

        return $map;
    }

    /**
     * Ejemplo 2: Mapa con Múltiples Marcadores de Ciudades
     *
     * Muestra las principales ciudades de Colombia con marcadores personalizados
     */
    public static function ejemploCiudadesColombia()
    {
        $map = new Maps('ciudades_colombia');
        $map->set_Size(1000, 700);
        $map->set_Center(4.5709, -74.2973); // Centro de Colombia
        $map->set_Zoom(6);

        // Datos de ciudades principales
        $ciudades = [
            [
                'nombre' => 'Bogotá',
                'lat' => 4.0633051,
                'lng' => -74.6633296,
                'poblacion' => '7.4 millones',
                'color' => 'red'
            ],
            [
                'nombre' => 'Medellín',
                'lat' => 6.2442,
                'lng' => -75.5812,
                'poblacion' => '2.5 millones',
                'color' => 'blue'
            ],
            [
                'nombre' => 'Cali',
                'lat' => 3.4516,
                'lng' => -76.5320,
                'poblacion' => '2.2 millones',
                'color' => 'green'
            ],
            [
                'nombre' => 'Barranquilla',
                'lat' => 10.9639,
                'lng' => -74.7964,
                'poblacion' => '1.2 millones',
                'color' => 'orange'
            ],
            [
                'nombre' => 'Cartagena',
                'lat' => 10.3910,
                'lng' => -75.4794,
                'poblacion' => '1.0 millones',
                'color' => 'purple'
            ]
        ];

        // Agregar marcador para cada ciudad
        foreach ($ciudades as $ciudad) {
            $infoWindow = "
                <div style='font-family: Arial, sans-serif;'>
                    <h3 style='color: #333; margin: 0 0 10px 0;'>{$ciudad['nombre']}</h3>
                    <p><strong>Población:</strong> {$ciudad['poblacion']}</p>
                    <p><strong>Coordenadas:</strong> {$ciudad['lat']}, {$ciudad['lng']}</p>
                </div>
            ";

            $map->add_Marker($ciudad['lat'], $ciudad['lng'], [
                'title' => $ciudad['nombre'],
                'html' => $infoWindow,
                'defColor' => $ciudad['color'],
                'animation' => Maps::ANIMATION_BOUNCE
            ]);
        }

        return $map;
    }

    /**
     * Ejemplo 3: Mapa con Ruta (Polilínea)
     *
     * Muestra una ruta entre varias ciudades usando polilíneas
     */
    public static function ejemploRutaCiudades()
    {
        $map = new Maps('ruta_ciudades');
        $map->set_Size(900, 600);
        $map->set_Center(5.0, -75.0);
        $map->set_Zoom(7);

        // Definir ruta: Bogotá -> Medellín -> Cali
        $ruta = [
            ['lat' => 4.0633051, 'lng' => -74.6633296], // Bogotá
            ['lat' => 5.5, 'lng' => -75.0],              // Punto intermedio
            ['lat' => 6.2442, 'lng' => -75.5812],       // Medellín
            ['lat' => 4.8, 'lng' => -76.0],             // Punto intermedio
            ['lat' => 3.4516, 'lng' => -76.5320]        // Cali
        ];

        // Agregar polilínea de la ruta
        $map->addPolyline($ruta, '#FF0000', 4, 0.8);

        // Agregar marcadores en puntos de inicio y fin
        $map->add_Marker(4.0633051, -74.6633296, [
            'title' => 'Inicio: Bogotá',
            'html' => '<h3>🚀 Inicio del Viaje</h3><p>Bogotá, Colombia</p>',
            'defColor' => 'green'
        ]);

        $map->add_Marker(6.2442, -75.5812, [
            'title' => 'Parada: Medellín',
            'html' => '<h3>⛽ Parada Intermedia</h3><p>Medellín, Colombia</p>',
            'defColor' => 'yellow'
        ]);

        $map->add_Marker(3.4516, -76.5320, [
            'title' => 'Destino: Cali',
            'html' => '<h3>🏁 Destino Final</h3><p>Cali, Colombia</p>',
            'defColor' => 'red'
        ]);

        return $map;
    }

    /**
     * Ejemplo 4: Mapa con Área (Polígono)
     *
     * Define un área específica usando polígonos
     */
    public static function ejemploAreaProtegida()
    {
        $map = new Maps('area_protegida');
        $map->set_Size(800, 600);
        $map->set_Center(4.2, -74.5);
        $map->set_Zoom(10);
        $map->set_MapTypeId(Maps::MAP_TYPE_ID_SATELLITE);

        // Definir área protegida (ejemplo: parque nacional)
        $areaProtegida = [
            ['lat' => 4.15, 'lng' => -74.45],
            ['lat' => 4.25, 'lng' => -74.45],
            ['lat' => 4.25, 'lng' => -74.55],
            ['lat' => 4.15, 'lng' => -74.55],
            ['lat' => 4.15, 'lng' => -74.45]  // Cerrar el polígono
        ];

        // Agregar polígono del área protegida
        $map->addPolygon(
            $areaProtegida,
            '#00FF00',  // Color del borde (verde)
            '#00FF00',  // Color de relleno (verde)
            3,          // Grosor del borde
            0.8,        // Opacidad del borde
            0.35        // Opacidad del relleno
        );

        // Agregar marcador informativo
        $map->add_Marker(4.2, -74.5, [
            'title' => 'Área Protegida',
            'html' => '
                <div style="font-family: Arial; width: 200px;">
                    <h3 style="color: green;">🌳 Área Protegida</h3>
                    <p><strong>Tipo:</strong> Parque Nacional</p>
                    <p><strong>Área:</strong> 100 km²</p>
                    <p><strong>Estado:</strong> Protegida</p>
                </div>
            ',
            'icon' => 'https://maps.google.com/mapfiles/ms/icons/green-dot.png'
        ]);

        return $map;
    }

    /**
     * Ejemplo 5: Mapa con Geocodificación
     *
     * Demuestra cómo usar la geocodificación para convertir direcciones en coordenadas
     */
    public static function ejemploGeocodificacion()
    {
        $map = new Maps('mapa_geocoding');
        $map->set_Size(800, 600);
        $map->set_Center(4.0633051, -74.6633296);
        $map->set_Zoom(12);

        // Lista de direcciones para geocodificar
        $direcciones = [
            'Plaza de Bolívar, Bogotá, Colombia',
            'Zona Rosa, Bogotá, Colombia',
            'Aeropuerto El Dorado, Bogotá, Colombia',
            'Universidad Nacional, Bogotá, Colombia'
        ];

        $colores = ['red', 'blue', 'green', 'yellow'];

        foreach ($direcciones as $index => $direccion) {
            try {
                // Geocodificar la dirección
                $coords = $map->get_LatLng($direccion, Maps::URL_FETCH_METHOD_CURL);

                // Agregar marcador en las coordenadas encontradas
                $map->add_Marker($coords['lat'], $coords['lng'], [
                    'title' => $direccion,
                    'html' => "
                        <div style='font-family: Arial;'>
                            <h4>{$direccion}</h4>
                            <p><strong>Lat:</strong> {$coords['lat']}</p>
                            <p><strong>Lng:</strong> {$coords['lng']}</p>
                        </div>
                    ",
                    'defColor' => $colores[$index % count($colores)],
                    'animation' => Maps::ANIMATION_DROP
                ]);

            } catch (Exception $e) {
                // Manejar errores de geocodificación
                error_log("Error geocodificando '{$direccion}': " . $e->getMessage());
            }
        }

        return $map;
    }

    /**
     * Ejemplo 6: Mapa Interactivo con Campos Vinculados
     *
     * Crea un mapa que actualiza campos HTML con las coordenadas
     */
    public static function ejemploMapaInteractivo()
    {
        $map = new Maps('mapa_interactivo');
        $map->set_Size(800, 500);
        $map->set_Center(4.0633051, -74.6633296);
        $map->set_Zoom(10);

        // Vincular campos de coordenadas
        $map->set_LatAndLngFields('campo_latitud', 'campo_longitud');

        // Configurar campos de geocodificación
        $map->set_GeocoderFields([
            'country' => 'select_pais',
            'region' => 'select_departamento',
            'town' => 'select_ciudad',
            'address' => 'input_direccion'
        ]);

        // Agregar marcador arrastrable
        $map->add_Marker(4.0633051, -74.6633296, [
            'title' => 'Arrastra este marcador',
            'html' => '<p>Arrastra este marcador para actualizar las coordenadas</p>',
            'draggable' => true,
            'animation' => Maps::ANIMATION_BOUNCE
        ]);

        return $map;
    }

    /**
     * Ejemplo 7: Mapa con Controles Personalizados
     *
     * Demuestra la configuración avanzada de controles del mapa
     */
    public static function ejemploControlesPersonalizados()
    {
        $map = new Maps('mapa_controles');
        $map->set_Size(900, 600);
        $map->set_Center(4.0633051, -74.6633296);
        $map->set_Zoom(12);

        // Configurar controles
        $map->set_MapTypeControl(true);
        $map->set_MapTypeControlStyle(Maps::MAP_TYPE_CONTROL_STYLE_HORIZONTAL_BAR);
        $map->set_MapTypeControlPosition(Maps::CONTROL_POSITION_TOP_RIGHT);

        $map->set_ZoomControl(true);
        $map->set_ZoomControlStyle(Maps::ZOOM_CONTROL_STYLE_LARGE);
        $map->set_ZoomControlPosition(Maps::CONTROL_POSITION_RIGHT_CENTER);

        $map->set_PanControl(true);
        $map->set_PanControlPosition(Maps::CONTROL_POSITION_LEFT_TOP);

        $map->set_ScaleControl(true);
        $map->set_ScaleControlStyle(Maps::SCALE_CONTROL_STYLE_DEFAULT);

        $map->set_StreetViewControl(true);

        // Deshabilitar doble click para zoom
        $map->set_DisableDoubleClickZoom(true);

        // Agregar marcador informativo
        $map->add_Marker(4.0633051, -74.6633296, [
            'title' => 'Mapa con Controles Personalizados',
            'html' => '
                <div>
                    <h3>🎛️ Controles Personalizados</h3>
                    <ul>
                        <li>Control de tipo de mapa: Arriba derecha</li>
                        <li>Control de zoom: Derecha centro</li>
                        <li>Control de panorámica: Arriba izquierda</li>
                        <li>Doble click deshabilitado</li>
                    </ul>
                </div>
            '
        ]);

        return $map;
    }

    /**
     * Ejemplo 8: Mapa de Calor (Simulado con Marcadores)
     *
     * Simula un mapa de calor usando múltiples marcadores con diferentes colores
     */
    public static function ejemploMapaCalor()
    {
        $map = new Maps('mapa_calor');
        $map->set_Size(800, 600);
        $map->set_Center(4.0633051, -74.6633296);
        $map->set_Zoom(11);

        // Generar puntos de datos simulados
        $puntos = [];
        $centroLat = 4.0633051;
        $centroLng = -74.6633296;

        for ($i = 0; $i < 50; $i++) {
            $lat = $centroLat + (rand(-100, 100) / 1000);
            $lng = $centroLng + (rand(-100, 100) / 1000);
            $intensidad = rand(1, 10);

            $puntos[] = [
                'lat' => $lat,
                'lng' => $lng,
                'intensidad' => $intensidad
            ];
        }

        // Agregar marcadores con colores según intensidad
        foreach ($puntos as $punto) {
            $color = $punto['intensidad'] > 7 ? 'red' :
                ($punto['intensidad'] > 4 ? 'yellow' : 'green');

            $map->add_Marker($punto['lat'], $punto['lng'], [
                'title' => "Intensidad: {$punto['intensidad']}/10",
                'html' => "
                    <div>
                        <h4>Punto de Datos</h4>
                        <p><strong>Intensidad:</strong> {$punto['intensidad']}/10</p>
                        <p><strong>Coordenadas:</strong> {$punto['lat']}, {$punto['lng']}</p>
                    </div>
                ",
                'defColor' => $color,
                'defSymbol' => (string)$punto['intensidad']
            ]);
        }

        return $map;
    }

    /**
     * Generar HTML completo para mostrar un ejemplo
     *
     * @param Maps $map Instancia del mapa
     * @param string $titulo Título del ejemplo
     * @param string $descripcion Descripción del ejemplo
     * @return string HTML completo
     */
    public static function generarHTMLCompleto($map, $titulo, $descripcion = '')
    {
        $mapHTML = $map->__toString();

        return "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>{$titulo}</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                    background-color: #f5f5f5;
                }
                .container {
                    max-width: 1200px;
                    margin: 0 auto;
                    background: white;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                }
                h1 {
                    color: #333;
                    border-bottom: 2px solid #007bff;
                    padding-bottom: 10px;
                }
                .descripcion {
                    background: #e9ecef;
                    padding: 15px;
                    border-radius: 5px;
                    margin-bottom: 20px;
                }
                .mapa-container {
                    margin: 20px 0;
                    text-align: center;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <h1>{$titulo}</h1>
                {$descripcion ? "<div class='descripcion'>{$descripcion}</div>" : ''}
                <div class='mapa-container'>
                    {$mapHTML}
                </div>
            </div>
        </body>
        </html>
        ";
    }
}

// Ejemplo de uso:
/*
// Crear un mapa básico
$mapaBasico = MapsExamples::ejemploBasico();
echo MapsExamples::generarHTMLCompleto(
    $mapaBasico, 
    'Ejemplo Básico de Maps.php',
    'Este es un ejemplo básico de cómo crear un mapa con un marcador simple.'
);
*/

?>
