<?php
//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
//[models]--------------------------------------------------------------------------------------------------------------
$mpensums = model("App\Modules\Sie\Models\Sie_Pensums");
$mprogress = model("App\Modules\Sie\Models\Sie_Progress");
$mmodules = model("App\Modules\Sie\Models\Sie_Modules");
$menrollments = model("App\Modules\Sie\Models\Sie_Enrollments");
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$mgrids = model("App\Modules\Sie\Models\Sie_Grids");
$mversions = model("App\Modules\Sie\Models\Sie_Versions");
$mexecutions = model("App\Modules\Sie\Models\Sie_Executions");
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");
//[vars]----------------------------------------------------------------------------------------------------------------


$progresses = $mprogress->where('pensum', null)->limit(5000)->find();
$count = 0;
echo("<table class='table-bordered col-auto'>");
echo("<tr>");
echo("<td>Caso</td>");
echo("<td>Progreso</td>");
echo("<td>Módulo</td>");
echo("<td>Matricula</td>");
echo("<td>Estudiante</td>");
echo("<td>Programa</td>");
echo("<td>Versión</td>");
echo("<td>Pensum</td>");

echo("</tr>");
foreach ($progresses as $progress) {
    $count++;
    $menrollment = $menrollments->find($progress['enrollment']);

    $rpensum = $mpensums
        ->where('version', $menrollment['version'])
        ->where('module', $progress['module'])
        ->first();


    $pensum = "<span class='badge text-bg-danger'>No encontrado</span>";
    if (is_array($rpensum)) {
        $update = $mprogress->update($progress['progress'], array('pensum' => $rpensum['pensum']));
        $pensum = "<span class='badge text-bg-success'>{$rpensum['pensum']}</span>";
    }

    echo("<tr>");
    echo("<td>{$count}</td>");
    echo("<td>{$progress['progress']}</td>");
    echo("<td>{$progress['module']}</td>");
    echo("<td>" . $progress['enrollment'] . "</td>");
    echo("<td>" . $menrollment['registration'] . "</td>");
    echo("<td>" . $menrollment['program'] . "</td>");
    echo("<td>" . $menrollment['version'] . "</td>");
    echo("<td>{$pensum}</td>");
    echo("</tr>");
}
echo("</table>");
?>