<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Addresses\Creator\processor.php]
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
$f = service("forms", array("lang" => "Addresses."));
$maddresses = model("App\Modules\C4isr\Models\C4isr_Addresses");
$d = array(
    "address" => $f->get_Value("address"),
    "profile" => $f->get_Value("profile"),
    "city" => $f->get_Value("city"),
    "direction" => $strings->get_URLEncode($f->get_Value("direction")),
    "reference" => $strings->get_URLEncode($f->get_Value("reference")),
    "author" => $authentication->get_User(),
);
$row = $maddresses->find($d["address"]);
$l["back"] = "/c4isr/profiles/edit/{$oid}";
$l["edit"] = "/c4isr/addresses/edit/{$d["address"]}";
if (isset($row["address"])) {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Addresses.create-duplicate-title"));
    $smarty->assign("message", lang("Addresses.create-duplicate-message"));
    $smarty->assign("continue", $l["back"]);
    $smarty->assign("voice", "c4isr/addresses-create-duplicate-message.mp3");
    $c = $smarty->view('alerts/card/warning.tpl');
} else {
    $create = $maddresses->insert($d);
    //cho($maddresses->getLastQuery()->getQuery());
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Addresses.create-success-title"));
    $smarty->assign("message", sprintf(lang("Addresses.create-success-message"), $d['address']));
    //$smarty->assign("edit", $l["edit"]);
    $smarty->assign("continue", $l["back"]);
    $smarty->assign("voice", "c4isr/addresses-create-success-message.mp3");
    $c = $smarty->view('alerts/card/success.tpl');
}
echo($c);
?>