<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-01-31 15:52:13
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Standards\Views\Objects\Creator\form.php]
* █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
* █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
* █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
* █ ---------------------------------------------------------------------------------------------------------------------
* █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
* █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
* █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
* █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
* █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
* █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
* █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
* █ ---------------------------------------------------------------------------------------------------------------------
* █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
* █ @link https://www.higgs.com.co
* █ @Version 1.5.1 @since PHP 8,PHP 9
* █ ---------------------------------------------------------------------------------------------------------------------
**/
//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms",array("lang" => "Standards_Objects."));
$server = service("server");
//[models]--------------------------------------------------------------------------------------------------------------
$mcategories = model('App\Modules\Standards\Models\Standards_Categories');
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

$parent = !empty($request->getVar("parent")) ? $request->getVar("parent") : "";


$r["object"] = $f->get_Value("object",pk());
$r["name"] = $f->get_Value("name");
$r["category"] = $f->get_Value("category");
$r["type_content"] = $f->get_Value("type_content");
$r["type_node"] = $f->get_Value("type_node");
$r["attachments"] = $f->get_Value("attachments");
$r["evaluation"] = $f->get_Value("evaluation");


if(!empty($parent)) {
    $r["parent"] = $f->get_Value("parent", $parent);
}else{
    $r["parent"] = $f->get_Value("parent");
}

$r["weight"] = $f->get_Value("weight",0);
$r["value"] = $f->get_Value("value",0);


$r["attributes"] = $f->get_Value("attributes");
$r["description"] = $f->get_Value("description");

$parent = !empty($request->getVar("parent")) ? $request->getVar("parent") : "";
if(!empty($parent)){
    $link_back="/standards/objects/list/{$parent}"."?parent=" . $parent;
}else{
    $link_back="/standards/objects/list/" . lpk();
}



$categories=$mcategories->get_SelectData();
$categories[] = array("value"=>"","label"=>"Ninguna");

$types=array(
    array("value"=>"","label"=>"Seleccione un tipo"),
    array("value"=>"HEATCHARTS","label"=>"Graficos de calor"),
    array("value"=>"GENERAL","label"=>"General"),
);

$types_nodes=array(
    array("value"=>"","label"=>"Seleccione una opción"),
    array("value"=>"N","label"=>"Normal"),
    array("value"=>"Y","label"=>"Objeto final"),
);


$attachments=array(
    array("value"=>"N","label"=>"No"),
    array("value"=>"Y","label"=>"Si"),
);

$back=$link_back;
//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("container",$parent);
$f->add_HiddenField("back",$back);
$f->fields["object"] = $f->get_FieldText("object", array("value" => $r["object"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12","readonly"=>"readonly"));
$f->fields["name"] = $f->get_FieldText("name", array("value" => $r["name"],"proportion"=>"col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12"));
$f->fields["category"] = $f->get_FieldSelect("category", array("selected" => $r["category"],"data"=>$categories,"proportion"=>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["parent"] = $f->get_FieldText("parent", array("value" => $r["parent"],"proportion"=>"col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["weight"] = $f->get_FieldText("weight", array("value" => $r["weight"],"proportion"=>"col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["attributes"] = $f->get_FieldTextArea("attributes", array("value" => $r["attributes"],"proportion"=>"col-12"));
$f->fields["description"] = $f->get_FieldTextArea("description", array("value" => $r["description"],"proportion"=>"col-12"));
$f->fields["evaluation"] = $f->get_FieldCKEditor("evaluation", array("value" => $r["evaluation"],"proportion"=>"col-12"));
$f->fields["value"] = $f->get_FieldText("value", array("value" => $r["value"],"proportion"=>"col-3"));
$f->fields["type_content"] = $f->get_FieldSelect("type_content", array("selected" => $r["type_content"],"data"=>$types,"proportion"=>"col-3"));
$f->fields["type_node"] = $f->get_FieldSelect("type_node", array("selected" => $r["type_node"],"data"=>$types_nodes,"proportion"=>"col-3"));
$f->fields["attachments"] = $f->get_FieldSelect("attachments", array("selected" => $r["attachments"],"data"=>$attachments,"proportion"=>"col-3"));
$f->fields["cancel"]=$f->get_Cancel("cancel", array("href" =>$back,"text" =>lang("App.Cancel"),"type"=>"secondary","proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] =$f->get_Submit("submit", array("value" =>lang("App.Create"),"proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["object"].$f->fields["name"])));
$f->groups["g2"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["category"].$f->fields["parent"].$f->fields["weight"])));
$f->groups["g3"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["description"])));
$f->groups["g4"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["evaluation"])));
//$f->groups["g5"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["attributes"])));
$f->groups["g6"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["value"].$f->fields["type_content"].$f->fields["type_node"].$f->fields["attachments"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] =$f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields"=>$f->fields["submit"].$f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card("create", array(
		 "title" => lang("Standards_Objects.create-title"),
		 "content" =>$f,
		 "header-back" =>$back
));
echo($card);
?>