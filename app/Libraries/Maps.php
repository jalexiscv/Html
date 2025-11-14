<?php

namespace App\Libraries;

use InvalidArgumentException;

/**
 * Google Maps API Library
 *
 * Una librería moderna y completa para interactuar con Google Maps API
 * Implementa todas las características principales de Google Maps con mejores prácticas
 *
 * @package App\Libraries
 * @version 2.0.0
 * @author Sistema GPS Timeline
 */
class Maps
{
    /**
     * Google Maps API Key
     * @var string
     */
    private const GOOGLE_API_KEY = 'AIzaSyAx1vnDnmIX9oZahYHt6oOB7xTadAQAslg';

    /**
     * Google Maps JavaScript API URL
     * @var string
     */
    private const MAPS_API_URL = 'https://maps.googleapis.com/maps/api/js';

    /**
     * Google Maps Geocoding API URL
     * @var string
     */
    private const GEOCODING_API_URL = 'https://maps.googleapis.com/maps/api/geocode/json';

    // Map Type Constants
    public const MAP_TYPE_ROADMAP = 'ROADMAP';
    public const MAP_TYPE_SATELLITE = 'SATELLITE';
    public const MAP_TYPE_HYBRID = 'HYBRID';
    public const MAP_TYPE_TERRAIN = 'TERRAIN';

    // Control Position Constants
    public const CONTROL_POSITION_TOP_LEFT = 'TOP_LEFT';
    public const CONTROL_POSITION_TOP_CENTER = 'TOP_CENTER';
    public const CONTROL_POSITION_TOP_RIGHT = 'TOP_RIGHT';
    public const CONTROL_POSITION_LEFT_TOP = 'LEFT_TOP';
    public const CONTROL_POSITION_LEFT_CENTER = 'LEFT_CENTER';
    public const CONTROL_POSITION_LEFT_BOTTOM = 'LEFT_BOTTOM';
    public const CONTROL_POSITION_RIGHT_TOP = 'RIGHT_TOP';
    public const CONTROL_POSITION_RIGHT_CENTER = 'RIGHT_CENTER';
    public const CONTROL_POSITION_RIGHT_BOTTOM = 'RIGHT_BOTTOM';
    public const CONTROL_POSITION_BOTTOM_LEFT = 'BOTTOM_LEFT';
    public const CONTROL_POSITION_BOTTOM_CENTER = 'BOTTOM_CENTER';
    public const CONTROL_POSITION_BOTTOM_RIGHT = 'BOTTOM_RIGHT';

    // Animation Constants
    public const ANIMATION_BOUNCE = 'BOUNCE';
    public const ANIMATION_DROP = 'DROP';

    // Marker Icon Colors
    public const MARKER_COLOR_RED = 'red';
    public const MARKER_COLOR_GREEN = 'green';
    public const MARKER_COLOR_BLUE = 'blue';
    public const MARKER_COLOR_YELLOW = 'yellow';
    public const MARKER_COLOR_ORANGE = 'orange';
    public const MARKER_COLOR_PURPLE = 'purple';

    /**
     * Map configuration
     * @var array
     */
    private array $config = [
        'id' => '',
        'width' => 800,
        'height' => 600,
        'center' => ['lat' => 4.7110, 'lng' => -74.0721], // Bogotá, Colombia
        'zoom' => 10,
        'mapType' => self::MAP_TYPE_ROADMAP,
        'scrollwheel' => true,
        'draggable' => true,
        'disableDefaultUI' => false,
        'zoomControl' => true,
        'mapTypeControl' => true,
        'streetViewControl' => true,
        'fullscreenControl' => true,
        'gestureHandling' => 'auto'
    ];

    /**
     * Markers collection
     * @var array
     */
    private array $markers = [];

    /**
     * Polylines collection
     * @var array
     */
    private array $polylines = [];

    /**
     * Polygons collection
     * @var array
     */
    private array $polygons = [];

    /**
     * Info Windows collection
     * @var array
     */
    private array $infoWindows = [];

    /**
     * Event listeners
     * @var array
     */
    private array $eventListeners = [];

    /**
     * Additional libraries to load
     * @var array
     */
    private array $libraries = [];

