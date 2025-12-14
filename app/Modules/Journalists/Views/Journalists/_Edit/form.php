<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-07-05 17:14:24
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Journalists\Views\Journalists\Editor\form.php]
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
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication =service('authentication');
$server = service("server");
$f = service("forms",array("lang" => "Journalists_Journalists."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Journalists\Models\Journalists_Journalists");
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
$row= $model->getJournalist($oid);
$r["journalist"] = $f->get_Value("journalist",$row["journalist"]);
$r["citizenshipcard"] = $f->get_Value("citizenshipcard",$row["citizenshipcard"]);
$r["firstname"] = $f->get_Value("firstname",$row["firstname"]);
$r["lastname"] = $f->get_Value("lastname",$row["lastname"]);
$r["email"] = $f->get_Value("email",$row["email"]);
$r["phone"] = $f->get_Value("phone",$row["phone"]);
$r["media"] = $f->get_Value("media",$row["media"]);
$r["photo"] = $f->get_Value("photo",$row["photo"]);
$r["date"] = $f->get_Value("date",service("dates")::get_Date());
$r["time"] = $f->get_Value("time",service("dates")::get_Time());
$r["status"] = $f->get_Value("status",$row["status"]);
$r["position"] = $f->get_Value("position",$row["position"]);
$back=$f->get_Value("back",$server->get_Referer());
//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("back",$back);
$f->fields["journalist"] = $f->get_FieldText("journalist", array("value" => $r["journalist"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["citizenshipcard"] = $f->get_FieldText("citizenshipcard", array("value" => $r["citizenshipcard"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["firstname"] = $f->get_FieldText("firstname", array("value" => $r["firstname"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["lastname"] = $f->get_FieldText("lastname", array("value" => $r["lastname"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["email"] = $f->get_FieldText("email", array("value" => $r["email"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["phone"] = $f->get_FieldText("phone", array("value" => $r["phone"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["media"] = $f->get_FieldText("media", array("value" => $r["media"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["photo"] = $f->get_FieldText("photo", array("value" => $r["photo"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["date"] = $f->get_FieldText("date", array("value" => $r["date"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["time"] = $f->get_FieldText("time", array("value" => $r["time"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["status"] = $f->get_FieldText("status", array("value" => $r["status"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["position"] = $f->get_FieldText("position", array("value" => $r["position"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"]=$f->get_Cancel("cancel", array("href" =>$back,"text" =>lang("App.Cancel"),"type"=>"secondary","proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] =$f->get_Submit("submit", array("value" =>lang("App.Edit"),"proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["journalist"].$f->fields["citizenshipcard"].$f->fields["firstname"])));
$f->groups["g2"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["lastname"].$f->fields["email"].$f->fields["phone"])));
$f->groups["g3"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["media"].$f->fields["photo"].$f->fields["date"])));
$f->groups["g4"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["time"].$f->fields["status"].$f->fields["position"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] =$f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields"=>$f->fields["submit"].$f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
		 "title" => lang("Journalists_Journalists.edit-title"),
		 "content" =>$f,
		 "header-back" =>$back
));
echo($card);
?>
