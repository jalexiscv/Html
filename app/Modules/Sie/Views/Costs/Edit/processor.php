<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-07-03 10:55:55
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Costs\Editor\processor.php]
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
$authentication =service('authentication');
//[services]------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sie\Models\Sie_Costs");
//[Process]-----------------------------------------------------------------------------
$f = service("forms",array("lang" => "Sie_Costs."));
$d = array(
    "cost" => $f->get_Value("cost"),
    "program" => $f->get_Value("program"),
    "period" => $f->get_Value("period"),
    "value" => $f->get_Value("value"),
    "currency" => $f->get_Value("currency"),
    "valid_from" => $f->get_Value("valid_from"),
    "valid_until" => $f->get_Value("valid_until"),
);
//[Elements]-----------------------------------------------------------------------------
$row = $model->find($d["cost"]);
$l["back"]=$f->get_Value("back");
$l["edit"]="/sie/costs/edit/{$d["cost"]}";
$asuccess = "sie/costs-edit-success-message.mp3";
$anoexist = "sie/costs-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
   $edit = $model->update($d['cost'],$d);
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Costs.edit-success-title"),
        "text-class" => "text-center",
        "text" => lang("Sie_Costs.edit-success-message"),
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
        "title" => lang("Sie_Costs.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sie_Costs.edit-noexist-message"),$d['cost']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
cache()->clean();
?>