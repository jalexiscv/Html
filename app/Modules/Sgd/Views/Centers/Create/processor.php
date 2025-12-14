<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-03-27 00:41:05
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sgd\Views\Centers\Creator\processor.php]
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
$f = service("forms",array("lang" => "Sgd_Centers."));
$model = model("App\Modules\Sgd\Models\Sgd_Centers");
//[Vars]-----------------------------------------------------------------------------
$back = "/sgd/centers/list/".lpk();
$d = array(
    "center" => $f->get_Value("center"),
    "reference" => $f->get_Value("reference"),
    "location" => $f->get_Value("location"),
    "name" => $f->get_Value("name"),
    "description" => $f->get_Value("description"),
    "author" => safe_get_user(),
);
$row = $model->find($d["center"]);
$l["back"]="$back";
$l["edit"]="/sgd/centers/edit/{$d["center"]}";
$asuccess = "sgd/centers-create-success-message.mp3";
$aexist = "sgd/centers-create-exist-message.mp3";
if (is_array($row)) {
    $c= $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sgd_Centers.create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Sgd_Centers.create-duplicate-message"),
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
        "title" => lang("Sgd_Centers.create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sgd_Centers.create-success-message"),$d['center']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" =>$asuccess,
    ));
}
echo($c);
cache()->clean();
?>
