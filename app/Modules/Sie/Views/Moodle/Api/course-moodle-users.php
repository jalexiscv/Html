<?php

$token = service("moodle")::getToken();
$domain = service("moodle")::getDomainName();
$endpoint = "$domain/webservice/rest/server.php";

$musers = model("App\Modules\Sie\Models\Sie_Users");
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");


$functionGetUser = 'core_user_get_users';
$functionEnroll = 'enrol_manual_enrol_users';
$dteacher = $mfields->get_Profile(@$d["teacher"]);

$errorInfo = null;
$successMsg = null;
$username = $dteacher["citizenshipcard"];
$courseid = @$row["moodle_course"];
$role = "3";

$searchParams = http_build_query(['criteria' => [['key' => 'username', 'value' => $username]]]);
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

echo("<pre>");
echo("<br>El usuario existe? " . var_dump($result));
echo("</pre>");


if (!empty($result['users'][0]['id'])) {
    $userid = $result['users'][0]['id'];
    $roleid = $role;
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
        $successMsg = "Usuario '$username' inscrito en el curso con rol de '$role'.";
    } elseif (isset($enrolResult['exception'])) {
        $errorInfo = $enrolResult['message'] ?? 'Error al enrolar al usuario.';
    } else {
        $errorInfo = 'Respuesta inesperada al intentar enrolar al usuario.';
    }
} else {
    $errorInfo = 'No se encontró un usuario con ese alias.';
}


/**
 *
 *
 *
 * $roleidMap = [
 * 'registration' => 5,  // ID por defecto en Moodle para estudiante
 * 'teacher' => 3   // ID por defecto para profesor
 * ];
 *
 *
 *
 *
 *
 * if (!$username || !$courseid || !isset($roleidMap[$role])) {
 * $errorInfo = 'Debes completar todos los campos correctamente.';
 * } else {
 * // 1. Obtener ID del usuario
 * $searchParams = http_build_query([
 * 'criteria' => [['key' => 'username', 'value' => $username]]
 * ]);
 *
 * $urlGet = "$endpoint?wstoken=$token&wsfunction=$functionGetUser&moodlewsrestformat=json&$searchParams";
 *
 * $curl = curl_init($urlGet);
 * curl_setopt_array($curl, [
 * CURLOPT_RETURNTRANSFER => true,
 * CURLOPT_SSL_VERIFYPEER => false,
 * CURLOPT_SSL_VERIFYHOST => false,
 * ]);
 *
 * $response = curl_exec($curl);
 * curl_close($curl);
 *
 * $result = json_decode($response, true);
 *
 * if (!empty($result['users'][0]['id'])) {
 * $userid = $result['users'][0]['id'];
 * $roleid = $roleidMap[$role];
 *
 * // 2. Enrolar usuario en curso
 * $enrolParams = http_build_query([
 * 'enrolments' => [[
 * 'roleid' => $roleid,
 * 'userid' => $userid,
 * 'courseid' => $courseid
 * ]]
 * ]);
 *
 * $urlEnroll = "$endpoint?wstoken=$token&wsfunction=$functionEnroll&moodlewsrestformat=json";
 *
 * $curl = curl_init($urlEnroll);
 * curl_setopt_array($curl, [
 * CURLOPT_POST => true,
 * CURLOPT_RETURNTRANSFER => true,
 * CURLOPT_POSTFIELDS => $enrolParams,
 * CURLOPT_SSL_VERIFYPEER => false,
 * CURLOPT_SSL_VERIFYHOST => false,
 * ]);
 * $enrolResponse = curl_exec($curl);
 * curl_close($curl);
 * $enrolResult = json_decode($enrolResponse, true);
 * if (empty($enrolResult)) {
 * $successMsg = "Usuario '$username' inscrito en el curso con rol de '$role'.";
 * } elseif (isset($enrolResult['exception'])) {
 * $errorInfo = $enrolResult['message'] ?? 'Error al enrolar al usuario.';
 * } else {
 * $errorInfo = 'Respuesta inesperada al intentar enrolar al usuario.';
 * }
 * } else {
 * $errorInfo = 'No se encontró un usuario con ese alias.';
 * }
 * }
 **/
?>