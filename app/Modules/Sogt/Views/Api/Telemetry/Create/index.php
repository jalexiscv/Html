<?php
// Receptor del API para Telemetría
/**
 * API Endpoint para recibir datos de telemetría GPS
 *
 * Ejemplo de uso:
 * POST https://intranet.pynpass.com/sogt/api/telemetry/json/create/a1b2c3d4e5f6g7h8
 *
 * JSON Payload:
 * {
 *   "device": "a1b2c3d4e5f6g7h8",
 *   "latitude": -12.046374,
 *   "longitude": -77.042793,
 *   "altitude": 154.0,
 *   "speed": 2.5,
 *   "heading": 45.0,
 *   "gps_valid": true,
 *   "satellites": 8,
 *   "network": "4G LTE",
 *   "battery": 85,
 *   "ignition": false,
 *   "event": "location_update",
 *   "motion": true,
 *   "timestamp": 1703123456789
 * }
 */

// Configurar headers para API JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Manejar preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Función para enviar respuesta JSON
function sendJsonResponse($success, $message, $data = null, $httpCode = 200)
{
    http_response_code($httpCode);
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data,
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    exit();
}

try {
    // Verificar que sea método POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        //sendJsonResponse(false, 'Método no permitido. Use POST.', null, 405);
    }

    // Obtener el device ID desde la URL (parámetro $oid)
    $deviceId = isset($oid) ? $oid : '';
    if (empty($deviceId)) {
        sendJsonResponse(false, 'Device ID requerido en la URL.', null, 400);
    }

    // Leer datos JSON del cuerpo de la petición
    $jsonInput = file_get_contents('php://input');
    if (empty($jsonInput)) {
        sendJsonResponse(false, 'No se recibieron datos JSON.', null, 400);
    }

    // Decodificar JSON
    $jsonData = json_decode($jsonInput, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        sendJsonResponse(false, 'JSON inválido: ' . json_last_error_msg(), null, 400);
    }

    // Validar campos requeridos
    $requiredFields = ['device', 'latitude', 'longitude'];
    foreach ($requiredFields as $field) {
        if (!isset($jsonData[$field]) || $jsonData[$field] === '') {
            sendJsonResponse(false, "Campo requerido faltante: {$field}", null, 400);
        }
    }

    // Verificar que el device del JSON coincida con el de la URL
    if ($jsonData['device'] !== $deviceId) {
        sendJsonResponse(false, 'Device ID en URL no coincide con el del JSON.', null, 400);
    }

    // Generar ID único para la telemetría
    $telemetryId = uniqid();

    // Procesar y validar datos
    $telemetryData = [
        'telemetry' => $telemetryId,
        'device' => $jsonData['device'],
        'user' => $jsonData['user'] ?? 'api_user',
        'latitude' => (float)$jsonData['latitude'],
        'longitude' => (float)$jsonData['longitude'],
        'altitude' => isset($jsonData['altitude']) ? (float)$jsonData['altitude'] : 0.0,
        'speed' => isset($jsonData['speed']) ? (float)$jsonData['speed'] : 0.0,
        'heading' => isset($jsonData['heading']) ? (float)$jsonData['heading'] : 0.0,
        'gps_valid' => isset($jsonData['gps_valid']) ? ($jsonData['gps_valid'] ? 1 : 0) : 1,
        'satellites' => isset($jsonData['satellites']) ? (int)$jsonData['satellites'] : 0,
        'network' => $jsonData['network'] ?? 'Unknown',
        'battery' => isset($jsonData['battery']) ? (int)$jsonData['battery'] : 0,
        'ignition' => isset($jsonData['ignition']) ? ($jsonData['ignition'] ? 1 : 0) : 0,
        'event' => $jsonData['event'] ?? 'location_update',
        'motion' => isset($jsonData['motion']) ? ($jsonData['motion'] ? 1 : 0) : 0,
        'timestamp' => time(),
        'author' => 'AUTOMATIC',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];

    // Validaciones adicionales
    if (abs($telemetryData['latitude']) > 90) {
        sendJsonResponse(false, 'Latitud inválida. Debe estar entre -90 y 90.', null, 400);
    }

    if (abs($telemetryData['longitude']) > 180) {
        sendJsonResponse(false, 'Longitud inválida. Debe estar entre -180 y 180.', null, 400);
    }

    if ($telemetryData['battery'] < 0 || $telemetryData['battery'] > 100) {
        sendJsonResponse(false, 'Batería inválida. Debe estar entre 0 y 100.', null, 400);
    }

    // Cargar modelo y guardar datos
    $mtelemetry = model('App\\Modules\\Sogt\\Models\\Sogt_Telemetry');
    $insertResult = $mtelemetry->insert($telemetryData);


    // Respuesta exitosa
    sendJsonResponse(true, 'Datos de telemetría guardados exitosamente.', [
        'telemetry_id' => $telemetryId,
        'device' => $telemetryData['device'],
        'coordinates' => [
            'latitude' => $telemetryData['latitude'],
            'longitude' => $telemetryData['longitude'],
            'altitude' => $telemetryData['altitude']
        ],
        'received_at' => $telemetryData['created_at']
    ], 201);


} catch (Exception $e) {
    // Log del error (opcional)
    error_log("API Telemetry Error: " . $e->getMessage());

    // Respuesta de error
    sendJsonResponse(false, 'Error interno del servidor: ' . $e->getMessage(), null, 500);
}
?>
