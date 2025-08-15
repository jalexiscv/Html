<?php
header('Content-Type: application/json; charset=utf-8');

/* === CONFIGURA AQUÍ === */
$domainName = 'https://campus.utede.edu.co';
$token = 'ce890746630ebf2c6b7baf4dde8f41b4';
$endpoint = rtrim($domainName, '/') . '/webservice/rest/server.php';


$course = moodle_get_course("685C25E197397");
if ($course) {
    echo("El curso existe");
    echo("<pre>");
    print_r($course);
    echo("</pre>");
} else {
    echo("No existe el curso");
}


function moodle_get_course(string $shortname)
{
    // Parámetros de conexión configurados directamente en la función
    $token = 'ce890746630ebf2c6b7baf4dde8f41b4';
    $domainName = 'https://campus.utede.edu.co';
    $restFormat = 'json';
    $wsfunction = "core_course_get_courses_by_field";
    $endpoint = rtrim($domainName, '/') . '/webservice/rest/server.php';

    $postFields = [
        'wstoken' => $token,
        'wsfunction' => $wsfunction,
        'moodlewsrestformat' => $restFormat,
        'field' => 'shortname',
        'value' => $shortname
    ];

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

    // Buscar el curso que coincida exactamente con el shortname
    if (isset($data['courses']) && is_array($data['courses']) && count($data['courses']) > 0) {
        foreach ($data['courses'] as $course) {
            if (isset($course['shortname']) && strcasecmp($course['shortname'], $shortname) === 0) {
                return isset($course['id']) ? (int)$course['id'] : null;
            }
        }
    }

    // No se encontró el curso
    return (false);
}


?>