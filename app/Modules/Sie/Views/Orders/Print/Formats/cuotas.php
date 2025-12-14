<?php
require_once(APPPATH . 'ThirdParty/FPDF/fpdf.php');
require_once(APPPATH . 'ThirdParty/FPDI/autoload.php');
require_once(APPPATH . 'ThirdParty/Barcode/autoload.php');
require_once(APPPATH . 'ThirdParty/GS1/autoload.php');

/* @var $order array */
$numbers = service("numbers");

use setasign\Fpdi\Fpdi;


$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$morders = model("App\Modules\Sie\Models\Sie_Orders");


$registration = $mregistrations->getRegistration($order['user']);

//[codebar]-------------------------------------------------------------------------------------------------------------
$price = 91000;
$entidad = "7709998818828";
$convenido = "0700";
$cedula = str_pad(@$registration['identification_number'], 10, "0", STR_PAD_LEFT);// 11 espacios
$pago = str_pad($price, 8, "0", STR_PAD_LEFT);
$ticket = str_pad($order['parent'], 6, "0", STR_PAD_LEFT);// 6 espacios
$dateTime = new DateTime($registration['updated_at']);
$expiration = $order['expiration'];
$fecha = str_replace("-", "", $expiration);


//[build]---------------------------------------------------------------------------------------------------------------
$pdf = new Fpdi();
$pdf->AddPage();
$pdf->setSourceFile(PUBLICPATH . "pdfs/formato-sie-orden-cuota-utede.pdf");
$tplId = $pdf->importPage(1);
$pdf->useTemplate($tplId, 10, 10, 190);

$x = 116.5;
$y = 40;
$text = $order['parent'] . " CUOTA: " . $order['order'];
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetXY($x, $y);
$pdf->Cell(0, 1, $text, 0, 1, 'L');


$y = 53;
$xlabel = 10;
$xvalue = 62;
$pdf->SetXY($xlabel, $y);
$pdf->Cell(50, 1, "Fecha:", 0, 1, 'R');
$dateTime = new DateTime($registration['updated_at']);
$pdf->SetXY($xvalue, $y);
$pdf->Cell(0, 1, $dateTime->format('Y-m-d'), 0, 1, 'L');

$y = 57;
$pdf->SetXY($xlabel, $y);
$pdf->Cell(50, 1, "Nombre:", 0, 1, 'R');
$text = mb_convert_encoding(@$registration['first_name'] . " " . @$registration['second_name'] . " " . @$registration['first_surname'] . " " . @$registration['second_surname'], 'ISO-8859-1', 'UTF-8');
$pdf->SetXY($xvalue, $y);
$pdf->Cell(0, 1, $text, 0, 1, 'L');

