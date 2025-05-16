<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-04-28 04:55:10
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Project\Views\Projects\Creator\processor.php]
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
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Project_Projects."));
$model = model("App\Modules\Project\Models\Project_Projects");
//[Vars]-----------------------------------------------------------------------------
$d = array(
    "project" => $f->get_Value("project"),
    "name" => $f->get_Value("name"),
    "description" => $f->get_Value("description"),
    "start" => $f->get_Value("start"),
    "end" => $f->get_Value("end"),
    "status" => $f->get_Value("status"),
    "budget" => $f->get_Value("budget"),
    "responsible" => $f->get_Value("responsible"),
    "priority" => $f->get_Value("priority"),
    "comments" => $f->get_Value("comments"),
    "author" => safe_get_user(),
    "estimated_end_date" => $f->get_Value("estimated_end_date"),
);
$row = $model->find($d["project"]);
$l["back"] = $f->get_Value("back");
$l["edit"] = "/project/projects/edit/{$d["project"]}";
$asuccess = "project/projects-create-success-message.mp3";
$aexist = "project/projects-create-exist-message.mp3";
if (is_array($row)) {
    $c = $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Project_Projects.create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Project_Projects.create-duplicate-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $aexist,
    ));
} else {
    $create = $model->insert($d);
    //echo($model->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Project_Projects.create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Project_Projects.create-success-message"), $d['project']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
}
echo($c);
cache()->clean();
?>
