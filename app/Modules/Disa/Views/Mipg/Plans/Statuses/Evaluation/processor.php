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

$back = "/disa/mipg/plans/view/{$oid}";

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
$row = $mstatuses->find($d["status"]);
if (isset($row["status"])) {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.statuses-approval-request-duplicate-title"));
    $smarty->assign("message", lang("Disa.statuses-approval-request-duplicate-message"));
    $smarty->assign("continue", $back);
    $smarty->assign("voice", "disa/statuses-approval-request-duplicate-message.mp3");
    $c = $smarty->view('alerts/warning.tpl');
} else {
    $create = $mstatuses->insert($d);
    $actions = $mactions->where("plan", $oid)->find();
    if ($d["value"] == "COMPLETED") {
        foreach ($actions as $action) {
            $mstatuses->insert(array("status" => pk(), "object" => $action["action"], "value" => "FINISHED", "observations" => "Estado automático", "author" => $authentication->get_User()));
        }
    } else {
        foreach ($actions as $action) {
            $mstatuses->insert(array("status" => pk(), "object" => $action["action"], "value" => "COMPLETED", "observations" => "Estado automático", "author" => $authentication->get_User()));
        }
    }

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    if ($d["value"] == "COMPLETED") {
        $smarty->assign("title", lang("Disa.statuses-evaluation-completed-success-title"));
        $smarty->assign("message", sprintf(lang("Disa.statuses-evaluation-completed-success-message"), $d['status']));
        $smarty->assign("voice", "disa/statuses-evaluation-completed-success-message.mp3");
    } else {
        $smarty->assign("title", lang("Disa.statuses-evaluation-notcompleted-success-title"));
        $smarty->assign("message", sprintf(lang("Disa.statuses-evaluation-notcompleted-success-message"), $d['status']));
        $smarty->assign("voice", "disa/statuses-evaluation-notcompleted-success-message.mp3");
    }
    $smarty->assign("continue", $back);
    $c = $smarty->view('alerts/card/success.tpl');
}
echo($c);

?>