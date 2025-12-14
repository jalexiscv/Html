<?php
$bootstrap = service('bootstrap');
$request = service('request');

use setasign\Fpdi\Fpdi;

require_once(APPPATH . 'ThirdParty/FPDF/fpdf.php');
require_once(APPPATH . 'ThirdParty/FPDI/autoload.php');

$pdf = new Fpdi();

$count = 0;
foreach ($customers as $customer) {
    $count++;
    //echo($count);
    if ($count == 1) {
        $pdf->AddPage();
        $pdf->setSourceFile(PUBLICPATH . "/pdfs/formato-aguas.pdf");
        $tplId = $pdf->importPage(1);
        $pdf->useTemplate($tplId, 10, 10, 190);
    }
    if (isset($customer['customer'])) {
        if ($count == 1) {
            $linea1 = 40;
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetXY(20, $linea1);
            $pdf->Cell(0, 1, substr($customer['registration'], -10), 0, 1, 'L');
            $pdf->SetXY(50, $linea1);
            $pdf->Cell(0, 1, substr($customer['names'], 0, 23), 0, 1, 'L');
            $pdf->SetXY(120, $linea1);
            $pdf->Cell(0, 1, substr($customer['address'], 0, 23), 0, 1, 'L');
            $linea2 = $linea1 + 12.5;
            $pdf->SetXY(144, $linea2);
            $pdf->Cell(0, 1, "R" . $customer['reading_route'] . "P" . intval($customer['registration']), 0, 1, 'L');
        } elseif ($count == 2) {
            $linea1 = 122;
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetXY(20, $linea1);
            $pdf->Cell(0, 1, substr($customer['registration'], -10), 0, 1, 'L');
            $pdf->SetXY(50, $linea1);
            $pdf->Cell(0, 1, substr($customer['names'], 0, 23), 0, 1, 'L');
            $pdf->SetXY(120, $linea1);
            $pdf->Cell(0, 1, substr($customer['address'], 0, 23), 0, 1, 'L');
            $linea2 = $linea1 + 12.5;
            $pdf->SetXY(144, $linea2);
            $pdf->Cell(0, 1, "R" . $customer['reading_route'] . "P" . intval($customer['registration']), 0, 1, 'L');
        } elseif ($count == 3) {
            $linea1 = 203;
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetXY(20, $linea1);
            $pdf->Cell(0, 1, substr($customer['registration'], -10), 0, 1, 'L');
            $pdf->SetXY(50, $linea1);
            $pdf->Cell(0, 1, substr($customer['names'], 0, 23), 0, 1, 'L');
            $pdf->SetXY(120, $linea1);
            $pdf->Cell(0, 1, substr($customer['address'], 0, 23), 0, 1, 'L');
            $linea2 = $linea1 + 12.5;
            $pdf->SetXY(144, $linea2);
            $pdf->Cell(0, 1, "R" . $customer['reading_route'] . "P" . intval($customer['registration']), 0, 1, 'L');
            $count = 0;
        }
    }
}
$buffer = $pdf->Output('', 'S');
$pdf_base64 = base64_encode($buffer);


$html = '<iframe width="100%" height="1200" src="data:application/pdf;base64,' . $pdf_base64 . '"></iframe>';

echo($html);
?>