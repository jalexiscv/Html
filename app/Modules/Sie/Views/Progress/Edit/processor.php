<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-08-13 07:26:00
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Progress\Editor\processor.php]
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
$mprogress = model("App\Modules\Sie\Models\Sie_Progress");
$mexecutions = model("App\Modules\Sie\Models\Sie_Executions");
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Progress."));
$d = array(
    "progress" => $f->get_Value("progress"),
    "enrollment" => $f->get_Value("enrollment"),
    "module" => $f->get_Value("module"),
    "status" => $f->get_Value("status"),
    "last_calification" => $f->get_Value("last_calification"),
    "period" => $f->get_Value("period"),
    "c1" => $f->get_Value("c1"),
    "c2" => $f->get_Value("c2"),
    "c3" => $f->get_Value("c3"),
    "last_course" => $f->get_Value("last_course"),
    "last_author" => $f->get_Value("last_author"),
    "last_date" => $f->get_Value("last_date"),
    "observation" => $f->get_Value("observation"),
    "author" => $f->get_Value("author"),
);
//[Elements]-----------------------------------------------------------------------------
$row = $model->find($d["progress"]);
$l["back"] = "/sie/progress/list/{$d["enrollment"]}";
$l["edit"] = "/sie/progress/edit/{$d["progress"]}";
$asuccess = "sie/progress-edit-success-message.mp3";
$anoexist = "sie/progress-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
    $edit = $model->update($d['progress'], $d);
    $execution = array(
        "execution" => pk(),
        "progress" => $d['progress'],
        "course" => @$d['course'],
        "date_start" => $d['last_date'],
        "date_end" => $d['last_date'],
        "c1" => $d['c1'],
        "c2" => $d['c2'],
        "c3" => $d['c3'],
        "total" => round((doubleval($d["c1"]) * 0.3333) + (doubleval($d["c2"]) * 0.3333) + (doubleval($d["c3"]) * 0.3334), 2),
        "status" => $d['status'],
        "observation" => $d['observation'],
        "period" => $d["period"],
        "author" => $d["author"],
        "created_at"=>$d["last_date"],
    );
    $create_execution = $mexecutions->insert($execution);

    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Progress.edit-success-title"),
        "text-class" => "text-center",
        "text" => lang("Sie_Progress.edit-success-message"),
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
        "title" => lang("Sie_Progress.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sie_Progress.edit-noexist-message"), $d['progress']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
?>
