<?php

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

function excel_colorRow($sheet, $row, $color)
{
    $highestColumn = $sheet->getHighestColumn();
    $range = 'A' . $row . ':' . $highestColumn . $row;

    $sheet->getStyle($range)->getFill()
        ->setFillType(Fill::FILL_SOLID)
        ->getStartColor()->setRGB($color);
}

function excel_htmlTableToSpreadsheet($html)
{
    $dom = new DOMDocument();
    @$dom->loadHTML($html);
    $table = $dom->getElementsByTagName('table')->item(0);
    $rows = $table->getElementsByTagName('tr');

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    foreach ($rows as $rowIndex => $row) {
        $cells = $row->getElementsByTagName('td');
        if ($cells->length === 0) {
            $cells = $row->getElementsByTagName('th');
        }

        foreach ($cells as $cellIndex => $cell) {
            $columnLetter = Coordinate::stringFromColumnIndex($cellIndex + 1);
            $sheet->setCellValue($columnLetter . ($rowIndex + 1), $cell->nodeValue);
        }
    }

    return $spreadsheet;
}

?>