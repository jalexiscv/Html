<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-03-15 12:20:32
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Courses\Editor\processor.php]
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
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
//[services]------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sie\Models\Sie_Courses");
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Courses."));
$d = array(
    "course" => $f->get_Value("course"),
    "reference" => $f->get_Value("reference"),
    "program" => $f->get_Value("program"),
    "grid" => $f->get_Value("grid"),
    "pensum" => $f->get_Value("pensum"),
    "version" => $f->get_Value("version"),
    "teacher" => $f->get_Value("teacher"),
    "name" => $f->get_Value("name"),
    "description" => $f->get_Value("description"),
    "maximum_quota" => $f->get_Value("maximum_quota"),
    "journey" => $f->get_Value("journey"),
    "start" => $f->get_Value("start"),
    "end" => $f->get_Value("end"),
    "period" => $f->get_Value("period"),
    "start_time" => $f->get_Value("start_time"),
    "end_time" => $f->get_Value("end_time"),
    "price" => $f->get_Value("price"),
    "status" => $f->get_Value("status"),
    "author" => safe_get_user(), 
    "agreement" => $f->get_Value("agreement"),
    "agreement_institution" => $f->get_Value("agreement_institution"),
    "agreement_group" => $f->get_Value("agreement_group"),
    "cycle" => $f->get_Value("cycle"),
    "space" => $f->get_Value("space"),
    "day" => $f->get_Value("day"),
    "free" => $f->get_Value("free"),
    "moodle_course" => $f->get_Value("moodle_course"),
);
//[Elements]------------------------------------------------------------------------------------------------------------
$row = $model->find($d["course"]);
$l["back"] = "/sie/courses/list/" . lpk();
$l["edit"] = "/sie/courses/edit/{$d["course"]}";
$asuccess = "sie/courses-edit-success-message.mp3";
$anoexist = "sie/courses-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
    $edit = $model->update($d['course'], $d);
    //include("moodle-edit.php");
    //include("moodle-delete.php");
    //include("moodle-users.php");
    $moodle = new App\Libraries\Moodle();
    // Actualizar curso en Moodle solo con nombre y referencia
    if (!empty($row["moodle_course"])) {
        $courseUpdateData = [
            'id' => (int)$row["moodle_course"],  // ID del curso en Moodle
            'fullname' => $d["name"],            // Nombre del curso
            'idnumber' => $d["reference"]        // Referencia del sistema
        ];
        $moodleResult = $moodle->updateCourse($courseUpdateData);
        if (!$moodleResult['success']) {
            error_log("Error actualizando curso en Moodle: " . $moodleResult['error']);
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
                    (int)$row["moodle_course"],
                    $teacherUsername
                );

                if (!$teacherResult['success']) {
                    error_log("Error reasignando profesor en Moodle: " . $teacherResult['error']);
                }
            } else {
                error_log("No se pudo obtener la cédula del profesor con ID: " . $d["teacher"]);
            }
        }

    }
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Courses.edit-success-title"),
        "text-class" => "text-center",
        "text" => lang("Sie_Courses.edit-success-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
} else {
    $create = $model->insert($d);
    //echo($model->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("warning", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Courses.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sie_Courses.edit-noexist-message"), $d['course']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
?>