<?php

$f = service("forms", array("lang" => "Nexus."));
$model = model("App\Modules\Nexus\Models\Nexus_Clients", true, $conexion);
$r = $model->find($oid);
$r["name"] = urldecode(@$r["name"]);
$r["theme_color"] = $f->get_Value("theme_color", @$r["theme_color"]);
/** fields * */
$f->add_HiddenField("client", @$r["client"]);
$f->add_HiddenField("option", "database");
$f->add_HiddenField("author", @$r["author"]);

$f->fields["db"] = $f->get_FieldText("db", array("value" => $r["db"]));
$f->fields["db_host"] = $f->get_FieldText("db_host", array("value" => $r["db_host"]));
$f->fields["db_port"] = $f->get_FieldText("db_port", array("value" => $r["db_port"]));
$f->fields["db_user"] = $f->get_FieldText("db_user", array("value" => $r["db_user"]));
$f->fields["db_password"] = $f->get_FieldText("db_password", array("value" => $r["db_password"]));


$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => "/nexus/clients/list/" . lpk(), "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Update"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
/** groups * */
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["db"] . $f->fields["db_host"] . $f->fields["db_port"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["db_user"] . $f->fields["db_password"])));
/** buttons **/
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));

echo($f);
?>