    /**
     * Constructor
     *
     * @param string $mapId Unique identifier for the map
     * @param array $config Optional configuration array
     */
    public function __construct(string $mapId = '', array $config = [])
    {
        $this->config['id'] = $mapId ?: 'map_' . uniqid();
        $this->config = array_merge($this->config, $config);

        $this->validateConfig();
    }

    /**
     * Validate configuration parameters
     *
     * @throws InvalidArgumentException
     */
    private function validateConfig(): void
    {
        if (empty($this->config['id'])) {
            throw new InvalidArgumentException('Map ID cannot be empty');
        }

        if ($this->config['width'] <= 0 || $this->config['height'] <= 0) {
            throw new InvalidArgumentException('Map dimensions must be positive integers');
        }

        if (!is_numeric($this->config['center']['lat']) || !is_numeric($this->config['center']['lng'])) {
            throw new InvalidArgumentException('Map center coordinates must be numeric');
        }

        if ($this->config['zoom'] < 0 || $this->config['zoom'] > 21) {
            throw new InvalidArgumentException('Map zoom level must be between 0 and 21');
        }
    }

    /**
     * Get map configuration
     *
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Set map configuration
     *
     * @param array $config Configuration array
     * @return self
     */
    public function setConfig(array $config): self
    {
        $this->config = array_merge($this->config, $config);
        $this->validateConfig();
        return $this;
    }

    /**
     * Set map center coordinates
     *
     * @param float $lat Latitude
     * @param float $lng Longitude
     * @return self
     */
    public function setCenter(float $lat, float $lng): self
    {
        $this->config['center'] = ['lat' => $lat, 'lng' => $lng];
        return $this;
    }

    /**
     * Set map zoom level
     *
     * @param int $zoom Zoom level (0-21)
     * @return self
     */
    public function setZoom(int $zoom): self
    {
        if ($zoom < 0 || $zoom > 21) {
            throw new InvalidArgumentException('Zoom level must be between 0 and 21');
        }

        $this->config['zoom'] = $zoom;
        return $this;
    }

    /**
     * Set map dimensions
     *
     * @param int $width Width in pixels
     * @param int $height Height in pixels
     * @return self
     */
    public function setSize(int $width, int $height): self
    {
        if ($width <= 0 || $height <= 0) {
            throw new InvalidArgumentException('Dimensions must be positive integers');
        }

        $this->config['width'] = $width;
        $this->config['height'] = $height;
        return $this;
    }

    /**
     * Set map type
     *
     * @param string $mapType Map type constant
     * @return self
     */
    public function setMapType(string $mapType): self
    {
        $validTypes = [self::MAP_TYPE_ROADMAP, self::MAP_TYPE_SATELLITE, self::MAP_TYPE_HYBRID, self::MAP_TYPE_TERRAIN];

        if (!in_array($mapType, $validTypes)) {
            throw new InvalidArgumentException('Invalid map type');
        }

        $this->config['mapType'] = $mapType;
        return $this;
    }

    /**
     * Add a marker to the map
     *
     * @param float $lat Latitude
     * @param float $lng Longitude
     * @param array $options Marker options
     * @return string Marker ID
     */
    public function addMarker(float $lat, float $lng, array $options = []): string
    {
        $markerId = 'marker_' . uniqid();

        $defaultOptions = [
            'title' => '',
            'icon' => null,
            'color' => self::MARKER_COLOR_RED,
            'animation' => null,
            'draggable' => false,
            'clickable' => true,
            'visible' => true,
            'zIndex' => null
        ];

        $this->markers[$markerId] = [
            'id' => $markerId,
            'position' => ['lat' => $lat, 'lng' => $lng],
            'options' => array_merge($defaultOptions, $options)
        ];

        return $markerId;
    }

    /**
     * Remove a marker from the map
     *
     * @param string $markerId Marker ID
     * @return self
     */
    public function removeMarker(string $markerId): self
    {
        unset($this->markers[$markerId]);
        return $this;
    }

    /**
     * Clear all markers
     *
     * @return self
     */
    public function clearMarkers(): self
    {
        $this->markers = [];
        return $this;
    }

