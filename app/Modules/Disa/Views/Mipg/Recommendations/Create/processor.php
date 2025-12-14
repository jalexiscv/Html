<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Recommendations\Creator\processor.php]
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
$strings = service("strings");

$f = service("forms", array("lang" => "Disa.recommendations-"));
$model = model("App\Modules\Disa\Models\Disa_Recommendations");


$description = $strings->get_Clear($f->get_Value("description"));
$description = urlencode($description);

$d = array(
    "recommendation" => $f->get_Value("recommendation"),
    "reference" => $f->get_Value("reference"),
    "dimension" => $f->get_Value("dimension"),
    "politic" => $f->get_Value("politic"),
    "description" => $description,
    "author" => $authentication->get_User(),
);
$row = $model->find($d["recommendation"]);
$continue = base_url("/disa/mipg/recommendations/list/{$d["reference"]}/" . lpk());
if (isset($row["recommendation"])) {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.recommendations-create-duplicate-title"));
    $smarty->assign("message", lang("Disa.recommendations-create-duplicate-message"));
    $smarty->assign("continue", $continue);
    $smarty->assign("voice", "disa/recommendations-create-duplicate-message.mp3");
    $c = $smarty->view('alerts/card/warning.tpl');
} else {
    $create = $model->insert($d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.recommendations-create-success-title"));
    $smarty->assign("message", sprintf(lang("Disa.recommendations-create-success-message"), $d['recommendation']));
    //$smarty->assign("edit", base_url("/disa/recommendations/edit/{$d['recommendation']}/" . lpk()));
    $smarty->assign("continue", $continue);
    $smarty->assign("voice", "disa/recommendations-create-success-message.mp3");
    $c = $smarty->view('alerts/card/success.tpl');
}
echo($c);
?>
