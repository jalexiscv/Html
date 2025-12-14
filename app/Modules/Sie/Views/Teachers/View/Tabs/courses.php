<?php

$b = service("bootstrap");
//[models]--------------------------------------------------------------------------------------------------------------
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");
$musers = model("App\Modules\Sie\Models\Sie_Users");
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
$mexecutions = model('App\Modules\Sie\Models\Sie_Executions');
$mprogress = model('App\Modules\Sie\Models\Sie_Progress');
$menrollments = model('App\Modules\Sie\Models\Sie_Enrollments');
$mpensums = model('App\Modules\Sie\Models\Sie_Pensums');
//[vars]----------------------------------------------------------------------------------------------------------------
$code = "";

$groups = $mcourses
        ->select('teacher, COUNT(*) as course_count')
        ->where('teacher', $oid)
        ->groupBy('teacher')
        ->find();

$count = 0;
$table = "<table class='table table-bordered'>";
foreach ($groups

         as $group) {
    $profile = $mfields->get_Profile($group['teacher']);
//[courses]---------------------------------------------------------------------------------------------------------
    $courses = $mcourses->where('teacher', $group['teacher'])->findAll();
    $table .= "<tr>";
    $table .= "<th valign='middle' class='text-center'>#</th>";
    $table .= "<th valign='middle' class='text-center'>Periodo</th>";
    $table .= "<th valign='middle' class='text-center '>Detalles</th>";
    $table .= "<th valign='middle' class='text-center'><i class=\"fa-regular fa-graduation-cap fa-xl\"></i></th>";
    $table .= "<th valign='middle' class='text-center'><i class=\"fa-regular fa-screen-users fa-xl\"></i></th>";
    $table .= "<th valign='middle' class='text-center'>C</th>";
    $table .= "<th valign='middle' class='text-center'>E</th>";
    $table .= "</tr>";
    $count = 0;
    foreach ($courses as $course) {
        $count++;
        $pensum=$mpensums->get_Pensum($course["pensum"]);
        $link="<a href=\"/sie/courses/view/{$course['course']}\" target=\"_blank\">" . @$course['name'] . "</a>";
        $details="<b>Nombre</b>: ".$link;
        $details.="<br><b>Código</b>: {$course['course']}";
        $details.="<br><b>Periodo</b>: {$course['period']}";

        $credits=@$pensum["credits"];
        $table .= "<tr>";
        $table .= "<td valign='middle' class='text-center'>{$count}</td>";
        $table .= "<td valign='middle' class='text-center'>{$course['period']}</td>";
        $table .= "<td valign='middle' class='text-left'>{$details}</td>";
        $table .= "<td valign='middle' class='text-center'>{$credits}</td>";
        //[students]----------------------------------------------------------------------------------------------------

        $alumns = 0;
        $executions = $mexecutions
                ->select('MAX(execution) as execution, progress, created_at')
                ->where('course', $course['course'])
                ->orderBy('created_at', 'DESC')
                ->groupBy(['course', 'progress', 'created_at'])
                ->find();

        // Esto se hace por que no solo es que se halle inscrito en el curso si no que le corresponda estudiarlo. es decir
        // no solo debe existir la ejecucion si no tambien el progreso
        //echo("<ol>");
        foreach ($executions as $execution) {
            $progress = $mprogress->where('progress', $execution['progress'])->first();
            if (!empty($progress['progress'])) {

                //echo("<li>{$progress['progress']}</li>");

                $enrollment = $menrollments->get_Enrollment($progress['enrollment']);
                if (!empty($enrollment['enrollment'])) {
                    $alumns++;
                }
            }
        }
        //echo("</ol>");
        $table .= "<td valign='middle' class=' text-center'>{$alumns}</td>";


        $conteo = 0;
        foreach ($executions as $execution) {
            $execution = $mexecutions->get_Execution($execution['execution']);
            //echo("<pre>");
            //echo(safe_dump($execution));
            //echo("</pre>");
            //if (is_array($execution)) {
            $c1 = (!empty($execution['c1']) && doubleval($execution['c1']) > 0) ? 1 : 0;
            $c2 = (!empty($execution['c2']) && doubleval($execution['c2']) > 0) ? 1 : 0;
            $c3 = (!empty($execution['c3']) && doubleval($execution['c3']) > 0) ? 1 : 0;
            $conteo += $c1 + $c2 + $c3;
            //$conteo.="<br>{$execution['execution']}--- {$execution['c1']}-{$execution['c2']}-{$execution['c3']}";
            //$conteo.="<br>".safe_dump($execution);
            //}
        }
        $table .= "<td valign='middle' class='text-center'>";
        $table .= $conteo . "/" . ($alumns * 3);
        $table .= "</td>";

        $execution_count = $alumns * 3;
        $percentage = $execution_count > 0 ? round($conteo * 100 / $execution_count, 2) : 0;

        if ($percentage > 100) {
            $percentage = 100;
        }
        $table .= "<td valign='middle' class='text-center'>{$percentage}%</td>";

        $table .= "</tr>";


        //[/students]---------------------------------------------------------------------------------------------------
    }

    //[/courses]--------------------------------------------------------------------------------------------------------
}
$table .= "</table>";
//[build]---------------------------------------------------------------------------------------------------------------
echo($table);
?>
<div id="card-view-convensions" class="card  mb-2">
    <div class="card-body ">
        <div class="card-header">
            Tabla de convenciones
        </div>
        <div class="card-content ">
            <p><ul>
                <li><i class="fa-regular fa-graduation-cap "></i> : Creditos de la malla curricular</li>
                <li><i class="fa-regular fa-screen-users"></i> : Alumnos inscritos</li>
                <li><b>C</b> Calificaciones</li>
                <li><b>E</b> Estado de calificaciones</li>
            </ul></p>
        </div>
    </div>
</div>



<style>
    .codigo {
        font-family: 'Roboto Mono', monospace;
    }
</style>