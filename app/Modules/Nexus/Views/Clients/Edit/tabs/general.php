<?php
$f = service("forms", array("lang" => "Nexus."));
$model = model("App\Modules\Nexus\Models\Nexus_Clients", true, $conexion);
$r = $model->find($oid);
$r["name"] = urldecode(@$r["name"]);
/** fields * */
$f->add_HiddenField("option", "profile");
$f->add_HiddenField("author", @$r["author"]);
$f->fields["client"] = $f->get_FieldText("client", array("value" => @$r["client"], "readonly" => true));
$f->fields["name"] = $f->get_FieldText("name", array("value" => $r["name"]));
$f->fields["domain"] = $f->get_FieldText("domain", array("value" => $r["domain"]));
$f->fields["default_url"] = $f->get_FieldText("default_url", array("value" => $r["default_url"]));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => "/nexus/clients/list/" . lpk(), "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Update"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
/** groups * */
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["client"] . $f->fields["name"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["domain"] . $f->fields["default_url"])));
/** buttons **/
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
echo($f);
?>