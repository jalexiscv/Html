<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Causes\Creator\processor.php]
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
$f = service("forms", array("lang" => "Disa.causes-"));
$model = model("App\Modules\Disa\Models\Disa_Causes");
$d = array(
    "cause" => $f->get_Value("cause"),
    "plan" => $f->get_Value("plan"),
    "score" => $f->get_Value("score"),
    "description" => urlencode($f->get_Value("description")),
    "author" => $authentication->get_User(),
);
$row = $model->find($d["cause"]);
if (isset($row["cause"])) {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.causes-create-duplicate-title"));
    $smarty->assign("message", lang("Disa.causes-create-duplicate-message"));
    $smarty->assign("continue", base_url("/disa/mipg/plans/causes/list/{$oid}"));
    $smarty->assign("voice", "disa/causes-create-duplicate-message.mp3");
    $c = $smarty->view('alerts/warning.tpl');
} else {
    $create = $model->insert($d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.causes-create-success-title"));
    $smarty->assign("message", sprintf(lang("Disa.causes-create-success-message"), $d['cause']));
    //$smarty->assign("edit", base_url("/disa/causes/edit/{$d['cause']}/" . lpk()));
    $smarty->assign("continue", base_url("/disa/mipg/plans/causes/list/{$oid}"));
    $smarty->assign("voice", "disa/causes-create-success-message.mp3");
    $c = $smarty->view('alerts/success.tpl');
}
echo($c);
?>
