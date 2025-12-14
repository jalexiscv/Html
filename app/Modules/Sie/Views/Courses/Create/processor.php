<?php

//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Courses."));
$model = model("App\Modules\Sie\Models\Sie_Courses");
$d = array(
    "course" => pk(),//$f->get_Value("course"),
    "reference" => $f->get_Value("reference"),
    "program" => $f->get_Value("program"),
    "grid" => $f->get_Value("grid"),
    "pensum" => $f->get_Value("pensum"),
    "version" => $f->get_Value("version"),
    "teacher" => $f->get_Value("teacher"),
    "name" => $f->get_Value("name"),
    "description" => $f->get_Value("description"),
    "maximum_quota" => $f->get_Value("maximum_quota"),
    "start" => $f->get_Value("start"),
    "end" => $f->get_Value("end"),
    "period" => $f->get_Value("period"),
    "journey" => $f->get_Value("journey"),
    "start_time" => $f->get_Value("start_time"),
    "end_time" => $f->get_Value("end_time"),
    "author" => safe_get_user(),
    "price" => $f->get_Value("price"),
    "agreement" => $f->get_Value("agreement"),
    "agreement_institution" => $f->get_Value("agreement_institution"),
    "agreement_group" => $f->get_Value("agreement_group"),
    "space" => $f->get_Value("space"),
    "day" => $f->get_Value("day"),
    "cycle" => $f->get_Value("cycle"),
    "free" => $f->get_Value("free"),
);
//print_r($d);
$row = $model->find($d["course"]);
$l["back"] = "/sie/courses/list/" . lpk();
$l["edit"] = "/sie/courses/edit/{$d["course"]}";
$asuccess = "sie/courses-create-success-message.mp3";
$aexist = "sie/courses-create-exist-message.mp3";
if (is_array($row)) {
    $c = $card = $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Courses.create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Sie_Courses.create-duplicate-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $aexist,
    ));
} else {
    $create = $model->insert($d);
    //echo($model->getLastQuery()->getQuery());
    $moodle = new App\Libraries\Moodle();
    $result = $moodle->cloneCourse($d["course"]);
    if ($result['success']) {
        $d["moodle_course"] = $result['clonedCourseId'];
        echo("Curso clonado con ID: " . $result['clonedCourseId']);
    } else {
        echo("Error: " . $result['error']);
    }


    //[asign-teacher]---------------------------------------------------------------------------------------------------
    // Actualizar curso en Moodle solo con nombre y referencia
    if (!empty($d["moodle_course"])) {
        $courseUpdateData = [
            'id' => (int)$d["moodle_course"],  // ID del curso en Moodle
            'fullname' => $d["name"],            // Nombre del curso
            'idnumber' => $d["reference"]        // Referencia del sistema
        ];
        $moodleResult = $moodle->updateCourse($courseUpdateData);
        if (!$moodleResult['success']) {
            //echo("Error actualizando curso en Moodle: " . $moodleResult['error']);
        }
        // Actualizar el profesor en el curso en Moodle
        if (!empty($d["teacher"])) {
            // Obtener los datos del profesor desde el modelo
            $mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");
            $teacherData = $mfields->get_Profile($d["teacher"]);
            if ($teacherData && !empty($teacherData["citizenshipcard"])) {
                // Usar la cédula como username para Moodle
                $teacherUsername = $teacherData["citizenshipcard"];
                // Reasignar profesor (elimina todos los actuales y asigna el nuevo)
                $teacherResult = $moodle->reassignTeacherInCourse(
                    (int)$d["moodle_course"],
                    $teacherUsername
                );
                if (!$teacherResult['success']) {
                    //echo("Error reasignando profesor en Moodle: " . $teacherResult['error']);
                }
            } else {
                //echo("No se pudo obtener la cédula del profesor con ID: " . $d["teacher"]);
            }
        }
    }
    //[/asign-teacher]--------------------------------------------------------------------------------------------------
    $c = $card = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Courses.create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sie_Courses.create-success-message"), $d['course']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
}
echo($c);
cache()->clean();
?>