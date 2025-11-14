<?php
// Simple test script to check telemetry data for multi-device timeline testing
use Config\Services;

require_once 'vendor/autoload.php';

// Initialize CodeIgniter
$app = Services::codeigniter();
$app->initialize();

// Load the telemetry model
$mtelemetry = model('App\Modules\Sogt\Models\Sogt_Telemetry');

try {
    $telemetry = $mtelemetry->findAll();

    echo "<h2>Telemetry Data Analysis for Multi-Device Timeline</h2>";
    echo "<p><strong>Total records:</strong> " . count($telemetry) . "</p>";

    if (count($telemetry) > 0) {
        // Group by device
        $deviceWaypoints = array();
        foreach ($telemetry as $row) {
            $device = $row["device"];
            if (!isset($deviceWaypoints[$device])) {
                $deviceWaypoints[$device] = array();
            }
            $deviceWaypoints[$device][] = $row;
        }

        echo "<h3>Devices Found:</h3>";
        echo "<ul>";
        foreach ($deviceWaypoints as $device => $waypoints) {
            echo "<li><strong>Device {$device}:</strong> " . count($waypoints) . " records</li>";
        }
        echo "</ul>";

        echo "<h3>Sample Data (First 5 records):</h3>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>Device</th><th>Latitude</th><th>Longitude</th><th>Speed</th><th>Timestamp</th></tr>";

        for ($i = 0; $i < min(5, count($telemetry)); $i++) {
            $row = $telemetry[$i];
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['device']) . "</td>";
            echo "<td>" . htmlspecialchars($row['latitude']) . "</td>";
            echo "<td>" . htmlspecialchars($row['longitude']) . "</td>";
            echo "<td>" . htmlspecialchars($row['speed']) . "</td>";
            echo "<td>" . htmlspecialchars($row['timestamp']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        // Check if we have multiple devices for multi-device testing
        if (count($deviceWaypoints) > 1) {
            echo "<h3>✅ Multi-Device Timeline Ready!</h3>";
            echo "<p>Found " . count($deviceWaypoints) . " different devices. Perfect for testing multi-device timeline functionality.</p>";
        } else {
            echo "<h3>⚠️ Single Device Only</h3>";
            echo "<p>Only one device found. For full multi-device testing, you may want to add sample data for additional devices.</p>";
        }

    } else {
        echo "<h3>❌ No Data Found</h3>";
        echo "<p>No telemetry data in database. Need to add sample data for testing.</p>";

        // Offer to create sample data
        echo "<h3>Sample Data Creation</h3>";
        echo "<p>Would you like to create sample multi-device GPS data for testing?</p>";
    }

} catch (Exception $e) {
    echo "<h3>❌ Error</h3>";
    echo "<p>Error accessing telemetry data: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
