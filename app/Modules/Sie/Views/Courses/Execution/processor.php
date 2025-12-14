<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-08-31 13:53:11
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Executions\Creator\processor.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @var object $parent Trasferido desde el controlador
 * █ @var object $authentication Trasferido desde el controlador
 * █ @var object $request Trasferido desde el controlador
 * █ @var object $dates Trasferido desde el controlador
 * █ @var string $component Trasferido desde el controlador
 * █ @var string $view Trasferido desde el controlador
 * █ @var string $oid Trasferido desde el controlador
 * █ @var string $views Trasferido desde el controlador
 * █ @var string $prefix Trasferido desde el controlador
 * █ @var array $data Trasferido desde el controlador
 * █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[Services]-----------------------------------------------------------------------------
use App\Libraries\Moodle;

$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Executions."));
$model = model("App\Modules\Sie\Models\Sie_Executions");
$mcourses = model("App\Modules\Sie\Models\Sie_Courses");
$mprogress = model("App\Modules\Sie\Models\Sie_Progress");
$menrollments = model("App\Modules\Sie\Models\Sie_Enrollments");
$mregistrations = model("App\Modules\Sie\Models\Sie_Enrollments");
$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
//[Vars]-----------------------------------------------------------------------------
$back = $f->get_Value("back");
$d = array(
    "execution" => $f->get_Value("execution"),
    "progress" => $f->get_Value("progress"),
    "course" => $f->get_Value("course"),
    "date_start" => $f->get_Value("date_start"),
    "date_end" => $f->get_Value("date_end"),
    "total" => $f->get_Value("total"),
    "author" => safe_get_user(),
);
$row = $model->find($d["execution"]);
$l["back"] = "$back";
$l["edit"] = "/sie/executions/edit/{$d["execution"]}";
$asuccess = "sie/course-execution-create-success-message.mp3";
$aexist = "sie/executions-create-exist-message.mp3";
if (is_array($row)) {
    $c = $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Executions.create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Sie_Executions.create-duplicate-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $aexist,
    ));
} else {
    $create = $model->insert($d);
    //echo($model->getLastQuery()->getQuery());
    $course = $mcourses->getCourse($d["course"]);
    $progress = $mprogress->get_Progress($d["progress"]);
    $enrollment = $menrollments->get_Enrollment($progress["enrollment"]);
    $registration = $mregistrations->getRegistration($enrollment["student"]);
    $moodle = new Moodle();
    $result = $moodle->enrollUserInCourse($course["moodle_course"], $registration["identification_number"], 5);
    if ($result['success']) {
        //echo "Usuario enrolado exitosamente: " . $result['userInfo']['fullName'];
    } else {
        //echo "Error: " . $result['error'];
    }
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Executions.create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sie_Executions.course-execution-create-success-message"), $d['execution']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
}
echo($c);
?>