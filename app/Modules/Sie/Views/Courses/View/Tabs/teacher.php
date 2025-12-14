<?php

/** @var object $parent Trasferido desde el controlador * */
/** @var object $authentication Trasferido desde el controlador * */
/** @var object $request Trasferido desde el controlador * */
/** @var object $dates Trasferido desde el controlador * */
/** @var string $component Trasferido desde el controlador * */
/** @var string $view Trasferido desde el controlador * */
/** @var string $oid Trasferido desde el controlador * */
/** @var string $views Trasferido desde el controlador * */
/** @var string $prefix Trasferido desde el controlador * */
/** @var array $data Trasferido desde el controlador * */
/** @var object $model Modelo de datos utilizado en la vista y trasferido desde el index * */
/** @var array $course Vector con los datos del curso para mostrarlos en la vista * */
//[Services]------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[models]--------------------------------------------------------------------------------------------------------------
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$mmodules = model("App\Modules\Sie\Models\Sie_Modules");
$mgrids = model("App\Modules\Sie\Models\Sie_Grids");
$mpensums = model("App\Modules\Sie\Models\Sie_Pensums");
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");
$magreements = model("App\Modules\Sie\Models\Sie_Agreements");
$minstitutions = model("App\Modules\Sie\Models\Sie_Institutions");
$mgroups = model("App\Modules\Sie\Models\Sie_Groups");
$mversions = model("App\Modules\Sie\Models\Sie_Versions");
//[vars]----------------------------------------------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Courses."));
//[Request]-------------------------------------------------------------------------------------------------------------
$program = $mprograms->getProgram(@$course["program"]);
$grid = $mgrids->get_Grid(@$course["grid"]);
$pensum = $mpensums->get_Pensum(@$course["pensum"]);
$module = $mmodules->get_Module(@$pensum["module"]);
$version = $mversions->get_Version(@$course["version"]);
$r["course"] = @$course["course"];
$r["reference"] = @$course["reference"];

$r["program"] = @$program['name'];
$r["grid"] = @$grid['name'];
$r["version"] = @$version['reference'];

$r["pensum"] = @$course["pensum"] . "-" . @$module['name'];// Es el codigo del curso pero dentro de la malla es decir codigo del pensum
$r["teacher"] = @$course["teacher"];
$r["teacher_name"] = $mfields->get_FullName(@$r["teacher"]);
$r["name"] = @$course["name"];
$r["description"] = @$course["description"];
$r["maximum_quota"] = @$course["maximum_quota"];
$r["start"] = @$course["start"];
$r["end"] = @$course["end"];
$r["period"] = @$course["period"];
$r["space"] = @$course["space"];
$r["author"] = @$course["author"];
$r["created_at"] = @$course["created_at"];
$r["updated_at"] = @$course["updated_at"];
$r["deleted_at"] = @$course["deleted_at"];
$r["agreement"] = $f->get_Value("agreement", @$course["agreement"]);
$r["agreement_institution"] = $f->get_Value("agreement_institution", @$course["agreement_institution"]);
$r["agreement_group"] = $f->get_Value("agreement_group", @$course["agreement_group"]);
$r["moodle_course"] = $f->get_Value("moodle_course", @$course["moodle_course"]);

$agreements = [];
$agreements[] = array("value" => "", "label" => "Seleccione un convenio");
$agreements = array_merge($agreements, $magreements->get_SelectData());

$agreement_institutions = [];
$agreement_institutions[] = array("value" => "", "label" => "Seleccione una institución");
$agreement_institutions = array_merge($agreement_institutions, $minstitutions->get_SelectData());

$group = $mgroups->getGroup(@$r["agreement_group"]);
$r["agreement_group"] = @$group["reference"];

$back = "/sie/courses/list/" . lpk();

$help_program = "Código del programa: " . @$course["program"];
$help_gid = "Código de la malla: " . @$course["grid"];
$help_version = "Código de la versión: " . @$course["version"];
//[Fields]-----------------------------------------------------------------------------
$f->fields["course"] = $f->get_FieldView("course", array("value" => $r["course"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["reference"] = $f->get_FieldView("reference", array("value" => $r["reference"], "proportion" => "col-md-3 col-sm-12 col-12"));

$f->fields["program"] = $f->get_FieldView("program", array("value" => $r["program"], "help" => $help_program, "proportion" => "col"));
$f->fields["grid"] = $f->get_FieldView("grid", array("value" => $r["grid"], "help" => $help_gid, "proportion" => "col"));
$f->fields["version"] = $f->get_FieldView("version", array("value" => $r["version"], "help" => $help_version, "proportion" => "col"));

$f->fields["pensum"] = $f->get_FieldView("pensum", array("value" => $r["pensum"], "proportion" => "col-sm-6 col-12"));
$f->fields["name"] = $f->get_FieldView("name", array("value" => $r["name"], "proportion" => "col-sm-6 col-12"));
$f->fields["description"] = $f->get_FieldView("description", array("value" => $r["description"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["maximum_quota"] = $f->get_FieldView("maximum_quota", array("value" => $r["maximum_quota"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["start"] = $f->get_FieldView("start", array("value" => $r["start"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["end"] = $f->get_FieldView("end", array("value" => $r["end"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["period"] = $f->get_FieldView("period", array("value" => $r["period"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["teacher"] = $f->get_FieldView("teacher", array("value" => $r["teacher"], "proportion" => "col-sm-4 col-12"));
$f->fields["teacher_name"] = $f->get_FieldView("teacher_name", array("value" => $r["teacher_name"], "proportion" => "col-sm-4 col-12"));
$f->fields["space"] = $f->get_FieldView("space", array("value" => $r["space"], "proportion" => "col-sm-4 col-12"));

$f->fields["agreement"] = $f->get_FieldSelect("agreement", array("selected" => $r["agreement"], "data" => $agreements, "proportion" => "col-md-3 col-sm-12 col-12", "disabled" => true));
$f->fields["agreement_institution"] = $f->get_FieldSelect("agreement_institution", array("selected" => $r["agreement_institution"], "data" => $agreement_institutions, "proportion" => "col-md-3 col-sm-12 col-12", "disabled" => true));
$f->fields["agreement_group"] = $f->get_FieldView("agreement_group", array("value" => $r["agreement_group"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["moodle_course"] = $f->get_FieldView("moodle_course", array("value" => $r["moodle_course"], "proportion" => "col-md-3 col-sm-12 col-12"));

$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldView("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldView("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldView("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["edit"] = $f->get_Button("edit", array("href" => "/sie/courses/edit/" . $oid, "text" => lang("App.Edit"), "class" => "btn btn-secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
//[Groups]-----------------------------------------------------------------------------
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["teacher"] . $f->fields["teacher_name"] . $f->fields["space"])));

//[Buttons]-----------------------------------------------------------------------------
//$f->groups["gy"] = $f->get_GroupSeparator();
//$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["edit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
echo($f);
?>