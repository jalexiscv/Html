<?php

//[vars]----------------------------------------------------------------------------------------------------------------
/** @var object $parent */
/** @var string $component */
/** @var string $view */
/** @var object $authentication */

/** @var object $request */

use App\Libraries\Maps;

$bootstrap = service("bootstrap");
//[models]--------------------------------------------------------------------------------------------------------------
$mtelemetry = model("App\Modules\Sogt\Models\Sogt_Telemetry");
//[vars]----------------------------------------------------------------------------------------------------------------
$telemetry = $mtelemetry->findAll();

// Agrupar waypoints por dispositivo
$deviceWaypoints = array();
$allTimestamps = array();

foreach ($telemetry as $key => $value) {
    $device = $value["device"];
    $latitude = $value["latitude"];
    $longitude = $value["longitude"];
    $altitude = $value["altitude"];
    $speed = $value["speed"];
    $heading = $value["heading"];
    $timestamp = $value["timestamp"];

    // Agrupar por dispositivo
    if (!isset($deviceWaypoints[$device])) {
        $deviceWaypoints[$device] = array();
    }

    $waypoint = array(
            "device" => $device,
            "lat" => floatval($latitude),
            "lng" => floatval($longitude),
            "alt" => floatval($altitude),
            "speed" => floatval($speed),
            "heading" => floatval($heading),
            "timestamp" => $timestamp,
    );

    $deviceWaypoints[$device][] = $waypoint;
    $allTimestamps[] = $timestamp;
}

// Ordenar waypoints de cada dispositivo por timestamp
foreach ($deviceWaypoints as $device => &$waypoints) {
    usort($waypoints, function ($a, $b) {
        return strtotime($a['timestamp']) - strtotime($b['timestamp']);
    });
}

// Obtener timestamps únicos ordenados para el timeline global
$allTimestamps = array_unique($allTimestamps);
sort($allTimestamps);

// Colores para diferentes dispositivos
$deviceColors = [
        Maps::MARKER_COLOR_RED,
        Maps::MARKER_COLOR_BLUE,
        Maps::MARKER_COLOR_GREEN,
        Maps::MARKER_COLOR_YELLOW,
        Maps::MARKER_COLOR_ORANGE,
        Maps::MARKER_COLOR_PURPLE
];

// Crear instancia del mapa usando la librería Maps.php
$map = new Maps('gps_timeline_map');

// Configurar el mapa
$map->setSize(800, 500);
$map->setMapType(Maps::MAP_TYPE_ROADMAP);
$map->setZoom(10);

// Configurar controles del mapa (usando el array de configuración)
$map->setConfig([
        'mapTypeControl' => true,
        'zoomControl' => true,
        'streetViewControl' => true,
        'fullscreenControl' => true,
        'scrollwheel' => true,
        'draggable' => true
]);

// Si hay dispositivos con waypoints, configurar el mapa
if (!empty($deviceWaypoints)) {
    // Calcular el centro del mapa basado en todos los puntos
    $allLats = [];
    $allLngs = [];

    foreach ($deviceWaypoints as $device => $waypoints) {
        foreach ($waypoints as $point) {
            $allLats[] = $point['lat'];
            $allLngs[] = $point['lng'];
        }
    }

    $centerLat = array_sum($allLats) / count($allLats);
    $centerLng = array_sum($allLngs) / count($allLngs);
    $map->setCenter($centerLat, $centerLng);

    // Crear polilíneas para cada dispositivo
    $colorIndex = 0;
    foreach ($deviceWaypoints as $device => $waypoints) {
        if (count($waypoints) > 1) {
            // Crear ruta para este dispositivo
            $devicePath = array();
            foreach ($waypoints as $point) {
                $devicePath[] = array(
                        'lat' => $point['lat'],
                        'lng' => $point['lng']
                );
            }

            // Color único para cada dispositivo
            $deviceColor = $deviceColors[$colorIndex % count($deviceColors)];
            $strokeColors = [
                    Maps::MARKER_COLOR_RED => '#FF0000',
                    Maps::MARKER_COLOR_BLUE => '#0000FF',
                    Maps::MARKER_COLOR_GREEN => '#00FF00',
                    Maps::MARKER_COLOR_YELLOW => '#FFFF00',
                    Maps::MARKER_COLOR_ORANGE => '#FFA500',
                    Maps::MARKER_COLOR_PURPLE => '#800080'
            ];

            // Comentado: Las polilíneas estáticas se reemplazan por trazado progresivo
            // $map->addPolyline($devicePath, [
            //     'strokeColor' => $strokeColors[$deviceColor] ?? '#FF0000',
            //     'strokeWeight' => 3,
            //     'strokeOpacity' => 0.8,
            //     'geodesic' => true
            // ]);

            // Marcadores de inicio y fin para cada dispositivo
            $firstPoint = $waypoints[0];
            $lastPoint = end($waypoints);

            // Marcador de inicio
            $map->addMarker($firstPoint['lat'], $firstPoint['lng'], [
                    'title' => 'Inicio - ' . $device,
                    'color' => $deviceColor,
                    'animation' => Maps::ANIMATION_DROP
            ]);

            // Info window de inicio
            $map->addInfoWindow(
                    '<div><h6>🚀 Inicio - ' . $device . '</h6><p><strong>Dispositivo:</strong> ' . $device . '</p><p><strong>Tiempo:</strong> ' . $firstPoint['timestamp'] . '</p><p><strong>Coordenadas:</strong> ' . $firstPoint['lat'] . ', ' . $firstPoint['lng'] . '</p></div>',
                    $firstPoint['lat'],
                    $firstPoint['lng']
            );

            // Marcador de fin (solo si hay más de un punto)
            if (count($waypoints) > 1) {
                $map->addMarker($lastPoint['lat'], $lastPoint['lng'], [
                        'title' => 'Fin - ' . $device,
                        'color' => $deviceColor,
                        'animation' => Maps::ANIMATION_BOUNCE
                ]);

                // Info window de fin
                $map->addInfoWindow(
                        '<div><h6>🏁 Fin - ' . $device . '</h6><p><strong>Dispositivo:</strong> ' . $device . '</p><p><strong>Tiempo:</strong> ' . $lastPoint['timestamp'] . '</p><p><strong>Coordenadas:</strong> ' . $lastPoint['lat'] . ', ' . $lastPoint['lng'] . '</p></div>',
                        $lastPoint['lat'],
                        $lastPoint['lng']
                );
            }

            $colorIndex++;
        }
    }
} else {
    // Si no hay dispositivos, centrar en Bogotá por defecto
    $map->setCenter(4.7110, -74.0721);
    $defaultMarkerId = $map->addMarker(4.7110, -74.0721, [
            'title' => 'Ubicación por defecto',
            'color' => Maps::MARKER_COLOR_BLUE
    ]);

    // Agregar info window para ubicación por defecto
    $map->addInfoWindow(
            '<div><h6>📍 Bogotá, Colombia</h6><p>No hay datos de telemetría disponibles</p><p><strong>Dispositivos encontrados:</strong> 0</p></div>',
            4.7110,
            -74.0721
    );

    // Inicializar arrays vacíos para JavaScript
    $deviceWaypoints = [];
    $allTimestamps = [];
}

