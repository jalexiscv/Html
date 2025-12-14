<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-10-03 06:59:58
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Iris\Views\Mstudies\Creator\processor.php]
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
$f = service("forms",array("lang" => "Iris_Mstudies."));
$model = model("App\Modules\Iris\Models\Iris_Mstudies");
//[Vars]-----------------------------------------------------------------------------
$d = array(
    "mstudy" => $f->get_Value("mstudy"),
    "loinc_code" => $f->get_Value("loinc_code"),
    "short_name" => $f->get_Value("short_name"),
    "long_name" => $f->get_Value("long_name"),
    "common_name" => $f->get_Value("common_name"),
    "coding_system" => $f->get_Value("coding_system"),
    "code_version" => $f->get_Value("code_version"),
    "category" => $f->get_Value("category"),
    "subcategory" => $f->get_Value("subcategory"),
    "procedure_type" => $f->get_Value("procedure_type"),
    "modality" => $f->get_Value("modality"),
    "cpt_code" => $f->get_Value("cpt_code"),
    "snomed_code" => $f->get_Value("snomed_code"),
    "status" => $f->get_Value("status"),
    "replaced_by" => $f->get_Value("replaced_by"),
    "patient_instructions" => $f->get_Value("patient_instructions"),
    "duration_minutes" => $f->get_Value("duration_minutes"),
    "requires_consent" => $f->get_Value("requires_consent"),
    "notes" => $f->get_Value("notes"),
    "created_by" => $f->get_Value("created_by"),
    "updated_by" => $f->get_Value("updated_by"),
    "deleted_by" => $f->get_Value("deleted_by"),
);
$row = $model->find($d["mstudy"]);
$l["back"]=$f->get_Value("back");
$l["edit"]="/iris/mstudies/edit/{$d["mstudy"]}";
$asuccess = "iris/mstudies-create-success-message.mp3";
$aexist = "iris/mstudies-create-exist-message.mp3";
if (is_array($row)) {
    $c= $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Iris_Mstudies.create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Iris_Mstudies.create-duplicate-message"),
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
        "title" => lang("Iris_Mstudies.create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Iris_Mstudies.create-success-message"),$d['mstudy']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" =>$asuccess,
    ));
}
echo($c);
cache()->clean();
?>
