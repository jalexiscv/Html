<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-07-27 09:56:27
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Enrollments\Creator\processor.php]
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
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Enrollments."));
$menrollments = model("App\Modules\Sie\Models\Sie_Enrollments");
$mprogress = model("App\Modules\Sie\Models\Sie_Progress");
$mgrids = model("App\Modules\Sie\Models\Sie_Grids");
$mpensums = model("App\Modules\Sie\Models\Sie_Pensums");
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
//[Vars]-----------------------------------------------------------------------------
$back = $f->get_Value("back");
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
    "period" => $f->get_Value("period"),
    "observation" => $f->get_Value("observation"),
    "author" => safe_get_user(),
);


$registration = $mregistrations->getRegistration($d["registration"]);

$l["back"] = $back;

$l["edit"] = "/sie/enrollments/edit/{$d["enrollment"]}";
$asuccess = "sie/enrollments-create-success-message.mp3";
$aexist = "sie/enrollments-create-exist-message.mp3";

$row = $menrollments->where("enrollment", $d["enrollment"])->first();

if (is_array($row) && !empty($row['enrollment'])) {
    $c = $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Enrollments.create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Sie_Enrollments.create-duplicate-message"),
        "footer-continue" => "/sie/enrollments/create/{$oid}",
        "footer-class" => "text-center",
        "voice" => $aexist,
    ));
} else {
    $create = $menrollments->insert($d);
    //echo($model->getLastQuery()->getQuery());
    // Debo tomar todos los modulos de la malla curricular y crear un registro en la tabla de progreso
    // los codigos de los modulos no seran los codigos de los modulos originales si no los modulos de la malla
    // programs -> grids -> versions -> pensums
    // literal un pemsum es un modulo dentro de una version de una malla curricular
    $pensums = $mpensums->get_PensumsByVersion($d["version"]);
    //echo($d["version"]);
    //echo("<pre>");
    //print_r($pensums);
    //echo("</pre>");
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


    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Enrollments.create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sie_Enrollments.create-success-message"), $d['enrollment']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
}
echo($c);
?>