<?php
// Configuración inicial para la API de Moodle
$token = 'd9551c4aa62771d4a38d74b1e885b13d';
$domainName = 'https://campus.utede.edu.co';
$functionName = 'core_course_delete_courses';
$restFormat = 'json';

$courseDeleted = false;
$errorInfo = null;
/** @var TYPE_NAME $row */

$courseIdToDelete = $row["moodle_course"];


if ($courseIdToDelete) {
    $params = [
        'courseids' => [$courseIdToDelete]
    ];

    $serverUrl = $domainName . '/webservice/rest/server.php'
        . '?wstoken=' . $token
        . '&wsfunction=' . $functionName
        . '&moodlewsrestformat=' . $restFormat
        . '&' . http_build_query($params);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $serverUrl);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, []);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($curl);

    if ($response === false) {
        $errorInfo = ['message' => 'Error en cURL: ' . curl_error($curl)];
    } else {
        $result = json_decode($response, true);
        if (isset($result['exception'])) {
            $errorInfo = [
                'message' => 'Error al eliminar el curso: ' . ($result['message'] ?? 'Error desconocido.'),
                'exception' => $result['exception'] ?? 'N/A',
                'errorcode' => $result['errorcode'] ?? 'N/A',
                'debuginfo' => $result['debuginfo'] ?? 'No debug info'
            ];
        } else {
            $courseDeleted = true;
        }
    }
    curl_close($curl);
} else {
    $errorInfo = ['message' => 'Debe ingresar un ID de curso válido.'];
}

?>