// Generar el HTML del mapa
$mapHTML = $map->render();

// Contenido del mapa con controles adicionales
$mapContent = $mapHTML;

$card = $bootstrap->get_Card("card-view-Plex", array(
        "class" => "mb-3",
        "title" => "Mapa GPS con Línea de Tiempo - Librería Maps.php",
        "content" => $mapContent,
));
echo($card);
?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<!-- Controles de Línea de Tiempo -->
<div class="row mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-clock"></i> Línea de Tiempo - Recorrido GPS</h6>
            </div>
            <div class="card-body">
                <div class="timeline-controls">
                    <!-- Controles de reproducción -->
                    <div class="d-flex justify-content-center align-items-center mb-3">
                        <button id="playBtn" class="btn btn-success btn-timeline me-2">
                            <i class="fas fa-play"></i>
                        </button>
                        <button id="pauseBtn" class="btn btn-warning btn-timeline me-2" disabled>
                            <i class="fas fa-pause"></i>
                        </button>
                        <button id="stopBtn" class="btn btn-danger btn-timeline me-3" disabled>
                            <i class="fas fa-stop"></i>
                        </button>

                        <!-- Control de velocidad -->
                        <div class="speed-control">
                            <label for="speedControl" class="form-label mb-0">Velocidad:</label>
                            <select id="speedControl" class="form-select form-select-sm" style="width: 80px;">
                                <option value="0.5">0.5x</option>
                                <option value="1" selected>1x</option>
                                <option value="2">2x</option>
                                <option value="5">5x</option>
                                <option value="10">10x</option>
                            </select>
                        </div>
                    </div>

                    <!-- Slider de progreso -->
                    <input type="range" id="timelineSlider" class="timeline-slider" min="0" max="100" value="0">

                    <!-- Información en tiempo real -->
                    <div class="timeline-info">
                        <div class="info-card">
                            <div class="info-label">Tiempo Actual</div>
                            <div class="info-value" id="currentTime">--:--:--</div>
                        </div>
                        <div class="info-card">
                            <div class="info-label">Dispositivos Activos</div>
                            <div class="info-value" id="activeDevices">--</div>
                        </div>
                        <div class="info-card">
                            <div class="info-label">Punto Timeline</div>
                            <div class="info-value" id="currentPoint">-- / --</div>
                        </div>
                        <div class="info-card">
                            <div class="info-label">Progreso</div>
                            <div class="info-value" id="progressPercent">--%</div>
                        </div>
                    </div>

                    <!-- Información detallada por dispositivo -->
                    <div class="devices-info mt-3" id="devicesInfo">
                        <!-- Se llenará dinámicamente con JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Controles del Mapa -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-cogs"></i> Controles del Mapa</h6>
            </div>
            <div class="card-body">
                <div class="btn-group me-2" role="group">
                    <button type="button" class="btn btn-outline-primary" onclick="changeMapType('roadmap')">
                        <i class="fas fa-road"></i> Carretera
                    </button>
                    <button type="button" class="btn btn-outline-primary" onclick="changeMapType('satellite')">
                        <i class="fas fa-satellite"></i> Satélite
                    </button>
                    <button type="button" class="btn btn-outline-primary" onclick="changeMapType('hybrid')">
                        <i class="fas fa-layer-group"></i> Híbrido
                    </button>
                    <button type="button" class="btn btn-outline-primary" onclick="changeMapType('terrain')">
                        <i class="fas fa-mountain"></i> Terreno
                    </button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-success" onclick="getCurrentLocation()">
                        <i class="fas fa-crosshairs"></i> Mi Ubicación
                    </button>
                    <button type="button" class="btn btn-info" onclick="clearTimelineMarkers()">
                        <i class="fas fa-eraser"></i> Limpiar Timeline
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Búsqueda de ubicaciones -->
<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-search"></i> Búsqueda de Ubicaciones</h6>
            </div>
            <div class="card-body">
                <div class="input-group">
                    <input type="text" id="searchInput" class="form-control" placeholder="Buscar dirección o lugar...">
                    <button id="searchBtn" class="btn btn-primary" type="button">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="latitude" class="form-label">Latitud:</label>
                        <input type="text" id="latitude" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="longitude" class="form-label">Longitud:</label>
                        <input type="text" id="longitude" class="form-control" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estilos CSS -->
