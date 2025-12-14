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
//[Models]--------------------------------------------------------------------------------------------------------------
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
$mmodules = model('App\Modules\Sie\Models\Sie_Modules');
$mversions = model('App\Modules\Sie\Models\Sie_Versions');
$mpensums = model('App\Modules\Sie\Models\Sie_Pensums');
$mgrids = model('App\Modules\Sie\Models\Sie_Grids');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
$musers = model('App\Modules\Sie\Models\Sie_Users');
$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');
$mexecutions = model('App\Modules\Sie\Models\Sie_Executions');
$mprogress = model('App\Modules\Sie\Models\Sie_Progress');
$menrollments = model('App\Modules\Sie\Models\Sie_Enrollments');
$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
$mstatuses = model('App\Modules\Sie\Models\Sie_Statuses');
$mobservations = model('App\Modules\Sie\Models\Sie_Observations');
//[vars]----------------------------------------------------------------------------------------------------------------
/**
 * $executions = $mexecutions
 * ->select('MAX(execution) as execution, progress')
 * ->where('course', $oid)
 * ->orderBy('created_at', 'DESC')
 * ->groupBy(['course', 'progress'])
 * ->find();
 **/
$status = $course['status'];
$executions = $mexecutions
    ->select('MAX(execution) as execution, registration,progress,c1,c2,c3')
    ->where('course', $oid)
    ->groupBy(['course', 'progress'])
    ->find();

$grid = $bootstrap->get_Grid();
$grid->set_Headers(array(
    array("content" => "#", "class" => "text-center align-middle"),
    array("content" => "EJE", "class" => "text-center align-middle"),
    array("content" => "PRO", "class" => "text-center align-middle"),
    array("content" => "MAT", "class" => "text-center align-middle"),
    //array("content" => "Registro", "class" => "text-center align-middle"),
    array("content" => "Identificación", "class" => "text-center align-middle"),
    array("content" => "OBS", "class" => "text-center align-middle"),
    array("content" => "Nombre", "class" => "text-center align-middle"),
    array("content" => "Estado", "class" => "text-center align-middle"),
    array("content" => "C1", "class" => "text-center align-middle"),
    array("content" => "C2", "class" => "text-center align-middle"),
    array("content" => "C3", "class" => "text-center align-middle"),
    array("content" => "T", "class" => "text-center align-middle"),
    array("content" => "Opciones", "class" => "text-center align-middle"),
));
$count = 0;

