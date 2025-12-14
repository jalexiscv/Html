<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-12-12 06:42:09
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
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication =service('authentication');
$server = service("server");
$f = service("forms",array("lang" => "Sie_Models."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sie\Models\Sie_Models");
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
$row= $model->getModel($oid);
$r["model"] = $f->get_Value("model",$row["model"]);
$r["code"] = $f->get_Value("code",$row["code"]);
$r["name"] = $f->get_Value("name",$row["name"]);
$r["description"] = $f->get_Value("description",$row["description"]);
$r["country"] = $f->get_Value("country",$row["country"]);
$r["regulatory_framework"] = $f->get_Value("regulatory_framework",$row["regulatory_framework"]);
$r["uses_credits"] = $f->get_Value("uses_credits",$row["uses_credits"]);
$r["hours_per_credit"] = $f->get_Value("hours_per_credit",$row["hours_per_credit"]);
$r["credit_calculation_formula"] = $f->get_Value("credit_calculation_formula",$row["credit_calculation_formula"]);
$r["requires_theoretical_hours"] = $f->get_Value("requires_theoretical_hours",$row["requires_theoretical_hours"]);
$r["requires_practical_hours"] = $f->get_Value("requires_practical_hours",$row["requires_practical_hours"]);
$r["requires_independent_hours"] = $f->get_Value("requires_independent_hours",$row["requires_independent_hours"]);
$r["requires_total_hours"] = $f->get_Value("requires_total_hours",$row["requires_total_hours"]);
$r["validation_rules"] = $f->get_Value("validation_rules",$row["validation_rules"]);
$r["configuration"] = $f->get_Value("configuration",$row["configuration"]);
$r["is_active"] = $f->get_Value("is_active",$row["is_active"]);
$r["created_at"] = $f->get_Value("created_at",$row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at",$row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at",$row["deleted_at"]);
$back=$f->get_Value("back",$server->get_Referer());
//[fields]--------------------------------------------------------------------------------------------------------------
require_once(__DIR__ . "/../fields.php");
//[groups]--------------------------------------------------------------------------------------------------------------
require_once(__DIR__ . "/../groups.php");
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] =$f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields"=>$f->fields["submit"].$f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("create", array(
		 "header-title" => lang("Sie_Models.edit-title"),
		 "content" =>$f,
		 "header-back" =>$back
));
echo($card);
?>