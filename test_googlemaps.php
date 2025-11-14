<?php
/**
 * Test file for the new Maps library
 *
 * This file demonstrates the new Maps library functionality
 * and can be used to test the GPS timeline integration.
 */

require_once 'app/Libraries/Maps.php';
require_once 'app/Libraries/GoogleMapsExample.php';

use App\Libraries\GoogleMapsExample;
use App\Libraries\Maps;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Maps Library Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .map-container {
            margin: 20px 0;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            background-color: #f8f9fa;
        }

        .test-section {
            margin-bottom: 40px;
        }

        .code-example {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 15px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center my-4">
                <i class="fas fa-map-marked-alt text-primary"></i>
                Google Maps Library Test
            </h1>

            <!-- Basic Map Test -->
            <div class="test-section">
                <h2><i class="fas fa-map"></i> 1. Basic Map Test</h2>
                <p class="text-muted">Simple map with a single marker in New York City.</p>

                <div class="map-container">
                    <?php echo GoogleMapsExample::basicMap(); ?>
                </div>

                <div class="code-example">
                    <small class="text-muted">Code used:</small>
                    <pre><code>$map = new GoogleMaps('basic_map');
$map->setCenter(40.7128, -74.0060)
    ->setZoom(12)
    ->setMapType(GoogleMaps::MAP_TYPE_ROADMAP);
$map->addMarker(40.7128, -74.0060, [
    'title' => 'New York City',
    'color' => GoogleMaps::MARKER_COLOR_BLUE
]);
echo $map->render();</code></pre>
                </div>
            </div>

            <!-- GPS Timeline Test -->
            <div class="test-section">
                <h2><i class="fas fa-route"></i> 2. GPS Timeline Test</h2>
                <p class="text-muted">Simulated GPS timeline with route, start/end markers, and info window.</p>

                <?php
                // Simulated telemetry data for testing
                $testTelemetryData = [
                        [
                                'latitude' => 40.7589,
                                'longitude' => -73.9851,
                                'speed' => 25.5,
                                'altitude' => 45.2,
                                'timestamp' => '2024-01-15 10:00:00',
                                'device_id' => 'GPS_001'
                        ],
                        [
                                'latitude' => 40.7614,
                                'longitude' => -73.9776,
                                'speed' => 30.2,
                                'altitude' => 42.1,
                                'timestamp' => '2024-01-15 10:05:00',
                                'device_id' => 'GPS_001'
                        ],
                        [
                                'latitude' => 40.7505,
                                'longitude' => -73.9934,
                                'speed' => 15.8,
                                'altitude' => 38.7,
                                'timestamp' => '2024-01-15 10:10:00',
                                'device_id' => 'GPS_001'
                        ],
                        [
                                'latitude' => 40.7484,
                                'longitude' => -73.9857,
                                'speed' => 0.0,
                                'altitude' => 35.4,
                                'timestamp' => '2024-01-15 10:15:00',
                                'device_id' => 'GPS_001'
                        ]
                ];
                ?>

                <div class="map-container">
                    <?php echo GoogleMapsExample::gpsTimelineMap($testTelemetryData); ?>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Timeline Data:</strong> This map shows a simulated GPS route with 4 waypoints in Central
                    Park area, NYC.
                    Green marker = Start, Red marker = End, Blue line = Route path.
                </div>
            </div>

            <!-- Advanced Features Test -->
            <div class="test-section">
                <h2><i class="fas fa-cogs"></i> 3. Advanced Features Test</h2>
                <p class="text-muted">Multiple markers, polylines, polygons, and different map types.</p>

                <div class="map-container">
                    <?php echo GoogleMapsExample::advancedFeaturesMap(); ?>
                </div>

                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <strong>Features demonstrated:</strong> Multiple colored markers, connecting polyline, polygon area,
                    hybrid map type.
                </div>
            </div>

            <!-- Geocoding Test -->
            <div class="test-section">
                <h2><i class="fas fa-search-location"></i> 4. Geocoding Test</h2>
                <p class="text-muted">Address to coordinates conversion and reverse geocoding.</p>

                <?php
                $geocodingResult = GoogleMapsExample::geocodingExample();
                ?>

                <div class="row">
                    <div class="col-md-6">
                        <h5>Geocoding Result:</h5>
                        <?php if (isset($geocodingResult['geocoding'])): ?>
                            <div class="alert alert-success">
                                <strong>Address:</strong> 1600 Amphitheatre Parkway, Mountain View, CA<br>
                                <strong>Coordinates:</strong> <?php echo $geocodingResult['geocoding']['lat']; ?>
                                , <?php echo $geocodingResult['geocoding']['lng']; ?><br>
                                <strong>Formatted:</strong> <?php echo $geocodingResult['geocoding']['formatted_address']; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                Geocoding failed. This might be due to API quota limits or network issues.
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <h5>Reverse Geocoding Result:</h5>
                        <?php if (isset($geocodingResult['reverse_geocoding'])): ?>
                            <div class="alert alert-info">
                                <strong>Address:</strong> <?php echo $geocodingResult['reverse_geocoding']['formatted_address']; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                Reverse geocoding not available.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (isset($geocodingResult['map_html'])): ?>
                    <div class="map-container">
                        <?php echo $geocodingResult['map_html']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Usage Instructions -->
            <div class="test-section">
                <h2><i class="fas fa-book"></i> 5. Usage Instructions</h2>
                <div class="card">
                    <div class="card-body">
                        <?php echo GoogleMapsExample::getUsageInstructions(); ?>
                    </div>
                </div>
            </div>

            <!-- API Key Information -->
            <div class="test-section">
                <h2><i class="fas fa-key"></i> 6. API Key Status</h2>
                <div class="alert alert-info">
                    <?php
                    $testMap = new Maps('test');
                    echo '<strong>API Key:</strong> ' . $testMap->getApiKey() . ' (masked for security)';
                    ?>
                    <br>
                    <small class="text-muted">
                        <i class="fas fa-shield-alt"></i>
                        The API key is hardcoded in the library as requested. For production use, consider using
                        environment variables.
                    </small>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Additional JavaScript for timeline functionality can be added here
    console.log('Google Maps Library Test Page Loaded');

    // Check if Google Maps API loaded successfully
    window.addEventListener('load', function () {
        setTimeout(function () {
            if (typeof google !== 'undefined' && google.maps) {
                console.log('✅ Google Maps API loaded successfully');
            } else {
                console.error('❌ Google Maps API failed to load');
            }
        }, 2000);
    });
</script>
</body>
</html>
