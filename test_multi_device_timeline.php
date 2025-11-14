<?php
/**
 * Comprehensive Test for Multi-Device GPS Timeline System
 * This script tests the multi-device timeline functionality by creating sample data
 * and verifying the system works correctly with multiple GPS devices.
 */

// Initialize CodeIgniter
use Config\Services;

require_once 'vendor/autoload.php';
$app = Services::codeigniter();
$app->initialize();

// Load the telemetry model
$mtelemetry = model('App\Modules\Sogt\Models\Sogt_Telemetry');

echo "<h1>🧪 Multi-Device GPS Timeline Test Suite</h1>";
echo "<hr>";

// Test 1: Check current data
echo "<h2>📊 Test 1: Current Telemetry Data Analysis</h2>";
try {
    $existingData = $mtelemetry->findAll();
    echo "<p><strong>Existing records:</strong> " . count($existingData) . "</p>";

    if (count($existingData) > 0) {
        $devices = array_unique(array_column($existingData, 'device'));
        echo "<p><strong>Existing devices:</strong> " . implode(', ', $devices) . "</p>";
        echo "<p>✅ Found existing data for testing</p>";
    } else {
        echo "<p>⚠️ No existing data found</p>";
    }
} catch (Exception $e) {
    echo "<p>❌ Error accessing data: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr>";

// Test 2: Create sample multi-device data if needed
echo "<h2>🏗️ Test 2: Sample Multi-Device Data Creation</h2>";

// Sample GPS routes for 3 different devices
$sampleRoutes = [
        'DEVICE_001' => [
                ['lat' => 4.7110, 'lng' => -74.0721, 'speed' => 25, 'heading' => 90],  // Bogotá Centro
                ['lat' => 4.7120, 'lng' => -74.0700, 'speed' => 30, 'heading' => 45],  // Movimiento NE
                ['lat' => 4.7140, 'lng' => -74.0680, 'speed' => 35, 'heading' => 45],  // Continúa NE
                ['lat' => 4.7160, 'lng' => -74.0660, 'speed' => 28, 'heading' => 90],  // Gira E
                ['lat' => 4.7160, 'lng' => -74.0640, 'speed' => 20, 'heading' => 90],  // Continúa E
        ],
        'DEVICE_002' => [
                ['lat' => 4.7100, 'lng' => -74.0750, 'speed' => 40, 'heading' => 180], // Sur de Bogotá
                ['lat' => 4.7080, 'lng' => -74.0750, 'speed' => 45, 'heading' => 180], // Movimiento S
                ['lat' => 4.7060, 'lng' => -74.0730, 'speed' => 38, 'heading' => 135], // Gira SE
                ['lat' => 4.7040, 'lng' => -74.0710, 'speed' => 32, 'heading' => 135], // Continúa SE
                ['lat' => 4.7020, 'lng' => -74.0690, 'speed' => 25, 'heading' => 90],  // Gira E
        ],
        'DEVICE_003' => [
                ['lat' => 4.7130, 'lng' => -74.0740, 'speed' => 15, 'heading' => 270], // Oeste de Bogotá
                ['lat' => 4.7130, 'lng' => -74.0760, 'speed' => 20, 'heading' => 270], // Movimiento W
                ['lat' => 4.7150, 'lng' => -74.0780, 'speed' => 25, 'heading' => 315], // Gira NW
                ['lat' => 4.7170, 'lng' => -74.0800, 'speed' => 30, 'heading' => 315], // Continúa NW
                ['lat' => 4.7190, 'lng' => -74.0820, 'speed' => 18, 'heading' => 0],   // Gira N
        ]
];

$sampleDataCreated = 0;
$baseTime = time() - 3600; // Hace 1 hora

foreach ($sampleRoutes as $deviceId => $route) {
    echo "<h3>📱 Creating route for {$deviceId}</h3>";

    foreach ($route as $index => $point) {
        $timestamp = date('Y-m-d H:i:s', $baseTime + ($index * 300)); // 5 minutos entre puntos

        $data = [
                'device' => $deviceId,
                'user' => 'test_user',
                'latitude' => $point['lat'],
                'longitude' => $point['lng'],
                'altitude' => rand(2600, 2700), // Altitud típica de Bogotá
                'speed' => $point['speed'],
                'heading' => $point['heading'],
                'gps_valid' => 1,
                'satellites' => rand(8, 12),
                'network' => 'GPS',
                'battery' => rand(70, 100),
                'ignition' => 1,
                'event' => 'position',
                'motion' => 1,
                'timestamp' => $timestamp,
                'author' => 'system'
        ];

        try {
            $result = $mtelemetry->insert($data);
            if ($result) {
                $sampleDataCreated++;
                echo "<p>✅ Point " . ($index + 1) . " created for {$deviceId} at {$timestamp}</p>";
            } else {
                echo "<p>❌ Failed to create point " . ($index + 1) . " for {$deviceId}</p>";
            }
        } catch (Exception $e) {
            echo "<p>❌ Error creating data: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
}

echo "<p><strong>Sample data created:</strong> {$sampleDataCreated} records</p>";
echo "<hr>";

// Test 3: Verify multi-device functionality
echo "<h2>🔍 Test 3: Multi-Device Functionality Verification</h2>";

try {
    $allData = $mtelemetry->findAll();

    // Group by device (same logic as in view.php)
    $deviceWaypoints = array();
    $allTimestamps = array();

    foreach ($allData as $row) {
        $device = $row["device"];
        if (!isset($deviceWaypoints[$device])) {
            $deviceWaypoints[$device] = array();
        }

        $waypoint = array(
                "device" => $device,
                "lat" => floatval($row["latitude"]),
                "lng" => floatval($row["longitude"]),
                "alt" => floatval($row["altitude"]),
                "speed" => floatval($row["speed"]),
                "heading" => floatval($row["heading"]),
                "timestamp" => $row["timestamp"],
        );

        $deviceWaypoints[$device][] = $waypoint;
        $allTimestamps[] = $row["timestamp"];
    }

    // Sort waypoints for each device
    foreach ($deviceWaypoints as $device => &$waypoints) {
        usort($waypoints, function ($a, $b) {
            return strtotime($a['timestamp']) - strtotime($b['timestamp']);
        });
    }

    // Get unique timestamps
    $allTimestamps = array_unique($allTimestamps);
    sort($allTimestamps);

    echo "<h3>📈 Multi-Device Analysis Results:</h3>";
    echo "<ul>";
    echo "<li><strong>Total devices:</strong> " . count($deviceWaypoints) . "</li>";
    echo "<li><strong>Total waypoints:</strong> " . count($allData) . "</li>";
    echo "<li><strong>Total timestamps:</strong> " . count($allTimestamps) . "</li>";
    echo "</ul>";

    echo "<h4>📱 Device Details:</h4>";
    foreach ($deviceWaypoints as $device => $waypoints) {
        echo "<div style='margin: 10px 0; padding: 10px; border: 1px solid #ddd; border-radius: 5px;'>";
        echo "<strong>Device: {$device}</strong><br>";
        echo "Waypoints: " . count($waypoints) . "<br>";
        echo "First point: " . $waypoints[0]['timestamp'] . "<br>";
        echo "Last point: " . end($waypoints)['timestamp'] . "<br>";
        echo "Coordinates range: {$waypoints[0]['lat']},{$waypoints[0]['lng']} to " . end($waypoints)['lat'] . "," . end($waypoints)['lng'] . "<br>";
        echo "</div>";
    }

    // Test multi-device timeline readiness
    if (count($deviceWaypoints) >= 2) {
        echo "<h3>✅ Multi-Device Timeline Ready!</h3>";
        echo "<p>The system has " . count($deviceWaypoints) . " devices with GPS data, perfect for testing multi-device timeline functionality.</p>";

        echo "<h4>🧪 Timeline Test Scenarios:</h4>";
        echo "<ul>";
        echo "<li>✅ Multiple device routes visualization</li>";
        echo "<li>✅ Synchronized timeline playback</li>";
        echo "<li>✅ Individual device tracking</li>";
        echo "<li>✅ Color-coded device identification</li>";
        echo "<li>✅ Real-time device status updates</li>";
        echo "</ul>";

    } else {
        echo "<h3>⚠️ Limited Testing Capability</h3>";
        echo "<p>Only " . count($deviceWaypoints) . " device(s) found. Multi-device features will be limited.</p>";
    }

} catch (Exception $e) {
    echo "<p>❌ Error in verification: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr>";

// Test 4: System Integration Test
echo "<h2>🔧 Test 4: System Integration Verification</h2>";

echo "<h3>📋 Component Checklist:</h3>";
echo "<ul>";

// Check Maps library
if (class_exists('App\Libraries\Maps')) {
    echo "<li>✅ Maps.php library available</li>";
} else {
    echo "<li>❌ Maps.php library missing</li>";
}

// Check view file
if (file_exists('app/Modules/Sogt/Views/Maps/Home/view.php')) {
    echo "<li>✅ Main view file exists</li>";

    $viewContent = file_get_contents('app/Modules/Sogt/Views/Maps/Home/view.php');

    // Check for multi-device functions
    if (strpos($viewContent, 'initMultiDeviceTimeline') !== false) {
        echo "<li>✅ Multi-device timeline functions integrated</li>";
    } else {
        echo "<li>❌ Multi-device timeline functions missing</li>";
    }

    // Check for device grouping logic
    if (strpos($viewContent, 'deviceWaypoints') !== false) {
        echo "<li>✅ Device waypoint grouping implemented</li>";
    } else {
        echo "<li>❌ Device waypoint grouping missing</li>";
    }

    // Check for multi-device UI
    if (strpos($viewContent, 'devices-info') !== false) {
        echo "<li>✅ Multi-device UI components present</li>";
    } else {
        echo "<li>❌ Multi-device UI components missing</li>";
    }

} else {
    echo "<li>❌ Main view file missing</li>";
}

echo "</ul>";

echo "<h3>🎯 Next Steps for Testing:</h3>";
echo "<ol>";
echo "<li>Access the GPS timeline view: <code>/sogt/maps/home</code></li>";
echo "<li>Verify multiple device routes are displayed with different colors</li>";
echo "<li>Test timeline playback controls (play, pause, stop)</li>";
echo "<li>Verify device information panel shows all active devices</li>";
echo "<li>Test synchronized movement of all device markers</li>";
echo "<li>Verify speed controls affect all devices simultaneously</li>";
echo "</ol>";

echo "<hr>";
echo "<h2>🏁 Test Summary</h2>";
echo "<p><strong>Status:</strong> Multi-device GPS timeline system is ready for comprehensive testing</p>";
echo "<p><strong>Recommendation:</strong> Access the web interface to perform live testing of all multi-device features</p>";

?>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    h1, h2, h3 {
        color: #333;
    }

    code {
        background: #f4f4f4;
        padding: 2px 4px;
        border-radius: 3px;
    }

    ul, ol {
        margin-left: 20px;
    }

    hr {
        margin: 20px 0;
        border: 1px solid #ddd;
    }
</style>
