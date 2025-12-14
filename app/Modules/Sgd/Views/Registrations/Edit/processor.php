<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-03-04 15:21:07
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sgd\Views\Registrations\Editor\processor.php]
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
//$model = model("App\Modules\Sgd\Models\Sgd_Registrations");
//[Process]-----------------------------------------------------------------------------
$f = service("forms",array("lang" => "Registrations."));
$d = array(
    "registration" => $f->get_Value("registration"),
    "folios" => $f->get_Value("folios"),
    "reference" => $f->get_Value("reference"),
    "observations" => $f->get_Value("observations"),
    "date" => safe_get_date(),
    "qrcode" => $f->get_Value("qrcode"),
    "time" => safe_get_time(),
    "author" => safe_get_user(),
    "from_identification"=>$f->get_Value("from_identification"),
    "from_name"=>$f->get_Value("from_name"),
    "from_email"=>$f->get_Value("from_email"),
    "from_phone"=>$f->get_Value("from_phone"),
    "from_user"=>$f->get_Value("from_user"),
    "to_identification"=>$f->get_Value("to_identification"),
    "to_name"=>$f->get_Value("to_name"),
    "to_email"=>$f->get_Value("to_email"),
    "to_phone"=>$f->get_Value("to_phone"),
    "to_user"=>$f->get_Value("to_user"),
);
//[Elements]-----------------------------------------------------------------------------
$row = $model->find($d["registration"]);
$l["back"]="/sgd/registrations/list/".lpk();
$l["edit"]="/sgd/registrations/edit/{$d["registration"]}";
$asuccess = "sgd/registrations-edit-success-message.mp3";
$anoexist = "sgd/registrations-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
   $edit = $model->update($d['registration'],$d);
   cache()->clean();
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sgd_Registrations.edit-success-title"),
        "text-class" => "text-center",
        "text" => lang("Sgd_Registrations.edit-success-message"),
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
        "title" => lang("Sgd_Registrations.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sgd_Registrations.edit-noexist-message"),$d['registration']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
?>