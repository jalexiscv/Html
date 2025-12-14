<?php
$f = service("forms", array("lang" => "Disa.institutionality-committee-upload-"));
//[Request]-------------------------------------------------------------------------------------------------------------
$r["attachment"] = $f->get_Value("attachment", pk());
$r["object"] = $f->get_Value("object", $oid);
$r["file"] = $f->get_Value("file");
$back = '/disa/mipg/scores/edit/' . $oid;
//[Fields]--------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("object", $r["object"]);
$f->fields["attachment"] = $f->get_FieldText("attachment", array("value" => $r["attachment"], "proportion" => "col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12", "readonly" => true));
$f->fields["file"] = $f->get_FieldFile("file", array("value" => $r["file"], "proportion" => "col-xxl-9 col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Upload"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[Groups]--------------------------------------------------------------------------------------------------------------
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["attachment"] . $f->fields["file"])));
//$f->groups["g2"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["name"].$f->fields["description"])));
//[Buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[Build]---------------------------------------------------------------------------------------------------------------
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("type", "uploader");
$smarty->assign("header", lang("Disa.institutionality-committee-upload-title"));
$smarty->assign("header_back", $back);
$smarty->assign("message", lang("Scores.evidences-upload-message"));
$smarty->assign("body", $f);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));
?>