<?php

use App\Libraries\Bootstrap;


$authentication = service('authentication');
$model = model("App\Modules\Wallet\Models\Wallet_Currencies");
$prefix = "Wallet.Currencies-";
$f = service("forms", array("lang" => "{$prefix}"));
/** request **/
$row = $model->find($id);
$r["currency"] = $f->get_Value("currency", $row["currency"]);
$r["name"] = $f->get_Value("name", urldecode($row["name"]));
$r["abbreviation"] = $f->get_Value("abbreviation", $row["abbreviation"]);
$r["icon"] = $f->get_Value("icon", $row["icon"]);
$r["author"] = $f->get_Value("author", $authentication->get_User());
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
/** fields * */
$f->fields["currency"] = $f->get_FieldText("currency", array("value" => $r["currency"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["name"] = $f->get_FieldText("name", array("value" => $r["name"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["abbreviation"] = $f->get_FieldText("abbreviation", array("value" => $r["abbreviation"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["icon"] = $f->get_FieldFile("icon", array("value" => $r["icon"], "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => "/wallet/currencies/list/", "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Update"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
/** groups * */
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["currency"] . $f->fields["name"] . $f->fields["abbreviation"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["icon"])));
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
