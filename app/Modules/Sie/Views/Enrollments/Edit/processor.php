<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-09-12 04:42:56
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Enrollments\Editor\processor.php]
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
//$model = model("App\Modules\Sie\Models\Sie_Enrollments");
$menrollments = model("App\Modules\Sie\Models\Sie_Enrollments");
$mprogress = model("App\Modules\Sie\Models\Sie_Progress");
$mgrids = model("App\Modules\Sie\Models\Sie_Grids");
$mpensums = model("App\Modules\Sie\Models\Sie_Pensums");
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$mversions = model("App\Modules\Sie\Models\Sie_Versions");
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Enrollments."));

$d = array(
    "enrollment" => $f->get_Value("enrollment"),
    "registration" => $f->get_Value("registration"),
    "program" => $f->get_Value("program"),
    "grid" => $f->get_Value("grid"),
    "version" => $f->get_Value("version"),
    "linkage_type" => $f->get_Value("linkage_type"),
    "cycle" => $f->get_Value("cycle"),
    "moment" => $f->get_Value("moment"),
    "headquarter" => $f->get_Value("headquarter"),
    "journey" => $f->get_Value("journey"),
    "date" => $f->get_Value("date"),
    "renewal" => $f->get_Value("renewal"),
    "status" => $f->get_Value("status"),
    "period" => $f->get_Value("period"),
    "observation" => $f->get_Value("observation"),
    "author" => safe_get_user(),
);
//[Elements]-----------------------------------------------------------------------------
$row = $model->find($d["enrollment"]);
$l["back"] = "/sie/students/view/{$d['registration']}#enrollments";
$l["edit"] = "/sie/enrollments/edit/{$d["enrollment"]}";
$asuccess = "sie/enrollments-edit-success-message.mp3";
$anoexist = "sie/enrollments-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
    $edit = $model->update($d['enrollment'], $d);
    // Detectar cambio de malla y version
    if ($row['grid'] != $d['grid'] || $row['version'] != $d['version']) {
        $model->update("sie_enrollments", array("grid" => $d['grid'], "version" => $d['version']), array("enrollment" => $d['enrollment']));
        // Si se ha producido cambio se deben eliminar todos los progresos "progress" de la matricula
        // 1. Tener en cuenta los progresss de la matricula que tengan notas y conservarlos
        // 2. Eliminar los progresss de la matricula que no tengan notas
        // 3. Cargar los "progress" de la nueva "malla" y "version"
        $program = $mprograms->getProgram($d["program"]);
        $grid = $mgrids->get_Grid($d["grid"]);
        $version = $mversions->get_Version($d["version"]);

        $delete = $mprogress->where("enrollment", $d['enrollment'])->delete();
        $pensums = $mpensums->get_PensumsByVersion($version["version"]);
        foreach ($pensums as $pensum) {
            if (is_array($pensum)) {
                $progress = array(
                    "progress" => pk(),
                    "enrollment" => $d["enrollment"],
                    "pensum" => @$pensum["pensum"],
                    "module" => @$pensum["module"],
                    "status" => "0",
                    "last_calification" => "0",
                    "last_course" => "0",
                    "last_author" => safe_get_user(),
                    "last_date" => safe_get_date(),
                    "author" => safe_get_user(),
                );
                //print_r($progress);
                $mprogress->insert($progress);
            }
        }
    }

    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Enrollments.edit-success-title"),
        "text-class" => "text-center",
        "text" => lang("Sie_Enrollments.edit-success-message"),
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
        "title" => lang("Sie_Enrollments.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sie_Enrollments.edit-noexist-message"), $d['enrollment']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
?>
