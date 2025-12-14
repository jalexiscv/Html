<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Wallet\Views\Transactions\Editor\processor.php]
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
//$model = model("App\Modules\Wallet\Models\Wallet_Transactions");
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Transactions."));
$d = array(
    "transaction" => $f->get_Value("transaction"),
    "module" => $f->get_Value("module"),
    "user" => $f->get_Value("user"),
    "reference" => $f->get_Value("reference"),
    "description" => $f->get_Value("description"),
    "currency" => $f->get_Value("currency"),
    "debit" => $f->get_Value("debit"),
    "credit" => $f->get_Value("credit"),
    "balance" => $f->get_Value("balance"),
    "status" => $f->get_Value("status"),
    "author" => $authentication->get_User(),
);
//[Elements]-----------------------------------------------------------------------------
$row = $model->find($d["transaction"]);
$continue = "/wallet/transactions/list/{$d["module"]}/";
$edit = "/wallet/transactions/edit/{$d["transaction"]}/";
$asuccess = "wallet/transactions-edit-success-message.mp3";
$anoexist = "wallet/transactions-edit-noexist-message.mp3";
//[Build]-----------------------------------------------------------------------------
if (isset($row["transaction"])) {
    $edit = $model->update($d['transaction'], $d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Transactions.edit-success-title"));
    $smarty->assign("message", sprintf(lang("Transactions.edit-success-message"), $d['transaction']));
    //$smarty->assign("edit", $edit);
    $smarty->assign("continue", $continue);
    $smarty->assign("voice", $asuccess);
    $c = $smarty->view('alerts/card/success.tpl');
} else {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Transactions.edit-noexist-title"));
    $smarty->assign("message", lang("Transactions.edit-noexist-message"));
    $smarty->assign("continue", $continue);
    $smarty->assign("voice", $anoexist);
    $c = $smarty->view('alerts/card/warning.tpl');
}
echo($c);
?>