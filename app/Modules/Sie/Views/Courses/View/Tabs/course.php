<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-03-15 09:44:30
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Courses\Editor\form.php]
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
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @var object $parent Trasferido desde el controlador
 * █ @var object $authentication Trasferido desde el controlador
 * █ @var object $request Trasferido desde el controlador
 * █ @var object $dates Trasferido desde el controlador
 * █ @var string $component Trasferido desde el controlador
 * █ @var string $view Trasferido desde el controlador
 * █ @var string $oid Trasferido desde el controlador
 * █ @var string $views Trasferido desde el controlador
 * █ @var string $prefix Trasferido desde el controlador
 * █ @var array $data Trasferido desde el controlador
 * █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[Services]-----------------------------------------------------------------------------
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
//[vars]-------------------------------------------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Courses."));
//[Request]-------------------------------------------------------------------------------------------------------------
$row = $model->get_Course($oid);
$program = $mprograms->getProgram(@$row["program"]);
$grid = $mgrids->get_Grid(@$row["grid"]);
$pensum = $mpensums->get_Pensum(@$row["pensum"]);
$module = $mmodules->get_Module(@$pensum["module"]);
$r["course"] = @$row["course"];
$r["reference"] = @$row["reference"];
$r["program"] = @$row["program"] . " - " . @$program['name'];
$r["pensum"] = @$row["pensum"] . "-" . @$module['name'];// Es el codigo del curso pero dentro de la malla es decir codigo del pensum
$r["teacher"] = @$row["teacher"];
$r["teacher_name"] = $mfields->get_FullName(@$r["teacher"]);
$r["name"] = @$row["name"];
$r["description"] = @$row["description"];
$r["maximum_quota"] = @$row["maximum_quota"];
$r["start"] = @$row["start"];
$r["end"] = @$row["end"];
$r["period"] = @$row["period"];
$r["space"] = @$row["space"];
$r["author"] = @$row["author"];
$r["created_at"] = @$row["created_at"];
$r["updated_at"] = @$row["updated_at"];
$r["deleted_at"] = @$row["deleted_at"];
$r["agreement"] = $f->get_Value("agreement", @$row["agreement"]);
$r["agreement_institution"] = $f->get_Value("agreement_institution", @$row["agreement_institution"]);
$r["agreement_group"] = $f->get_Value("agreement_group", @$row["agreement_group"]);
$r["moodle_course"] = $f->get_Value("moodle_course", @$row["moodle_course"]);

$agreements = [];
$agreements[] = array("value" => "", "label" => "Seleccione un convenio");
$agreements = array_merge($agreements, $magreements->get_SelectData());

$agreement_institutions = [];
$agreement_institutions[] = array("value" => "", "label" => "Seleccione una institución");
$agreement_institutions = array_merge($agreement_institutions, $minstitutions->get_SelectData());

$group = $mgroups->getGroup(@$r["agreement_group"]);
$r["agreement_group"] = @$group["reference"];

$back = "/sie/courses/list/" . lpk();
//[Fields]-----------------------------------------------------------------------------
$f->fields["course"] = $f->get_FieldView("course", array("value" => $r["course"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["reference"] = $f->get_FieldView("reference", array("value" => $r["reference"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["program"] = $f->get_FieldView("program", array("value" => $r["program"], "proportion" => "col-md-9 col-sm-12 col-12"));
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
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["course"] . $f->fields["reference"] . $f->fields["start"] . $f->fields["end"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["program"] . $f->fields["period"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["pensum"] . $f->fields["name"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["teacher"] . $f->fields["teacher_name"] . $f->fields["space"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["agreement"] . $f->fields["agreement_institution"] . $f->fields["agreement_group"] . $f->fields["moodle_course"])));

//[Buttons]-----------------------------------------------------------------------------
//$f->groups["gy"] = $f->get_GroupSeparator();
//$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["edit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card2("card-view-service", array(
    "header-title" => sprintf(lang("Sie_Courses.view-title"), $r['name']),
    "header-back" => $back,
    "header-print" => "/sie/courses/print/" . $oid,
    "content" => $f,
    "content-class" => "px-2",
));
echo($card);

$data = $parent->get_Array();
$data["status"] = @$row["status"];
echo(view($component . '\enrrolleds', $data));
?>