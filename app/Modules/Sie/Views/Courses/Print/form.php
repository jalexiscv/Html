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

$agreements = [];
$agreements[] = array("value" => "", "label" => "Seleccione un convenio");
$agreements = array_merge($agreements, $magreements->get_SelectData());

$agreement_institutions = [];
$agreement_institutions[] = array("value" => "", "label" => "Seleccione una institución");
$agreement_institutions = array_merge($agreement_institutions, $minstitutions->get_SelectData());

$group = $mgroups->getGroup(@$r["agreement_group"]);
$r["agreement_group"] = @$group["reference"];

$back = "/sie/courses/list/" . lpk();

$pdf = view("App\Modules\Sie\Views\Courses\Print\pdf", array());


//[Buttons]-----------------------------------------------------------------------------
//$f->groups["gy"] = $f->get_GroupSeparator();
//$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["edit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card2("card-view-service", array(
    "header-title" => sprintf(lang("Sie_Courses.view-title"), $r['name']),
    "header-back" => $back,
    "content" => $pdf,
    "content-class" => "px-2",
));
echo($card);
?>