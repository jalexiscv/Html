<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-04-28 04:56:02
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Project\Views\Tasks\Editor\processor.php]
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
 * █ @link https://www.higgs.com.co
 * █ @Version 1.5.1 @since PHP 8,PHP 9
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[Services]-----------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
//[services]------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Project\Models\Project_Tasks");
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Project_Tasks."));
$d = array(
    "task" => $f->get_Value("task"),
    "project" => $f->get_Value("project"),
    "name" => $f->get_Value("name"),
    "description" => safe_urlencode($f->get_Value("description")),
    "start" => $f->get_Value("start"),
    "end" => $f->get_Value("end"),
    "status" => $f->get_Value("status"),
    "responsible" => $f->get_Value("responsible"),
    "priority" => $f->get_Value("priority"),
    "order" => $f->get_Value("order"),
    "author" => safe_get_user(),
);
//[Elements]-----------------------------------------------------------------------------
$row = $model->find($d["task"]);
$l["back"] = $f->get_Value("back");
$l["edit"] = "/project/tasks/edit/{$d["task"]}";
$asuccess = "project/tasks-edit-success-message.mp3";
$anoexist = "project/tasks-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
    $edit = $model->update($d['task'], $d);
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Project_Tasks.edit-success-title"),
        "text-class" => "text-center",
        "text" => lang("Project_Tasks.edit-success-message"),
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
        "title" => lang("Project_Tasks.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Project_Tasks.edit-noexist-message"), $d['task']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
cache()->clean();
?>
