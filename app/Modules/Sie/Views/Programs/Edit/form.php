<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-03-14 07:59:32
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Programs\Editor\form.php]
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
 * █ @var object $mprograms Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[services]------------------------------------------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Sie_Programs."));
//[models]--------------------------------------------------------------------------------------------------------------
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
//[vars]----------------------------------------------------------------------------------------------------------------
$row = $mprograms->getProgram($oid);
$r["program"] = $f->get_Value("program", $row["program"]);
$r["reference"] = $f->get_Value("reference", $row["reference"]);
$r["name"] = $f->get_Value("name", $row["name"]);
$r["acronym"] = $f->get_Value("acronym", $row["acronym"]);

$r["snies"] = $f->get_Value("snies", $row["snies"]);
$r["ies"] = $f->get_Value("ies", $row["ies"]);
$r["ies_parent"] = $f->get_Value("ies_parent", $row["ies_parent"]);
$r["credits"] = $f->get_Value("credits", $row["credits"]);

$r["resolution"] = $f->get_Value("resolution", $row["resolution"]);
$r["resolution_date"] = $f->get_Value("resolution_date", $row["resolution_date"]);
$r["resolution_execution"] = $f->get_Value("resolution_execution", $row["resolution_execution"]);

$r["academic_level"] = $f->get_Value("academic_level", "TECHNICAL");
$r["modality"] = $f->get_Value("modality", "DISTANCE");
$r["education_level"] = $f->get_Value("education_level", "TECHNICAL");
$r["awarded_title"] = $f->get_Value("awarded_title", @$row["awarded_title"]);

$r["evaluation"] = $f->get_Value("evaluation", "QUANTITATIVE");
$r["groups"] = $f->get_Value("groups", $row["groups"]);
$r["preregistration"] = $f->get_Value("preregistration", $row["preregistration"]);
$r["status"] = $f->get_Value("status", $row["status"]);
$r["value"] = $f->get_Value("value", $row["value"]);

$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
$back = "/sie/programs/list/" . lpk();

$evaluations = LIST_EVALUATIONS_TYPES;
$yn = LIST_YN;
$programs = LIST_PROGRAMS_STATUSES;
$academic_levels = LIST_ACADEMIC_LEVELS;
$modalities = LIST_MODALITIES;
$education_level = LIST_EDUCATION_LEVEL;
$awarded_titles = LIST_AWARDED_TITLES;

//[fields]----------------------------------------------------------------------------------------------------------------
$f->fields["program"] = $f->get_FieldText("program", array("value" => $r["program"], "proportion" => "col-md-5 col-sm-12 col-12", "readonly" => true));
$f->fields["reference"] = $f->get_FieldText("reference", array("value" => $r["reference"], "proportion" => "col-md-7 col-sm-12 col-12"));
$f->fields["name"] = $f->get_FieldText("name", array("value" => $r["name"], "proportion" => "col-12"));
$f->fields["acronym"] = $f->get_FieldText("acronym", array("value" => $r["acronym"], "proportion" => "col-12"));

$f->fields["snies"] = $f->get_FieldText("snies", array("value" => $r["snies"], "max" => "999999", "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["ies"] = $f->get_FieldText("ies", array("value" => $r["ies"], "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["ies_parent"] = $f->get_FieldText("ies_parent", array("value" => $r["ies_parent"], "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["credits"] = $f->get_FieldText("credits", array("value" => $r["credits"], "max" => "999", "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["value"] = $f->get_FieldText("value", array("value" => $r["value"], "max" => "9999999999", "proportion" => "col-md-4 col-sm-12 col-12"));

$f->fields["resolution"] = $f->get_FieldText("resolution", array("value" => $r["resolution"], "proportion" => "col-12"));
$f->fields["resolution_date"] = $f->get_FieldDate("resolution_date", array("value" => $r["resolution_date"], "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["resolution_execution"] = $f->get_FieldDate("resolution_execution", array("value" => $r["resolution_execution"], "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["evaluation"] = $f->get_FieldSelect("evaluation", array("selected" => $r["evaluation"], "data" => $evaluations, "proportion" => "col-md-6 col-sm-12 col-12"));

$f->fields["academic_level"] = $f->get_FieldSelect("academic_level", array("selected" => $r["academic_level"], "data" => $academic_levels, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["modality"] = $f->get_FieldSelect("modality", array("selected" => $r["modality"], "data" => $modalities, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["education_level"] = $f->get_FieldSelect("education_level", array("selected" => $r["education_level"], "data" => $education_level, "proportion" => "col-12"));
$f->fields["awarded_title"] = $f->get_FieldSelect("awarded_title", array("selected" => $r["awarded_title"], "data" => $awarded_titles, "proportion" => "col-12"));

$f->fields["journeys"] = $f->get_FieldCheckBoxes("journeys", array("proportion" => "col-12", "options" => array(
    array("value" => "MORNING", "label" => "Diurno"),
    array("value" => "NIGHT", "label" => "Nocturno"),
    array("value" => "SATURDAY", "label" => "Sábados"),
)));

$f->fields["groups"] = $f->get_FieldSelect("groups", array("selected" => $r["groups"], "data" => $yn, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["preregistration"] = $f->get_FieldSelect("preregistration", array("selected" => $r["preregistration"], "data" => $yn, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["status"] = $f->get_FieldSelect("status", array("selected" => $r["status"], "data" => $programs, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["program"] . $f->fields["reference"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["acronym"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["snies"] . $f->fields["ies"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["ies_parent"] . $f->fields["credits"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["name"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["academic_level"] . $f->fields["modality"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["education_level"])));
$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["awarded_title"])));
$f->groups["g9"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["resolution"])));
$f->groups["g10"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["resolution_date"] . $f->fields["resolution_execution"])));
$f->groups["g11"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["evaluation"] . $f->fields["groups"])));
$f->groups["g13"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["journeys"])));
$f->groups["g14"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["preregistration"] . $f->fields["status"] . $f->fields["value"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
//$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("create", array(
    "header-title" => lang("Sie_Programs.edit-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>

