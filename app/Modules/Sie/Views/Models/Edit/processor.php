<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-12-12 06:42:09
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Models\Editor\processor.php]
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
//$model = model("App\Modules\Sie\Models\Sie_Models");
//[Process]-----------------------------------------------------------------------------
$f = service("forms",array("lang" => "Sie_Models."));
$d = array(
    "model" => $f->get_Value("model"),
    "code" => $f->get_Value("code"),
    "name" => $f->get_Value("name"),
    "description" => $f->get_Value("description"),
    "country" => $f->get_Value("country"),
    "regulatory_framework" => $f->get_Value("regulatory_framework"),
    "uses_credits" => $f->get_Value("uses_credits"),
    "hours_per_credit" => $f->get_Value("hours_per_credit"),
    "credit_calculation_formula" => $f->get_Value("credit_calculation_formula"),
    "requires_theoretical_hours" => $f->get_Value("requires_theoretical_hours"),
    "requires_practical_hours" => $f->get_Value("requires_practical_hours"),
    "requires_independent_hours" => $f->get_Value("requires_independent_hours"),
    "requires_total_hours" => $f->get_Value("requires_total_hours"),
    "validation_rules" => $f->get_Value("validation_rules"),
    "configuration" => $f->get_Value("configuration"),
    "is_active" => $f->get_Value("is_active"),
);
//[Elements]-----------------------------------------------------------------------------
$row = $model->find($d["model"]);
$l["back"]=$f->get_Value("back");
$l["edit"]="/sie/models/edit/{$d["model"]}";
$asuccess = "sie/models-edit-success-message.mp3";
$anoexist = "sie/models-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
    if(empty($d["validation_rules"])){
        $d["validation_rules"]=json_encode(array());
    }
    if(empty($d["configuration"])){
        $d["configuration"]=json_encode(array());
    }
   $edit = $model->update($d['model'],$d);
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Models.edit-success-title"),
        "text-class" => "text-center",
        "text" => lang("Sie_Models.edit-success-message"),
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
        "title" => lang("Sie_Models.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sie_Models.edit-noexist-message"),$d['model']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
cache()->clean();
?>
