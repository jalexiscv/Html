<?php
/**
 * API Endpoint para servir datos de telemetría GPS en formato JSON
 * Ruta: /sogt/api/telemetry/json/
 * Método: GET
 * Respuesta: JSON con datos de waypoints GPS
 */

// Headers CORS para permitir acceso desde diferentes dominios
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Manejar preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Solo permitir método GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido. Solo se permite GET.',
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    exit();
}

try {
    // Cargar modelo de telemetría
    $mtelemetry = model("App\Modules\Sogt\Models\Sogt_Telemetry");

    // Obtener todos los datos de telemetría
    $telemetry = $mtelemetry->findAll();

    // Procesar y limpiar datos para JSON
    $waypoints = array();

    if (is_array($telemetry) && !empty($telemetry)) {
        foreach ($telemetry as $record) {
            // Validar que el registro tenga los campos requeridos
            if (isset($record["latitude"]) && isset($record["longitude"])) {
                $waypoint = array(
                    'device' => isset($record['device']) ? (string)$record['device'] : '',
                    'lat' => (float)$record['latitude'],
                    'lng' => (float)$record['longitude'],
                    'alt' => isset($record['altitude']) ? (float)$record['altitude'] : 0,
                    'speed' => isset($record['speed']) ? (float)$record['speed'] : 0,
                    'heading' => isset($record['heading']) ? (float)$record['heading'] : 0,
                    'timestamp' => isset($record['timestamp']) ? (string)$record['timestamp'] : '',
                    'battery' => isset($record['battery']) ? (int)$record['battery'] : 0,
                    'satellites' => isset($record['satellites']) ? (int)$record['satellites'] : 0
                );

                // Solo agregar waypoints con coordenadas válidas
                if ($waypoint['lat'] >= -90 && $waypoint['lat'] <= 90 &&
                    $waypoint['lng'] >= -180 && $waypoint['lng'] <= 180) {
                    $waypoints[] = $waypoint;
                }
            }
        }
    }

    // Ordenar waypoints por timestamp
    usort($waypoints, function ($a, $b) {
        return strtotime($a['timestamp']) - strtotime($b['timestamp']);
    });

    // Respuesta exitosa
    $response = array(
        'success' => true,
        'message' => 'Datos de telemetría obtenidos exitosamente',
        'data' => $waypoints,
        'count' => count($waypoints),
        'timestamp' => date('Y-m-d H:i:s')
    );

    http_response_code(200);
    echo json_encode($response, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    // Error en el servidor
    error_log("Error en API telemetría: " . $e->getMessage());

    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error interno del servidor',
        'error' => $e->getMessage(),
        'timestamp' => date('Y-m-d H:i:s')
    ]);
}
?>
