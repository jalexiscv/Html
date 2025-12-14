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
$mcauses = model('App\Modules\Disa\Models\Disa_Causes');
$mscores = model('App\Modules\Disa\Models\Disa_Causes_Scores');
/** Fields * */
$plan = $f->get_Value("plan");
$author = $authentication->get_User();
$values = $f->get_Value("value");

foreach ($values as $key => $value) {
    $mscores->where("cause", $key)->where("author", $author)->delete();
    $create = $mscores->insert(array("score" => pk(), "cause" => $key, "value" => $value, "author" => $author));
}

$mscores->purgeDeleted();

$subtotals = array();
$causes = $mcauses->where("plan", $plan)->findAll();
foreach ($causes as $cause) {
    $scores = $mscores->where("cause", $cause["cause"])->find();
    $sum = 0;
    foreach ($scores as $score) {
        $sum += $score["value"];
    }
    $subtotals[$cause["cause"]]["subtotal"] = $sum;
}

$total = 0;
foreach ($subtotals as $subtotal) {
    $total += $subtotal["subtotal"];
}

//echo("<br>Total: ".$total);

foreach ($causes as $cause) {
    $subtotal = $subtotals[$cause["cause"]]["subtotal"];
    $subtotals[$cause["cause"]]["percentaje"] = $subtotal / $total;
    $update = $mcauses->update($cause["cause"], array("score" => $subtotals[$cause["cause"]]["percentaje"]));
}


$link["continue"] = "/disa/mipg/plans/causes/list/{$oid}";


$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("title", lang("Disa.causes-evaluate-success-title"));
$smarty->assign("message", sprintf(lang("Disa.causes-evaluate-success-message"), ""));
//$smarty->assign("edit", base_url("/disa/causes/edit/{$d['cause']}/" . lpk()));
$smarty->assign("continue", base_url($link["continue"]));
$smarty->assign("voice", "disa/causes-create-success-message.mp3");
$c = $smarty->view('alerts/success.tpl');

echo($c);

?>