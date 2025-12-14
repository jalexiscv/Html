<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-02-21 14:17:51
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sgd\Views\Versions\Creator\processor.php]
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
$authentication =service('authentication');
//[Models]-----------------------------------------------------------------------------
$f = service("forms",array("lang" => "Versions."));
$model = model("App\Modules\Sgd\Models\Sgd_Versions");
//[Vars]-----------------------------------------------------------------------------
$back = "/sgd/versions/list/".lpk();
$d = array(
    "version" => $f->get_Value("version"),
    "reference" => $f->get_Value("reference"),
    "name" => $f->get_Value("name"),
    "description" => $f->get_Value("description"),
    "date" => safe_get_date(),
    "time" => $f->get_Value("time"),
    "author" => safe_get_user(),
);
$row = $model->find($d["version"]);
$l["back"]="$back";
$l["edit"]="/sgd/versions/edit/{$d["version"]}";
$asuccess = "sgd/versions-create-success-message.mp3";
$aexist = "sgd/versions-create-exist-message.mp3";
if (is_array($row)) {
    $c= $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Versions.create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Versions.create-duplicate-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $aexist,
    ));
} else {
    $create = $model->insert($d);
    cache()->clean();
    //echo($model->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Versions.create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Versions.create-success-message"),$d['version']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" =>$asuccess,
    ));
}
echo($c);
?>
