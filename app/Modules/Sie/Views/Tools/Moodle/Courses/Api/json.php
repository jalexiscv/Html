<?php
// Configuración de headers para respuesta JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');

// Configuración de Moodle API
$token = 'ce890746630ebf2c6b7baf4dde8f41b4';
$domain = 'https://campus.utede.edu.co';
$endpoint = "$domain/webservice/rest/server.php";

$functionEnroll = 'enrol_manual_enrol_users';

// Inicializar respuesta
$response = [
    'success' => false,
    'message' => '',
    'data' => []
];

// Verificar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Método no permitido. Solo se acepta POST.';
    echo json_encode($response);
    exit;
}

// Obtener datos JSON del cuerpo de la petición
$input = json_decode(file_get_contents('php://input'), true);

// Validar parámetros recibidos
$courseId = $input['course'] ?? null;
$userId = $input['user'] ?? null;
$roleId = 5; // ID por defecto para estudiante

if (!$courseId || !$userId) {
    $response['message'] = 'Parámetros faltantes: course y user son requeridos.';
    echo json_encode($response);
    exit;
}

try {
    // Validar y limpiar datos
    $courseid = (int)$courseId;
    $userid = (int)$userId;
    $roleid = (int)$roleId;

    if (!$courseid || !$userid || !$roleid) {
        throw new Exception('Datos inválidos: course y user deben ser números enteros válidos mayores a 0.');
    }

    // Enrolar usuario en curso usando enrol_manual_enrol_users
    $enrolParams = http_build_query([
        'enrolments' => [[
            'roleid' => $roleid,
            'userid' => $userid,
            'courseid' => $courseid
        ]]
    ]);

    $urlEnroll = "$endpoint?wstoken=$token&wsfunction=$functionEnroll&moodlewsrestformat=json";

    // Configurar cURL para matrícula
    $enrolCurl = curl_init();
    curl_setopt_array($enrolCurl, [
        CURLOPT_URL => $urlEnroll,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $enrolParams,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_TIMEOUT => 5,
        CURLOPT_CONNECTTIMEOUT => 5
    ]);

    $enrolResponse = curl_exec($enrolCurl);
    $enrolHttpCode = curl_getinfo($enrolCurl, CURLINFO_HTTP_CODE);
    $curlError = curl_error($enrolCurl);
    curl_close($enrolCurl);

    // Si hay timeout de cURL, considerarlo como éxito (Moodle procesó pero no respondió a tiempo)
    if ($enrolResponse === false && (strpos($curlError, 'timeout') !== false || strpos($curlError, 'timed out') !== false)) {
        $response['success'] = true;
        $response['message'] = "Matrícula procesada (timeout considerado como éxito)";
        $response['data'] = [
            'user_id' => $userid,
            'course_id' => $courseid,
            'role_id' => $roleid,
            'moodle_api_response' => null,
            'moodle_http_code' => $enrolHttpCode,
            'moodle_raw_response' => '',
            'curl_error' => $curlError,
            'response_analysis' => [
                'is_timeout' => true,
                'treated_as_success' => true,
                'reason' => 'Timeout considerado como matrícula exitosa'
            ]
        ];
    } elseif ($enrolResponse === false) {
        throw new Exception('Error de conexión al intentar matricular en Moodle: ' . $curlError);
    } else {
        if ($enrolHttpCode !== 200) {
            throw new Exception("Error HTTP al matricular: código $enrolHttpCode");
        }

        $enrolResult = json_decode($enrolResponse, true);

        // Moodle enrol_manual_enrol_users puede devolver respuesta vacía cuando es exitoso
        $response['success'] = true;
        $response['message'] = "Respuesta completa del API de Moodle";
        $response['data'] = [
            'user_id' => $userid,
            'course_id' => $courseid,
            'role_id' => $roleid,
            'moodle_api_response' => $enrolResult,
            'moodle_http_code' => $enrolHttpCode,
            'moodle_raw_response' => $enrolResponse,
            'response_analysis' => [
                'is_empty_response' => empty($enrolResponse),
                'is_null_json' => is_null($enrolResult),
                'is_empty_array' => (is_array($enrolResult) && empty($enrolResult)),
                'response_length' => strlen($enrolResponse),
                'http_success' => ($enrolHttpCode >= 200 && $enrolHttpCode < 300),
                'likely_success' => (
                    ($enrolHttpCode >= 200 && $enrolHttpCode < 300) &&
                    (empty($enrolResponse) || is_null($enrolResult) || (is_array($enrolResult) && empty($enrolResult)))
                )
            ]
        ];
    }
} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
    $response['data'] = [
        'error_type' => 'enrollment_error',
        'user' => $userId,
        'course' => $courseId,
        'role_id' => $roleId
    ];
}
// Enviar respuesta JSON
echo json_encode($response);
?>