$y = 61;
$pdf->SetXY($xlabel, $y);
$pdf->Cell(50, 1, mb_convert_encoding("Identificación:", 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');
$text = @$registration['identification_number'];
$pdf->SetXY($xvalue, $y);
$pdf->Cell(0, 1, $text, 0, 1, 'L');

$y = 65;
$pdf->SetXY($xlabel, $y);
$pdf->Cell(50, 1, mb_convert_encoding("Teléfono :", 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');
$text = @$registration['phone'];
$pdf->SetXY($xvalue, $y);
$pdf->Cell(0, 1, $text, 0, 1, 'L');

$y = 69;
$pdf->SetXY($xlabel, $y);
$pdf->Cell(50, 1, mb_convert_encoding("Dirección :", 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');
$text = @$registration['address'];
$pdf->SetXY($xvalue, $y);
$pdf->Cell(0, 1, $text, 0, 1, 'L');

$y = 69;
$pdf->SetXY($xlabel, $y);
$pdf->Cell(50, 1, mb_convert_encoding("Dirección :", 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');
$text = @$registration['address'];
$pdf->SetXY($xvalue, $y);
$pdf->Cell(0, 1, $text, 0, 1, 'L');

$y = 73;


$program = $mprograms->getProgram(@$registration['program']);
if (!empty($order['program'])) {
    $program = $mprograms->getProgram($order['program']);
}

$program_name = !empty($program['name']) ?? "";

$pdf->SetXY($xlabel, $y);
$pdf->Cell(50, 1, mb_convert_encoding("Programa :", 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');
$text = is_array($program) ? mb_convert_encoding(substr($program['name'], 0, 64) . "...", 'ISO-8859-1', 'UTF-8') : "";
$pdf->SetXY($xvalue, $y);
$pdf->Cell(0, 1, $text, 0, 1, 'L');

$y = 77;
$program = $mprograms->getProgram(@$registration['program']);
$pdf->SetXY($xlabel, $y);
$pdf->Cell(50, 1, mb_convert_encoding("Periodo:", 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');
$text = is_array($program) ? mb_convert_encoding(@$order['period'], 'ISO-8859-1', 'UTF-8') : "";
$pdf->SetXY($xvalue, $y);
$pdf->Cell(0, 1, $text, 0, 1, 'L');

$y = 97;
$xvalue = 123;
$capital = $order['total'];
$pdf->SetXY($xlabel, $y);
$pdf->Cell(108, 1, mb_convert_encoding("Capital:", 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');
$text = mb_convert_encoding("$ " . $numbers->get_NumberFormat($capital, 0), 'ISO-8859-1', 'UTF-8');
$pdf->SetXY($xvalue, $y);
$pdf->Cell(0, 1, "" . $text, 0, 1, 'L');

$y = 101;
$xvalue = 123;
$capital = $order['total'];
$pdf->SetXY($xlabel, $y);
$pdf->Cell(108, 1, mb_convert_encoding("Interés:", 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');
$text = is_array($program) ? mb_convert_encoding("$ 0.0", 'ISO-8859-1', 'UTF-8') : "";
$pdf->SetXY($xvalue, $y);
$pdf->Cell(0, 1, $text, 0, 1, 'L');

$y = 115;
$xvalue = 123;
$capital = $order['total'];
$pdf->SetXY($xlabel, $y);
$pdf->Cell(108, 1, mb_convert_encoding("", 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');
$text = mb_convert_encoding("$ " . $numbers->get_NumberFormat($capital, 0), 'ISO-8859-1', 'UTF-8');
$pdf->SetXY($xvalue, $y);
$pdf->Cell(0, 1, $text, 0, 1, 'L');


$y = 126;
$xvalue = 65;
$expiration = $expiration;
$pdf->SetXY($xlabel, $y);
$pdf->Cell(108, 1, mb_convert_encoding("", 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');
$text = mb_convert_encoding($expiration, 'ISO-8859-1', 'UTF-8');
$pdf->SetXY($xvalue, $y);
$pdf->Cell(0, 1, $text, 0, 1, 'L');


//[GSM]-----------------------------------------------------------------------------------------------------------------
$pago = intval($capital);
$gs1_data = "(415){$entidad}(8020){$convenido}{$cedula}{$ticket}(3900){$pago}(96){$fecha}";

$pdf->Image("https://intranet.utede.edu.co/codebar/GS1/test.php?cb={$gs1_data}", 15, 175, 180, 20, 'PNG');

$y = $y + 74;
$x = $x;
$pdf->SetFont('Arial', 'B', 9);
$text = mb_convert_encoding($gs1_data, 'ISO-8859-1', 'UTF-8');
$pdf->SetXY($x, $y);
$pdf->Cell(50, 0, $text, 0, 1, 'R');

$buffer = $pdf->Output('', 'S');
$pdf_base64 = base64_encode($buffer);
$code = '<iframe width="100%" height="1200" src="data:application/pdf;base64,' . $pdf_base64 . '"></iframe>';


//[/build]--------------------------------------------------------------------------------------------------------------

?>