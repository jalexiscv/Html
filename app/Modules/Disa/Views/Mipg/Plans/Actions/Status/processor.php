<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Statuses\Creator\processor.php]
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
$mactions = model("App\Modules\Disa\Models\Disa_Actions");

$f = service("forms", array("lang" => "Disa.statuses-"));
$mstatuses = model("App\Modules\Disa\Models\Disa_Statuses");
$mactions = model('App\Modules\Disa\Models\Disa_Actions');

$d = array(
    "status" => $f->get_Value("status"),
    "object" => $f->get_Value("object"),
    "value" => $f->get_Value("value"),
    "observations" => urlencode($f->get_Value("observations")),
    "author" => $authentication->get_User(),
);

$action = $mactions->find($d["object"]);
$back = "/disa/mipg/plans/actions/list/{$action["plan"]}";

$row = $mstatuses->find($d["status"]);
if (isset($row["status"])) {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.actions-status-edit-duplicate-title"));
    $smarty->assign("message", lang("Disa.actions-status-edit-duplicate-message"));
    $smarty->assign("continue", $back);
    $smarty->assign("voice", "disa/statuses-approval-request-duplicate-message.mp3");
    $c = $smarty->view('alerts/card/warning.tpl');
} else {
    $create = $mstatuses->insert($d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.actions-status-edit-success-title"));
    $smarty->assign("message", sprintf(lang("Disa.actions-status-edit-success-message"), $d['status']));
    //$smarty->assign("edit", base_url("/disa/statuses/edit/{$d['status']}/" . lpk()));
    $smarty->assign("continue", $back);
    $smarty->assign("voice", "disa/actions-status-edit-success-message.mp3");
    $c = $smarty->view('alerts/card/success.tpl');
}
echo($c);

?>