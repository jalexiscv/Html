<?php
require_once(APPPATH . 'ThirdParty/Spreadsheet/vendor/autoload.php');


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
// Añadir algunos datos de ejemplo
//[services]----------------------------------------------------------------------------------------------------
$request = service('Request');
//[models]------------------------------------------------------------------------------------------------------
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
//[request]-----------------------------------------------------------------------------------------------------
$offset = !empty($request->getGet("offset")) ? $request->getGet("offset") : 0;
$search = !empty($request->getGet("search")) ? $request->getGet("search") : "";
$limit = !empty($request->getGet("limit")) ? $request->getGet("limit") : 100000;
//[build]-------------------------------------------------------------------------------------------------------
$executions = $mexecutions->get_Preenrollments($limit, $offset, $search);
//$total = $mexecutions->get_TotalPreenrollments($search);
//[build]-------------------------------------------------------------------------------------------------------
/**
 * Array
 * (
 * [0] => Array
 * (
 * [enrollment] => 66BE8E1537106
 * [student] => 66B4454958D96
 * [execution] => 66E45BA4AD02D
 * [course] => 66D62B7BA7D11
 * [course_progress] => 66E459E648BAD
 * [course_program] => 6629B65C80C1F
 * [course_grid] => 662A9E842243D
 * [course_module] => 662AAE03B5F51
 * [course_name] => Elegible 2 (TCO procesos administrativos) - 41112V4p
 * [pensum] => 662AAE03B5F51
 * [pensum_module] => 6629B4787E328
 * [pensum_module_name] => Elegible 2 (TCO procesos administrativos)
 * [version] => 662A9E9B8C2DB
 * [version_reference] => V4
 * [grid] => 662A9E842243D
 * [grid_name] => Técnico Profesional en Procesos Administrativos
 * [first_name] => Luisa
 * [second_name] => Fernanda
 * [first_surname] => Valero
 * [second_surname] => Henao
 * [identification_number] => 1115084193
 * [identification_type] => CC
 * [period] =>
 * )
 */

$count = $offset;
// ciclo
//
$sheet->setCellValue('A1', 'Identificación');
$sheet->setCellValue('B1', 'Tipo');
$sheet->setCellValue('C1', 'Estudiante');
$sheet->setCellValue('D1', 'Periodo');
$sheet->setCellValue('E1', 'Programa académico');
$sheet->setCellValue('F1', 'Modulo');
$sheet->setCellValue('G1', 'Ciclo');
$sheet->setCellValue('H1', 'Momento');
$sheet->setCellValue('I1', 'Curso');
$sheet->setCellValue('J1', 'Profesor');
$sheet->setCellValue('K1', 'Jornada');
$sheet->setCellValue('L1', 'Detalle');
$row = 1;
foreach ($executions as $key => $value) {
    $row++;

    $program = $mprograms->getProgram($value['enrollment_program']);
    $course = $mcourses->getCourse($value['course']);
    $teacher_name = $mfields->get_FullName(@$course['teacher']);
    $pensum = $mpensums->get_Pensum($value['pensum']);
    $cycle = $pensum['cycle'];
    $moment = $pensum['moment'];

    $sheet->setCellValue("A{$row}", $value['identification_number']);
    $sheet->setCellValue("B{$row}", $value['identification_type']);
    $sheet->setCellValue("C{$row}", "{$value['first_name']} {$value['second_name']} {$value['first_surname']} {$value['second_surname']}");
    $sheet->setCellValue("D{$row}", $value['period']);
    $sheet->setCellValue("E{$row}", $program['name']);
    $sheet->setCellValue("F{$row}", $value['pensum_module_name']);
    $sheet->setCellValue("G{$row}", $cycle);
    $sheet->setCellValue("H{$row}", $moment);
    $sheet->setCellValue("I{$row}", $value['course_name']);
    $sheet->setCellValue("J{$row}", $teacher_name);
    $sheet->setCellValue("K{$row}", @$course['journey']);
    $sheet->setCellValue("L{$row}", @$course['description']);
    //$sheet->setCellValue('A' . ($key + 1), $value['enrollment']);
    //$sheet->setCellValue('B' . ($key + 1), $value['registration']);
    //$sheet->setCellValue('C' . ($key + 1), $value['execution']);
    //$sheet->setCellValue('D' . ($key + 1), $value['course']);
    //$sheet->setCellValue('E' . ($key + 1), $value['course_progress']);
    //$sheet->setCellValue('F' . ($key + 1), $value['course_program']);
    //$sheet->setCellValue('G' . ($key + 1), $value['course_grid']);
    //$sheet->setCellValue('H' . ($key + 1), $value['course_module']);
    //$sheet->setCellValue('I' . ($key + 1), $value['course_name']);
    //$sheet->setCellValue('J' . ($key + 1), $value['pensum']);
    //$sheet->setCellValue('K' . ($key + 1), $value['pensum_module']);
    //$sheet->setCellValue('L' . ($key + 1), $value['pensum_module_name']);
    //$sheet->setCellValue('M' . ($key + 1), $value['version']);
    //$sheet->setCellValue('N' . ($key + 1), $value['version_reference']);
    //$sheet->setCellValue('O' . ($key + 1), $value['grid']);
    //$sheet->setCellValue('P' . ($key + 1), $value['grid_name']);
}

// Crear el escritor de Excel
$writer = new Xlsx($spreadsheet);
// Configurar las cabeceras para la descarga
$response = service('response');
$response->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
$response->setHeader('Content-Disposition', 'attachment;filename="estudiantes-prematriculados-encursos.xlsx"');
$response->setHeader('Cache-Control', 'max-age=0');
// Guardar el archivo directamente en el output
$writer->save('php://output');

?>