<?php

require_once(APPPATH . 'ThirdParty/Spreadsheet/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$data = json_decode(file_get_contents('php://input'), true);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Llenar la hoja de cálculo con los datos
$rowIndex = 1;
foreach ($data as $row) {
    $colIndex = 'A';
    foreach ($row as $cell) {
        $sheet->setCellValue($colIndex . $rowIndex, $cell);
        $colIndex++;
    }
    $rowIndex++;
}

$filename = 'reporte-gratuidad-' . date('YmdHis') . '.xlsx'; // Nombre dinámico

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output'); // Enviar el archivo al navegador
exit;


?>