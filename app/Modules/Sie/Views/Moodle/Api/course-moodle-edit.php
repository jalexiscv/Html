<?php


$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
$mmodules = model("App\Modules\Sie\Models\Sie_Modules");
$mpensums = model("App\Modules\Sie\Models\Sie_Pensums");

/** @var array $d */
$course = $mcourses->getCourse($d["course"]);
$pensum = $mpensums->get_Pensum($course["pensum"]);
$module = $mmodules->get_Module($pensum["module"]);
$red = $module["red"];
$subsector = $module["subsector"];

$clonar = "";
if ($subsector == "SBM") {
    $clonar = "577";
} elseif ($subsector == "SBA") {
    $clonar = "574";
} elseif ($subsector == "SBG") {
    $clonar = "573";
} elseif ($subsector == "SBS") {
    $clonar = "572";
} elseif ($subsector == "SBE") {
    $clonar = "571";
} elseif ($red == "F") {
    $clonar = "576";
} elseif ($red == "EI") {
    $clonar = "575";
}

//[config]--------------------------------------------------------------------------------------------------------------
// Configuración de la API
$token = service("moodle")::getToken();
$domain = service("moodle")::getDomainName();
$function = 'core_course_update_courses';
$restFormat = 'json';

// Parámetros para la actualización del curso
$params = [
    'courses' => [
        [
            'id' => $course["moodle_course"], // ID del curso en Moodle a editar
            'fullname' => $course["name"],
            'shortname' => $course["name"],
            'idnumber' => $course["reference"],
            'categoryid' => 1,
            'visible' => 1
        ]
    ]
];

// Construir URL para la API
$serverUrl = $domain . '/webservice/rest/server.php'
    . '?wstoken=' . $token
    . '&wsfunction=' . $function
    . '&moodlewsrestformat=' . $restFormat;

// Realizar la petición
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $serverUrl,
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => http_build_query($params),
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false
]);

$response = curl_exec($curl);
$errorInfo = "";
$success = false;

if ($response === false) {
    $errorInfo = 'Error cURL: ' . curl_error($curl);
} else {
    $result = json_decode($response, true);
    // La función update no devuelve un ID, pero podemos verificar si hay errores.
    if (isset($result['warnings']) && empty($result['warnings'])) {
        $success = true;
    } elseif (isset($result['exception'])) {
        $errorInfo = $result['message'] ?? 'Error al actualizar el curso en Moodle.';
    } else {
        $success = true; // Asumimos éxito si no hay excepciones ni warnings
    }
}

curl_close($curl);

// Preparar respuesta
$response = [
    "success" => $success,
    "error" => $errorInfo,
    "originalData" => $result ?? null
];

echo json_encode($response);
?>