<?php
$mcountries = model('App\Modules\C4isr\Models\C4isr_Countries');
$f = service("forms", array("lang" => "Phones."));
//[Requests]------------------------------------------------------------------------------------------------------------
$r["phone"] = $f->get_Value("phone", pk());
$r["profile"] = $f->get_Value("profile", $oid);
$r["country_code"] = $f->get_Value("country_code", '57');
$r["area_code"] = $f->get_Value("area_code");
$r["local_number"] = $f->get_Value("local_number");
$r["extension"] = $f->get_Value("extension");
$r["type"] = $f->get_Value("type");
$r["carrier"] = $f->get_Value("carrier");
$r["normalized_number"] = $f->get_Value("normalized_number");
$r["author"] = $f->get_Value("author", $authentication->get_User());
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
$countries = $mcountries->get_SelectCountryCodes();
$back = "/c4isr/profiles/edit/{$oid}";
$types = array(
    array("value" => "M", "label" => "Mobile"),
    array("value" => "L", "label" => "Landline"),
    array("value" => "F", "label" => "Fax"),
);
//[Fields]--------------------------------------------------------------------------------------------------------------
$f->fields["phone"] = $f->get_FieldText("phone", array("value" => $r["phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", 'readonly' => true));
$f->fields["profile"] = $f->get_FieldText("profile", array("value" => $r["profile"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", 'readonly' => true));
$f->fields["country_code"] = $f->get_FieldSelect("country_code", array("selected" => $r["country_code"], "data" => $countries, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["area_code"] = $f->get_FieldText("area_code", array("value" => $r["area_code"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["local_number"] = $f->get_FieldText("local_number", array("value" => $r["local_number"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["extension"] = $f->get_FieldText("extension", array("value" => $r["extension"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["type"] = $f->get_FieldSelect("type", array("selected" => $r["type"], "data" => $types, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["carrier"] = $f->get_FieldText("carrier", array("value" => $r["carrier"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["normalized_number"] = $f->get_FieldText("normalized_number", array("value" => $r["normalized_number"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[Groups]--------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["phone"] . $f->fields["profile"] . $f->fields["country_code"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["area_code"] . $f->fields["local_number"] . $f->fields["extension"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["type"] . $f->fields["carrier"] . $f->fields["normalized_number"])));
//[Buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[Build]---------------------------------------------------------------------------------------------------------------
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("type", "normal");
$smarty->assign("header", lang("Phones.create-title"));
$smarty->assign("header_back", $back);
$smarty->assign("body", $f);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));
?>