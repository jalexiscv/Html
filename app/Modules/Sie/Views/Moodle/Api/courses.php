<?php


use App\Libraries\Moodle;

$mcourses = model("App\Modules\Sie\Models\Sie_Courses");
$mmodules = model("App\Modules\Sie\Models\Sie_Modules");
$mpensums = model("App\Modules\Sie\Models\Sie_Pensums");

$course = $mcourses->get_Course($_GET["course"]);
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

/**
 * $redes=array(
 * array("value"=>"","label"=>"Seleccione una red"),
 * array("value"=>"RTP","label"=>"Red de transformación productiva"),
 * array("value"=>"RAOR","label"=>"Red de arte, ocio y recreación"),
 * array("value"=>"RAV","label"=>"Red de agregación de valor"),
 * array("value"=>"EI","label"=>"Escuela de Idiomas"),
 * array("value"=>"F","label"=>"Fundamentación")
 * );
 *
 * if($r["red"]=="RTP"){
 * $sectores[]=array("value"=>"SBA","label"=>"Subsector Agrícola");
 * $sectores[]=array("value"=>"SBM","label"=>"Subsector minero-energético");
 * }elseif ($r["red"]=="RAOR"){
 * $sectores[]=array("value"=>"SBG","label"=>"Subsector Gastronomía");
 * $sectores[]=array("value"=>"SBS","label"=>"Subsector Software");
 * }elseif ($r["red"]=="RAV"){
 * $sectores[]=array("value"=>"SBE","label"=>"Subsector Empresarial");
 * }elseif($r["red"]=="EI"){
 * $sectores[]=array("value"=>"SBE","label"=>"General");
 * }elseif($r["red"]=="F"){
 * $sectores[]=array("value"=>"G","label"=>"General");
 * }
 **/

// Módulo base red de transformación productiva - Subsector minería	577
// Módulo base fundamentación	576
// Módulo base red de escuela de idiomas	575
// Módulo base red de transformación productiva - Subsector agrícola	574
// Módulo base red de arte, ocio y recreación - Subsector Gastronomía	573
// Módulo base red de arte, ocio y recreación - Subsector software	572
// Módulo base red de agregación de valor - Subsector empresarial	571

//[config]--------------------------------------------------------------------------------------------------------------
// Configuración de la API
$token = 'ce890746630ebf2c6b7baf4dde8f41b4';
$domain = 'https://campus.utede.edu.co';
$function = 'core_course_duplicate_course';
$restFormat = 'json';

// Parámetros para la clonación
$params = [
    'courseid' => $clonar,
    'fullname' => $course["name"],
    'shortname' => $course["course"],
    //'idnumber' => $course["reference"],
    'categoryid' => 1,
    'visible' => 1,
    'options' => [
        [
            'name' => 'users',
            'value' => 0
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
$clonedCourseId = "";

if ($response === false) {
    $errorInfo = 'Error cURL: ' . curl_error($curl);
} else {
    $result = json_decode($response, true);
    if (isset($result['id'])) {
        $clonedCourseId = $result['id'];
        // Actualizar el ID del curso en la base de datos local
        $siecourse = [
            "course" => $course["course"],
            "moodle_course" => $clonedCourseId,
        ];
        $mcourses->update($course['course'], $siecourse);
    } else {
        $errorInfo = $result['message'] ?? 'Error al clonar el curso';
    }
}

curl_close($curl);

// Preparar respuesta
$response = [
    "success" => !empty($clonedCourseId),
    "clonedCourseId" => $clonedCourseId,
    "error" => $errorInfo,
    "originalData" => $result ?? null
];


// Actualizar el SIE
$moodle = new Moodle();
$moodle_courseid = $moodle->getCourse($params["shortname"]);
if ($moodle_courseid) {
    $siecourse = [
        "course" => $course["course"],
        "moodle_course" => $moodle_courseid,
    ];
    $mcourses->update($course['course'], $siecourse);
}

echo json_encode($response);
?>