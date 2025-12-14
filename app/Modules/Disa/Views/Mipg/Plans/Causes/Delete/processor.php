<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Causes\Editor\processor.php]
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
$mcauses = model("App\Modules\Disa\Models\Disa_Causes");
$mscores = model('App\Modules\Disa\Models\Disa_Causes_Scores');

$pkey = $f->get_Value("pkey");
$row = $mcauses->find($pkey);
if (isset($row["cause"])) {
    $mcauses->delete($pkey);
    $mscores->where("cause", $row["cause"])->delete();
    //$mcauses->purgeDeleted();
    //$mscores->purgeDeleted();

    /* Calc */
    $subtotals = array();
    $causes = $mcauses->where("plan", $row["plan"])->findAll();
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

    foreach ($causes as $cause) {
        $subtotal = $subtotals[$cause["cause"]]["subtotal"];
        if ($total > 0) {
            $subtotals[$cause["cause"]]["percentaje"] = $subtotal / $total;
        } else {
            $subtotals[$cause["cause"]]["percentaje"] = 0;
        }
        $update = $mcauses->update($cause["cause"], array("score" => $subtotals[$cause["cause"]]["percentaje"]));
    }

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.causes-delete-success-title"));
    $smarty->assign("message", sprintf(lang("Disa.causes-delete-success-message"), $row['cause']));
    $smarty->assign("continue", base_url("/disa/mipg/plans/causes/list/{$row["plan"]}"));
    $smarty->assign("voice", "disa/causes-delete-success-message.mp3");
    $c = $smarty->view('alerts/success.tpl');
} else {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.causes-delete-noexist-title"));
    $smarty->assign("message", lang("Disa.causes-delete-noexist-message"));
    $smarty->assign("continue", base_url("/disa/mipg/plans/causes/list/{$row["plan"]}"));
    $smarty->assign("voice", "disa/causes-delete-noexist-message.mp3");
    $c = $smarty->view('alerts/warning.tpl');
}
echo($c);

?>