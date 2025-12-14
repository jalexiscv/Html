<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Statuses\Editor\processor.php]
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
$f = service("forms", array("lang" => "Disa.statuses-"));
$model = model("App\Modules\Disa\Models\Disa_Statuses");
$d = array(
    "status" => $f->get_Value("status"),
    "object" => $f->get_Value("object"),
    "value" => $f->get_Value("value"),
    "observations" => $f->get_Value("observations"),
    "author" => $authentication->get_User(),
);
/* Elements */
$row = $model->find($d["status"]);
$continue = "/disa/statuses/list/{$d["object"]}/";
$edit = "/disa/statuses/edit/{$d["status"]}/";
$asuccess = "disa/statuses-edit-success-message.mp3";
$anoexist = "disa/statuses-edit-noexist-message.mp3";
/* Build */
if (isset($row["status"])) {
    $edit = $model->update($d['status'], $d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.statuses-edit-success-title"));
    $smarty->assign("message", sprintf(lang("Disa.statuses-edit-success-message"), $d['status']));
    //$smarty->assign("edit", $edit);
    $smarty->assign("continue", $continue);
    $smarty->assign("voice", $asuccess);
    $c = $smarty->view('alerts/success.tpl');
} else {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.statuses-edit-noexist-title"));
    $smarty->assign("message", lang("Disa.statuses-edit-noexist-message"));
    $smarty->assign("continue", $continue);
    $smarty->assign("voice", $anoexist);
    $c = $smarty->view('alerts/warning.tpl');
}
echo($c);
?>