<?php
/** @var string $code */
/** @var array $d */
/** @var string $moodle_course */

$courseid = $moodle_course;
$token = service("moodle")::getToken();
$domain = service("moodle")::getDomainName();
$restFormat = 'json';

// 1. Obtener usuarios
$function_get_users = 'core_enrol_get_enrolled_users';
$url_get_users = "{$domain}/webservice/rest/server.php?wstoken={$token}&wsfunction={$function_get_users}&moodlewsrestformat={$restFormat}&courseid={$courseid}";

$curl_get_users = curl_init($url_get_users);
curl_setopt($curl_get_users, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl_get_users);
curl_close($curl_get_users);

$enrolled_users = json_decode($response, true);

//$code.=safe_dump($enrolled_users);

if (!is_array($enrolled_users)) {
    $code .= "Error: No se pudieron obtener los usuarios";
    return;
}

// 2. Desvincular profesores
$function_unenrol = 'enrol_manual_unenrol_users';
$url_unenrol = "{$domain}/webservice/rest/server.php?wstoken={$token}&wsfunction={$function_unenrol}&moodlewsrestformat={$restFormat}";

$teachers_found = 0;


foreach ($enrolled_users as $user) {
    if (isset($user['roles']) && is_array($user['roles'])) {
        foreach ($user['roles'] as $role) {
            // Modificamos la condición para incluir ambos tipos de profesor
            if (isset($role['shortname']) &&
                ($role['shortname'] === 'teacher' || $role['shortname'] === 'editingteacher')) {
                $teachers_found++;
                $params_unenrol = [
                    'enrolments' => [
                        [
                            'userid' => $user['id'],
                            'courseid' => $courseid,
                            'roleid' => 3
                        ]
                    ]
                ];

                $curl_unenrol = curl_init($url_unenrol);
                curl_setopt($curl_unenrol, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_unenrol, CURLOPT_POST, true);
                curl_setopt($curl_unenrol, CURLOPT_POSTFIELDS, http_build_query($params_unenrol));
                $response = curl_exec($curl_unenrol);

                if ($response === false) {
                    $code .= "Error al desvincular profesor {$user['id']}: " . curl_error($curl_unenrol);
                }

                curl_close($curl_unenrol);
                break;
            }
        }
    }
}

if ($teachers_found > 0) {
    $code .= "Se han desvinculado {$teachers_found} profesores del curso {$courseid}";
} else {
    $code .= "No se encontraron profesores para desvincular en el curso {$courseid}";
}