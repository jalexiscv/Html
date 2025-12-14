<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-12-12 06:42:08
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Models\Editor\form.php]
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
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication =service('authentication');
$server = service("server");
$f = service("forms",array("lang" => "Sie_Models."));
//[models]--------------------------------------------------------------------------------------------------------------
//[vars]----------------------------------------------------------------------------------------------------------------
$row= $model->getModel($oid);
$r["model"] =$row["model"];
$r["code"] =$row["code"];
$r["name"] =$row["name"];
$r["description"] =$row["description"];
$r["country"] =$row["country"];
$r["regulatory_framework"] =$row["regulatory_framework"];
$r["uses_credits"] =$row["uses_credits"];
$r["hours_per_credit"] =$row["hours_per_credit"];
$r["credit_calculation_formula"] =$row["credit_calculation_formula"];
$r["requires_theoretical_hours"] =$row["requires_theoretical_hours"];
$r["requires_practical_hours"] =$row["requires_practical_hours"];
$r["requires_independent_hours"] =$row["requires_independent_hours"];
$r["requires_total_hours"] =$row["requires_total_hours"];
$r["validation_rules"] =$row["validation_rules"];
$r["configuration"] =$row["configuration"];
$r["is_active"] =$row["is_active"];
$r["created_at"] =$row["created_at"];
$r["updated_at"] =$row["updated_at"];
$r["deleted_at"] =$row["deleted_at"];
$back=$f->get_Value("back",$server->get_Referer());
//[Fields]-----------------------------------------------------------------------------
$f->fields["model"] = $f->get_FieldView("model", array("value" => $r["model"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["code"] = $f->get_FieldView("code", array("value" => $r["code"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["name"] = $f->get_FieldView("name", array("value" => $r["name"],"proportion"=>"col-12"));
$f->fields["description"] = $f->get_FieldView("description", array("value" => $r["description"],"proportion"=>"col-12"));
$f->fields["country"] = $f->get_FieldView("country", array("value" => $r["country"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["regulatory_framework"] = $f->get_FieldView("regulatory_framework", array("value" => $r["regulatory_framework"],"proportion"=>"col-12"));
$f->fields["uses_credits"] = $f->get_FieldView("uses_credits", array("value" => $r["uses_credits"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["hours_per_credit"] = $f->get_FieldView("hours_per_credit", array("value" => $r["hours_per_credit"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["credit_calculation_formula"] = $f->get_FieldView("credit_calculation_formula", array("value" => $r["credit_calculation_formula"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["requires_theoretical_hours"] = $f->get_FieldView("requires_theoretical_hours", array("value" => $r["requires_theoretical_hours"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["requires_practical_hours"] = $f->get_FieldView("requires_practical_hours", array("value" => $r["requires_practical_hours"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["requires_independent_hours"] = $f->get_FieldView("requires_independent_hours", array("value" => $r["requires_independent_hours"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["requires_total_hours"] = $f->get_FieldView("requires_total_hours", array("value" => $r["requires_total_hours"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["validation_rules"] = $f->get_FieldView("validation_rules", array("value" => $r["validation_rules"],"proportion"=>"col-12"));
$f->fields["configuration"] = $f->get_FieldView("configuration", array("value" => $r["configuration"],"proportion"=>"col-12"));
$f->fields["is_active"] = $f->get_FieldView("is_active", array("value" => $r["is_active"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["created_at"] = $f->get_FieldView("created_at", array("value" => $r["created_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldView("updated_at", array("value" => $r["updated_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldView("deleted_at", array("value" => $r["deleted_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"]=$f->get_Cancel("cancel", array("href" =>$back,"text" =>lang("App.Cancel"),"type"=>"secondary","proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["edit"] =$f->get_Button("edit", array("href" =>"/sie/models/edit/".$oid,"text" =>lang("App.Edit"),"class"=>"btn btn-secondary","proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
//[Groups]-----------------------------------------------------------------------------
$f->groups["g01"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["model"].$f->fields["code"].$f->fields["country"])));
$f->groups["g02"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["name"])));
$f->groups["g03"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["description"])));
$f->groups["g04"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["regulatory_framework"])));
$f->groups["g05"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["uses_credits"].$f->fields["hours_per_credit"].$f->fields["credit_calculation_formula"])));
$f->groups["g06"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["requires_theoretical_hours"].$f->fields["requires_practical_hours"].$f->fields["requires_independent_hours"])));
$f->groups["g07"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["requires_total_hours"].$f->fields["is_active"])));
$f->groups["g08"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["validation_rules"])));
$f->groups["g09"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["configuration"])));
//[Buttons]-----------------------------------------------------------------------------
$f->groups["gy"] =$f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields"=>$f->fields["edit"].$f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card2("card-view-service", array(
		"header-title" => lang("Sie_Models.view-title"),
		"header-back" => $back,
		"content" => $f,
));
echo($card);
?>