<?php


$mcourses = model("App\Modules\Sie\Models\Sie_Courses");

$course = $mcourses->get_Course($_GET["course"]);

//[config]--------------------------------------------------------------------------------------------------------------
$token = 'd9551c4aa62771d4a38d74b1e885b13d';
$domain = 'https://campus2025b.utede.edu.co';
$function = 'core_course_create_courses';
$endpoint = "$domain/webservice/rest/server.php";


$idnumber = !empty($course["reference"]) ? $course["reference"] : $course["course"];

// Convertir la fecha a timestamp si viene en formato "00:00"
$startdate = !empty($course["start_time"]) ? $course["start_time"] : time();
if (is_string($startdate) && preg_match('/^\d{2}:\d{2}$/', $startdate)) {
    // Si es una hora en formato "00:00", convertir a timestamp del día actual
    $today = date('Y-m-d ');
    $startdate = strtotime($today . $startdate);
} elseif (!is_numeric($startdate)) {
    // Si no es numérico y tampoco es el formato anterior, usar tiempo actual
    $startdate = time();
}

$nuevocourse = [
    'idnumber' => $idnumber,
    'fullname' => $course["name"],
    'shortname' => $course["course"],
    'categoryid' => "1",
    'summary' => $course["description"],
    'summaryformat' => 1,
    'format' => 'topics',
    'startdate' => (int)$startdate,
    'numsections' => "10",
    'visible' => 1,
];


$params = http_build_query(['courses' => [$nuevocourse]]);
$url = $endpoint . '?wstoken=' . $token . '&wsfunction=' . $function . '&moodlewsrestformat=json';
$curl = curl_init($url);
curl_setopt_array($curl, [
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => $params,
]);

$errorInfo = "";
$createdCourseId = "";


$response = curl_exec($curl);
if ($response === false) {
    $errorInfo = 'Error cURL: ' . curl_error($curl);
}

curl_close($curl);

$result = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    $errorInfo = "Respuesta no es JSON válido: $response";
} elseif (isset($result[0]['id'])) {
    $createdCourseId = $result[0]['id'];
    $siecourse= array(
        "course" =>$course["course"],
        "moodle_course" =>$createdCourseId,
    );
    $edit = $mcourses->update($course['course'], $siecourse);
} elseif (isset($result['exception'])) {
    $errorInfo = $result['message'] ?? 'Error desconocido al crear el usuario.';
}


$response = array(
    "createdCourseId" => $createdCourseId,
    "error" => $errorInfo,
    "data" => $result
);

echo(json_encode($response));
?>