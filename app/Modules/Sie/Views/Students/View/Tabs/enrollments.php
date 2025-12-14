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
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields.php");
$mstatuses = model("App\Modules\Sie\Models\Sie_Statuses");
//[request]-------------------------------------------------------------------------------------------------------------
$back = "/sie/enrollments/home/" . lpk();
$offset = !empty($request->getGet("offset")) ? $request->getGet("offset") : 0;
$search = !empty($request->getGet("search")) ? $request->getGet("search") : "";
$field = !empty($request->getGet("field")) ? $request->getGet("field") : "";
$limit = !empty($request->getGet("limit")) ? $request->getGet("limit") : 10;
$fields = ['identification' => 'Número de identificación', 'names' => 'Nombres'];
//[build]--------------------------------------------------------------------------------------------------------------
if ($field == "identification") {
    $registration = $mregistrations->getRegistrationByIdentification($search);
    $vsearch = $registration['registration'];
} elseif ($field == "names") {
    $registration = $mregistrations->getRegistrationByName($search);
    $vsearch = $search;
    if ($registration) {
        $vsearch = $registration['registration'];
    }
} else {
    $vsearch = $search;
}
$enrollments = $menrollments->get_EnrollmentsByStudent($oid);
$total = $menrollments->get_Total($oid);
//[build]--------------------------------------------------------------------------------------------------------------
$bgrid = $bootstrap->get_Grid();
$bgrid->set_Total($total);
$bgrid->set_Limit($limit);
$bgrid->set_Offset($offset);
$bgrid->set_Class("P-0 m-0");
$bgrid->set_Limits(array(10, 20, 40, 80, 160, 320, 640, 1200, 2400));
$bgrid->set_Headers(array(
    array("content" => "#", "class" => "text-center text-nowrap align-middle"),
    array("content" => "", "class" => "text-center text-nowrap align-middle"),
    //array("content" => lang("App.Enrollment"), "class" => "text-center align-middle"),
    array("content" => lang("App.Student"), "class" => "text-center align-middle"),
    //array("content" => lang("App.Identification"), "class" => "text-center align-middle"),
    //array("content" => lang("App.Program"), "class" => "text-center align-middle"),
    //array("content" => lang("App.Date"), "class" => "text-center align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center text-nowrap align-middle"),
));
//$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$bgrid->set_Buttons(
    array(
        $bootstrap->get_Link("btn-bill", array(
            "size" => "sm",
            "icon" => ICON_PLUS,
            "text" => "Crear Matricula",
            "href" => "/sie/enrollments/create/{$oid}?back=" . urlencode("/sie/students/view/{$oid}#enrollments"),
        )),
    )
);
$count = $offset;
foreach ($enrollments as $enrollment) {
    $count++;
    $registration = $mregistrations->getRegistration($enrollment['registration']);
    $btnView = $bootstrap->get_Link("btn-view", array(
        "size" => "sm",
        "icon" => ICON_VIEW,
        "title" => lang("App.View"),
        "href" => "/sie/enrollments/view/" . $enrollment['enrollment'],
        "class" => "btn-sm btn-primary ml-1",
        "target" => "_blank",
    ));
    $btnProgress = $bootstrap->get_Link("btn-progress", array(
        "size" => "sm",
        "icon" => ICON_ENROLLMENT,
        "title" => lang("App.View"),
        "href" => "/sie/progress/list/" . $enrollment['enrollment'],
        "class" => "btn-sm btn-warning ml-1",
        "target" => "_blank",
    ));
    $btnedit = $bootstrap->get_Link("btn-edit", array(
        "size" => "sm",
        "icon" => ICON_EDIT,
        "title" => lang("App.Delete"),
        "href" => "/sie/enrollments/edit/" . $enrollment['enrollment'],
        "class" => "btn-secondary ml-1",
        "target" => "_self",
    ));

    $btndelete = $bootstrap->get_Link("btn-delete", array(
        "size" => "sm",
        "icon" => ICON_DELETE,
        "title" => lang("App.Delete"),
        "href" => "/sie/enrollments/delete/" . $enrollment['enrollment'],
        "class" => "btn-sm btn-danger ml-1",
        "target" => "_blank",
    ));


    $btnmove = $bootstrap->get_Link("btn-move", array(
        "size" => "sm",
        "icon" => ICON_MOVE,
        "title" => lang("App.Move"),
        "href" => "/sie/enrollments/move/" . $enrollment['enrollment'],
        "class" => "btn-sm btn-warning ml-1",
        "target" => "_blank",
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
    $program_program = @$program['program'];
    $program_name = @$program['name'];
    $grid = $mgrids->get_Grid(@$enrollment['grid']);
    $grid_name = @$grid['name'];
    $date = @$enrollment['date'];

    $options = $bootstrap->get_BtnGroup("btn-group", array(
        "content" => $btnProgress . $btnView,
    ));


    $author = $mfields->get_profile($enrollment['author']);
    $author_name = @$author['name'];


    // Debo buscar el último estado asociado con esta matrícula, dado que es una matrícula por programa se supone
    // No deben existir multiples matrículas en un mismo programa. El estado visible será igual al último estado asociable
    // al programa de la matrícula visualizada.
    $qstatus = $mstatuses->get_LastStatusByRegistrationByProgram(@$student["registration"], @$program["program"]);

    $reference = @$qstatus["reference"];
    $enrollment_status = @$enrollment["status"];

    if ($reference == "GRADUATED") {
        $status = "<span class='badge bg-success'>Graduado</span>";
    } elseif ($reference == "ENROLLED-OLD") {
        if ($enrollment_status == "DISABLED") {
            $status = "<span class='badge bg-secondary text-white'>Inactivo</span>";
        } else {
            $status = "<span class='badge bg-danger'>Activo {$enrollment_status}</span>";
        }
    } else {
        //$status_refrence=@$qstatus["reference"];
        $status = "<span class='badge bg-danger'>Activo</span>";
        //$status.= " | <span class='badge bg-danger'>{$student["registration"]}</span>";
        //$status.= " | <span class='badge bg-danger'>{$program["program"]}</span>";
        //$status.= " | <span class='badge bg-danger'>{$status_refrence}</span>";
    }

    // Buscare el ultimo estado
    $laststatus = $mstatuses->getLastByRegistrationAndProgram($enrollment['registration'], $enrollment['program']);
    $laststatus_period = @$laststatus['period'];
    $laststatus_name = get_sie_status_type_name(@$laststatus['reference']);
    if (empty($laststatus_period)) {
        $laststatus_period = "<span class=\"opacity-3\">Sin referencia</span>";
    }

    if (empty($laststatus_name)) {
        $laststatus_name = "<span class=\"opacity-3\">Sin referencia</span>";
    }

    $grid_cycle = @$laststatus['cycle'];
    $grid_journey = @$laststatus['journey'];


    $details = "";
    $details .= "<b>Programa</b>: {$program_name} - <span class=\"opacity-25\">{$program_program}</span> <br>";
    $details .= "<b>Matricula</b>: {$enrollment['enrollment']} <b>Fecha de matricula</b>: {$enrollment['date']} <br>";
    $details .= "<b>Periodo</b>: {$laststatus_period} <b>Último estado</b>: {$laststatus_name}</b><br>";
    //$details .= "<b>Estudiante</b>: {$student_name}<br>";
    //$details .= "<b>Identificación</b>: {$student_identification}<br>";
    $details .= "<b>Ciclo</b>: {$grid_cycle} <b>Jornada</b>: {$grid_journey}<br>";
    $details .= "<b>Malla</b>: {$grid_name}<br>";
    $details .= "<b>Descripción</b>: {$enrollment['observation']}<br>";
    $details .= "<b>Responsable</b>: {$author_name} - <span class=\"opacity-25\">{$enrollment['author']}</span><br>";
    $details .= "<b>Referencia académica</b>: {$status}";

    $bgrid->add_Row(
        array(
            array("content" => $count, "class" => "text-center align-middle"),
            array("content" => "<img src=\"/themes/assets/images/icons/enrollment.png\" width=\"128\">", "class" => "text-center align-middle"),
            //array("content" => $enrollment['enrollment'], "class" => "text-center align-middle"),
            //array("content" => $identificacion, "class" => "text-left align-middle"),
            //array("content" => $student_name . "<br>" . $program_name, "class" => "text-left align-middle"),
            //array("content" => $program_name, "class" => "text-left text-nowrap align-middle"),
            array("content" => $details, "class" => "text-left align-middle"),
            //array("content" => $date, "class" => "text-center align-middle"),
            array("content" => $options, "class" => "text-center align-middle"),
        )
    );
}
//[build]---------------------------------------------------------------------------------------------------------------
$create_enrollment = "/sie/enrollments/create/{$oid}";
$info = $bootstrap->get_Alert(array(
    'type' => 'info',
    'title' => lang('App.Remember'),
    "message" => sprintf(lang("Sie_Enrollments.message-student-list-info"), $create_enrollment),
));
echo($info);
echo($bgrid);
?>