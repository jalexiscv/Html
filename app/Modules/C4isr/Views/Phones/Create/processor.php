<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Phones\Creator\processor.php]
*  ╩ ╩╝╚╝╚═╝╚═╝╩╚═╝╩═╝╚═╝
* -----------------------------------------------------------------------------
* Copyright 2021 - Higgs Bigdata S.A.S., Inc. <admin@Higgs.com>
* Este archivo es parte de Higgs Bigdata Framework 7.1
* Para obtener información completa sobre derechos de autor y licencia, consulte
* la LICENCIA archivo que se distribuyó con este código fuente.
* -----------------------------------------------------------------------------
* EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
* IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
* APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
* LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
* RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
* AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
* O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
* -----------------------------------------------------------------------------
* @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
* @link https://www.Higgs.com
* @Version 1.5.0
* @since PHP 7, PHP 8
* -----------------------------------------------------------------------------
* Datos recibidos desde el controlador - @ModuleController
* -----------------------------------------------------------------------------
* @Authentication
* @request
* @dates
* @view
* @oid
* @component
* @views
* @prefix
* @parent
* -----------------------------------------------------------------------------
*/
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Phones."));
$mphones = model("App\Modules\C4isr\Models\C4isr_Phones");
$d = array(
    "phone" => $f->get_Value("phone"),
    "profile" => $f->get_Value("profile"),
    "country_code" => $f->get_Value("country_code"),
    "area_code" => $f->get_Value("area_code"),
    "local_number" => $f->get_Value("local_number"),
    "extension" => $f->get_Value("extension"),
    "type" => $f->get_Value("type"),
    "carrier" => $f->get_Value("carrier"),
    "normalized_number" => $f->get_Value("normalized_number"),
    "author" => $authentication->get_User(),
);
$sufix = substr($d['normalized_number'], 0, 5);
$mphones->setTable("c4isr_phones_{$sufix}");
$mphones->regenerate();

$row = $mphones->find($d["phone"]);
$l["back"] = "/c4isr/profiles/edit/{$oid}";
$l["edit"] = "/c4isr/phones/edit/{$d["phone"]}";
if (isset($row["phone"])) {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Phones.create-duplicate-title"));
    $smarty->assign("message", lang("Phones.create-duplicate-message"));
    $smarty->assign("continue", $l["back"]);
    $smarty->assign("voice", "c4isr/phones-create-duplicate-message.mp3");
    $c = $smarty->view('alerts/card/warning.tpl');
} else {
    $create = $mphones->insert($d);
    //cho($mphones->getLastQuery()->getQuery());
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Phones.create-success-title"));
    $smarty->assign("message", sprintf(lang("Phones.create-success-message"), $d['phone']));
    //$smarty->assign("edit", $l["edit"]);
    $smarty->assign("continue", $l["back"]);
    $smarty->assign("voice", "c4isr/phones-create-success-message.mp3");
    $c = $smarty->view('alerts/card/success.tpl');
}
echo($c);
?>
