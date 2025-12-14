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

$help_program = "Código del programa: " . @$course["program"];
$help_gid = "Código de la malla: " . @$course["grid"];
$help_version = "Código de la versión: " . @$course["version"];
//[Fields]-----------------------------------------------------------------------------
$f->fields["program"] = $f->get_FieldView("program", array("value" => $r["program"], "help" => $help_program, "proportion" => "col"));
$f->fields["grid"] = $f->get_FieldView("grid", array("value" => $r["grid"], "help" => $help_gid, "proportion" => "col"));
$f->fields["version"] = $f->get_FieldView("version", array("value" => $r["version"], "help" => $help_version, "proportion" => "col"));
//[Groups]-----------------------------------------------------------------------------
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["program"] . $f->fields["grid"] . $f->fields["version"])));
//[Buttons]-----------------------------------------------------------------------------
//$f->groups["gy"] = $f->get_GroupSeparator();
//$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["edit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
echo($f);
?>