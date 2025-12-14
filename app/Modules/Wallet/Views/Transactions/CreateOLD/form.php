<?php

use App\Libraries\Bootstrap;


$authentication = service('authentication');
$prefix = "Wallet.Transactions";
$f = service("forms", array("lang" => "{$prefix}-"));
/** request **/
$r["transaction"] = $f->get_Value("transaction", pk());
$r["module"] = $f->get_Value("module", "WALLET");
$r["user"] = $f->get_Value("user");
$r["reference"] = $f->get_Value("reference");
$r["currency"] = $f->get_Value("currency");
$r["debit"] = $f->get_Value("debit", "0.0");
$r["credit"] = $f->get_Value("credit", "0.0");
$r["balance"] = $f->get_Value("balance");
$r["status"] = $f->get_Value("status");
$r["author"] = $f->get_Value("author", $authentication->get_User());
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
$mcurrencies = model('App\Modules\Wallet\Models\Wallet_Currencies');
$currencies = $mcurrencies->get_SelectData();
$statuses = array(
    array("label" => "EN PROCESO", "value" => "inprocess"),
    array("label" => "RECHAZADA", "value" => "rejected"),
    array("label" => "FINALIZADA", "value" => "finished"),
);


/** fields * */
$f->fields["transaction"] = $f->get_FieldText("transaction", array("value" => $r["transaction"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["module"] = $f->get_FieldText("module", array("value" => $r["module"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["user"] = $f->get_FieldDropdown("user", array("value" => $r["user"], "json" => "/wallet/acounts/ajax/users", "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
$f->fields["reference"] = $f->get_FieldText("reference", array("value" => $r["reference"], "proportion" => "col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12"));
$f->fields["currency"] = $f->get_FieldSelect("currency", array("value" => $r["currency"], "data" => $currencies, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["debit"] = $f->get_FieldMoney("debit", array("value" => $r["debit"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["credit"] = $f->get_FieldMoney("credit", array("value" => $r["credit"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["balance"] = $f->get_FieldText("balance", array("value" => $r["balance"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["status"] = $f->get_FieldSelect("status", array("value" => $r["status"], "data" => $statuses, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => "/wallet/transactions/list/", "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
/** groups * */

$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["transaction"] . $f->fields["module"] . $f->fields["status"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["user"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["reference"] . $f->fields["currency"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["debit"] . $f->fields["credit"] . $f->fields["balance"])));
/** buttons **/
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
/** build **/
$b = new Bootstrap();
$card = $b->get_card("card-" . uniqid(), array(
    "title" => lang("{$prefix}-create-title"),
    "content" => $f
));
echo($card);
?>
