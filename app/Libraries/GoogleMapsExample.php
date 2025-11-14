<?php

namespace App\Libraries;

/**
 * Google Maps Library Usage Example
 *
 * This file demonstrates how to use the new Maps library
 * with various features like markers, polylines, polygons, and geocoding.
 */
class GoogleMapsExample
{
    /**
     * Basic map example
     */
    public static function basicMap(): string
    {
        $map = new Maps('basic_map');

        // Configure map
        $map->setCenter(40.7128, -74.0060) // New York City
        ->setZoom(12)
            ->setMapType(Maps::MAP_TYPE_ROADMAP);

        // Add a marker
        $map->addMarker(40.7128, -74.0060, [
            'title' => 'New York City',
            'color' => Maps::MARKER_COLOR_BLUE
        ]);

        return $map->render();
    }

    /**
     * GPS Timeline map example (similar to the Sogt module)
     */
    public static function gpsTimelineMap(array $telemetryData): string
    {
        $map = new Maps('gps_timeline_map', [
            'width' => 800,
            'height' => 600,
            'zoom' => 15
        ]);

        if (!empty($telemetryData)) {
            // Set center to first GPS point
            $firstPoint = $telemetryData[0];
            $map->setCenter($firstPoint['latitude'], $firstPoint['longitude']);

            // Create polyline path for the route
            $routePath = [];
            foreach ($telemetryData as $point) {
                $routePath[] = [
                    'lat' => (float)$point['latitude'],
                    'lng' => (float)$point['longitude']
                ];
            }

            // Add route polyline
            $map->addPolyline($routePath, [
                'strokeColor' => '#FF0000',
                'strokeWeight' => 3,
                'strokeOpacity' => 0.8
            ]);

            // Add start marker
            $startPoint = $telemetryData[0];
            $map->addMarker($startPoint['latitude'], $startPoint['longitude'], [
                'title' => 'Start: ' . $startPoint['timestamp'],
                'color' => Maps::MARKER_COLOR_GREEN,
                'animation' => Maps::ANIMATION_DROP
            ]);

            // Add end marker
            $endPoint = end($telemetryData);
            $map->addMarker($endPoint['latitude'], $endPoint['longitude'], [
                'title' => 'End: ' . $endPoint['timestamp'],
                'color' => Maps::MARKER_COLOR_RED,
                'animation' => Maps::ANIMATION_BOUNCE
            ]);

            // Add info window for current position
            $currentPoint = $telemetryData[0];
            $infoContent = sprintf(
                '<div><strong>Device:</strong> %s<br>' .
                '<strong>Speed:</strong> %.2f km/h<br>' .
                '<strong>Altitude:</strong> %.2f m<br>' .
                '<strong>Time:</strong> %s</div>',
                $currentPoint['device_id'] ?? 'Unknown',
                $currentPoint['speed'] ?? 0,
                $currentPoint['altitude'] ?? 0,
                $currentPoint['timestamp'] ?? 'Unknown'
            );

            $map->addInfoWindow($currentPoint['latitude'], $currentPoint['longitude'], $infoContent);
        }

        // Add event listeners for timeline functionality
        $map->addEventListener('click', 'function(event) { 
            console.log("Map clicked at:", event.latLng.lat(), event.latLng.lng()); 
        }');

        return $map->render();
    }

    /**
     * Advanced features example
     */
    public static function advancedFeaturesMap(): string
    {
        $map = new Maps('advanced_map', [
            'width' => 1000,
            'height' => 700,
            'zoom' => 10,
            'mapType' => Maps::MAP_TYPE_HYBRID
        ]);

        // Set center to San Francisco
        $map->setCenter(37.7749, -122.4194);

        // Load additional libraries
        $map->loadLibrary('geometry')
            ->loadLibrary('places');

        // Add multiple markers with different colors
        $locations = [
            ['lat' => 37.7749, 'lng' => -122.4194, 'title' => 'San Francisco', 'color' => Maps::MARKER_COLOR_RED],
            ['lat' => 37.8044, 'lng' => -122.2711, 'title' => 'Oakland', 'color' => Maps::MARKER_COLOR_BLUE],
            ['lat' => 37.6879, 'lng' => -122.4702, 'title' => 'San Mateo', 'color' => Maps::MARKER_COLOR_GREEN],
            ['lat' => 37.4419, 'lng' => -122.1430, 'title' => 'Palo Alto', 'color' => Maps::MARKER_COLOR_YELLOW]
        ];

        foreach ($locations as $location) {
            $map->addMarker($location['lat'], $location['lng'], [
                'title' => $location['title'],
                'color' => $location['color'],
                'animation' => Maps::ANIMATION_DROP
            ]);
        }

        // Add a polygon area
        $polygonPath = [
            ['lat' => 37.7849, 'lng' => -122.4294],
            ['lat' => 37.7849, 'lng' => -122.4094],
            ['lat' => 37.7649, 'lng' => -122.4094],
            ['lat' => 37.7649, 'lng' => -122.4294]
        ];

        $map->addPolygon($polygonPath, [
            'strokeColor' => '#FF0000',
            'strokeOpacity' => 0.8,
            'strokeWeight' => 2,
            'fillColor' => '#FF0000',
            'fillOpacity' => 0.35
        ]);

        // Add polyline connecting the markers
        $polylinePath = array_map(function ($loc) {
            return ['lat' => $loc['lat'], 'lng' => $loc['lng']];
        }, $locations);

        $map->addPolyline($polylinePath, [
            'strokeColor' => '#0000FF',
            'strokeOpacity' => 1.0,
            'strokeWeight' => 2,
            'geodesic' => true
        ]);

        return $map->render();
    }

