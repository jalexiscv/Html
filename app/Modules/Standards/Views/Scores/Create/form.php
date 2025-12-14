<?php

//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms",array("lang" => "Standards_Scores."));
$server = service("server");
$request=service("request");
//[models]--------------------------------------------------------------------------------------------------------------
$mscores = model("App\Modules\Standards\Models\Standards_Scores");
$mobjects = model('App\Modules\Standards\Models\Standards_Objects');
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

$parent=$request->getvar("parent");
$object=$mobjects->getObject($oid);
$r["score"] = $f->get_Value("score",pk());
$r["object"] = $f->get_Value("object",$oid);
$r["value"] = $f->get_Value("value",$object["value"]);
$r["description"] = $f->get_Value("description");
$r["author"] = $f->get_Value("author",safe_get_user());
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
$back="/standards/scores/list/{$oid}?parent={$parent}";
//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("back",$back);
$f->add_HiddenField("parent",$parent);
$f->fields["score"] = $f->get_FieldText("score", array("value" => $r["score"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12","readonly"=>true));
$f->fields["object"] = $f->get_FieldText("object", array("value" => $r["object"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12","readonly"=>true));
$f->fields["value"] = $f->get_FieldNumber("value", array("value" => $r["value"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["file"] = $f->get_FieldFile("file", array("value" => @$r["file"],"proportion"=>"col-12"));
$f->fields["description"] = $f->get_FieldTextArea("description", array("value" => $r["description"],"proportion"=>"col-12"));
$f->add_HiddenField("author",$r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"]=$f->get_Cancel("cancel", array("href" =>$back,"text" =>lang("App.Cancel"),"type"=>"secondary","proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] =$f->get_Submit("submit", array("value" =>lang("App.Create"),"proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["score"].$f->fields["object"].$f->fields["value"])));
$f->groups["g2"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["file"])));
$f->groups["g3"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["description"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] =$f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields"=>$f->fields["submit"].$f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card2("create", array(
		 "header-title" => lang("Standards_Scores.create-title"),
		 "content" =>$f,
		 "header-back" =>$back
));
echo($card);

$title="Actividad";
$description=$object["description"];
$card = $b->get_Card2("create", array(
    "header-title" => $title,
    "content" =>$description,
));
echo($card);

$title=lang("Standards_Scores.create-alert-title");
$content=$object["evaluation"];
$card = $b->get_Card2("create", array(
    "header-title" => $title,
    "content" =>$content,
));
echo($card);
?>