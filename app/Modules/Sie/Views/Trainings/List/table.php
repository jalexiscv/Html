<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-05-01 08:14:05
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Registrations\List\table.php]
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
$bootstrap = service("bootstrap");
$request = service('Request');
//[vars]----------------------------------------------------------------------------------------------------------------
//[models]--------------------------------------------------------------------------------------------------------------
$menrollments = model("App\Modules\Sie\Models\Sie_Enrollments");
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$mtrainings = model("App\Modules\Sie\Models\Sie_Trainings");
$mgrids = model("App\Modules\Sie\Models\Sie_Grids");
$mversions = model("App\Modules\Sie\Models\Sie_Versions");
$mattachments = model("App\Modules\Sie\Models\Sie_Attachments");
//[request]-------------------------------------------------------------------------------------------------------------
$back = "/sie/trainings/home/" . lpk();
$offset = !empty($request->getGet("offset")) ? $request->getGet("offset") : 0;
$search = !empty($request->getGet("search")) ? $request->getGet("search") : "";
$field = !empty($request->getGet("field")) ? $request->getGet("field") : "";
$limit = !empty($request->getGet("limit")) ? $request->getGet("limit") : 10;
$fields = [
    'identification' => 'Número de identificación',
];
//[build]--------------------------------------------------------------------------------------------------------------
$registrations = $mtrainings->get_List($limit, $offset, $search);
$total = $mtrainings->get_Total($search);
//[Grid]--------------------------------------------------------------------------------------------------------------
$bgrid = $bootstrap->get_Grid();
$bgrid->set_Total($total);
$bgrid->set_Limit($limit);
$bgrid->set_Offset($offset);
$bgrid->set_Class("P-0 m-0");
$bgrid->set_Limits(array(10, 20, 40, 80, 160, 320, 640, 1200, 2400));
$bgrid->set_Headers(array(
    array("content" => "#", "class" => "text-center align-middle"),
    array("content" => "", "class" => "no-wrap text-center align-middle w-1"),
    array("content" => lang("App.Student"), "class" => "text-center align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center align-middle"),
));
$count = $offset;
foreach ($registrations as $registration) {
    $count++;
    $fullname = $registration["first_name"] . " " . $registration["second_name"] . " " . $registration["first_surname"] . " " . $registration["second_surname"];
    $identification = $registration["identification_type"] . " " . $registration["identification_number"];
    $program = $mprograms->getProgram($registration["program"]);
    $program_name = isset($program['name']) ? $program['name'] : "";

    // Debo obtener el numero de matricula de este usuario en el proceso de formacion continua


    $lastcourse = "";

    $details = "<b>Nombre</b>: {$fullname}</br>";
    $details .= "<b>Identificación</b>: {$identification}</br>";
    $details .= "<b>Programa</b>: {$program_name} </br>";
    $details .= "<b>Último curso</b>: {$lastcourse} </br>";


    $photo = $mattachments->get_StudentPhoto($registration['registration']);
    $image = $bootstrap->get_Img("img-thumbnail", array("src" => $photo, "alt" => $fullname, "width" => "64", "class" => "",));

    $btnprofile = $bootstrap->get_Link("btn-profile", array("size" => "sm", "icon" => ICON_USER, "title" => lang("App.Profile"), "href" => "/sie/students/view/{$registration['registration']}", "class" => "btn-sm btn-primary ml-1",));
    $btnenrollment = $bootstrap->get_Link("btn-enrollment", array("size" => "sm", "icon" => ICON_ENROLL, "title" => lang("App.View"), "href" => "/sie/enrollments/create/{$registration['registration']}", "class" => "btn-secondary ml-1",));
    $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnprofile));
    $bgrid->add_Row(
        array(
            array("content" => $count, "class" => "text-center align-middle"),
            array("content" => $image, "class" => "text-center no-wrap align-middle"),
            array("content" => $details, "class" => "text-left align-middle"),
            array("content" => $options, "class" => "text-center align-middle"),
        )
    );
}
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => "Formación Continua / Listado de estudiantes",
    "header-back" => $back,
    //"header-add"=>"/sie/enrollments/create/" . lpk(),
    "content" => $bgrid,
));
echo($card);
?>