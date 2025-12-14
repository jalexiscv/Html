<?php

//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms",array("lang" => "Plex_Modules."));
$server = service("server");
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Plex\Models\Plex_Modules");
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
$r["module"] = $f->get_Value("module",pk());
$r["alias"] = $f->get_Value("alias");
$r["title"] = $f->get_Value("title");
$r["description"] = $f->get_Value("description");
$r["icon_light"] = $f->get_Value("icon_light");
$r["icon_dark"] = $f->get_Value("icon_dark");
$r["date"] = $f->get_Value("date",service("dates")::get_Date());
$r["time"] = $f->get_Value("time",service("dates")::get_Time());
$r["author"] = $f->get_Value("author",safe_get_user());
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
$back=$f->get_Value("back",$server->get_Referer());
//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("back",$back);
$f->fields["module"] = $f->get_FieldText("module", array("value" => $r["module"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12","readonly"=>true));
$f->fields["alias"] = $f->get_FieldText("alias", array("value" => $r["alias"],"proportion"=>"col-md-6 col-sm-12 col-12"));
$f->fields["title"] = $f->get_FieldText("title", array("value" => $r["title"],"proportion"=>"col-md-6 col-sm-12 col-12"));
$f->fields["description"] = $f->get_FieldText("description", array("value" => $r["description"],"proportion"=>"col-md-6 col-sm-12 col-12"));
$f->fields["icon_light"] = $f->get_FieldText("icon_light", array("value" => $r["icon_light"],"proportion"=>"col-md-6 col-sm-12 col-12"));
$f->fields["icon_dark"] = $f->get_FieldText("icon_dark", array("value" => $r["icon_dark"],"proportion"=>"col-md-6 col-sm-12 col-12"));
$f->fields["date"] = $f->get_FieldText("date", array("value" => $r["date"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["time"] = $f->get_FieldText("time", array("value" => $r["time"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author",$r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"]=$f->get_Cancel("cancel", array("href" =>$back,"text" =>lang("App.Cancel"),"type"=>"secondary","proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] =$f->get_Submit("submit", array("value" =>lang("App.Create"),"proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["module"].$f->fields["alias"])));
$f->groups["g2"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["title"].$f->fields["description"])));
$f->groups["g3"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["icon_light"].$f->fields["icon_dark"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] =$f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields"=>$f->fields["submit"].$f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card("create", array(
		 "title" => lang("Plex_Modules.create-title"),
		 "content" =>$f,
		 "header-back" =>$back
));
echo($card);
?>