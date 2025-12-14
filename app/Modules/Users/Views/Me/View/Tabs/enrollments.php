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
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields2");
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
$enrollments = $menrollments->get_EnrollmentsByStudent($registration);
$total = $menrollments->get_Total($registration);
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
    array("content" => lang("App.Date"), "class" => "text-center align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center text-nowrap align-middle"),
));
//$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$bgrid->set_Buttons(
    array(
    )
);
$count = $offset;
foreach ($enrollments as $enrollment) {
    $count++;
    $registration = $mregistrations->getRegistration($enrollment['registration']);
    $btnview = $bootstrap->get_Link("btn-view", array(
        "size" => "sm",
        "icon" => ICON_VIEW,
        "title" => lang("App.View"),
        "href" => "/sie/progress/reader/" . $enrollment['enrollment'],
        "class" => "btn-primary ml-1",
        "target" => "_self",
    ));
    $btnedit = $bootstrap->get_Link("btn-edit", array(
        "size" => "sm",
        "icon" => ICON_EDIT,
        "title" => lang("App.Delete"),
        "href" => "/sie/enrollments/edit/" . $enrollment['enrollment'],
        "class" => "btn-secondary ml-1",
        "target" => "_blank",
    ));

    $btndelete = $bootstrap->get_Link("btn-delete", array(
        "size" => "sm",
        "icon" => ICON_DELETE,
        "title" => lang("App.Delete"),
        "href" => "/sie/enrollments/delete/" . $enrollment['enrollment'],
        "class" => "btn-danger ml-1",
        "target" => "_blank",
    ));


    $btnmove = $bootstrap->get_Link("btn-move", array(
        "size" => "sm",
        "icon" => ICON_MOVE,
        "title" => lang("App.Move"),
        "href" => "/sie/enrollments/move/" . $enrollment['enrollment'],
        "class" => "btn-warning ml-1",
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
    $program_name = $program['name'];
    $grid = $mgrids->get_Grid($enrollment['grid']);
    $grid_name = $grid['name'];
    $date = $enrollment['date'];

    $options = $bootstrap->get_BtnGroup("btn-group", array(
        "content" => $btnview ,
    ));

    $author="";
    $author_name="";
    if(!empty($enrollment['author'])){
        //$author = $mfields->get_profile($enrollment['author']);
        //$author_name = @$author['name'];
    }


    $details = "<b>Matricula</b>: {$enrollment['enrollment']} <b>Periodo</b>: " . @$registration['period'] . " <br>";
    $details .= "<b>Estudiante</b>: {$student_name}<br>";
    $details .= "<b>Identificación</b>: {$student_identification}<br>";
    $details .= "<b>Programa</b>: {$program_name}<br>";
    $details .= "<b>Malla</b>: {$grid_name}<br>";
    $details .= "<b>Descripción</b>: {$enrollment['observation']}<br>";
    $details .= "<b>Responsable</b>: {$author_name} - <span class=\"opacity-25\">{$enrollment['author']}</span>";

    $bgrid->add_Row(
        array(
            array("content" => $count, "class" => "text-center align-middle"),
            array("content" => "<img src=\"/themes/assets/images/icons/enrollment.png\" width=\"128\">", "class" => "text-center align-middle"),
            //array("content" => $enrollment['enrollment'], "class" => "text-center align-middle"),
            //array("content" => $identificacion, "class" => "text-left align-middle"),
            //array("content" => $student_name . "<br>" . $program_name, "class" => "text-left align-middle"),
            //array("content" => $program_name, "class" => "text-left text-nowrap align-middle"),
            array("content" => $details, "class" => "text-left align-middle"),
            array("content" => $date, "class" => "text-center align-middle"),
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

