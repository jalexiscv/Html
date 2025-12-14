<?php
/** @var array $progress */
/** @var array $execution */

$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");

$exec = "";
if (is_array($execution) && !empty($execution['execution'])) {
    $course = @$mcourses->getCourse($execution['course']);
    $course_course = !empty($course["course"]) ? $course["course"] : "Q10";
    $course_name = !empty($course["name"]) ? $course["name"] : "Posible importación historica";
    $course_description = !empty($course["description"]) ? $course["description"] : "Posible importación historica";

    $teacher = !empty($course["teacher"]) ? $mfields->get_Profile($course["teacher"]) : "";
    $teacher_name = (is_array($teacher) && !empty($teacher["name"])) ? $teacher["name"] : "Posible importación historica";

    $created_at = $execution['created_at'];
    $responsible = !empty($execution['author']) ? $mfields->get_Profile($execution['author']) : "";
    $responsible_name = (is_array($responsible) && !empty($responsible["name"])) ? $responsible["name"] : "";


    $exec = "<b>Curso</b>: {$course_name} <span class=\"opacity-25\">{$course_course}</span></br>";
    $exec .= "<b>Profesor</b>: {$teacher_name} </br>";
    $exec .= "<b>Descripción</b>: {$course_description} </br>";
    $exec .= "<b>Periodo</b>:" . @$course['period'] . " </br>";
    $exec .= "<b>Fecha del registro</b>: {$created_at}</br>";
    $exec .= "<b>Responsable</b>: {$responsible_name}</br>";

} else {
    $progress_calification = @$progress['last_calification'];
    if (!empty($progress_calification) && $progress_calification > 0) {
        $exec = "<p class='text-center'>Importación Histórica Sistema Académico Q10";
        $exec .= "<br>" . @$progress['period'] . "</p>";
    } else {
        $exec = "";
        $exec .= "";
    }
}

echo(json_encode(
    array(
        'render' => $exec,
    )
));
?>