foreach ($executions as $execution) {
    if (is_array($execution)) {
        //echo(safe_dump($execution));

        if (!empty($execution['progress'])) {
            $progress = $mprogress->where('progress', $execution['progress'])->first();
            if (!empty($progress['enrollment'])) {
                $count++;
                $enrollment = $menrollments->where('enrollment', $progress['enrollment'])->first();
                $registration = $mregistrations->where('registration', $enrollment['registration'])->first();

                $linkView = "/sie/executions/edit/{$execution['execution']}?t=" . pk();
                $linkDelete = "/sie/executions/delete/{$execution['execution']}?t=" . pk();

                $class_course_status = in_array($status, ["CANCELED", "CLOSED"]) ? "disabled" : "";
                $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_STAR, "title" => lang("App.View"), "href" => $linkView, "class" => "btn-sm btn-primary ml-1 {$class_course_status} e-{$status}",));
                $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $linkDelete, "class" => "btn-sm btn-danger ml-1 {$class_course_status} e-{$status}",));
                $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView . $btnDelete));
                $fullname = @$registration['first_name'] . " " . @$registration['second_name'] . " " . @$registration['first_surname'] . " " . @$registration['second_surname'];

                $real_execution = $mexecutions->where('execution', $execution['execution'])->first();
                $c1 = empty($real_execution['c1']) ? "0,0" : $real_execution['c1'];
                $c2 = empty($real_execution['c2']) ? "0,0" : $real_execution['c2'];
                $c3 = empty($real_execution['c3']) ? "0,0" : $real_execution['c3'];
                $total = empty($real_execution['total']) ? "0,0" : $real_execution['total'];


                $identification_number = @$registration['identification_number'];
                $rn = @$registration['registration'];
                $rnlink = "<a href=\"/sie/students/view/{$rn}\" target=\"_blank\">{$identification_number}</a>";

                $scanceledorpostponed = $mstatuses->get_LastStatusCanceledOrPostponed(@$registration['registration']);

                $istatus = "";
                if (@$scanceledorpostponed['reference'] == "CANCELED") {
                    $istatus = "<span class=\"badge rounded-pill bg-danger\">Cancelado</span>";
                } elseif (@$scanceledorpostponed['reference'] == "POSTPONED") {
                    $istatus = "<span class=\"badge rounded-pill bg-warning text-dark\">Aplazado</span>";
                }

                $countObservations = $mobservations->getCountByAuthorInObject(@$registration['registration'], safe_get_user());

                $execution = "<button type=\"button\" class=\"btn btn-sm btn-outline-secondary\" data-type=\"execution\" data-value=\"" . @$execution['execution'] . "\">E</button>";
                $progress = "<button type=\"button\" class=\"btn btn-sm btn-outline-secondary\" data-type=\"progress\" data-value=\"" . @$progress['progress'] . "\">P</button>";
                $enrollment = "<button type=\"button\" class=\"btn btn-sm btn-outline-secondary\" data-type=\"enrollment\" data-value=\"" . @$enrollment['enrollment'] . "\">M</button>";
                $observations = "<a  href=\"/sie/observations/teacher/{$registration['registration']}?back=/sie/courses/view/{$oid}&course={$oid}\" target=\"_self\" class=\"btn btn-sm btn-outline-secondary\">{$countObservations}</a>";

                $grid->add_Row(
                    array(
                        array("content" => $count, "class" => "text-center align-middle"),
                        array("content" => $execution, "class" => "text-center align-middle"),
                        array("content" => $progress, "class" => "text-center align-middle"),
                        array("content" => $enrollment, "class" => "text-center align-middle"),
                        //array("content" => @$registration['registration'], "class" => "text-center align-middle"),
                        array("content" => $rnlink, "class" => "text-center align-middle"),
                        array("content" => $observations, "class" => "text-center align-middle"),
                        array("content" => $fullname, "class" => "text-left align-middle"),
                        array("content" => $istatus, "class" => "text-center align-middle"),
                        array("content" => $c1, "class" => "text-center align-middle"),
                        array("content" => $c2, "class" => "text-center align-middle"),
                        array("content" => $c3, "class" => "text-center align-middle"),
                        array("content" => $total, "class" => "text-center align-middle"),
                        array("content" => $options, "class" => "text-center align-middle"),
                    ),
                );
            } else {
                // Lo dejo por que nos podria ayudar a identificar estudiantes a los que por error les dieron
                // de baja el modulo y estaban activos en el curso
                /**
                 * $progress = $mprogress->where('progress', $execution['progress'])->first();
                 * $enrollment = $menrollments->where('enrollment', @$progress['enrollment'])->first();
                 * $grid->add_Row(
                 * array(
                 * array("content" => "R", "class" => "text-center align-middle"),
                 * array("content" => $execution['execution'], "class" => "text-center align-middle"),
                 * array("content" => @$progress['progress'], "class" => "text-center align-middle"),
                 * array("content" => "", "class" => "text-center align-middle"),
                 * //array("content" => "", "class" => "text-center align-middle"),
                 * array("content" => "", "class" => "text-center align-middle"),
                 * array("content" => "", "class" => "text-left align-middle"),
                 * array("content" => "", "class" => "text-center align-middle"),
                 * array("content" => @$execution['c1'], "class" => "text-center align-middle"),
                 * array("content" => @$execution['c2'], "class" => "text-center align-middle"),
                 * array("content" => @$execution['c3'], "class" => "text-center align-middle"),
                 * array("content" => "", "class" => "text-center align-middle"),
                 * array("content" => "", "class" => "text-center align-middle"),
                 * ),
                 * );
                 **/
            }
        } elseif (!empty($execution['registration'])) {
            $registration = $mregistrations->getRegistration($execution['registration']);
            if (!empty($registration['registration'])) {
                $count++;
                $linkView = "/sie/executions/edit/{$execution['execution']}?t=" . pk();
                $linkDelete = "/sie/executions/delete/{$execution['execution']}?t=" . pk();

                $class_course_status = in_array($status, ["CANCELED", "CLOSED"]) ? "disabled" : "";
                $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_STAR, "title" => lang("App.View"), "href" => $linkView, "class" => "btn-sm btn-primary ml-1 {$class_course_status} e-{$status}",));
                $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $linkDelete, "class" => "btn-sm btn-danger ml-1 {$class_course_status} e-{$status}",));
                $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView . $btnDelete));
                $fullname = @$registration['first_name'] . " " . @$registration['second_name'] . " " . @$registration['first_surname'] . " " . @$registration['second_surname'];

                $real_execution = $mexecutions->where('execution', $execution['execution'])->first();
                $c1 = empty($real_execution['c1']) ? "0,0" : $real_execution['c1'];
                $c2 = empty($real_execution['c2']) ? "0,0" : $real_execution['c2'];
                $c3 = empty($real_execution['c3']) ? "0,0" : $real_execution['c3'];
                $total = empty($real_execution['total']) ? "0,0" : $real_execution['total'];


                $identification_number = @$registration['identification_number'];
                $rn = @$registration['registration'];
                $rnlink = "<a href=\"/sie/students/view/{$rn}\" target=\"_blank\">{$identification_number}</a>";

                $scanceledorpostponed = $mstatuses->get_LastStatusCanceledOrPostponed(@$registration['registration']);

                $istatus = "";
                if (@$scanceledorpostponed['reference'] == "CANCELED") {
                    $istatus = "<span class=\"badge rounded-pill bg-danger\">Cancelado</span>";
                } elseif (@$scanceledorpostponed['reference'] == "POSTPONED") {
                    $istatus = "<span class=\"badge rounded-pill bg-warning text-dark\">Aplazado</span>";
                }

                $countObservations = $mobservations->getCountByAuthorInObject(@$registration['registration'], safe_get_user());


                $execution = "<button type=\"button\" class=\"btn btn-sm btn-outline-secondary\" data-type=\"execution\" data-value=\"" . @$execution['execution'] . "\">E</button>";
                $progress = "<button type=\"button\" class=\"btn btn-sm btn-outline-secondary\" data-type=\"progress\" data-value=\"" . @$progress['progress'] . "\">P</button>";
                $enrollment = "<button type=\"button\" class=\"btn btn-sm btn-outline-secondary\" data-type=\"enrollment\" data-value=\"" . @$enrollment['enrollment'] . "\">M</button>";
                $observations = "<a  href=\"/sie/observations/teacher/{$registration['registration']}?back=/sie/courses/view/{$oid}&course={$oid}\" target=\"_self\" class=\"btn btn-sm btn-outline-secondary\">{$countObservations}</a>";

                $grid->add_Row(
                    array(
                        array("content" => $count, "class" => "text-center align-middle"),
                        array("content" => $execution, "class" => "text-center align-middle"),
                        array("content" => @$progress['progress'], "class" => "text-center align-middle"),
                        array("content" => @$enrollment['enrollment'], "class" => "text-center align-middle"),
                        //array("content" => @$registration['registration'], "class" => "text-center align-middle"),
                        array("content" => $rnlink, "class" => "text-center align-middle"),
                        array("content" => $observations, "class" => "text-center align-middle"),
                        array("content" => $fullname, "class" => "text-left align-middle"),
                        array("content" => $istatus, "class" => "text-center align-middle"),
                        array("content" => $c1, "class" => "text-center align-middle"),
                        array("content" => $c2, "class" => "text-center align-middle"),
                        array("content" => $c3, "class" => "text-center align-middle"),
                        array("content" => $total, "class" => "text-center align-middle"),
                        array("content" => $options, "class" => "text-center align-middle"),
                    ),
                );
            }
        }
    }
}


$card = $bootstrap->get_Card2("card-view-service", array(
    "header-title" => "Estudiantes Matriculados",
    "header-add" => "#" . $oid,
    "body-class" => "px-0 py-0",
    "header-synchronize" => "/sie/tools/moodle/courses/" . $oid,
    //"header-add" => "/sie/enrolleds/create/" . $oid,
    "content" => $grid,
));
echo($card);
?>
<?php include("modals.php"); ?>
<?php include("javascript.php"); ?>