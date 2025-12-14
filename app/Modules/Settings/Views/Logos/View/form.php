<?php
//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$server = service("server");
$domain = $server::get_FullName();
$f = service("forms", array("lang" => "Settings_Logotypes."));
//[vars]----------------------------------------------------------------------------------------------------------------
$clients = model("App\Modules\Settings\Models\Settings_Clients");
$row = $clients->get_ClientByDomain($domain);
$r["logo"] = cdn_url(@$row["logo"]);
$r["logo_portrait"] = cdn_url(@$row["logo_portrait"]);
$r["logo_landscape"] = cdn_url(@$row["logo_landscape"]);
$r["logo_portrait_light"] = cdn_url(@$row["logo_portrait_light"]);
$r["logo_landscape_light"] = cdn_url(@$row["logo_landscape_light"]);

$r["setting"] = @$row["setting"];
$r["name"] = @$row["name"];
$r["value"] = @$row["value"];
$r["author"] = @$row["author"];
$r["created_at"] = @$row["created_at"];
$r["updated_at"] = @$row["updated_at"];
$r["deleted_at"] = @$row["deleted_at"];
//[Fields]--------------------------------------------------------------------------------------------------------------
$f->fields["logo"] = $f->get_FieldViewImage("logo", array("value" => $r["logo"]));
$f->fields["logo_portrait"] = $f->get_FieldViewImage("logo_portrait", array("value" => $r["logo_portrait"]));
$f->fields["logo_portrait_light"] = $f->get_FieldViewImage("logo_portrait_light", array("value" => $r["logo_portrait_light"]));
$f->fields["logo_landscape"] = $f->get_FieldViewImage("logo_landscape", array("value" => $r["logo_landscape"]));
$f->fields["logo_landscape_light"] = $f->get_FieldViewImage("logo_landscape_light", array("value" => $r["logo_landscape_light"]));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => "/settings", "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Button("edit", array("href" => "/settings/logos/edit/" . lpk(), "text" => lang("App.Edit"), "class" => "btn btn-secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
//[Groups]--------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["logo"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["logo_portrait"] . $f->fields["logo_portrait_light"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["logo_landscape"] . $f->fields["logo_landscape_light"])));
//[Buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-logotypes", array(
    "title" => lang("Settings_Logotypes.logotypes-view-title"),
    "header-back" => "/settings/",
    "content" => $f
));
//[print]---------------------------------------------------------------------------------------------------------------
echo($card);
?>