    /**
     * Add a polyline to the map
     *
     * @param array $path Array of coordinates [['lat' => x, 'lng' => y], ...]
     * @param array $options Polyline options
     * @return string Polyline ID
     */
    public function addPolyline(array $path, array $options = []): string
    {
        $polylineId = 'polyline_' . uniqid();

        $defaultOptions = [
            'strokeColor' => '#FF0000',
            'strokeOpacity' => 1.0,
            'strokeWeight' => 2,
            'geodesic' => false,
            'clickable' => true,
            'visible' => true,
            'zIndex' => null
        ];

        $this->polylines[$polylineId] = [
            'id' => $polylineId,
            'path' => $path,
            'options' => array_merge($defaultOptions, $options)
        ];

        return $polylineId;
    }

    /**
     * Remove a polyline from the map
     *
     * @param string $polylineId Polyline ID
     * @return self
     */
    public function removePolyline(string $polylineId): self
    {
        unset($this->polylines[$polylineId]);
        return $this;
    }

    /**
     * Clear all polylines
     *
     * @return self
     */
    public function clearPolylines(): self
    {
        $this->polylines = [];
        return $this;
    }

    /**
     * Add a polygon to the map
     *
     * @param array $path Array of coordinates [['lat' => x, 'lng' => y], ...]
     * @param array $options Polygon options
     * @return string Polygon ID
     */
    public function addPolygon(array $path, array $options = []): string
    {
        $polygonId = 'polygon_' . uniqid();

        $defaultOptions = [
            'strokeColor' => '#FF0000',
            'strokeOpacity' => 1.0,
            'strokeWeight' => 2,
            'fillColor' => '#FF0000',
            'fillOpacity' => 0.35,
            'clickable' => true,
            'visible' => true,
            'zIndex' => null
        ];

        $this->polygons[$polygonId] = [
            'id' => $polygonId,
            'path' => $path,
            'options' => array_merge($defaultOptions, $options)
        ];

        return $polygonId;
    }

    /**
     * Remove a polygon from the map
     *
     * @param string $polygonId Polygon ID
     * @return self
     */
    public function removePolygon(string $polygonId): self
    {
        unset($this->polygons[$polygonId]);
        return $this;
    }

    /**
     * Clear all polygons
     *
     * @return self
     */
    public function clearPolygons(): self
    {
        $this->polygons = [];
        return $this;
    }

    /**
     * Add an info window
     *
     * @param string $content HTML content
     * @param float $lat Latitude
     * @param float $lng Longitude
     * @param array $options Info window options
     * @return string Info window ID
     */
    public function addInfoWindow(string $content, float $lat, float $lng, array $options = []): string
    {
        $infoWindowId = 'infowindow_' . uniqid();

        $defaultOptions = [
            'maxWidth' => 300,
            'disableAutoPan' => false,
            'zIndex' => null
        ];

        $this->infoWindows[$infoWindowId] = [
            'id' => $infoWindowId,
            'content' => $content,
            'position' => ['lat' => $lat, 'lng' => $lng],
            'options' => array_merge($defaultOptions, $options)
        ];

        return $infoWindowId;
    }

    /**
     * Add a library to load with the map
     *
     * @param string $library Library name (geometry, places, drawing, etc.)
     * @return self
     */
    public function addLibrary(string $library): self
    {
        if (!in_array($library, $this->libraries)) {
            $this->libraries[] = $library;
        }
        return $this;
    }

    /**
     * Add an event listener
     *
     * @param string $event Event name
     * @param string $callback JavaScript callback function
     * @return self
     */
    public function addEventListener(string $event, string $callback): self
    {
        $this->eventListeners[] = [
            'event' => $event,
            'callback' => $callback
        ];
        return $this;
    }

    /**
     * Geocode an address to coordinates
     *
     * @param string $address Address to geocode
     * @return array|null Coordinates array or null if failed
     */
    public function geocode(string $address): ?array
    {
        $url = self::GEOCODING_API_URL . '?' . http_build_query([
                'address' => $address,
                'key' => self::GOOGLE_API_KEY
            ]);

        $response = $this->makeHttpRequest($url);

        if ($response && isset($response['results'][0])) {
            $location = $response['results'][0]['geometry']['location'];
            return [
                'lat' => $location['lat'],
                'lng' => $location['lng'],
                'formatted_address' => $response['results'][0]['formatted_address']
            ];
        }

        return null;
    }

