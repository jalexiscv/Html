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
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$mgrids = model("App\Modules\Sie\Models\Sie_Grids");
$mversions = model("App\Modules\Sie\Models\Sie_Versions");
//[request]-------------------------------------------------------------------------------------------------------------
$back = "/sie/enrollments/home/" . lpk();
$offset = !empty($request->getGet("offset")) ? $request->getGet("offset") : 0;
$search = !empty($request->getGet("search")) ? $request->getGet("search") : "";
$field = !empty($request->getGet("field")) ? $request->getGet("field") : "";
$limit = !empty($request->getGet("limit")) ? $request->getGet("limit") : 10;
$fields = [
    'identification' => 'Número de identificación',
    'names' => 'Nombres',
    //'surnames' => 'Apellidos',
    //'email' => 'Correo electrónico',
    //'eid' => 'Codigo de estudiante',
    //'phone' => 'Teléfono',

    //'program' => 'Programa académico',
];
//[build]--------------------------------------------------------------------------------------------------------------
$vsearch = $search;
if ($field == "identification") {
    $registration = $mregistrations->getRegistrationByIdentification($search);
    $vsearch = @$registration['registration'];
} elseif ($field == "names") {
    $registration = $mregistrations->getRegistrationsByName($search);
    $vsearch = $search;
    if ($registration) {
        $vsearch = @$registration['registration'];
    }
}

$enrollments = $menrollments->get_List($limit, $offset, $vsearch);

$total = $menrollments->get_Total($vsearch);
//[build]--------------------------------------------------------------------------------------------------------------
$bgrid = $bootstrap->get_Grid();
$bgrid->set_Total($total);
$bgrid->set_Limit($limit);
$bgrid->set_Offset($offset);
$bgrid->set_Class("P-0 m-0");
$bgrid->set_Limits(array(10, 20, 40, 80, 160, 320, 640, 1200, 2400));
$bgrid->set_Headers(array(
    array("content" => "#", "class" => "text-center  align-middle"),
    //array("content" => lang("App.Enrollment"), "class" => "text-center align-middle"),
    array("content" => lang("App.Student"), "class" => "text-center align-middle"),
    //array("content" => lang("App.Identification"), "class" => "text-center align-middle"),
    //array("content" => lang("App.Program"), "class" => "text-center align-middle"),
    array("content" => lang("App.Date"), "class" => "text-center align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center  align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$count = $offset;
foreach ($enrollments as $enrollment) {
    $count++;
    $registration = $mregistrations->getRegistration($enrollment['registration']);
    $btnview = $bootstrap->get_Link("btn-view", array(
        "size" => "sm",
        "icon" => ICON_VIEW,
        "title" => lang("App.View"),
        "href" => "/sie/progress/list/" . $enrollment['enrollment'],
        "class" => "btn-sm btn-primary ml-1",
    ));
    $btnedit = $bootstrap->get_Link("btn-edit", array(
        "size" => "sm",
        "icon" => ICON_EDIT,
        "title" => lang("App.Delete"),
        "href" => "/sie/enrollments/edit/" . $enrollment['enrollment'],
        "class" => "btn-secondary ml-1",
    ));

    $btndelete = $bootstrap->get_Link("btn-delete", array(
        "size" => "sm",
        "icon" => ICON_DELETE,
        "title" => lang("App.Delete"),
        "href" => "/sie/enrollments/delete/" . $enrollment['enrollment'],
        "class" => "btn-sm btn-danger ml-1",
    ));


    $btnmove = $bootstrap->get_Link("btn-move", array(
        "size" => "sm",
        "icon" => ICON_MOVE,
        "title" => lang("App.Move"),
        "href" => "/sie/enrollments/move/" . $enrollment['enrollment'],
        "class" => "btn-sm btn-warning ml-1",
    ));


    $student = $mregistrations->getRegistration($enrollment['registration']);
    $program = $mprograms->getProgram($enrollment['program']);
    $identificacion = "<b>" . $registration['identification_type'] . "</b> " . $registration['identification_number'];
    $student_name = $student['first_name'] . " " . $student['second_name'] . " " . $student['first_surname'] . " " . $student['second_surname'];
    $student_identification = $registration['identification_type'] . " " . $registration['identification_number'];
    if ($registration['status'] == "DESISTEMENT") {
        $student_name .= "<span class=\"badge bg-danger mx-3\"> Cancelo </span>";
    } else {
        //$student_name .= "<span class='badge bg-success'>" . $registration['status'] . "</span>";
    }
    $program_name = $program['name'];
    $grid = $mgrids->get_Grid($enrollment['grid']);
    $grid_name = $grid['name'];

    $date = $enrollment['date'];
    $options = $bootstrap->get_BtnGroup("btn-group", array(
        "content" => $btnview . $btnedit . $btndelete . $btnmove,
    ));
    $details = "<b>Matricula</b>: {$enrollment['enrollment']} <b>Periodo</b>: {$registration['period']} <br>";
    $details .= "<b>Estudiante</b>: <a href=\"/sie/students/view/{$student["registration"]}\" target=\"_blank\">{$student_name}</a><br>";
    $details .= "<b>Identificación</b>: {$student_identification}<br>";
    $details .= "<b>Programa</b>: {$program_name}<br>";
    $details .= "<b>Malla</b>: {$grid_name}<br>";
    $details .= "<b>Descripción</b>: {$enrollment['observation']}<br>";

    $bgrid->add_Row(
        array(
            array("content" => $count, "class" => "text-center align-middle"),
            //array("content" => $enrollment['enrollment'], "class" => "text-center align-middle"),
            //array("content" => $identificacion, "class" => "text-left align-middle"),
            //array("content" => $student_name . "<br>" . $program_name, "class" => "text-left align-middle"),
            //array("content" => $program_name, "class" => "text-left  align-middle"),
            array("content" => $details, "class" => "text-left  align-middle"),
            array("content" => $date, "class" => "text-center align-middle"),
            array("content" => $options, "class" => "text-center align-middle"),
        )
    );
}
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang('Sie_Enrollments.list_of_enrolled'),
    "header-back" => $back,
    //"header-add"=>"/sie/enrollments/create/" . lpk(),
    "content" => $bgrid,
));
echo($card);
?>