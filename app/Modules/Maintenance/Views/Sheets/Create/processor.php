<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-04-08 11:56:22
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Maintenance\Views\Sheets\Creator\processor.php]
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
$f = service("forms",array("lang" => "Maintenance_Sheets."));
$model = model("App\Modules\Maintenance\Models\Maintenance_Sheets");
//[Vars]-----------------------------------------------------------------------------
$d = array(
    "sheet" => $f->get_Value("sheet"),
    "asset" => $f->get_Value("asset"),
    "name" => $f->get_Value("name"),
    "value" => $f->get_Value("value"),
    "author" => safe_get_user(),
);
$row = $model->find($d["sheet"]);
$l["back"]=$f->get_Value("back");
$l["edit"]="/maintenance/sheets/edit/{$d["sheet"]}";
$asuccess = "maintenance/sheets-create-success-message.mp3";
$aexist = "maintenance/sheets-create-exist-message.mp3";
if (is_array($row)) {
    $c= $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Maintenance_Sheets.create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Maintenance_Sheets.create-duplicate-message"),
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
        "title" => lang("Maintenance_Sheets.create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Maintenance_Sheets.create-success-message"),$d['sheet']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" =>$asuccess,
    ));
}
echo($c);
cache()->clean();
?>
