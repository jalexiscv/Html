<?php
/** @var string $oid */
/** @var object $bootstrap */
/** @var string $status */
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
//[vars]----------------------------------------------------------------------------------------------------------------
/**
 * $executions = $mexecutions
 * ->select('MAX(execution) as execution, progress')
 * ->where('course', $oid)
 * ->orderBy('created_at', 'DESC')
 * ->groupBy(['course', 'progress'])
 * ->find();
 **/
$executions = $mexecutions
    ->select('MAX(execution) as execution, progress')
    ->where('course', $oid)
    ->groupBy(['course', 'progress'])
    ->find();

$grid = $bootstrap->get_Grid();
$grid->set_Headers(array(
    array("content" => "#", "class" => "text-center align-middle"),
    //array("content" => "Ejecución", "class" => "text-center align-middle"),
    array("content" => "Progreso", "class" => "text-center align-middle"),
    array("content" => "Matricula", "class" => "text-center align-middle"),
    //array("content" => "Registro", "class" => "text-center align-middle"),
    array("content" => "Identificación", "class" => "text-center align-middle"),
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
        $count++;
        $progress = $mprogress->where('progress', $execution['progress'])->first();
        if (!empty($progress['enrollment'])) {
            $enrollment = $menrollments->where('enrollment', $progress['enrollment'])->first();
            $registration = $mregistrations->where('registration', $enrollment['student'])->first();

            $linkView = "/sie/executions/edit/{$execution['execution']}?t=" . pk();


            $class_course_status = "";

            if ($status == "CANCELED" || $status == "CLOSED") {
                $class_course_status = "disabled";
            }

            $btnview = $bootstrap->get_Link("btn-view", array(
                    "size" => "sm",
                    "icon" => ICON_STAR,
                    "title" => lang("App.View"),
                    "href" => $linkView,
                    "class" => "btn-danger ml-1 {$class_course_status}",)
            );


            $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnview));

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

            $status = "";
            if (@$scanceledorpostponed['reference'] == "CANCELED") {
                $status = "<span class=\"badge rounded-pill bg-danger\">Cancelado</span>";
            } elseif (@$scanceledorpostponed['reference'] == "POSTPONED") {
                $status = "<span class=\"badge rounded-pill bg-warning text-dark\">Aplazado</span>";
            }

            $grid->add_Row(
                array(
                    array("content" => $count, "class" => "text-center align-middle"),
                    //array("content" => $execution['execution'], "class" => "text-center align-middle"),
                    array("content" => @$progress['progress'], "class" => "text-center align-middle"),
                    array("content" => @$enrollment['enrollment'], "class" => "text-center align-middle"),
                    //array("content" => @$registration['registration'], "class" => "text-center align-middle"),
                    array("content" => $rnlink, "class" => "text-center align-middle"),
                    array("content" => $fullname, "class" => "text-left align-middle"),
                    array("content" => $status, "class" => "text-center align-middle"),
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
echo($grid);
?>