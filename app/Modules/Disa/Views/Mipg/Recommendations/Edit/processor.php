<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Recommendations\Editor\processor.php]
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
$f = service("forms", array("lang" => "Disa.recommendations-"));
$model = model("App\Modules\Disa\Models\Disa_Recommendations");
$d = array(
    "recommendation" => $f->get_Value("recommendation"),
    "dimension" => $f->get_Value("dimension"),
    "politic" => $f->get_Value("politic"),
    "description" => $f->get_Value("description"),
    "author" => $authentication->get_User(),
);


$row = $model->find($d["recommendation"]);
$continue = "/disa/mipg/recommendations/list/{$row["reference"]}/" . lpk();
if (isset($row["recommendation"])) {
    $edit = $model->update($d['recommendation'], $d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.recommendations-edit-success-title"));
    $smarty->assign("message", sprintf(lang("Disa.recommendations-edit-success-message"), $d['recommendation']));
    //$smarty->assign("edit", base_url("/disa/recommendations/edit/{$d['recommendation']}/" . lpk()));
    $smarty->assign("continue", $continue);
    $smarty->assign("voice", "disa/recommendations-edit-success-message.mp3");
    $c = $smarty->view('alerts/card/success.tpl');
} else {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.recommendations-edit-noexist-title"));
    $smarty->assign("message", lang("Disa.recommendations-edit-noexist-message"));
    $smarty->assign("continue", $continue);
    $smarty->assign("voice", "disa/recommendations-edit-noexist-message.mp3");
    $c = $smarty->view('alerts/card/warning.tpl');
}
echo($c);
?>
