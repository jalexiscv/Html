<?php

use App\Libraries\Bootstrap;


$authentication = service('authentication');
$model = model("App\Modules\Wallet\Models\Wallet_Transactions");
$prefix = "Transactions.";
$f = service("forms", array("lang" => "{$prefix}"));
/** request **/
$row = $model->find($id);
$r["transaction"] = $f->get_Value("transaction", $row["transaction"]);
$r["module"] = $f->get_Value("module", $row["module"]);
$r["user"] = $f->get_Value("user", $row["user"]);
$r["reference"] = $f->get_Value("reference", $row["reference"]);
$r["currency"] = $f->get_Value("currency", $row["currency"]);
$r["debit"] = $f->get_Value("debit", $row["debit"]);
$r["credit"] = $f->get_Value("credit", $row["credit"]);
$r["balance"] = $f->get_Value("balance", $row["balance"]);
$r["status"] = $f->get_Value("status", $row["status"]);
$r["author"] = $f->get_Value("author", $authentication->get_User());
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
/** fields * */
$f->fields["transaction"] = $f->get_FieldText("transaction", array("value" => $r["transaction"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["module"] = $f->get_FieldText("module", array("value" => $r["module"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["user"] = $f->get_FieldText("user", array("value" => $r["user"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["reference"] = $f->get_FieldText("reference", array("value" => $r["reference"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["currency"] = $f->get_FieldText("currency", array("value" => $r["currency"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["debit"] = $f->get_FieldText("debit", array("value" => $r["debit"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["credit"] = $f->get_FieldText("credit", array("value" => $r["credit"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["balance"] = $f->get_FieldText("balance", array("value" => $r["balance"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["status"] = $f->get_FieldText("status", array("value" => $r["status"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => "/wallet/transactions/list/", "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Update"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
/** groups * */

$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["transaction"] . $f->fields["module"] . $f->fields["user"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["reference"] . $f->fields["currency"] . $f->fields["debit"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["credit"] . $f->fields["balance"] . $f->fields["status"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["author"] . $f->fields["created_at"] . $f->fields["updated_at"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["deleted_at"])));
/** buttons **/
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
/** build **/
$b = new Bootstrap();
$card = $b->get_card("card-" . uniqid(), array(
    "title" => lang("{$prefix}edit-title"),
    "content" => $f
));
echo($card);
?>
