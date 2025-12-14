<?php
header('Content-Type: application/json; charset=utf-8');

/* === CONFIGURA AQUÍ === */
$domainName = service("moodle")::getDomainName();
$token = service("moodle")::getToken();
$endpoint = rtrim($domainName, '/') . '/webservice/rest/server.php';

// Datos de entrada (p.ej., desde POST JSON) — ajusta a tu flujo:
$input = json_decode(file_get_contents('php://input'), true) ?: [];
$shortname = $input['shortname'] ?? 'CURSO_DEMO_001';
$fullname = $input['fullname'] ?? 'Curso de Demostración';
$categoryid = isset($input['categoryid']) ? (int)$input['categoryid'] : 1; // 1 suele ser "Misceláneos"

/* === Helper para llamar al WS REST de Moodle === */
function moodle_call(array $params)
{
    // Parámetros de conexión configurados directamente en la función
    $token = service("moodle")::getToken();
    $domainName = service("moodle")::getDomainName();
    $restFormat = 'json';
    $wsfunction = "core_course_get_courses_by_field";
    $endpoint = rtrim($domainName, '/') . '/webservice/rest/server.php';

    $postFields = array_merge($params, [
        'wstoken' => $token,
        'wsfunction' => $wsfunction,
        'moodlewsrestformat' => $restFormat,
    ]);

    $ch = curl_init($endpoint);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($postFields),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
    ]);

    $raw = curl_exec($ch);
    $err = curl_error($ch);
    $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($raw === false) {
        throw new RuntimeException("Error cURL: $err");
    }
    $data = json_decode($raw, true);
    if ($http >= 400) {
        throw new RuntimeException("HTTP $http: $raw");
    }
    // Moodle devuelve excepciones en JSON con keys 'exception'/'errorcode'/'message'
    if (is_array($data) && isset($data['exception'])) {
        $msg = $data['message'] ?? 'Error Moodle';
        $code = $data['errorcode'] ?? 'unknown';
        throw new RuntimeException("Moodle exception ($code): $msg");
    }
    return $data;
}

try {
    // 1) Buscar por shortname
    $resp = moodle_call(
        ['field' => 'shortname', 'value' => $shortname]
    );

    if (isset($resp['courses']) && is_array($resp['courses']) && count($resp['courses']) > 0) {
        // Existe: devolver el ID del primero que coincida exactamente
        $found = null;
        foreach ($resp['courses'] as $c) {
            if (isset($c['shortname']) && strcasecmp($c['shortname'], $shortname) === 0) {
                $found = $c;
                break;
            }
        }
        if ($found && isset($found['id'])) {
            echo json_encode([
                'status' => 'exists',
                'courseid' => (int)$found['id'],
                'shortname' => $shortname
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    // 2) No existe: crearlo
    $create = moodle_call(
        'core_course_create_courses',
        [
            'courses[0][fullname]' => $fullname,
            'courses[0][shortname]' => $shortname,
            'courses[0][categoryid]' => $categoryid,
            // opcionales:
            // 'courses[0][summary]'    => 'Descripción del curso',
            // 'courses[0][visible]'    => 1,
            // 'courses[0][startdate]'  => time(),
        ]
    );

    // Respuesta típica: array con cursos creados; cada elemento incluye 'id'
    if (is_array($create) && isset($create[0]['id'])) {
        echo json_encode([
            'status' => 'created',
            'courseid' => (int)$create[0]['id'],
            'shortname' => $shortname
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Fallback si el formato fuera distinto
    echo json_encode([
        'status' => 'created',
        'raw' => $create
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}
?>