<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-04-28 04:55:14
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Project\Views\Projects\Editor\form.php]
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
$authentication = service('authentication');
$server = service("server");
$f = service("forms", array("lang" => "Project_Projects."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Project\Models\Project_Projects");
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
$row = $model->getProject($oid);
$r["project"] = $f->get_Value("project", $row["project"]);
$r["name"] = $f->get_Value("name", $row["name"]);
$r["description"] = $f->get_Value("description", $row["description"]);
$r["start"] = $f->get_Value("start", $row["start"]);
$r["end"] = $f->get_Value("end", $row["end"]);
$r["status"] = $f->get_Value("status", $row["status"]);
$r["budget"] = $f->get_Value("budget", $row["budget"]);
$r["responsible"] = $f->get_Value("responsible", $row["responsible"]);
$r["priority"] = $f->get_Value("priority", $row["priority"]);
$r["comments"] = $f->get_Value("comments", $row["comments"]);
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
$r["estimated_end_date"] = $f->get_Value("estimated_end_date", $row["estimated_end_date"]);
$back = $f->get_Value("back", $server->get_Referer());
//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("back", $back);
$f->fields["project"] = $f->get_FieldText("project", array("value" => $r["project"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["name"] = $f->get_FieldText("name", array("value" => $r["name"], "proportion" => "col-12"));
$f->fields["description"] = $f->get_FieldTextArea("description", array("value" => $r["description"], "proportion" => "col-12"));
$f->fields["start"] = $f->get_FieldDate("start", array("value" => $r["start"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["end"] = $f->get_FieldDate("end", array("value" => $r["end"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["status"] = $f->get_FieldText("status", array("value" => $r["status"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["budget"] = $f->get_FieldText("budget", array("value" => $r["budget"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["responsible"] = $f->get_FieldText("responsible", array("value" => $r["responsible"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["priority"] = $f->get_FieldText("priority", array("value" => $r["priority"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["comments"] = $f->get_FieldTextArea("comments", array("value" => $r["comments"], "proportion" => "col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["estimated_end_date"] = $f->get_FieldText("estimated_end_date", array("value" => $r["estimated_end_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["project"] . $f->fields["start"] . $f->fields["end"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["name"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["responsible"] . $f->fields["budget"] . $f->fields["priority"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["comments"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("create", array(
    "header-title" => lang("Project_Projects.edit-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>