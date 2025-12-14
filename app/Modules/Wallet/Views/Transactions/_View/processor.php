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
$f = service("forms", array("lang" => "Transactions."));
$model = model("App\Modules\Wallet\Models\Wallet_Transactions");
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
$row = $model->find($d["transaction"]);
if (isset($row["transaction"])) {
    $edit = $model->update($d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Transactions.view-success-title"));
    $smarty->assign("message", sprintf(lang("Transactions.view-success-message"), $d['transaction']));
    $smarty->assign("edit", base_url("/wallet/transactions/edit/{$d['transaction']}/" . lpk()));
    $smarty->assign("continue", base_url("/wallet/transactions/view/{$d["transaction"]}/" . lpk()));
    $smarty->assign("voice", "wallet/transactions-view-success-message.mp3");
    $c = $smarty->view('alerts/success.tpl');
} else {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Transactions.view-noexist-title"));
    $smarty->assign("message", lang("Transactions.view-noexist-message"));
    $smarty->assign("continue", base_url("/wallet/transactions"));
    $smarty->assign("voice", "wallet/transactions-view-noexist-message.mp3");
    $c = $smarty->view('alerts/warning.tpl');
}
echo($c);
?>
