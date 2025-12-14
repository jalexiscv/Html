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
$mexecutions = model("App\Modules\Sie\Models\Sie_Executions");
$mpensums = model("App\Modules\Sie\Models\Sie_Pensums");
$mprogress = model("App\Modules\Sie\Models\Sie_Progress");
$mmodules = model("App\Modules\Sie\Models\Sie_Modules");
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");
//[request]-------------------------------------------------------------------------------------------------------------
$back = "/sie/enrollments/home/" . lpk();
$offset = !empty($request->getGet("offset")) ? $request->getGet("offset") : 0;
$search = !empty($request->getGet("search")) ? $request->getGet("search") : "";
$field = !empty($request->getGet("field")) ? $request->getGet("field") : "";
$limit = !empty($request->getGet("limit")) ? $request->getGet("limit") : 100000;
$fields = [
    'identification' => 'Matricula',
    'names' => 'Estudiante',
    'program' => 'Programa académico',
];
//[build]--------------------------------------------------------------------------------------------------------------
$executions = $mexecutions->get_Preenrollments($limit, $offset, $search);
//print_r($executions);
$total = $mexecutions->get_TotalPreenrollments($search);
//[build]--------------------------------------------------------------------------------------------------------------
$count = $offset;
$code = "";
$code .= "<table class='table table-bordered'>";
$code .= "<tr>";
$code .= "<th>#</th>";
//$code.="<th>Matricula</th>";
$code .= "<th>Estudiante</th>";
$code .= "<th>Identificación</th>";
$code .= "<th>Programa académico</th>";
$code .= "<th>Prematricula</th>";
$code .= "</tr>";
foreach ($executions as $exec) {
    //echo("<pre>");
    //print_r($exec);
    //echo("</pre>");
    $registration = $mregistrations->getRegistration($exec['registration']);
    $enrollment = $menrollments->get_Enrollment($exec['enrollment']);
    $program = $mprograms->getProgram($enrollment['program']);
    $student_name = $registration['first_name'] . " " . $registration['second_name'] . " " . $registration['first_surname'] . " " . $registration['second_surname'];
    $student_identification = $registration['identification_type'] . " " . $registration['identification_number'];
    $program_name = $program['name'];

    $count++;
    $code .= "<tr>";
    $code .= "<td>{$count}</td>";
    //$code.="<td>{$exec['enrollment']}</td>";
    $code .= "<td>{$student_name}</td>";
    $code .= "<td>{$student_identification}</td>";
    $code .= "<td>{$program_name}</td>";
    $code .= "<td>";

    $progresses = $mprogress->get_ProgressByEnrollment($enrollment['enrollment']);
    $code .= "<table class='table table-bordered'>";
    $code .= "<tr>";
    //$code.="<th>Progreso</th>";
    //$code.="<th>Módulo</th>";
    $code .= "<th>Módulo</th>";
    $code .= "<th>Curso</th>";
    $code .= "<th>Profesor</th>";
    $code .= "<th>Jornada</th>";
    $code .= "<th>Detalle</th>";
    $code .= "</tr>";
    foreach ($progresses as $progress) {
        //print_r($progress);
        //1. Consulto la ejecucion por el progreso
        $module = $mmodules->get_Module($progress['module']);
        $exec = $mexecutions->getLastExecutionbyProgress($progress['progress']);

        if (!empty($exec['course'])) {
            $course = $mcourses->getCourse($exec['course']);
            $teacher_name = $mfields->get_FullName($course['teacher']);

            $code .= "<tr>";
            //$code.="<td>{$progress['progress']}</td>";
            //$code.="<td>{$progress['module']}</td>";
            $code .= "<td>{$module['name']}";
            $code .= "<td>" . @$course['name'] . "</td>";
            $code .= "<td>" . $teacher_name . "</td>";
            $code .= "<td>" . @$course['journey'] . "</td>";
            $code .= "<td>" . @$course['description'] . "</td>";
            $code .= "</tr>";
        }

    }
    $code .= "</table>";
    $code .= "</td>";
    $code .= "</tr>";

}
$code .= "</table>";
echo($code);
?>