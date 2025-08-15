<?php
/**********************
 *  Configuración
 **********************/
$token = 'ce890746630ebf2c6b7baf4dde8f41b4';
$domain = 'https://campus.utede.edu.co';
$endpoint = "$domain/webservice/rest/server.php";

$functionGetUser = 'core_user_get_users';
$functionEnroll = 'enrol_manual_enrol_users';

$errorInfo = null;
$successMsg = null;

/** @var TYPE_NAME $identification_number */
/** @var TYPE_NAME $course_moodle_id */


$username = $identification_number;
$courseid = (int)$course_moodle_id;
$role = 'student';

$roleidMap = [
    'student' => 5,  // ID por defecto en Moodle para estudiante
    'teacher' => 3   // ID por defecto para profesor
];

// 1. Obtener ID del usuario
$searchParams = http_build_query([
    'criteria' => [['key' => 'username', 'value' => $username]]
]);

$urlGet = "$endpoint?wstoken=$token&wsfunction=$functionGetUser&moodlewsrestformat=json&$searchParams";

$curl = curl_init($urlGet);
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
]);

$response = curl_exec($curl);
curl_close($curl);

$result = json_decode($response, true);

if (!empty($result['users'][0]['id'])) {
    $userid = $result['users'][0]['id'];
    $roleid = $roleidMap[$role];

    // 2. Enrolar usuario en curso
    $enrolParams = http_build_query([
        'enrolments' => [[
            'roleid' => $roleid,
            'userid' => $userid,
            'courseid' => $courseid
        ]]
    ]);

    $urlEnroll = "$endpoint?wstoken=$token&wsfunction=$functionEnroll&moodlewsrestformat=json";

    $curl = curl_init($urlEnroll);
    curl_setopt_array($curl, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => $enrolParams,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
    ]);

    $enrolResponse = curl_exec($curl);
    curl_close($curl);

    $enrolResult = json_decode($enrolResponse, true);

    if (empty($enrolResult)) {
        $console[] = "> --- : Usuario {$username} inscrito en el curso con rol de {$role}.";
    } elseif (isset($enrolResult['exception'])) {
        $console[] = $enrolResult['message'] ?? 'Error al enrolar al usuario.';
    } else {
        $console[] = '> --- : Respuesta inesperada al intentar enrolar al usuario.';
    }
} else {
    $console[] = '> --- : No se encontró un usuario con ese alias.';
}
?>