<?php
/** @var array $pdfmodules */

require_once(APPPATH . 'ThirdParty/FPDF/fpdf.php');
require_once(APPPATH . 'ThirdParty/FPDI/autoload.php');
require_once(APPPATH . 'ThirdParty/Barcode/autoload.php');
require_once(APPPATH . 'ThirdParty/GS1/autoload.php');

use setasign\Fpdi\Fpdi;


/** @var TYPE_NAME $student_full_name */
/** @var TYPE_NAME $registration */


$text2 = "Nota: El sistema de evaluación en la institución es cualitativo, es decir, de 0 a 100. Entre 0 y 79%: Aplazado,  "
    . "Entre 80% y 90%: Competente, 100%: Mejor práctica, Tenga en cuenta que los espacios en blanco en la referencia corresponden "
    . "a modulos que deben ser matriculados en periodos posteriores.";

$text3 = "Firma: líder de Registro y Control Académico";


$text2 = mb_convert_encoding($text2, 'ISO-8859-1', 'UTF-8');
$text3 = mb_convert_encoding($text3, 'ISO-8859-1', 'UTF-8');

// Column widths
$w = array(10, 130, 35, 15, 15, 15, 15, 10, 20); // Adjusted widths, split Ciclo Momento
// Header
$header = array('#', mb_convert_encoding("MÓDULO", 'ISO-8859-1', 'UTF-8'), 'REFERENCIA SIE', 'UC1', 'UC2', 'C03', 'T', 'CA', 'CICLO', 'MOMENTO'); // Updated header array

// Initial position
$x = 0;
$y = 0;

// Tabla: //[pdf]-----------------------------------------------------------------------------------------------------------------
$pdf = new Fpdi('P', 'mm', array(297, 450)); // A4 size, mm
$pdf->AddPage();
$pdf->setSourceFile(PUBLICPATH . "pdfs/utede-impresiones-calificaciones-v3.pdf");
$tplId = $pdf->importPage(1);
$pdf->useTemplate($tplId, 10, 10, 280);


$x = 15;
$y = 120;

// Set Font
$pdf->SetFont('Arial', 'B', 10);
// Set the X and Y position for the main header row
$pdf->SetXY($x, $y);
//Header superior
$pdf->Cell($w[0], 14, $header[0], 1, 0, 'C');
$pdf->Cell($w[1], 14, $header[1], 1, 0, 'C');
$pdf->Cell($w[2] + $w[3] + $w[4] + $w[5] + $w[6], 7, 'CURSO', 1, 0, 'C');
$pdf->Cell($w[7], 14, "CA", 1, 0, 'C');
$pdf->Cell($w[8], 14, 'CICLO', 1, 0, 'C'); // Cell for CICLO
$pdf->Ln();
$y += 7; // Move Y position for the next row
//Set the X and Y position for the secondary header row
$pdf->SetXY($x, $y);
//Second Header
$pdf->Cell($w[0], 7, '', 0, 0, 'C');
$pdf->Cell($w[1], 7, '', 0, 0, 'C');
$pdf->Cell($w[2], 7, $header[2], 1, 0, 'C');
$pdf->Cell($w[3], 7, $header[3], 1, 0, 'C');
$pdf->Cell($w[4], 7, $header[4], 1, 0, 'C');
$pdf->Cell($w[5], 7, $header[5], 1, 0, 'C');
$pdf->Cell($w[6], 7, $header[6], 1, 0, 'C');
$pdf->Cell($w[7], 7, '', 0, 0, 'C');
$pdf->Cell($w[8], 7, "", 0, 0, 'C'); // Ciclo
$pdf->Ln();
$y += 7; // Move Y position for the first data row
//Data
$rowHeight = 7; // Adjust row height as needed
// Set the X and Y position for the data
$pdf->SetXY($x, $y);

$credits_total = 0;
for ($i = 0; $i < count($pdfmodules); $i++) {
    $ct = round($pdfmodules[$i]['ct'], 0);
    $pdf->SetX($x); // Reset X position at the beginning of each row
    $pdf->Cell($w[0], $rowHeight, $i + 1, 1, 0, 'C');
    $pdf->Cell($w[1], $rowHeight, $pdfmodules[$i]['module'], 1, 0, 'L');
    $pdf->Cell($w[2], $rowHeight, $pdfmodules[$i]['reference'], 1, 0, 'L');
    $pdf->Cell($w[3], $rowHeight, $pdfmodules[$i]['uc1'], 1, 0, 'R');
    $pdf->Cell($w[4], $rowHeight, $pdfmodules[$i]['uc2'], 1, 0, 'R');
    $pdf->Cell($w[5], $rowHeight, $pdfmodules[$i]['uc3'], 1, 0, 'R');
    $pdf->Cell($w[6], $rowHeight, $ct, 1, 0, 'R');
    $pdf->Cell($w[7], $rowHeight, $pdfmodules[$i]['credits'], 1, 0, 'C');
    $pdf->Cell($w[8], $rowHeight, $pdfmodules[$i]['cycle'], 1, 0, 'C');
    $pdf->Ln();
    $y += $rowHeight; // Move Y position for the next row
    $pdf->SetXY($x, $y); //set to the next line for the next loop
    $credits_total += $pdfmodules[$i]['creditsearned'];
}


$text = "El(la) señor(a) {$student_full_name}, identificado(a) con documento de identidad {$registration['identification_type']} {$registration['identification_number']}, cursó "
    . "un total de {$credits_total} créditos académicos en el programa {$program_name} ({$program_program}) , el cual "
    . "cuenta con registro calificado N° {$program_resolution} del {$program_resolution_date} del Ministerio de Educación Nacional. "
    . "En la modalidad presencial hasta el periodo académico [                ].";
$text = mb_convert_encoding($text, 'ISO-8859-1', 'UTF-8');
$pdf->SetXY(15, 68);
$pdf->SetFont('Arial', '', 18);
$pdf->MultiCell(270, 5, "CERTIFICA QUE:", 0, 'C');
$pdf->SetFont('Arial', '', 16);
$pdf->SetXY(13, 85); // Reset X position at the beginning of each row
$pdf->MultiCell(265, 6, $text, 0, 'J');


$y = $y + 10;
$pdf->SetFont('Arial', '', 16);
$pdf->SetXY(13, $y);
//$pdf->Cell(270,14,$text,1,0,'C');
//$pdf->Write(5, $text);
$pdf->MultiCell(265, 6, $text2, 0, 'J');

$y = $y + 45;
$pdf->SetXY(13, $y);
//$pdf->Cell(270,14,$text,1,0,'C');
//$pdf->Write(5, $text);
$pdf->MultiCell(265, 6, $text3, 0, 'R');

//[build]---------------------------------------------------------------------------------------------------------------
$buffer = $pdf->Output('', 'S');
$pdf_base64 = base64_encode($buffer);
$code = '<iframe width="100%" height="1200" src="data:application/pdf;base64,' . $pdf_base64 . '"></iframe>';
?>