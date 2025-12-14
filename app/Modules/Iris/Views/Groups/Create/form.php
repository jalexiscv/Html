<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-11-21 10:45:48
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Iris\Views\Groups\Creator\form.php]
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
$f = service("forms",array("lang" => "Iris_Groups."));
$server = service("server");
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Iris\Models\Iris_Groups");
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
$back=$server->get_Referer();
$r["back"] = $f->get_Value("back",$back);
$r["group"] = $f->get_Value("group",pk());
$r["code"] = $f->get_Value("code");
$r["name"] = $f->get_Value("name");
$r["description"] = $f->get_Value("description");
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("back",$r["back"]);
$f->fields["group"] = $f->get_FieldText("group", array("value" => $r["group"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12","readonly"=>true));
$f->fields["code"] = $f->get_FieldText("code", array("value" => $r["code"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["name"] = $f->get_FieldText("name", array("value" => $r["name"],"proportion"=>"col-12"));
$f->fields["description"] = $f->get_FieldTextArea("description", array("value" => $r["description"],"proportion"=>"col-12"));
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"]=$f->get_Cancel("cancel", array("href" =>$r["back"],"text" =>lang("App.Cancel"),"type"=>"secondary","proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] =$f->get_Submit("submit", array("value" =>lang("App.Create"),"proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["group"].$f->fields["code"])));
$f->groups["g2"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["name"])));
$f->groups["g3"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["description"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] =$f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields"=>$f->fields["submit"].$f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card2("create", array(
		 "header-title" => lang("Iris_Groups.create-title"),
		 "content" =>$f,
		 "header-back" =>$back
));
echo($card);
?>