    /**
     * Make HTTP request
     *
     * @param string $url URL to request
     * @return array|null Response data or null if failed
     */
    private function makeHttpRequest(string $url): ?array
    {
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'user_agent' => 'Maps Library/2.0'
            ]
        ]);

        $response = @file_get_contents($url, false, $context);

        if ($response === false) {
            return null;
        }

        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE || !isset($data['status'])) {
            return null;
        }

        if ($data['status'] !== 'OK') {
            return null;
        }

        return $data;
    }

    /**
     * Reverse geocode coordinates to address
     *
     * @param float $lat Latitude
     * @param float $lng Longitude
     * @return array|null Address information or null if failed
     */
    public function reverseGeocode(float $lat, float $lng): ?array
    {
        $url = self::GEOCODING_API_URL . '?' . http_build_query([
                'latlng' => $lat . ',' . $lng,
                'key' => self::GOOGLE_API_KEY
            ]);

        $response = $this->makeHttpRequest($url);

        if ($response && isset($response['results'][0])) {
            return [
                'formatted_address' => $response['results'][0]['formatted_address'],
                'address_components' => $response['results'][0]['address_components']
            ];
        }

        return null;
    }

    /**
     * Get map ID
     *
     * @return string Map ID
     */
    public function getId(): string
    {
        return $this->config['id'];
    }

    /**
     * Get API key (for debugging purposes only)
     *
     * @return string Masked API key
     */
    public function getApiKey(): string
    {
        return substr(self::GOOGLE_API_KEY, 0, 10) . '...';
    }

    /**
     * Magic method to render map as string
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * Render complete map HTML with scripts
     *
     * @return string Complete HTML output
     */
    public function render(): string
    {
        $html = $this->getMapContainer() . "\n";
        $html .= $this->getApiScript() . "\n";
        $html .= "<script>\n" . $this->getInitScript() . "</script>\n";

        return $html;
    }

    /**
     * Generate the map HTML container
     *
     * @return string HTML div element
     */
    public function getMapContainer(): string
    {
        $style = sprintf(
            'width: %dpx; height: %dpx; border: 1px solid #ccc;',
            $this->config['width'],
            $this->config['height']
        );

        return sprintf(
            '<div id="%s" style="%s"></div>',
            htmlspecialchars($this->config['id']),
            $style
        );
    }

    /**
     * Generate the Google Maps API script tag
     *
     * @return string Script tag
     */
    public function getApiScript(): string
    {
        $params = [
            'key' => self::GOOGLE_API_KEY,
            'callback' => 'initMap_' . $this->config['id']
        ];

        if (!empty($this->libraries)) {
            $params['libraries'] = implode(',', $this->libraries);
        }

        $url = self::MAPS_API_URL . '?' . http_build_query($params);

        return sprintf(
            '<script async defer src="%s"></script>',
            htmlspecialchars($url)
        );
    }

    /**
     * Generate the JavaScript initialization code
     *
     * @return string JavaScript code
     */
    public function getInitScript(): string
    {
        $mapId = $this->config['id'];
        $mapVar = 'map_' . $mapId;

        $js = "// Google Maps Initialization for {$mapId}\n";
        $js .= "let {$mapVar};\n";
        $js .= "let markers_{$mapId} = [];\n";
        $js .= "let polylines_{$mapId} = [];\n";
        $js .= "let polygons_{$mapId} = [];\n";
        $js .= "let infoWindows_{$mapId} = [];\n\n";

        $js .= "function initMap_{$mapId}() {\n";
        $js .= "    if (typeof google === 'undefined' || !google.maps) {\n";
        $js .= "        console.error('Google Maps API not loaded');\n";
        $js .= "        return;\n";
        $js .= "    }\n\n";

        // Map initialization
        $js .= "    const mapOptions = {\n";
        $js .= "        center: { lat: {$this->config['center']['lat']}, lng: {$this->config['center']['lng']} },\n";
        $js .= "        zoom: {$this->config['zoom']},\n";
        $js .= "        mapTypeId: google.maps.MapTypeId.{$this->config['mapType']},\n";
        $js .= "        scrollwheel: " . ($this->config['scrollwheel'] ? 'true' : 'false') . ",\n";
        $js .= "        draggable: " . ($this->config['draggable'] ? 'true' : 'false') . ",\n";
        $js .= "        disableDefaultUI: " . ($this->config['disableDefaultUI'] ? 'true' : 'false') . ",\n";
        $js .= "        zoomControl: " . ($this->config['zoomControl'] ? 'true' : 'false') . ",\n";
        $js .= "        mapTypeControl: " . ($this->config['mapTypeControl'] ? 'true' : 'false') . ",\n";
        $js .= "        streetViewControl: " . ($this->config['streetViewControl'] ? 'true' : 'false') . ",\n";
        $js .= "        fullscreenControl: " . ($this->config['fullscreenControl'] ? 'true' : 'false') . ",\n";
        $js .= "        gestureHandling: '{$this->config['gestureHandling']}'\n";
        $js .= "    };\n\n";

        $js .= "    {$mapVar} = new google.maps.Map(document.getElementById('{$mapId}'), mapOptions);\n\n";

        // Add markers
        foreach ($this->markers as $marker) {
            $js .= $this->generateMarkerJS($marker, $mapVar, $mapId);
        }

        // Add polylines
        foreach ($this->polylines as $polyline) {
            $js .= $this->generatePolylineJS($polyline, $mapVar, $mapId);
        }

        // Add polygons
        foreach ($this->polygons as $polygon) {
            $js .= $this->generatePolygonJS($polygon, $mapVar, $mapId);
        }

        // Add info windows
        foreach ($this->infoWindows as $infoWindow) {
            $js .= $this->generateInfoWindowJS($infoWindow, $mapVar, $mapId);
        }

        // Add event listeners
        foreach ($this->eventListeners as $listener) {
            $js .= "    {$mapVar}.addListener('{$listener['event']}', {$listener['callback']});\n";
        }

        $js .= "}\n\n";

        // Expose map variable globally for external access
        $js .= "window.{$mapVar} = null;\n";
        $js .= "window.addEventListener('load', function() {\n";
        $js .= "    if (typeof initMap_{$mapId} === 'function') {\n";
        $js .= "        initMap_{$mapId}();\n";
        $js .= "        window.{$mapVar} = {$mapVar};\n";
        $js .= "    }\n";
        $js .= "});\n";

        return $js;
    }

    /**
     * Generate JavaScript code for a marker
     *
     * @param array $marker Marker data
     * @param string $mapVar Map variable name
     * @param string $mapId Map ID
     * @return string JavaScript code
     */
    private function generateMarkerJS(array $marker, string $mapVar, string $mapId): string
    {
        $js = "    // Marker: {$marker['id']}\n";
        $js .= "    const {$marker['id']} = new google.maps.Marker({\n";
        $js .= "        position: { lat: {$marker['position']['lat']}, lng: {$marker['position']['lng']} },\n";
        $js .= "        map: {$mapVar}";

        if (!empty($marker['options']['title'])) {
            $js .= ",\n        title: '" . addslashes($marker['options']['title']) . "'";
        }

        if ($marker['options']['icon']) {
            $js .= ",\n        icon: '" . addslashes($marker['options']['icon']) . "'";
        } elseif ($marker['options']['color'] !== self::MARKER_COLOR_RED) {
            $iconUrl = "https://maps.google.com/mapfiles/ms/icons/{$marker['options']['color']}-dot.png";
            $js .= ",\n        icon: '{$iconUrl}'";
        }

        if ($marker['options']['animation']) {
            $js .= ",\n        animation: google.maps.Animation.{$marker['options']['animation']}";
        }

        $js .= ",\n        draggable: " . ($marker['options']['draggable'] ? 'true' : 'false');
        $js .= ",\n        clickable: " . ($marker['options']['clickable'] ? 'true' : 'false');
        $js .= ",\n        visible: " . ($marker['options']['visible'] ? 'true' : 'false');

        if ($marker['options']['zIndex'] !== null) {
            $js .= ",\n        zIndex: {$marker['options']['zIndex']}";
        }

        $js .= "\n    });\n";
        $js .= "    markers_{$mapId}.push({$marker['id']});\n\n";

        return $js;
    }

    /**
     * Generate JavaScript code for a polyline
     *
     * @param array $polyline Polyline data
     * @param string $mapVar Map variable name
     * @param string $mapId Map ID
     * @return string JavaScript code
     */
    private function generatePolylineJS(array $polyline, string $mapVar, string $mapId): string
    {
        $pathJS = '[';
        foreach ($polyline['path'] as $point) {
            $pathJS .= "{ lat: {$point['lat']}, lng: {$point['lng']} }, ";
        }
        $pathJS = rtrim($pathJS, ', ') . ']';

        $js = "    // Polyline: {$polyline['id']}\n";
        $js .= "    const {$polyline['id']} = new google.maps.Polyline({\n";
        $js .= "        path: {$pathJS},\n";
        $js .= "        geodesic: " . ($polyline['options']['geodesic'] ? 'true' : 'false') . ",\n";
        $js .= "        strokeColor: '{$polyline['options']['strokeColor']}',\n";
        $js .= "        strokeOpacity: {$polyline['options']['strokeOpacity']},\n";
        $js .= "        strokeWeight: {$polyline['options']['strokeWeight']},\n";
        $js .= "        clickable: " . ($polyline['options']['clickable'] ? 'true' : 'false') . ",\n";
        $js .= "        visible: " . ($polyline['options']['visible'] ? 'true' : 'false');

        if ($polyline['options']['zIndex'] !== null) {
            $js .= ",\n        zIndex: {$polyline['options']['zIndex']}";
        }

        $js .= "\n    });\n";
        $js .= "    {$polyline['id']}.setMap({$mapVar});\n";
        $js .= "    polylines_{$mapId}.push({$polyline['id']});\n\n";

        return $js;
    }

    /**
     * Generate JavaScript code for a polygon
     *
     * @param array $polygon Polygon data
     * @param string $mapVar Map variable name
     * @param string $mapId Map ID
     * @return string JavaScript code
     */
    private function generatePolygonJS(array $polygon, string $mapVar, string $mapId): string
    {
        $pathJS = '[';
        foreach ($polygon['path'] as $point) {
            $pathJS .= "{ lat: {$point['lat']}, lng: {$point['lng']} }, ";
        }
        $pathJS = rtrim($pathJS, ', ') . ']';

        $js = "    // Polygon: {$polygon['id']}\n";
        $js .= "    const {$polygon['id']} = new google.maps.Polygon({\n";
        $js .= "        paths: {$pathJS},\n";
        $js .= "        strokeColor: '{$polygon['options']['strokeColor']}',\n";
        $js .= "        strokeOpacity: {$polygon['options']['strokeOpacity']},\n";
        $js .= "        strokeWeight: {$polygon['options']['strokeWeight']},\n";
        $js .= "        fillColor: '{$polygon['options']['fillColor']}',\n";
        $js .= "        fillOpacity: {$polygon['options']['fillOpacity']},\n";
        $js .= "        clickable: " . ($polygon['options']['clickable'] ? 'true' : 'false') . ",\n";
        $js .= "        visible: " . ($polygon['options']['visible'] ? 'true' : 'false');

        if ($polygon['options']['zIndex'] !== null) {
            $js .= ",\n        zIndex: {$polygon['options']['zIndex']}";
        }

        $js .= "\n    });\n";
        $js .= "    {$polygon['id']}.setMap({$mapVar});\n";
        $js .= "    polygons_{$mapId}.push({$polygon['id']});\n\n";

        return $js;
    }

    /**
     * Generate JavaScript code for an info window
     *
     * @param array $infoWindow Info window data
     * @param string $mapVar Map variable name
     * @param string $mapId Map ID
     * @return string JavaScript code
     */
    private function generateInfoWindowJS(array $infoWindow, string $mapVar, string $mapId): string
    {
        $js = "    // Info Window: {$infoWindow['id']}\n";
        $js .= "    const {$infoWindow['id']} = new google.maps.InfoWindow({\n";
        $js .= "        content: '" . addslashes($infoWindow['content']) . "',\n";
        $js .= "        position: { lat: {$infoWindow['position']['lat']}, lng: {$infoWindow['position']['lng']} },\n";
        $js .= "        maxWidth: {$infoWindow['options']['maxWidth']},\n";
        $js .= "        disableAutoPan: " . ($infoWindow['options']['disableAutoPan'] ? 'true' : 'false');

        if ($infoWindow['options']['zIndex'] !== null) {
            $js .= ",\n        zIndex: {$infoWindow['options']['zIndex']}";
        }

        $js .= "\n    });\n";
        $js .= "    infoWindows_{$mapId}.push({$infoWindow['id']});\n\n";

        return $js;
    }
}
