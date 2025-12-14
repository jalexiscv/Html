<?php

$b = service("bootstrap");
//[models]--------------------------------------------------------------------------------------------------------------
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");
$musers = model("App\Modules\Sie\Models\Sie_Users");
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
$mexecutions = model('App\Modules\Sie\Models\Sie_Executions');
//[vars]----------------------------------------------------------------------------------------------------------------
$code = "";

$groups = $mcourses
    ->select('teacher, COUNT(*) as course_count')
    ->groupBy('teacher')
    ->findAll();


$code .= "<table class='table table-bordered'>";
$code .= "<tr>";
$code .= "    <th>#</th>";
//$code.="    <th>Profesor</th>";
$code .= "    <th>Nombre</th>";
$code .= "    <th>Cursos</th>";
$code .= "    <th>Notas</th>";
$code .= "    <th>Fechas</th>";
//$code.="    <th>Fecha(Ultima)</th>";
$code .= "</tr>";

$count = 0;
foreach ($groups as $group) {
    $profile = $mfields->get_Profile($group['teacher']);
    //[courses]---------------------------------------------------------------------------------------------------------
    $courses = $mcourses->where('teacher', $group['teacher'])->findAll();
    $textcourses = "<table>";
    foreach ($courses as $course) {
        $textcourses .= "<tr>";
        //$califications = $musers->get_Califications($group['teacher'], $course['id']);
        $textcourses .= "<td class='text-left'>";
        $textcourses .= "<b>Curso</b>: <a href=\"/sie/courses/view/{$course['course']}\" target=\"_blank\">" . $course['course'] . "</a>";
        $textcourses .= "</td>";
        //[students]----------------------------------------------------------------------------------------------------
        $executions = $mexecutions
            ->select('MAX(execution) as execution, progress')
            ->where('course', $course['course'])
            ->orderBy('created_at', 'DESC')
            ->groupBy(['course', 'progress'])
            ->find();
        $textcourses .= "<td class='text-left'>";
        $textcourses .= "<b>Estudiantes</b>: " . count($executions) . "</br>";
        $textcourses .= "</td>";
        $textcourses .= "<td class='text-left'>";
        $textcourses .= "<b>Calificaciones</b>: ";
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
        $textcourses .= $conteo . "/" . (count($executions) * 3);
        $textcourses .= "</td>";
        $textcourses .= "</tr>";
        //[/students]---------------------------------------------------------------------------------------------------
    }
    $textcourses .= "</table>";
    //[/courses]--------------------------------------------------------------------------------------------------------
    $count++;
    $code .= "<tr>";
    $code .= "    <td>" . $count . "</td>";
    //$code.="    <td>".$group['teacher']."</td>";
    $code .= "    <td><a href=\"/sie/teachers/report/" . lpk() . "?teacher={$group['teacher']}\" target=\"_blank\">" . $profile['name'] . "</a></td>";
    $code .= "    <td class=\"text-end\">" . $group['course_count'] . "</td>";
    $code .= "    <td class=\"text-left\">" . $textcourses . "</td>";
    $code .= "    <td class=\"text-center\">Inicio<br>Final</td>";
    //$code.="    <td class=\"text-center\">Final</td>";
    $code .= "</tr>";
}
$code .= "</table>";

//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card("create", array(
    "title" => "Reporte de Profesores",
    "content" => $code,
    "header-back" => "/sie/teachers/list/" . lpk(),
));
echo($card);
?>