<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-08-31 13:53:15
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Executions\Editor\processor.php]
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
 * █ @var object $mexecutions Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[Services]-----------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
//[services]------------------------------------------------------------------------------------------------------------
$mexecutions = model("App\Modules\Sie\Models\Sie_Executions");
$mprogress = model('App\Modules\Sie\Models\Sie_Progress');
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Executions."));
$d = array(
    "execution" => $f->get_Value("execution"),
    "progress" => $f->get_Value("progress"),
    "course" => $f->get_Value("course"),
    "date_start" => $f->get_Value("date_start"),
    "date_end" => $f->get_Value("date_end"),
    "c1" => $f->get_Value("c1"),
    "c2" => $f->get_Value("c2"),
    "c3" => $f->get_Value("c3"),
    "total" => $f->get_Value("total"),
    "author" => safe_get_user(),
);
//[Elements]-----------------------------------------------------------------------------
$row = $mexecutions->find($d["execution"]);
$l["back"] = "/sie/courses/view/{$d["course"]}";
$l["edit"] = "/sie/executions/edit/{$d["execution"]}";
$asuccess = "sie/executions-edit-success-message.mp3";
$anoexist = "sie/executions-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
    $status=sie_getStatusExecution($d["c1"], $d["c2"],$d["c3"]);
    $d["status"]=$status;
    $updateExecution = $mexecutions->update($d['execution'], $d);
    $p = array(
        "progress" => $d["progress"],
        "status" => $d["status"],
    );
    $updateProgress = $mprogress->update($p['progress'],$p);

    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Executions.edit-success-title"),
        "text-class" => "text-center",
        "text" => lang("Sie_Executions.edit-success-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
} else {
    $create = $mexecutions->insert($d);
    $status=sie_getStatusExecution($d["c1"], $d["c2"],$d["c3"]);
    $d["status"]=$status;
    $p = array(
        "progress" => $d["progress"],
        "status" => $d["status"],
    );
    $updateProgress = $mprogress->update($p['progress'],$p);
    //echo($mexecutions->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("warning", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Executions.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sie_Executions.edit-noexist-message"), $d['execution']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
?>