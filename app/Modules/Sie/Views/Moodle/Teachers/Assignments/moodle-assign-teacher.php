<?php
/** @var string $code */
/** @var array $d */
/** @var string $moodle_course */
/** @var string $moodle_teacher */

$courseid = $moodle_course;
$token = service("moodle")::getToken();
$domain = service("moodle")::getDomainName();
$restFormat = 'json';

// 1. Obtener ID del usuario (profesor)
$function_get_user = 'core_user_get_users_by_field';
$url_get_user = "{$domain}/webservice/rest/server.php?wstoken={$token}&wsfunction={$function_get_user}&moodlewsrestformat={$restFormat}";
$params_get_user = http_build_query(['field' => 'username', 'values[0]' => $moodle_teacher]);

$curl = curl_init($url_get_user . '&' . $params_get_user);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);

$result = json_decode($response, true);

if (empty($result[0]['id'])) {
    $code .= "Error: No se encontró el profesor con username {$moodle_teacher}";
    return;
}

$userid = $result[0]['id'];

// 2. Asignar profesor al curso
$function_enroll = 'enrol_manual_enrol_users';
$url_enroll = "{$domain}/webservice/rest/server.php?wstoken={$token}&wsfunction={$function_enroll}&moodlewsrestformat={$restFormat}";

$enrol_params = http_build_query([
    'enrolments[0][roleid]' => 3,
    'enrolments[0][userid]' => $userid,
    'enrolments[0][courseid]' => $courseid
]);

$curl = curl_init($url_enroll);
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $enrol_params
]);

$enrol_response = curl_exec($curl);
$enrol_result = json_decode($enrol_response, true);
curl_close($curl);

if (empty($enrol_result)) {
    $code .= "Profesor asignado exitosamente al curso {$courseid}";
} else {
    $code .= "Error al asignar profesor: " . json_encode($enrol_result);
}
?>