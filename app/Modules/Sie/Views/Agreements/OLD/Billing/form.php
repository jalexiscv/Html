<?php
require_once(APPPATH . 'ThirdParty/FPDF/fpdf.php');
require_once(APPPATH . 'ThirdParty/FPDI/autoload.php');
require_once(APPPATH . 'ThirdParty/Barcode/autoload.php');
require_once(APPPATH . 'ThirdParty/GS1/autoload.php');


use setasign\Fpdi\Fpdi;

/** @var string $oid * */

//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Sie_Registrations."));
//[models]--------------------------------------------------------------------------------------------------------------
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
//[Variables]-----------------------------------------------------------------------------------------------------------

$registration = $mregistrations->getRegistration($oid);
$back = "/sie/registrations/list/{$oid}";

//[codebar]-------------------------------------------------------------------------------------------------------------
$price = 91000;
$entidad = "7709998818828";
$convenido = "0700";
$cedula = str_pad(@$registration['identification_number'], 10, "0", STR_PAD_LEFT);// 11 espacios
$pago = str_pad($price, 8, "0", STR_PAD_LEFT);
$ticket = str_pad($registration['ticket'], 6, "0", STR_PAD_LEFT);// 6 espacios

if (!empty($registration['created_at'])) {
    $dateTime = new DateTime($registration['created_at']);
} else {
    $dateTime = new DateTime();
}

$fecha = "20240619";//Fecha maxima de pago $dateTime->format('Ymd');
$gs1_data = "(415){$entidad}(8020){$convenido}{$cedula}{$ticket}(3900){$pago}(96){$fecha}";
//[pdf]-----------------------------------------------------------------------------------------------------------------
$pdf = new Fpdi();
$pdf->AddPage();
$pdf->setSourceFile(PUBLICPATH . "pdfs/formato-preinscripcion-utede.pdf");
$tplId = $pdf->importPage(1);
$pdf->useTemplate($tplId, 10, 10, 190);

$x = 116.5;
$y = 40;
$text = @$registration['ticket'];
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetXY($x, $y);
$pdf->Cell(0, 1, $text, 0, 1, 'L');

$x = 54;
$y = 53;

$text = $dateTime->format('Y-m-d');
$pdf->SetXY($x, $y);
$pdf->Cell(0, 1, $text, 0, 1, 'L');

$y = $y + 6;
$text = mb_convert_encoding(@$registration['first_name'] . " " . @$registration['second_name'] . " " . @$registration['first_surname'] . " " . @$registration['second_surname'], 'ISO-8859-1', 'UTF-8');
$pdf->SetXY($x, $y);
$pdf->Cell(0, 1, $text, 0, 1, 'L');

$y = $y + 6;
$text = @$registration['identification_number'];
$pdf->SetXY($x, $y);
$pdf->Cell(0, 1, $text, 0, 1, 'L');

$y = $y + 5.5;
$text = @$registration['phone'];
$pdf->SetXY($x, $y);
$pdf->Cell(0, 1, $text, 0, 1, 'L');

$y = $y + 5.9;
$text = @$registration['address'];
$pdf->SetXY($x, $y);
$pdf->Cell(0, 1, $text, 0, 1, 'L');

$y = $y + 5.5;
$pdf->SetFont('Arial', 'B', 11);
$program = $mprograms->getProgram(@$registration['program']);
$text = is_array($program) ? mb_convert_encoding(substr($program['name'], 0, 64) . "...", 'ISO-8859-1', 'UTF-8') : "";
$pdf->SetXY($x, $y);
$pdf->Cell(0, 1, $text, 0, 1, 'L');

$y = $y + 5.5;
$pdf->SetFont('Arial', 'B', 12);
$text = is_array($program) ? mb_convert_encoding(@$registration['period'], 'ISO-8859-1', 'UTF-8') : "";
$pdf->SetXY($x, $y);
$pdf->Cell(0, 1, $text, 0, 1, 'L');

$y = $y + 22;
$concept = "Inscripción";
$text = is_array($program) ? mb_convert_encoding($concept, 'ISO-8859-1', 'UTF-8') : "";
$pdf->SetXY($x, $y);
$pdf->Cell(0, 1, $text, 0, 1, 'L');

$x = $x + 110;
$concept = "$" . number_format($price, 0, ",", ".");
$text = is_array($program) ? mb_convert_encoding($concept, 'ISO-8859-1', 'UTF-8') : "";
$pdf->SetXY($x, $y);
$pdf->Cell(0, 1, $text, 0, 1, 'L');


$x = $x - 30;
$y = $y + 46;
$pdf->SetFont('Arial', 'B', 10);
$concept = "19 de junio";
$text = is_array($program) ? mb_convert_encoding($concept, 'ISO-8859-1', 'UTF-8') : "";
$pdf->SetXY($x, $y);
$pdf->Cell(50, 0, $text, 0, 1, 'R');

$pdf->Image("https://intranet.utede.edu.co/codebar/GS1/test.php?cb={$gs1_data}", 10, 220, 180, 20, 'PNG');

$y = $y + 90;
$x = $x - 22;
$pdf->SetFont('Arial', 'B', 9);
$text = mb_convert_encoding($gs1_data, 'ISO-8859-1', 'UTF-8');
$pdf->SetXY($x, $y);
$pdf->Cell(50, 0, $text, 0, 1, 'R');


$ancho = 205; // Ancho de la cuadrícula
$alto = 270; // Alto de la cuadrícula
$divisionesX = 100; // Número de divisiones en el eje X
$divisionesY = 100; // Número de divisiones en el eje Y

$anchoDivision = $ancho / $divisionesX;
$altoDivision = $alto / $divisionesY;

$pdf->SetDrawColor(0, 0, 0); // Color del borde de la cuadrícula


$buffer = $pdf->Output('', 'S');
$pdf_base64 = base64_encode($buffer);
$code = '<iframe width="100%" height="1200" src="data:application/pdf;base64,' . $pdf_base64 . '"></iframe>';

$card = $bootstrap->get_Card("card-view-service", array(
    "title" => "Facturación {$oid}",
    "header-back" => $back,
    "content" => $code,
));
echo($card);


?>
