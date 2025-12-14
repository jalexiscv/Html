<?php

//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Sie_Certificates."));
$server = service("server");
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sie\Models\Sie_Certificates");
$mformats = model('App\Modules\Sie\Models\Sie_Formats');
//[vars]----------------------------------------------------------------------------------------------------------------
/**
 * @var object $authentication Authentication service from the ModuleController.
 * @var object $bootstrap Instance of the Bootstrap class from the ModuleController.
 * @var string $component Complete URI to the requested component.
 * @var object $dates Date service from the ModuleController.
 * @var string $oid String representing the object received, usually an object/data to be viewed, transferred from the ModuleController.
 * @var object $parent Represents the ModuleController.
 * @var object $request Request service from the ModuleController.
 * @var object $strings String service from the ModuleController.
 * @var string $view String passed to the view defined in the viewer for evaluation.
 * @var string $viewer Complete URI to the view responsible for evaluating each requested view.
 * @var string $views Complete URI to the module views.
 **/
$r["identification_type"] = $f->get_Value("identification_type");
$r["identification_number"] = $f->get_Value("identification_number");
$back = $f->get_Value("back", $server->get_Referer());
$types = LIST_IDENTIFICATION_TYPES;
//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("back", $back);
$f->fields["identification_type"] = $f->get_FieldSelect("identification_type", array("selected" => $r["identification_type"], "data" => $types, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["identification_number"] = $f->get_FieldText("identification_number", array("value" => $r["identification_number"], "proportion" => "col-md-8 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->getSearch("submit", array("value" => lang("App.Search"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["identification_type"] . $f->fields["identification_number"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
//$f->groups["gy"] =$f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card2("create", array(
    "header-title" => lang("Sie_Certificates.search-title"),
    "content" => $f,
    "header-back" => $back,
    "alert" => array(
        "icon" => ICON_INFO,
        "type" => "info",
        "title" => lang('Sie_Certificates.search-alert-title'),
        "message" => lang('Sie_Certificates.search-alert-message')),
));
echo($card);


?>