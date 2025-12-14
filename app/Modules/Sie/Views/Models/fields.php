<?php
$mcountries = model("App\Modules\Sie\Models\Sie_Countries");
$list_countries=$mcountries->get_SelectData();
$f->add_HiddenField("back",$back);
$f->fields["model"] = $f->get_FieldText("model", array("value" => $r["model"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12","readonly"=>true));
$f->fields["code"] = $f->get_FieldText("code", array("value" => $r["code"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["name"] = $f->get_FieldText("name", array("value" => $r["name"],"proportion"=>"col-12"));
$f->fields["description"] = $f->get_FieldTextArea("description", array("value" => $r["description"],"proportion"=>"col-12"));
$f->fields["country"] = $f->get_FieldSelect("country", array("selected" => $r["country"],"data"=>$list_countries,"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["regulatory_framework"] = $f->get_FieldText("regulatory_framework", array("value" => $r["regulatory_framework"],"proportion"=>"col-12"));
$f->fields["uses_credits"] = $f->get_FieldSelect("uses_credits", array("selected" => $r["uses_credits"],"data"=>LIST_YN,"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["hours_per_credit"] = $f->get_FieldText("hours_per_credit", array("value" => $r["hours_per_credit"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["credit_calculation_formula"] = $f->get_FieldText("credit_calculation_formula", array("value" => $r["credit_calculation_formula"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["requires_theoretical_hours"] = $f->get_FieldSelect("requires_theoretical_hours", array("selected" => $r["requires_theoretical_hours"],"data"=>LIST_YN,"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["requires_practical_hours"] = $f->get_FieldSelect("requires_practical_hours", array("selected" => $r["requires_practical_hours"],"data"=>LIST_YN,"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["requires_independent_hours"] = $f->get_FieldSelect("requires_independent_hours", array("selected" => $r["requires_independent_hours"],"data"=>LIST_YN,"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["requires_total_hours"] = $f->get_FieldSelect("requires_total_hours", array("selected" => $r["requires_total_hours"],"data"=>LIST_YN,"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["validation_rules"] = $f->get_FieldTextArea("validation_rules", array("value" => $r["validation_rules"],"proportion"=>"col-12"));
$f->fields["configuration"] = $f->get_FieldTextArea("configuration", array("value" => $r["configuration"],"proportion"=>"col-12"));
$f->fields["is_active"] = $f->get_FieldSelect("is_active", array("selected" => $r["is_active"],"data"=>LIST_YN,"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"]=$f->get_Cancel("cancel", array("href" =>$back,"text" =>lang("App.Cancel"),"type"=>"secondary","proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] =$f->get_Submit("submit", array("value" =>lang("App.Edit"),"proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
?>