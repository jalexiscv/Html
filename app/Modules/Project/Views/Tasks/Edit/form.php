<?php

//[services]------------------------------------------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
$server = service("server");
$f = service("forms", array("lang" => "Project_Tasks."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Project\Models\Project_Tasks");
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
$row = $model->getTask($oid);
$r["task"] = $f->get_Value("task", $row["task"]);
$r["project"] = $f->get_Value("project", $row["project"]);
$r["name"] = $f->get_Value("name", $row["name"]);
$r["description"] = safe_urldecode($f->get_Value("description", $row["description"]));
$r["start"] = $f->get_Value("start", $row["start"]);
$r["end"] = $f->get_Value("end", $row["end"]);
$r["status"] = $f->get_Value("status", $row["status"]);
$r["responsible"] = $f->get_Value("responsible", $row["responsible"]);
$r["priority"] = $f->get_Value("priority", $row["priority"]);
$r["order"] = $f->get_Value("order", $row["order"]);
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
$back = $f->get_Value("back", $server->get_Referer());

$statuses = get_list_tasks_statuses();
$priorities = get_list_tasks_priorities();

//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("back", $back);
$f->fields["task"] = $f->get_FieldText("task", array("value" => $r["task"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["project"] = $f->get_FieldText("project", array("value" => $r["project"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["name"] = $f->get_FieldText("name", array("value" => $r["name"], "proportion" => "col-12"));
$f->fields["description"] = $f->get_FieldCKEditor("description", array("value" => $r["description"], "proportion" => "col-12"));
$f->fields["status"] = $f->get_FieldSelect("status", array("selected" => $r["status"], "data" => $statuses, "proportion" => "col-sm-6 col-12"));
$f->fields["responsible"] = $f->get_FieldText("responsible", array("value" => $r["responsible"], "proportion" => "col-sm-6 col-12"));
$f->fields["priority"] = $f->get_FieldSelect("priority", array("selected" => $r["priority"], "data" => $priorities, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["order"] = $f->get_FieldText("order", array("value" => $r["order"], "proportion" => "col-md-4 col-12"));
$f->fields["start"] = $f->get_FieldDate("start", array("value" => $r["start"], "proportion" => "col-sm-4 col-12"));
$f->fields["end"] = $f->get_FieldDate("end", array("value" => $r["end"], "proportion" => "col-sm-4 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["task"] . $f->fields["project"] . $f->fields["priority"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["name"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["order"] . $f->fields["start"] . $f->fields["end"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["status"] . $f->fields["responsible"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("create", array(
    "header-title" => lang("Project_Tasks.edit-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>