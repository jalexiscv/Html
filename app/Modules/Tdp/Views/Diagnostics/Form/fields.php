<?php
$f->fields["diagnostic"] = $f->get_FieldText("diagnostic", array("value" => $r["diagnostic"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => "readonly"));
$f->fields["line"] = $f->get_FieldText("line", array("value" => $r["line"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => "readonly"));
$f->fields["order"] = $f->get_FieldNumber("order", array("value" => $r["order"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["version"] = $f->get_FieldNumber("version", array("value" => $r["version"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["name"] = $f->get_FieldText("name", array("value" => $r["name"], "proportion" => "col-12"));
$f->fields["description"] = $f->get_FieldCKEditor("description", array("value" => $r["description"], "proportion" => "col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
?>