<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Vulnerabilities\Editor\processor.php]
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
//$model = model("App\Modules\C4isr\Models\C4isr_Vulnerabilities");
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Vulnerabilities."));
$d = array(
    "vulnerability" => $f->get_Value("vulnerability"),
    "mail" => $f->get_Value("mail"),
    "alias" => $f->get_Value("alias"),
    "password" => $f->get_Value("password"),
    "hash" => $f->get_Value("hash"),
    "salt" => $f->get_Value("salt"),
    "author" => $authentication->get_User(),
);
//[Elements]-----------------------------------------------------------------------------
$row = $model->find($d["vulnerability"]);
$continue = "/c4isr/vulnerabilities/list/{$d["mail"]}/";
$edit = "/c4isr/vulnerabilities/edit/{$d["vulnerability"]}/";
$asuccess = "c4isr/vulnerabilities-edit-success-message.mp3";
$anoexist = "c4isr/vulnerabilities-edit-noexist-message.mp3";
//[Build]-----------------------------------------------------------------------------
if (isset($row["vulnerability"])) {
    $edit = $model->update($d['vulnerability'], $d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Vulnerabilities.edit-success-title"));
    $smarty->assign("message", sprintf(lang("Vulnerabilities.edit-success-message"), $d['vulnerability']));
    //$smarty->assign("edit", $edit);
    $smarty->assign("continue", $continue);
    $smarty->assign("voice", $asuccess);
    $c = $smarty->view('alerts/card/success.tpl');
} else {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Vulnerabilities.edit-noexist-title"));
    $smarty->assign("message", lang("Vulnerabilities.edit-noexist-message"));
    $smarty->assign("continue", $continue);
    $smarty->assign("voice", $anoexist);
    $c = $smarty->view('alerts/card/warning.tpl');
}
echo($c);
?>