    /**
     * Geocoding example
     */
    public static function geocodingExample(): array
    {
        $map = new Maps('geocoding_map');

        // Geocode an address
        $address = "1600 Amphitheatre Parkway, Mountain View, CA";
        $coordinates = $map->geocode($address);

        $result = ['geocoding' => $coordinates];

        if ($coordinates) {
            // Reverse geocode the coordinates
            $reverseResult = $map->reverseGeocode($coordinates['lat'], $coordinates['lng']);
            $result['reverse_geocoding'] = $reverseResult;

            // Create map with the geocoded location
            $map->setCenter($coordinates['lat'], $coordinates['lng'])
                ->setZoom(15);

            $map->addMarker($coordinates['lat'], $coordinates['lng'], [
                'title' => $coordinates['formatted_address'],
                'color' => Maps::MARKER_COLOR_BLUE
            ]);

            $result['map_html'] = $map->render();
        }

        return $result;
    }

    /**
     * Get usage instructions
     */
    public static function getUsageInstructions(): string
    {
        return "
        <h2>Google Maps Library Usage Instructions</h2>
        
        <h3>1. Basic Usage</h3>
        <pre><code>
        \$map = new Maps('my_map');
        \$map->setCenter(40.7128, -74.0060)
            ->setZoom(12)
            ->addMarker(40.7128, -74.0060, ['title' => 'New York']);
        echo \$map->render();
        </code></pre>
        
        <h3>2. GPS Timeline Integration</h3>
        <pre><code>
        // In your controller
        \$telemetryData = \$this->sogtTelemetryModel->getTelemetryData();
        \$mapHtml = GoogleMapsExample::gpsTimelineMap(\$telemetryData);
        
        // In your view
        echo \$mapHtml;
        </code></pre>
        
        <h3>3. Available Methods</h3>
        <ul>
            <li><strong>setCenter(\$lat, \$lng)</strong> - Set map center</li>
            <li><strong>setZoom(\$level)</strong> - Set zoom level (1-20)</li>
            <li><strong>setMapType(\$type)</strong> - Set map type (ROADMAP, SATELLITE, HYBRID, TERRAIN)</li>
            <li><strong>addMarker(\$lat, \$lng, \$options)</strong> - Add marker</li>
            <li><strong>addPolyline(\$path, \$options)</strong> - Add polyline</li>
            <li><strong>addPolygon(\$path, \$options)</strong> - Add polygon</li>
            <li><strong>addInfoWindow(\$lat, \$lng, \$content)</strong> - Add info window</li>
            <li><strong>geocode(\$address)</strong> - Convert address to coordinates</li>
            <li><strong>reverseGeocode(\$lat, \$lng)</strong> - Convert coordinates to address</li>
            <li><strong>addEventListener(\$event, \$callback)</strong> - Add event listener</li>
            <li><strong>loadLibrary(\$library)</strong> - Load additional Google Maps libraries</li>
        </ul>
        
        <h3>4. Configuration Options</h3>
        <pre><code>
        \$config = [
            'width' => 800,
            'height' => 600,
            'zoom' => 12,
            'mapType' => Maps::MAP_TYPE_ROADMAP,
            'scrollwheel' => true,
            'draggable' => true,
            'zoomControl' => true,
            'mapTypeControl' => true,
            'streetViewControl' => true,
            'fullscreenControl' => true
        ];
        \$map = new Maps('my_map', \$config);
        </code></pre>
        ";
    }
}
