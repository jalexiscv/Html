<?php

$musers = model("App\Modules\Sie\Models\Sie_Users");
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");

/** @var TYPE_NAME $row */
/** @var array $d */

$token = 'ce890746630ebf2c6b7baf4dde8f41b4';
$domain = 'https://campus.utede.edu.co';
$restFormat = 'json';

// El ID del profesor anterior se encuentra en $row['teacher'] (datos antes de la actualización)
$old_teacher_id = @$row["teacher"];
$new_teacher_id = @$d['teacher'];

// Solo proceder si el profesor ha cambiado y había uno asignado previamente
if (empty($old_teacher_id) || $old_teacher_id == $new_teacher_id) {
    return;
}

$dteacher = $mfields->get_Profile($old_teacher_id);
$username = @$dteacher["citizenshipcard"];
$courseid = @$row["moodle_course"];

if (empty($username) || empty($courseid)) {
    return; // No hay suficientes datos para proceder
}

// 1. Obtener el userid de Moodle a partir del username (cédula)
$function_get_user = 'core_user_get_users_by_field';
$url_get_user = "{$domain}/webservice/rest/server.php?wstoken={$token}&wsfunction={$function_get_user}&moodlewsrestformat={$restFormat}";
$params_get_user = http_build_query(['field' => 'username', 'values' => [$username]]);

$curl_get_user = curl_init($url_get_user . '&' . $params_get_user);
curl_setopt($curl_get_user, CURLOPT_RETURNTRANSFER, true);
$response_get_user = curl_exec($curl_get_user);
curl_close($curl_get_user);

$users_data = json_decode($response_get_user, true);
$userid = null;
if (!empty($users_data) && isset($users_data[0]['id'])) {
    $userid = $users_data[0]['id'];
}

if (!$userid) {
    return; // Usuario no encontrado en Moodle, no se puede desvincular.
}

// 2. Desvincular al usuario del curso
$function_unenrol = 'enrol_manual_unenrol_users';
$params_unenrol = [
    'enrolments' => [
        [
            'userid' => $userid,
            'courseid' => $courseid
        ]
    ]
];

$url_unenrol = "{$domain}/webservice/rest/server.php?wstoken={$token}&wsfunction={$function_unenrol}&moodlewsrestformat={$restFormat}";

$curl_unenrol = curl_init($url_unenrol);
curl_setopt($curl_unenrol, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl_unenrol, CURLOPT_POSTFIELDS, http_build_query($params_unenrol));
curl_exec($curl_unenrol);
curl_close($curl_unenrol);

?>