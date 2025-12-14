<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-05-01 08:14:09
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Registrations\Editor\processor.php]
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
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$menrollments = model("App\Modules\Sie\Models\Sie_Enrollments");
$mexecutions = model("App\Modules\Sie\Models\Sie_Executions");
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Registrations."));
$postData = $request->getPost();
$data = [];
$current_year = date('Y');
$current_month = date('n');
$period = $current_year . ($current_month <= 6 ? 'A' : 'B');


foreach ($postData as $progress => $course) {
    $progress = str_replace('form_preenrrolments_', '', $progress);
    if ($progress !== 'enrollment' && $progress !== 'submited') {
        $d = array(
            "execution" => pk(),
            "progress" => $progress,
            "course" => $course,
            "period" => $period,
            "date_start" => safe_get_date(),
            "date_end" => safe_get_date(),
            "total" => "0",
            "author" => "PREMATRICULA",
        );
        //Debo serciorarme que la asignacion no exista
        $execution = $mexecutions
            ->where("progress", $progress)
            ->where("course", $course)
            ->where("period", $period)
            ->first();
        if (is_array($execution) && !empty($execution['execution'])) {
            //echo("Si existia la execution...<br>");
        } else {
            //echo("No existia la execution...<br>");
            // Deberia borrar los registros asociados a la execution
            $mexecutions->where("progress", $progress)->delete();
            // Crear el registro de una nueva "execution" para el "progress" y "course" seleccionado
            $create = $mexecutions->insert($d);
        }
    }
}
//[Elements]-----------------------------------------------------------------------------
$row = $menrollments->get_Enrollment($oid);
$l["back"] = "/sie/progress/list/{$oid}";
$l["edit"] = "/sie/registrations/edit/{$oid}";
$asuccess = "sie/registrations-edit-success-message.mp3";
$anoexist = "sie/registrations-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
    //$edit = $model->update($d['registration'], $d);
    //cache()->clean();
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Registrations.edit-success-title"),
        "text-class" => "text-center",
        "text" => lang("Sie_Registrations.edit-success-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
} else {
    //$create = $model->insert($d);
    //echo($model->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("warning", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Registrations.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sie_Registrations.edit-noexist-message"), $oid),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
?>