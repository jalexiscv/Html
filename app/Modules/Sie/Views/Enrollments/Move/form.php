<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-07-27 09:56:27
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Enrollments\Creator\form.php]
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
//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Sie_Enrollments."));
$server = service("server");
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sie\Models\Sie_Enrollments");
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$mgrids = model("App\Modules\Sie\Models\Sie_Grids");
$mversions = model("App\Modules\Sie\Models\Sie_Versions");
$menrollments = model("App\Modules\Sie\Models\Sie_Enrollments");
//[vars]----------------------------------------------------------------------------------------------------------------
//$registration = $mregistrations->getRegistration($oid);
//$program = $mprograms->getProgram($registration["program"]);
//$grid = $mgrids->get_GridByProgram($program["program"]);
//$version = $mversions->get_Active($grid["grid"]);

$enrollment = $menrollments->get_Enrollment($oid);
$program = $mprograms->getProgram($enrollment["program"]);
$registration = $mregistrations->getRegistration($enrollment["registration"]);

$r["enrollment"] = $f->get_Value("enrollment", $oid);
$r["registration"] = $f->get_Value("registration", $registration["registration"]);
$r["student_name"] = $f->get_Value("student_name", $registration["first_name"] . " " . $registration["second_name"] . " " . $registration["first_surname"] . " " . $registration["second_surname"]);
$r["program"] = $f->get_Value("program", $enrollment["program"]);
$r["program_name"] = $f->get_Value("program_name", $program["name"]);
$r["author"] = $f->get_Value("author", safe_get_user());
$programs_move = array(array("value" => "", "label" => "Seleccione un programa"),);
$programs_move = array_merge($programs_move, $mprograms->get_SelectPreregistration());
$back = $server->get_Referer();
//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("back", $back);
$f->add_HiddenField("enrollment", $r["enrollment"]);
$f->fields["registration"] = $f->get_FieldText("registration", array("value" => $r["registration"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["student_name"] = $f->get_FieldText("student_name", array("value" => $r["student_name"], "proportion" => "col-md-8 col-sm-12 col-12", "readonly" => true));
$f->fields["program"] = $f->get_FieldText("program", array("value" => $r["program"], "proportion" => "col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["program_name"] = $f->get_FieldText("program_name", array("value" => $r["program_name"], "proportion" => "col-md-8 col-sm-12 col-12", "readonly" => true));
$f->fields["program_move"] = $f->get_FieldSelect("program_move", array("selected" => $r["program"], "data" => $programs_move, "proportion" => "col-12"));

$f->add_HiddenField("author", $r["author"]);
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Move"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["registration"] . $f->fields["student_name"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["program"] . $f->fields["program_name"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["program_move"])));

//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card("create", array(
    "title" => lang("Sie_Enrollments.move-title"),
    "alert" => array(
        'type' => 'info',
        'title' => lang("Sie_Enrollments.move-alert-title"),
        'message' => lang("Sie_Enrollments.move-alert-message")
    ),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>