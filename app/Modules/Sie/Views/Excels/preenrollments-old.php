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
$total = $mexecutions->get_TotalPreenrollments($search);
//[build]-------------------------------------------------------------------------------------------------------
$count = $offset;
$sheet->setCellValue('A1', 'Identificación');
$sheet->setCellValue('B1', 'Estudiante');
$sheet->setCellValue('C1', 'Programa académico');
$sheet->setCellValue('D1', 'Prematricula');
$sheet->setCellValue('E1', 'Modulo');
$sheet->setCellValue('F1', 'Curso');
$sheet->setCellValue('G1', 'Profesor');
$sheet->setCellValue('H1', 'Jornada');
$sheet->setCellValue('I1', 'Detalle');

$code = "";
$row = 1;
foreach ($executions as $exec) {
    $row++;
    $registration = $mregistrations->getRegistration($exec['registration']);
    $enrollment = $menrollments->get_Enrollment($exec['enrollment']);
    $program = $mprograms->getProgram($enrollment['program']);
    $student_name = $registration['first_name'] . " " . $registration['second_name'] . " " . $registration['first_surname'] . " " . $registration['second_surname'];
    $student_identification = $registration['identification_type'] . " " . $registration['identification_number'];
    $program_name = $program['name'];

    $count++;
    $sheet->setCellValue("A{$row}", $student_identification);
    $sheet->setCellValue("B{$row}", $student_name);
    $sheet->setCellValue("C{$row}", $program_name);
    excel_colorRow($spreadsheet->getActiveSheet(), $row, 'CCEDFF');

    $progresses = $mprogress->get_ProgressByEnrollment($enrollment['enrollment']);
    foreach ($progresses as $progress) {
        $module = $mmodules->get_Module($progress['module']);
        $exec = $mexecutions->getLastExecutionbyProgress($progress['progress']);
        if (!empty($exec['course'])) {
            $row += 1;
            $course = $mcourses->getCourse($exec['course']);
            $teacher_name = $mfields->get_FullName($course['teacher']);
            $sheet->setCellValue("A{$row}", $student_identification);
            $sheet->setCellValue("B{$row}", $student_name);
            $sheet->setCellValue("C{$row}", $program_name);
            $sheet->setCellValue("D{$row}", "");
            $sheet->setCellValue("E{$row}", $module['name']);
            $sheet->setCellValue("F{$row}", $course['name']);
            $sheet->setCellValue("G{$row}", $teacher_name);
            $sheet->setCellValue("H{$row}", $course['journey']);
            $sheet->setCellValue("I{$row}", $course['description']);
        }

    }
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