<style>
    /* Estilos para el contenedor del mapa generado por Maps.php */
    #gps_timeline_map {
        width: 100% !important;
        height: 500px !important;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        margin-bottom: 20px;
    }

    .map {
        width: 100% !important;
        height: 500px !important;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .timeline-controls {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .timeline-slider {
        width: 100%;
        margin: 10px 0;
    }

    .timeline-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }

    .info-card {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 10px;
    }

    .info-label {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 5px;
    }

    .info-value {
        font-size: 14px;
        font-weight: 600;
        color: #495057;
    }

    .speed-control {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-timeline {
        min-width: 45px;
    }

    .gm-style-iw {
        max-width: 300px !important;
    }

    .gm-style-iw-c {
        max-width: 300px !important;
    }

    .info-window-content {
        font-size: 14px;
    }

    /* Estilos para dispositivos multi-timeline */
    .devices-info {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
    }

    .device-card {
        background: white;
        border-radius: 6px;
        padding: 10px;
        margin-bottom: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .device-card.active {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        transform: translateY(-1px);
    }

    .device-card.inactive {
        opacity: 0.7;
    }

    .device-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 5px;
    }

    .device-icon {
        font-size: 16px;
        margin-right: 8px;
    }

    .device-name {
        font-weight: 600;
        color: #495057;
        flex-grow: 1;
    }

    .device-status {
        font-size: 11px;
        padding: 2px 6px;
        border-radius: 10px;
        font-weight: 500;
    }

    .status-active {
        background-color: #d4edda;
        color: #155724;
    }

    .status-inactive {
        background-color: #f8d7da;
        color: #721c24;
    }

    .device-details {
        font-size: 12px;
        color: #6c757d;
        margin-top: 5px;
    }
</style>

<!-- JavaScript del timeline multi-dispositivo integrado -->

<!-- JavaScript para Timeline GPS -->
<script>
    // Variables globales para timeline multi-dispositivo
    let deviceWaypoints = <?php echo json_encode($deviceWaypoints); ?>;
    let allTimestamps = <?php echo json_encode($allTimestamps); ?>;
    let deviceColors = <?php echo json_encode($deviceColors); ?>;
    let currentDeviceMarkers = {};
    let isPlaying = false;
    let isPaused = false;
    let currentTimeIndex = 0;
    let playbackInterval = null;
    let playbackSpeed = 1;
    let timelineMarkers = [];
    let devicePaths = {};
    let deviceCurrentPositions = {};
    let deviceProgressivePolylines = {}; // Polilíneas que se construyen progresivamente
    let deviceVisitedPoints = {}; // Puntos ya visitados por cada dispositivo

    // Colores para marcadores por dispositivo
    const DEVICE_MARKER_COLORS = {
        'red': '#FF0000',
        'blue': '#0000FF',
        'green': '#00FF00',
        'yellow': '#FFFF00',
        'orange': '#FFA500',
        'purple': '#800080'
    };

    // Iconos personalizados para cada dispositivo
    const DEVICE_ICONS = {
        'red': '🔴',
        'blue': '🔵',
        'green': '🟢',
        'yellow': '🟡',
        'orange': '🟠',
        'purple': '🟣'
    };

    /**
     * Inicializar timeline multi-dispositivo
     */
    function initMultiDeviceTimeline() {
        console.log('🚀 Inicializando timeline multi-dispositivo...');
        console.log('📊 Datos disponibles:', {
            deviceWaypoints: deviceWaypoints,
            allTimestamps: allTimestamps,
            deviceColors: deviceColors
        });

        // Verificar si deviceWaypoints está definido
        if (typeof deviceWaypoints === 'undefined') {
            console.error('❌ ERROR: deviceWaypoints no está definido');
            console.log('💡 Esto indica que la variable PHP no se está pasando correctamente al JavaScript');
            initEventListeners(); // Inicializar controles para debug manual
            return;
        }

        if (!deviceWaypoints || Object.keys(deviceWaypoints).length === 0) {
            console.warn('⚠️ No hay dispositivos con waypoints disponibles');
            console.log('📋 deviceWaypoints está vacío o es null:', deviceWaypoints);
            updateActiveDevicesCount(0);
            // Aún así inicializar los controles para debug
            initEventListeners();
            return;
        }

        console.log('✅ Dispositivos encontrados:', Object.keys(deviceWaypoints));
        console.log('📈 Total de waypoints por dispositivo:');
        Object.keys(deviceWaypoints).forEach(device => {
            console.log(`  - ${device}: ${deviceWaypoints[device].length} waypoints`);
        });
        console.log('📅 Timestamps totales:', allTimestamps.length);

        // Configurar slider con el número total de timestamps
        const slider = document.getElementById("timelineSlider");
        if (slider) {
            slider.max = allTimestamps.length - 1;
            slider.value = 0;
            console.log('🎚️ Slider configurado: max =', allTimestamps.length - 1);
        } else {
            console.error('❌ Slider de timeline no encontrado');
        }

        // Inicializar posiciones de cada dispositivo
        initializeDevicePositions();

        // Mostrar información inicial
        updateTimelineInfo();
        updateDevicesInfo();
        updateActiveDevicesCount(Object.keys(deviceWaypoints).length);

        // Inicializar event listeners
        initEventListeners();

        // Actualizar botones iniciales
        updatePlaybackButtons();

        console.log('✅ Timeline multi-dispositivo inicializado exitosamente');
    }

    /**
     * Inicializar posiciones de dispositivos
     */
    function initializeDevicePositions() {
        Object.keys(deviceWaypoints).forEach(device => {
            deviceCurrentPositions[device] = {
                currentIndex: 0,
                lastKnownPosition: null,
                isActive: false
            };

            // Inicializar arrays para trazado progresivo
            deviceVisitedPoints[device] = [];
            deviceProgressivePolylines[device] = null;
        });
    }

    /**
     * Reproducir timeline multi-dispositivo
     */
    function playMultiDeviceTimeline() {
        console.log('▶️ Iniciando reproducción del timeline...');
        console.log('📊 Estado actual:', {
            allTimestamps: allTimestamps.length,
            currentTimeIndex: currentTimeIndex,
            isPlaying: isPlaying,
            isPaused: isPaused
        });

        if (!allTimestamps || allTimestamps.length === 0) {
            console.error('❌ No hay timestamps disponibles para reproducir');
            alert('No hay datos de telemetría para reproducir');
            return;
        }

        // Si estamos empezando desde el inicio, limpiar polilíneas progresivas
        if (currentTimeIndex === 0) {
            clearProgressivePolylines();
            console.log('🧹 Limpiando polilíneas progresivas para nuevo inicio');
        }

        isPlaying = true;
        isPaused = false;
        updatePlaybackButtons();

        // Velocidad base: 1 timestamp por segundo
        const baseInterval = 1000;
        const interval = baseInterval / playbackSpeed;

        console.log(`⏱️ Configurando intervalo: ${interval}ms (velocidad: ${playbackSpeed}x)`);

        playbackInterval = setInterval(() => {
            if (currentTimeIndex < allTimestamps.length - 1) {
                currentTimeIndex++;
                const currentTimestamp = allTimestamps[currentTimeIndex];
                console.log(`📍 Avanzando a timestamp ${currentTimeIndex}/${allTimestamps.length - 1} - Tiempo: ${currentTimestamp}`);

                // Mostrar coordenadas de cada dispositivo en este timestamp
                Object.keys(deviceWaypoints).forEach(device => {
                    const position = findDevicePositionAtTime(device, currentTimestamp);
                    if (position) {
                        console.log(`  🔵 ${device}: Lat ${position.lat}, Lng ${position.lng} (${position.timestamp})`);
                    } else {
                        console.log(`  ⚪ ${device}: Sin posición en este timestamp`);
                    }
                });

                updateAllDevicesAtCurrentTime();
                updateSlider();
                updateTimelineInfo();
                updateDevicesInfo();
            } else {
                console.log('🏁 Timeline completado, deteniendo...');
                stopMultiDeviceTimeline();
            }
        }, interval);

        console.log('✅ Timeline multi-dispositivo iniciado exitosamente');
    }

    /**
     * Pausar timeline multi-dispositivo
     */
    function pauseMultiDeviceTimeline() {
        console.log('⏸️ Pausando timeline...');
        if (playbackInterval) {
            clearInterval(playbackInterval);
            playbackInterval = null;
            console.log('✅ Intervalo de reproducción limpiado');
        }
        isPlaying = false;
        isPaused = true;
        updatePlaybackButtons();
        console.log('✅ Timeline multi-dispositivo pausado');
    }

    /**
     * Detener timeline multi-dispositivo
     */
    function stopMultiDeviceTimeline() {
        console.log('⏹️ Deteniendo timeline...');
        if (playbackInterval) {
            clearInterval(playbackInterval);
            playbackInterval = null;
            console.log('✅ Intervalo de reproducción limpiado');
        }
        isPlaying = false;
        isPaused = false;
        currentTimeIndex = 0;

        // Limpiar marcadores actuales y polilíneas progresivas
        clearCurrentDeviceMarkers();
        clearProgressivePolylines();
        console.log('🧹 Marcadores y polilíneas progresivas limpiados');

        updateAllDevicesAtCurrentTime();
        updateSlider();
        updateTimelineInfo();
        updateDevicesInfo();
        updatePlaybackButtons();

        console.log('✅ Timeline multi-dispositivo detenido y reiniciado');
    }

    /**
     * Actualizar todas las posiciones de dispositivos en el tiempo actual
     */
    function updateAllDevicesAtCurrentTime() {
        if (!mapInstance || allTimestamps.length === 0) return;

        const currentTimestamp = allTimestamps[currentTimeIndex];
        let activeDevicesCount = 0;

        console.log(`🔄 updateAllDevicesAtCurrentTime() - Timestamp: ${currentTimestamp}`);
        console.log(`📊 Mapa disponible: ${!!mapInstance}, Dispositivos: ${Object.keys(deviceWaypoints).length}`);

        // Limpiar marcadores anteriores
        clearCurrentDeviceMarkers();

        // Actualizar cada dispositivo
        Object.keys(deviceWaypoints).forEach((device, index) => {
            const waypoints = deviceWaypoints[device];
            const deviceColor = deviceColors[index % deviceColors.length];

            console.log(`🔍 Procesando ${device} (${waypoints.length} waypoints, color: ${deviceColor})`);

            // Encontrar la posición más cercana para este timestamp
            const position = findDevicePositionAtTime(device, currentTimestamp);

            if (position) {
                console.log(`✅ ${device} - Posición encontrada: Lat ${position.lat}, Lng ${position.lng}`);
                console.log(`📍 Creando marcador para ${device}...`);
                createDeviceMarker(device, position, deviceColor, index);
                deviceCurrentPositions[device].isActive = true;
                deviceCurrentPositions[device].lastKnownPosition = position;
                activeDevicesCount++;
            } else {
                console.log(`❌ ${device} - Sin posición en timestamp ${currentTimestamp}`);
                deviceCurrentPositions[device].isActive = false;
                // Aún así actualizar la polilínea para mostrar el trazo hasta este punto
                updateProgressivePolyline(device, DEVICE_MARKER_COLORS[deviceColors[index % deviceColors.length].toLowerCase()] || '#FF0000');
            }
        });

        console.log(`📈 Dispositivos activos: ${activeDevicesCount}/${Object.keys(deviceWaypoints).length}`);
        updateActiveDevicesCount(activeDevicesCount);
    }

    /**
     * Encontrar la posición de un dispositivo en un timestamp específico
     */
    function findDevicePositionAtTime(device, targetTimestamp) {
        const waypoints = deviceWaypoints[device];
        if (!waypoints || waypoints.length === 0) return null;

        console.log(`🔍 findDevicePositionAtTime: Buscando posición para ${device} en timestamp ${targetTimestamp}`);
        console.log(`📊 Waypoints disponibles: ${waypoints.length}`);

        // Debug: Mostrar formato de los primeros waypoints
        if (waypoints.length > 0) {
            console.log(`🔍 Formato de waypoint ejemplo:`, {
                timestamp: waypoints[0].timestamp,
                tipo: typeof waypoints[0].timestamp,
                lat: waypoints[0].lat,
                lng: waypoints[0].lng
            });
        }

        // Convertir targetTimestamp a número Unix
        let targetTime;
        if (typeof targetTimestamp === 'string') {
            // Si es string, podría ser timestamp Unix como string o fecha ISO
            const parsed = parseInt(targetTimestamp);
            if (!isNaN(parsed)) {
                // Es timestamp Unix como string
                targetTime = parsed;
            } else {
                // Es fecha ISO string
                targetTime = Math.floor(new Date(targetTimestamp).getTime() / 1000);
            }
        } else {
            // Ya es número Unix
            targetTime = targetTimestamp;
        }

        console.log(`🎯 Target time (Unix): ${targetTime}`);

        // Validar que el timestamp convertido sea válido antes de crear la fecha
        let dateString = 'Fecha inválida';
        try {
            const testDate = new Date(targetTime);
            if (!isNaN(testDate.getTime())) {
                dateString = testDate.toISOString();
            }
        } catch (e) {
            console.warn('⚠️ Error al convertir timestamp a fecha:', e);
        }

        console.log(`🎯 Target time convertido: ${targetTime} (${dateString})`);

        // Buscar el waypoint más cercano al timestamp objetivo
        let closestWaypoint = null;
        let minTimeDiff = Infinity;

        for (let waypoint of waypoints) {
            // Convertir timestamp del waypoint a número Unix
            let waypointTime;
            if (typeof waypoint.timestamp === 'string') {
                // Si es string, podría ser timestamp Unix como string o fecha ISO
                const parsed = parseInt(waypoint.timestamp);
                if (!isNaN(parsed)) {
                    // Es timestamp Unix como string
                    waypointTime = parsed;
                } else {
                    // Es fecha ISO string
                    waypointTime = Math.floor(new Date(waypoint.timestamp).getTime() / 1000);
                }
            } else {
                // Ya es número Unix
                waypointTime = waypoint.timestamp;
            }

            const timeDiff = Math.abs(waypointTime - targetTime);

            if (timeDiff < minTimeDiff) {
                minTimeDiff = timeDiff;
                closestWaypoint = waypoint;
            }

            // Si encontramos un waypoint exacto o muy cercano (menos de 30 segundos), lo usamos
            if (timeDiff < 30000) {
                console.log(`✅ Waypoint cercano encontrado para ${device}: diferencia ${timeDiff}ms`);
                break;
            }
        }

        if (closestWaypoint) {
            console.log(`✅ ${device} - Waypoint más cercano: Lat ${closestWaypoint.lat}, Lng ${closestWaypoint.lng} (diferencia: ${minTimeDiff}ms)`);
        } else {
            console.log(`❌ ${device} - No se encontró waypoint cercano`);
        }

        return closestWaypoint;
    }

    /**
     * Crear marcador para un dispositivo y actualizar trazado progresivo
     */
    function createDeviceMarker(device, position, deviceColor, deviceIndex) {
        if (!mapInstance) {
            console.error('❌ createDeviceMarker: mapInstance no disponible');
            return;
        }

        const colorKey = deviceColor.toLowerCase();
        const markerColor = DEVICE_MARKER_COLORS[colorKey] || '#FF0000';
        const deviceIcon = DEVICE_ICONS[colorKey] || '📍';

        console.log(`🎯 createDeviceMarker: ${device} en Lat ${position.lat}, Lng ${position.lng} (color: ${markerColor})`);

        // Actualizar polilínea progresiva basada en la posición actual del timeline
        updateProgressivePolyline(device, markerColor);

        // Crear punto para el marcador
        const currentPoint = {lat: position.lat, lng: position.lng};

        // Crear marcador personalizado
        const marker = new google.maps.Marker({
            position: currentPoint,
            map: mapInstance,
            title: `${device} - ${formatTimestamp(position.timestamp)}`,
            icon: {
                path: google.maps.SymbolPath.CIRCLE,
                scale: 12,
                fillColor: markerColor,
                fillOpacity: 0.9,
                strokeColor: "#ffffff",
                strokeWeight: 3,
            },
            animation: isPlaying ? google.maps.Animation.BOUNCE : null,
            zIndex: 1000 + deviceIndex
        });

        // Guardar referencia del marcador
        currentDeviceMarkers[device] = marker;

        // Info window con información detallada
        const infoContent = `
        <div style="font-family: Arial, sans-serif; max-width: 280px;">
            <h6 style="margin: 0 0 10px 0; color: ${markerColor};">
                ${deviceIcon} ${device}
            </h6>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; font-size: 13px;">
                <div><strong>Coordenadas:</strong></div>
                <div>${position.lat.toFixed(6)}, ${position.lng.toFixed(6)}</div>
                
                <div><strong>Velocidad:</strong></div>
                <div>${position.speed || 0} km/h</div>
                
                <div><strong>Altitud:</strong></div>
                <div>${position.alt || 0} m</div>
                
                <div><strong>Rumbo:</strong></div>
                <div>${position.heading || 0}°</div>
                
                <div><strong>Tiempo:</strong></div>
                <div>${formatTimestamp(position.timestamp)}</div>
            </div>
        </div>
    `;

        marker.addListener("click", () => {
            if (infoWindow) {
                infoWindow.setContent(infoContent);
                infoWindow.open(mapInstance, marker);
            }
        });

        // Detener animación después de un tiempo
        if (isPlaying) {
            setTimeout(() => {
                if (marker) {
                    marker.setAnimation(null);
                }
            }, 1500);
        }
    }

    /**
     * Limpiar marcadores actuales de dispositivos
     */
    function clearCurrentDeviceMarkers() {
        Object.values(currentDeviceMarkers).forEach(marker => {
            if (marker && marker.setMap) {
                marker.setMap(null);
            }
        });
        currentDeviceMarkers = {};
    }

    /**
     * Limpiar polilíneas progresivas de dispositivos
     */
    function clearProgressivePolylines() {
        Object.keys(deviceProgressivePolylines).forEach(device => {
            if (deviceProgressivePolylines[device] && deviceProgressivePolylines[device].setMap) {
                deviceProgressivePolylines[device].setMap(null);
            }
            deviceProgressivePolylines[device] = null;
            deviceVisitedPoints[device] = [];
        });
    }

    /**
     * Actualizar polilínea progresiva de un dispositivo basada en la posición actual del timeline
     */
    function updateProgressivePolyline(device, color) {
        if (!mapInstance) {
            return;
        }

        // Si no existe polilínea, crear una nueva
        if (!deviceProgressivePolylines[device]) {
            deviceProgressivePolylines[device] = new google.maps.Polyline({
                path: [],
                geodesic: true,
                strokeColor: color,
                strokeOpacity: 0.8,
                strokeWeight: 3,
                map: mapInstance
            });
            console.log(`🆕 Nueva polilínea creada para ${device}`);
        }

        // Calcular qué puntos deben estar visibles basado en currentTimeIndex
        const visiblePoints = calculateVisiblePointsForDevice(device, currentTimeIndex);

        // Actualizar el path completo de la polilínea
        const newPath = visiblePoints.map(point => new google.maps.LatLng(point.lat, point.lng));
        deviceProgressivePolylines[device].setPath(newPath);

        console.log(`🔄 Polilínea actualizada para ${device}: ${newPath.length} puntos visibles (timeline: ${currentTimeIndex}/${allTimestamps.length - 1})`);
    }

    /**
     * Calcular qué puntos de un dispositivo deben estar visibles hasta el timestamp actual
     */
    function calculateVisiblePointsForDevice(device, timeIndex) {
        const waypoints = deviceWaypoints[device];
        if (!waypoints || waypoints.length === 0 || timeIndex < 0) {
            return [];
        }

        const currentTimestamp = allTimestamps[timeIndex];
        const visiblePoints = [];

        // Convertir currentTimestamp a número Unix para comparación
        let currentTime;
        if (typeof currentTimestamp === 'string') {
            const parsed = parseInt(currentTimestamp);
            currentTime = !isNaN(parsed) ? parsed : Math.floor(new Date(currentTimestamp).getTime() / 1000);
        } else {
            currentTime = currentTimestamp;
        }

        // Agregar todos los waypoints que están antes o en el timestamp actual
        for (let waypoint of waypoints) {
            let waypointTime;
            if (typeof waypoint.timestamp === 'string') {
                const parsed = parseInt(waypoint.timestamp);
                waypointTime = !isNaN(parsed) ? parsed : Math.floor(new Date(waypoint.timestamp).getTime() / 1000);
            } else {
                waypointTime = waypoint.timestamp;
            }

            // Si este waypoint está antes o en el tiempo actual, incluirlo
            if (waypointTime <= currentTime) {
                visiblePoints.push({
                    lat: waypoint.lat,
                    lng: waypoint.lng,
                    timestamp: waypoint.timestamp
                });
            }
        }

        return visiblePoints;
    }

    /**
     * Actualizar información del timeline
     */
    function updateTimelineInfo() {
        if (allTimestamps.length === 0) return;

        const currentTimestamp = allTimestamps[currentTimeIndex];
        const progress = ((currentTimeIndex + 1) / allTimestamps.length * 100).toFixed(1);

        // Actualizar elementos de información
        const elements = {
            currentTime: formatTimestamp(currentTimestamp),
            currentPoint: `${currentTimeIndex + 1} / ${allTimestamps.length}`,
            progressPercent: `${progress}%`
        };

        Object.keys(elements).forEach(id => {
            const element = document.getElementById(id);
            if (element) element.textContent = elements[id];
        });
    }

    /**
     * Actualizar información detallada de dispositivos
     */
    function updateDevicesInfo() {
        const devicesInfoContainer = document.getElementById('devicesInfo');
        if (!devicesInfoContainer) return;

        let html = '<div class="row">';

        Object.keys(deviceWaypoints).forEach((device, index) => {
            const deviceColor = deviceColors[index % deviceColors.length];
            const colorKey = deviceColor.toLowerCase();
            const markerColor = DEVICE_MARKER_COLORS[colorKey] || '#FF0000';
            const deviceIcon = DEVICE_ICONS[colorKey] || '📍';
            const position = deviceCurrentPositions[device];
            const isActive = position && position.isActive;
            const lastPosition = position ? position.lastKnownPosition : null;

            html += `
            <div class="col-md-6 col-lg-4 mb-2">
                <div class="device-card ${isActive ? 'active' : 'inactive'}" style="border-left: 4px solid ${markerColor};">
                    <div class="device-header">
                        <span class="device-icon">${deviceIcon}</span>
                        <span class="device-name">${device}</span>
                        <span class="device-status ${isActive ? 'status-active' : 'status-inactive'}">
                            ${isActive ? '🟢 Activo' : '⚫ Inactivo'}
                        </span>
                    </div>
                    ${lastPosition ? `
                        <div class="device-details">
                            <small>
                                <strong>Vel:</strong> ${lastPosition.speed || 0} km/h | 
                                <strong>Alt:</strong> ${lastPosition.alt || 0} m
                            </small>
                        </div>
                    ` : ''}
                </div>
            </div>
        `;
        });

        html += '</div>';
        devicesInfoContainer.innerHTML = html;
    }

    /**
     * Actualizar contador de dispositivos activos
     */
    function updateActiveDevicesCount(count) {
        const element = document.getElementById('activeDevices');
        if (element) {
            element.textContent = `${count} / ${Object.keys(deviceWaypoints).length}`;
        }
    }

    /**
     * Actualizar slider
     */
    function updateSlider() {
        const slider = document.getElementById("timelineSlider");
        if (slider) slider.value = currentTimeIndex;
    }

    /**
     * Formatear timestamp
     */
    function formatTimestamp(timestamp) {
        const date = new Date(timestamp);
        return date.toLocaleString("es-ES", {
            year: "numeric",
            month: "2-digit",
            day: "2-digit",
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit"
        });
    }

    /**
     * Manejar cambio en el slider
     */
    function handleSliderChange(value) {
        currentTimeIndex = parseInt(value);
        updateAllDevicesAtCurrentTime();
        updateTimelineInfo();
        updateDevicesInfo();
    }

    /**
     * Manejar cambio de velocidad
     */
    function handleSpeedChange(speed) {
        playbackSpeed = parseFloat(speed);

        // Si está reproduciendo, reiniciar con nueva velocidad
        if (isPlaying) {
            pauseMultiDeviceTimeline();
            playMultiDeviceTimeline();
        }
    }

    // Referencia al mapa generado por Maps.php
    let mapInstance = null;
    let geocoder = null;
    let infoWindow = null;

    // Función para obtener la instancia del mapa de Maps.php
    function getMapInstance() {
        // La librería Maps.php genera una variable con el nombre map_{mapId}
        const mapId = 'gps_timeline_map';
        const mapVarName = 'map_' + mapId;

        // Verificar si la variable del mapa existe en el scope global
        if (typeof window[mapVarName] !== 'undefined' && window[mapVarName]) {
            console.log('Mapa encontrado:', mapVarName);
            return window[mapVarName];
        }

        console.log('Mapa no encontrado:', mapVarName);
        return null;
    }

    // Inicializar timeline después de que Maps.php haya inicializado el mapa
    function initTimelineAfterMapLoad() {
        console.log('Iniciando verificación de mapa...');
        let attempts = 0;
        const maxAttempts = 20; // Máximo 10 segundos

        // Esperar a que Maps.php inicialice el mapa
        const checkMapReady = () => {
            attempts++;
            console.log(`Intento ${attempts}/${maxAttempts} - Verificando mapa...`);

            // Verificar si Google Maps está disponible
            if (typeof google === 'undefined' || !google.maps) {
                console.log('Google Maps API no está disponible aún');
                if (attempts < maxAttempts) {
                    setTimeout(checkMapReady, 500);
                } else {
                    console.error('Timeout: Google Maps API no se cargó');
                }
                return;
            }

            // Intentar obtener la instancia del mapa
            mapInstance = getMapInstance();
            if (mapInstance) {
                console.log('✅ Mapa encontrado, inicializando timeline...');

                // Debug detallado de los datos antes de inicializar
                console.log('🔍 DEBUG - Verificando datos antes de inicializar:');
                console.log('- deviceWaypoints:', deviceWaypoints);
                console.log('- Número de dispositivos:', deviceWaypoints ? Object.keys(deviceWaypoints).length : 0);
                console.log('- allTimestamps:', allTimestamps);
                console.log('- Número de timestamps:', allTimestamps ? allTimestamps.length : 0);

                // Inicializar servicios de Google Maps
                geocoder = new google.maps.Geocoder();
                infoWindow = new google.maps.InfoWindow();

                // Configurar event listeners del mapa
                setupMapEventListeners();

                // Inicializar timeline multi-dispositivo
                initMultiDeviceTimeline();
            } else {
                console.log('Mapa no disponible aún, reintentando...');
                if (attempts < maxAttempts) {
                    setTimeout(checkMapReady, 500);
                } else {
                    console.error('Timeout: No se pudo obtener la instancia del mapa');
                    // Intentar inicializar sin mapa para debug
                    console.log('Intentando inicializar timeline sin mapa para debug...');
                    initMultiDeviceTimeline();
                }
            }
        };

        checkMapReady();
    }

    // Configurar event listeners del mapa
    function setupMapEventListeners() {
        if (mapInstance) {
            // Event listener para clicks en el mapa
            mapInstance.addListener("click", (event) => {
                const lat = event.latLng.lat();
                const lng = event.latLng.lng();

                // Actualizar campos de coordenadas
                const latField = document.getElementById("latitude");
                const lngField = document.getElementById("longitude");

                if (latField) latField.value = lat.toFixed(6);
                if (lngField) lngField.value = lng.toFixed(6);

                console.log('Click en mapa:', lat, lng);
            });
        }
    }

    // Funciones de timeline ahora delegadas al sistema multi-dispositivo
    function playTimeline() {
        console.log('🎮 Botón Play presionado - delegando a playMultiDeviceTimeline()');
        playMultiDeviceTimeline();
    }

    function pauseTimeline() {
        console.log('🎮 Botón Pause presionado - delegando a pauseMultiDeviceTimeline()');
        pauseMultiDeviceTimeline();
    }

    function stopTimeline() {
        console.log('🎮 Botón Stop presionado - delegando a stopMultiDeviceTimeline()');
        stopMultiDeviceTimeline();
    }

    // Actualizar botones de reproducción
    function updatePlaybackButtons() {
        const playBtn = document.getElementById("playBtn");
        const pauseBtn = document.getElementById("pauseBtn");
        const stopBtn = document.getElementById("stopBtn");

        if (playBtn) playBtn.disabled = isPlaying;
        if (pauseBtn) pauseBtn.disabled = !isPlaying;
        if (stopBtn) stopBtn.disabled = !isPlaying && !isPaused;
    }

    // Actualizar posición actual
    function updateCurrentPosition() {
        if (allTimestamps.length === 0 || !mapInstance) return;

        // Esta función ya no se usa en el sistema multi-dispositivo
        // pero se mantiene para compatibilidad

    }


    // Formatear timestamp
    function formatTimestamp(timestamp) {
        const date = new Date(timestamp);
        return date.toLocaleTimeString("es-ES", {
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit"
        });
    }

    // Cambiar tipo de mapa
    function changeMapType(mapType) {
        if (!mapInstance) {
            console.log('Mapa no disponible para cambiar tipo');
            return;
        }

        let googleMapType;
        switch (mapType) {
            case 'roadmap':
                googleMapType = google.maps.MapTypeId.ROADMAP;
                break;
            case 'satellite':
                googleMapType = google.maps.MapTypeId.SATELLITE;
                break;
            case 'hybrid':
                googleMapType = google.maps.MapTypeId.HYBRID;
                break;
            case 'terrain':
                googleMapType = google.maps.MapTypeId.TERRAIN;
                break;
            default:
                googleMapType = google.maps.MapTypeId.ROADMAP;
        }

        mapInstance.setMapTypeId(googleMapType);
        console.log('Tipo de mapa cambiado a:', mapType);
    }

    // Obtener ubicación actual
    function getCurrentLocation() {
        if (!navigator.geolocation) {
            alert("La geolocalización no es compatible con este navegador");
            return;
        }

        navigator.geolocation.getCurrentPosition(
            (position) => {
                const pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };

                // Actualizar campos de coordenadas
                const latField = document.getElementById("latitude");
                const lngField = document.getElementById("longitude");

                if (latField) latField.value = pos.lat.toFixed(6);
                if (lngField) lngField.value = pos.lng.toFixed(6);

                // Centrar mapa en la ubicación actual
                if (mapInstance) {
                    mapInstance.setCenter(pos);
                    mapInstance.setZoom(15);

                    // Agregar marcador de ubicación actual
                    const locationMarker = new google.maps.Marker({
                        position: pos,
                        map: mapInstance,
                        title: "Mi ubicación actual",
                        icon: {
                            path: google.maps.SymbolPath.CIRCLE,
                            scale: 8,
                            fillColor: "#00FF00",
                            fillOpacity: 1,
                            strokeColor: "#ffffff",
                            strokeWeight: 2,
                        },
                        animation: google.maps.Animation.DROP
                    });

                    // Info window para ubicación actual
                    const locationInfo = `
                    <div style="font-family: Arial, sans-serif;">
                        <h6 style="margin: 0 0 10px 0; color: #333;">📍 Mi Ubicación Actual</h6>
                        <p style="margin: 5px 0;"><strong>Latitud:</strong> ${pos.lat.toFixed(6)}</p>
                        <p style="margin: 5px 0;"><strong>Longitud:</strong> ${pos.lng.toFixed(6)}</p>
                        <p style="margin: 5px 0;"><strong>Precisión:</strong> ±${Math.round(position.coords.accuracy)}m</p>
                    </div>
                `;

                    locationMarker.addListener("click", () => {
                        if (infoWindow) {
                            infoWindow.setContent(locationInfo);
                            infoWindow.open(mapInstance, locationMarker);
                        }
                    });
                }

                console.log('Ubicación actual obtenida:', pos);
            },
            (error) => {
                let errorMessage = "Error: No se pudo obtener la ubicación";
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage = "Error: Permiso de geolocalización denegado";
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMessage = "Error: Información de ubicación no disponible";
                        break;
                    case error.TIMEOUT:
                        errorMessage = "Error: Tiempo de espera agotado para obtener ubicación";
                        break;
                }
                alert(errorMessage);
                console.error('Error de geolocalización:', error);
            }
        );
    }

    // Limpiar marcadores de timeline
    function clearTimelineMarkers() {
        // Limpiar marcadores de timeline tradicionales
        timelineMarkers.forEach(marker => {
            if (marker.setMap) marker.setMap(null);
        });
        timelineMarkers = [];

        // Limpiar marcadores de dispositivos actuales
        clearCurrentDeviceMarkers();

        // Limpiar polilíneas progresivas
        clearProgressivePolylines();

        console.log('Marcadores de timeline y polilíneas progresivas limpiados');
    }

    // Buscar ubicación
    function searchLocation() {
        const address = document.getElementById("searchInput").value;
        if (!address) {
            alert("Por favor ingrese una dirección para buscar");
            return;
        }

        if (!geocoder || !mapInstance) {
            alert("Servicios de búsqueda no disponibles");
            return;
        }

        geocoder.geocode({address: address}, (results, status) => {
            if (status === "OK" && results[0]) {
                const location = results[0].geometry.location;
                const lat = location.lat();
                const lng = location.lng();

                // Centrar mapa en el resultado
                mapInstance.setCenter(location);
                mapInstance.setZoom(15);

                // Actualizar campos de coordenadas
                const latField = document.getElementById("latitude");
                const lngField = document.getElementById("longitude");

                if (latField) latField.value = lat.toFixed(6);
                if (lngField) lngField.value = lng.toFixed(6);

                // Agregar marcador en el resultado de búsqueda
                const searchMarker = new google.maps.Marker({
                    position: {lat: lat, lng: lng},
                    map: mapInstance,
                    title: "Resultado de búsqueda",
                    icon: {
                        path: google.maps.SymbolPath.CIRCLE,
                        scale: 8,
                        fillColor: "#FF6B35",
                        fillOpacity: 1,
                        strokeColor: "#ffffff",
                        strokeWeight: 2,
                    },
                    animation: google.maps.Animation.DROP
                });

                // Info window para resultado de búsqueda
                const searchInfo = `
                <div style="font-family: Arial, sans-serif; max-width: 250px;">
                    <h6 style="margin: 0 0 10px 0; color: #333;">🔍 Resultado de Búsqueda</h6>
                    <p style="margin: 5px 0;"><strong>Dirección:</strong> ${results[0].formatted_address}</p>
                    <p style="margin: 5px 0;"><strong>Coordenadas:</strong> ${lat.toFixed(6)}, ${lng.toFixed(6)}</p>
                </div>
            `;

                searchMarker.addListener("click", () => {
                    if (infoWindow) {
                        infoWindow.setContent(searchInfo);
                        infoWindow.open(mapInstance, searchMarker);
                    }
                });

                console.log('Búsqueda exitosa:', results[0].formatted_address);
            } else {
                alert("No se pudo encontrar la ubicación: " + status);
                console.error('Error en búsqueda:', status);
            }
        });
    }

    // Inicializar event listeners
    function initEventListeners() {
        console.log('🎛️ Configurando event listeners...');

        // Controles de timeline
        const playBtn = document.getElementById("playBtn");
        const pauseBtn = document.getElementById("pauseBtn");
        const stopBtn = document.getElementById("stopBtn");

        if (playBtn) {
            playBtn.addEventListener("click", function () {
                console.log('🎬 Botón Play clickeado - llamando playMultiDeviceTimeline');
                playMultiDeviceTimeline();
            });
            console.log('✅ Event listener configurado para botón Play');
        } else {
            console.error('❌ Botón Play no encontrado');
        }

        if (pauseBtn) {
            pauseBtn.addEventListener("click", function () {
                console.log('⏸️ Botón Pause clickeado - llamando pauseMultiDeviceTimeline');
                pauseMultiDeviceTimeline();
            });
            console.log('✅ Event listener configurado para botón Pause');
        } else {
            console.error('❌ Botón Pause no encontrado');
        }

        if (stopBtn) {
            stopBtn.addEventListener("click", function () {
                console.log('⏹️ Botón Stop clickeado - llamando stopMultiDeviceTimeline');
                stopMultiDeviceTimeline();
            });
            console.log('✅ Event listener configurado para botón Stop');
        } else {
            console.error('❌ Botón Stop no encontrado');
        }

        // Control de velocidad
        const speedControl = document.getElementById("speedControl");
        if (speedControl) {
            speedControl.addEventListener("change", (e) => {
                console.log('⚡ Velocidad cambiada a:', e.target.value);
                playbackSpeed = parseFloat(e.target.value);
                // Si está reproduciendo, reiniciar con nueva velocidad
                if (isPlaying && !isPaused) {
                    console.log('🔄 Reiniciando reproducción con nueva velocidad');
                    clearInterval(playbackInterval);
                    const baseInterval = 1000;
                    const interval = baseInterval / playbackSpeed;
                    playbackInterval = setInterval(advanceTimeline, interval);
                }
            });
            console.log('✅ Event listener configurado para control de velocidad');
        }

        // Slider de timeline
        const timelineSlider = document.getElementById("timelineSlider");
        if (timelineSlider) {
            timelineSlider.addEventListener("input", (e) => {
                console.log('🎚️ Slider movido a posición:', e.target.value);
                currentTimeIndex = parseInt(e.target.value);
                updateAllDevicesAtCurrentTime();
                updateTimelineInfo();
            });
            console.log('✅ Event listener configurado para slider de timeline');
        }

        // Búsqueda
        const searchInput = document.getElementById("searchInput");
        const searchBtn = document.getElementById("searchBtn");

        if (searchInput) {
            searchInput.addEventListener("keypress", (e) => {
                if (e.key === "Enter") {
                    searchLocation();
                }
            });
        }

        if (searchBtn) {
            searchBtn.addEventListener("click", searchLocation);
        }
    }

    // Función de debug para verificar estado
    function debugTimelineState() {
        console.log('🔍 DEBUG - Estado del Timeline:');
        console.log('- deviceWaypoints:', deviceWaypoints);
        console.log('- allTimestamps:', allTimestamps);
        console.log('- mapInstance:', mapInstance);
        console.log('- Botones encontrados:', {
            playBtn: !!document.getElementById("playBtn"),
            pauseBtn: !!document.getElementById("pauseBtn"),
            stopBtn: !!document.getElementById("stopBtn")
        });

        // Hacer disponible globalmente para testing manual
        window.debugTimeline = {
            playMultiDeviceTimeline,
            pauseMultiDeviceTimeline,
            stopMultiDeviceTimeline,
            deviceWaypoints,
            allTimestamps,
            mapInstance
        };
    }

    // Inicializar cuando el DOM esté listo
    document.addEventListener("DOMContentLoaded", function () {
        console.log('🚀 DOM cargado, inicializando timeline...');
        debugTimelineState();
        // Esperar un poco para que el mapa de Maps.php se inicialice
        setTimeout(initTimelineAfterMapLoad, 1000);
    });

    // También intentar inicializar cuando la ventana esté completamente cargada
    window.addEventListener('load', function () {
        console.log('🌐 Ventana cargada, verificando mapa...');
        debugTimelineState();
        // Segundo intento de inicialización por si el primer timeout no fue suficiente
        setTimeout(initTimelineAfterMapLoad, 500);
    });
</script>