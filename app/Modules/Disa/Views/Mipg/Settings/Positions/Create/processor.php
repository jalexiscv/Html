<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Positions\Creator\processor.php]
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
$f = service("forms", array("lang" => "Disa.positions-"));
$model = model("App\Modules\Disa\Models\Disa_Positions");
$d = array(
    "position" => $f->get_Value("position"),
    "subprocess" => $f->get_Value("subprocess"),
    "name" => urlencode($f->get_Value("name")),
    "responsible" => $f->get_Value("responsible"),
    "author" => $authentication->get_User(),
    "phone" => $f->get_Value("phone"),
    "email" => $f->get_Value("email"),
);
$row = $model->find($d["position"]);
if (isset($row["position"])) {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.positions-create-duplicate-title"));
    $smarty->assign("message", lang("Disa.positions-create-duplicate-message"));
    $smarty->assign("continue", base_url("/disa/positions"));
    $smarty->assign("voice", "disa/positions-create-duplicate-message.mp3");
    $c = $smarty->view('alerts/card/warning.tpl');
} else {
    $create = $model->insert($d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.positions-create-success-title"));
    $smarty->assign("message", sprintf(lang("Disa.positions-create-success-message"), $d['position']));
    //$smarty->assign("edit", base_url("/disa/positions/edit/{$d['client']}/" . lpk()));
    $smarty->assign("continue", base_url("/disa/settings/positions/list/{$d["position"]}/" . lpk()));
    $smarty->assign("voice", "disa/positions-create-success-message.mp3");
    $c = $smarty->view('alerts/card/success.tpl');
    /** Logger **/
    history_logger(array(
        "log" => pk(),
        "module" => "DISA",
        "author" => $authentication->get_User(),
        "description" => "Creo un nuevo cargo <a target=\"_blank\" href=\"/disa/settings/positions/view/" . lpk() . "\">" . $d["name"] . "</a>.",
        "code" => "",
    ));
}
echo($c);
?>
