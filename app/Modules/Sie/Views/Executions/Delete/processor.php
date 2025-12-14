<?php

use App\Libraries\Moodle;

$bootstrap = service('Bootstrap');
$f = service("forms", array("lang" => "Executions."));
$mexecutions = model("App\Modules\Sie\Models\Sie_Executions");
$mprogress = model("App\Modules\Sie\Models\Sie_Progress");
$menrollments = model("App\Modules\Sie\Models\Sie_Enrollments");
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$mcourses = model("App\Modules\Sie\Models\Sie_Courses");

$pkey = $f->get_Value("pkey");
$includemoodle = $f->get_Value("includemoodle");


$execution = $mexecutions->withDeleted()->find($pkey);
$course = $mcourses->getCourse($execution["course"]);

if (!empty($execution["progress"])) {
    $progress = $mprogress->get_Progress($execution["progress"]);
    $enrollment = $menrollments->get_Enrollment($progress["enrollment"]);
    $registration = $mregistrations->getRegistration($enrollment["registration"]);
} elseif (!empty($execution["registration"])) {
    $registration = $mregistrations->getRegistration($execution["registration"]);
}

/* Vars */
$l["back"] = "/sie/progress/edit/{$execution[ "progress"]}";
$l["edit"] = "/sie/executions/edit/{$pkey}";
$vsuccess = "sie/executions-delete-success-message.mp3";
$vnoexist = "sie/executions-delete-noexist-message.mp3";
/* Build */
if (isset($execution["execution"])) {
    if ($includemoodle == "Y") {
        //echo("Si borra de moodle");
        $delete = $mexecutions->delete($pkey);
        $moodle = new Moodle();
        //Eliminar estudiante del curso en Moodle
        if (!empty($course["moodle_course"]) && !empty($registration["identification_number"])) {
            $removeResult = $moodle->removeUserFromCourse(
                (int)$course["moodle_course"],              // ID del curso en Moodle
                $registration["identification_number"]      // ID del estudiante (cédula)
            );
            if (!$removeResult['success']) {
                echo("Error eliminando estudiante {$registration["identification_number"]} del curso {$course["moodle_course"]} en  Moodle: " . $removeResult['error']);
            }
        }
    } else {
        //echo("No borra del moodle");
        $delete = $mexecutions->delete($pkey);
    }

    $c = $bootstrap->get_Card("duplicate", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Executions.delete-success-title"),
        "text-class" => "text-center",
        "text" => lang("Sie_Executions.delete-success-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $vsuccess,
    ));
} else {
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Executions.delete-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sie_Executions.delete-noexist-message"), $d['execution']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $vnoexist,
    ));
}
echo($c);
?>