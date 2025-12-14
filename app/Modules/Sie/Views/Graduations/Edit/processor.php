<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-11-06 13:55:39
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Graduations\Editor\processor.php]
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
//$model = model("App\Modules\Sie\Models\Sie_Graduations");
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Sie_Graduations."));
$d = array(
    "graduation" => $f->get_Value("graduation"),
    "city" => $f->get_Value("city"),
    "date" => $f->get_Value("date"),
    "application_type" => $f->get_Value("application_type"),
    "full_name" => $f->get_Value("full_name"),
    "document_type" => $f->get_Value("document_type"),
    "document_number" => $f->get_Value("document_number"),
    "expedition_place" => $f->get_Value("expedition_place"),
    "address" => $f->get_Value("address"),
    "phone_1" => $f->get_Value("phone_1"),
    "email" => $f->get_Value("email"),
    "phone_2" => $f->get_Value("phone_2"),
    "degree" => $f->get_Value("degree"),
    "doc_id" => $f->get_Value("doc_id"),
    "highschool_diploma" => $f->get_Value("highschool_diploma"),
    "highschool_graduation_act" => $f->get_Value("highschool_graduation_act"),
    "icfes_results" => $f->get_Value("icfes_results"),
    "saber_pro" => $f->get_Value("saber_pro"),
    "academic_clearance" => $f->get_Value("academic_clearance"),
    "financial_clearance" => $f->get_Value("financial_clearance"),
    "graduation_fee_receipt" => $f->get_Value("graduation_fee_receipt"),
    "graduation_request" => $f->get_Value("graduation_request"),
    "admin_graduation_request" => $f->get_Value("admin_graduation_request"),
    "ac" => $f->get_Value("ac"),
    "ac_score" => $f->get_Value("ac_score"),
    "ek" => $f->get_Value("ek"),
    "ek_score" => $f->get_Value("ek_score"),
    "status" => $f->get_Value("status"),
    "author" => safe_get_user(),
);
//[Elements]-----------------------------------------------------------------------------
$row = $model->find($d["graduation"]);
$l["back"] = "/sie/graduations/list/" . lpk();
$l["edit"] = "/sie/graduations/edit/{$d["graduation"]}";
$asuccess = "sie/graduations-edit-success-message.mp3";
$anoexist = "sie/graduations-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
    $edit = $model->update($d['graduation'], $d);
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Graduations.edit-success-title"),
        "text-class" => "text-center",
        "text" => lang("Sie_Graduations.edit-success-message"),
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
        "title" => lang("Sie_Graduations.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sie_Graduations.edit-noexist-message"), $d['graduation']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
?>