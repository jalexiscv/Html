<?php
$f = service("forms", array("lang" => "Nexus."));
//[Models]--------------------------------------------------------------------------------------------------------------
$model = model("App\Modules\Nexus\Models\Nexus_Clients", true, $conexion);
//[Query]---------------------------------------------------------------------------------------------------------------
$r = $model->find($oid);
$r["name"] = urldecode(@$r["name"]);
$r["theme_color"] = $f->get_Value("theme_color", @$r["theme_color"]);
//[Datas]---------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("option", "images");
$f->add_HiddenField("author", @$r["author"]);
$f->add_HiddenField("client", @$r["client"]);
//[Fields]--------------------------------------------------------------------------------------------------------------
$f->fields["logo"] = $f->get_FieldFile("logo", array("value" => $r["logo"]));
$f->fields["logo_portrait"] = $f->get_FieldFile("logo_portrait", array("value" => $r["logo_portrait"]));
$f->fields["logo_portrait_light"] = $f->get_FieldFile("logo_portrait_light", array("value" => $r["logo_portrait_light"]));
$f->fields["logo_landscape"] = $f->get_FieldFile("logo_landscape", array("value" => $r["logo_landscape"]));
$f->fields["logo_landscape_light"] = $f->get_FieldFile("logo_landscape_light", array("value" => $r["logo_landscape_light"]));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => "/nexus/clients/list/" . lpk(), "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Update"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[Groups]--------------------------------------------------------------------------------------------------------------
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["logo"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["logo_portrait"] . $f->fields["logo_portrait_light"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["logo_landscape"] . $f->fields["logo_landscape_light"])));
//[Buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[Build]---------------------------------------------------------------------------------------------------------------
echo($f);
?>