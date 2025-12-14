<?php

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
$mattachments = model("App\Modules\Sie\Models\Sie_Attachments");
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");
$mstatuses = model("App\Modules\Sie\Models\Sie_Statuses");
$magreements = model("App\Modules\Sie\Models\Sie_Agreements");
//[request]-------------------------------------------------------------------------------------------------------------
$back = "/sie";
$offset = !empty($request->getGet("offset")) ? $request->getGet("offset") : 0;
$search = !empty($request->getGet("search")) ? $request->getGet("search") : "";
$field = !empty($request->getGet("field")) ? $request->getGet("field") : "";
$limit = !empty($request->getGet("limit")) ? $request->getGet("limit") : 10;
$fields = [
    'general' => 'General',
    'enrrolleds' => 'Matriculados',
];

//[build]--------------------------------------------------------------------------------------------------------------
$registrations = $mregistrations->getGrid($limit, $offset, $field, $search);
$total = $mregistrations->getGridCount($search);
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
    $author_name = sie_get_textual_author($registration["author"]);
    $last_status = $mstatuses->get_LastStatus($registration['registration']);
    $status_name = sie_get_textual_status($last_status);
    $status_period = @$last_status['period'];
    $status_moment = @$last_status['moment'];
    $status_cycle = @$last_status['cycle'];
    $status_author_name = sie_get_textual_author(@$last_status['author']);
    $status_date = @$last_status['date'];

    $agreement = $magreements->get_Agreement(@$registration['agreement']);
    $agreement_agreement = @$agreement['agreement'];
    $agreement_name = !empty($agreement['name']) ? $agreement['name'] : "Estudiante Regular";

    //[build]-----------------------------------------------------------------------------------------------------------
    $details = "<b>Nombre</b>: {$fullname} - <span class=\"opacity-25\">{$registration['registration']}</span> | ";
    $details .= "<b>Identificación</b>: {$identification}</br>";
    $details .= "<b>Convenio</b>: {$agreement_name} - <span class=\"opacity-25\">{$agreement_agreement}</span> </br>";
    $details .= "<b>Programa</b>: {$program_name} </br>";
    $details .= "<b>Último Estado</b>: {$status_name} | <b>Periodo</b>: {$status_period} | <b>Momento</b>: {$status_moment} | <b>Ciclo</b>{$status_cycle} | <b>Fecha</b>: {$status_date}</br>";
    $details .= "<b>Responsable Último Estado</b>: {$status_author_name} </br>";


    $photo = $mattachments->get_StudentPhoto($registration['registration']);
    $image = $bootstrap->get_Img("img-thumbnail", array("src" => $photo, "alt" => $fullname, "width" => "64", "class" => "",));

    $btnprofile = $bootstrap->get_Link("btn-profile", array("size" => "sm", "icon" => ICON_USER, "title" => lang("App.Profile"), "href" => "/sie/students/view/{$registration['registration']}", "class" => "btn-sm btn-primary ml-1",));
    $btnenrollment = $bootstrap->get_Link("btn-enrollment", array("size" => "sm", "icon" => ICON_ENROLL, "title" => lang("App.View"), "href" => "/sie/enrollments/create/{$registration['registration']}", "class" => "btn-secondary ml-1",));
    $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnprofile));
    $bgrid->add_Row(
        array(
            array("content" => $count, "class" => "text-center align-middle"),
            array("content" => $image, "class" => "text-center no-wrap align-middle"),
            array("content" => $details, "class" => "text-left align-middle details"),
            array("content" => $options, "class" => "text-center align-middle"),
        )
    );
}
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));

//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("card-view-service", array(
    "header-title" => "Listado de estudiantes",
    "header-back" => $back,
    "header-add" => "/sie/students/create/" . lpk(),
    "content" => $bgrid,
));
echo($card);
//[history-logger]------------------------------------------------------------------------------------------------------
history_logger(array(
    "module" => "SIE",
    "type" => "ACCESS",
    "reference" => "COMPONENT",
    "object" => "STUDENTS-LIST",
    "log" => "El usuario accede al listado de estudiantes del <b>Módulo SIE</b>",
));
safe_js_title("Listado de estudiantes");
?>