<?php
require_once(APPPATH . 'ThirdParty/FPDF/fpdf.php');
require_once(APPPATH . 'ThirdParty/FPDI/autoload.php');
require_once(APPPATH . 'ThirdParty/Barcode/autoload.php');
require_once(APPPATH . 'ThirdParty/GS1/autoload.php');


use setasign\Fpdi\Fpdi;

//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Sie_Registrations."));
//[models]--------------------------------------------------------------------------------------------------------------
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
//[Variables]-----------------------------------------------------------------------------------------------------------
$registration = $model->getRegistration($oid);
$back = "/sie/enrollments/list/{$oid}";

//[codebar]-------------------------------------------------------------------------------------------------------------
$price = 91000;
$entidad = "7709998818828";
$convenido = "0700";
$rticket = $registration['ticket'] + 10000;
$cedula = str_pad(@$registration['identification_number'], 10, "0", STR_PAD_LEFT);// 11 espacios
$pago = str_pad($price, 8, "0", STR_PAD_LEFT);
$ticket = str_pad($rticket, 6, "0", STR_PAD_LEFT);// 6 espacios

if (!empty($registration['created_at'])) {
    $dateTime = new DateTime($registration['created_at']);
} else {
    $dateTime = new DateTime();
}

$fecha = "202408015";//Fecha maxima de pago $dateTime->format('Ymd');
//[pdf]-----------------------------------------------------------------------------------------------------------------
$pdf = new Fpdi();
$pdf->AddPage();
$pdf->setSourceFile(PUBLICPATH . "pdfs/formato-matricula-utede.pdf");
$tplId = $pdf->importPage(1);
$pdf->useTemplate($tplId, 10, 10, 190);

$x = 116.5;
$y = 40;
$text = $ticket;
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


/**
 * Técnico - Tecnólogo - Profesional
 * 6657A680B1616    007    Inscripción de Estudiantes    $91.000,00
 * 6657A60B770A5    011    Seguro Estudiantil    $23.400,00
 * 6657A5BE00AD6    009    Derechos registro, control y papelería estudiante    $39.000,00
 * 6657A59065FE8    010    Carné Estudiantil    $35.100,00
 * 6657A2F7AA325    012    Aporte Bienestar Estudiantil    $26.000,00
 * 6630B5BC340BE    005    Inscripción para estudiantes en articulación    $0,00
 * 6630B31E9349B    003    Matricula Nivel Profesional Universitario    $1.950.000,00
 * 6630B1EB4307E    002    Matricula Nivel Tecnológico    $1.560.000,00
 * 6630AE0FC6936    001    Matricula Nivel Técnico
 */

$details = array();
$matricula = 0;
if (strpos(safe_strtolower(@$program['name']), 'técnico') !== false) {
    $details[] = array("6630AE0FC6936", "001", "Matricula Nivel Técnico", "1300000");
    $matricula = 1300000;
} elseif (strpos(safe_strtolower(@$program['name']), 'tecnólogo') !== false) {
    $details[] = array("6630B1EB4307E", "002", "Matricula Nivel Tecnológico", "1560000");
    $matricula = 1560000;
} elseif (strpos(safe_strtolower(@$program['name']), 'tecnología') !== false) {
    $details[] = array("6630B1EB4307E", "002", "Matricula Nivel Tecnológico", "1560000");
    $matricula = 1560000;
} elseif (strpos(safe_strtolower(@$program['name']), 'profesional') !== false) {
    $details[] = array("6630B31E9349B", "003", "Matricula Nivel Profesional Universitario", "1950000");
    $matricula = 1950000;
} else {
    $details[] = array("XXX", "XXX", "Error-" . @$program['name'], "1950000");
    $matricula = 1950000;
}
$details[] = array("6657A60B770A5", "011", "Seguro Estudiantil", "23400");
$details[] = array("6657A5BE00AD6", "009", "Derechos registro, control y papelería estudiante", "39000");
$details[] = array("6657A59065FE8", "010", "Carné Estudiantil", "35100");
$details[] = array("6657A2F7AA325", "012", "Aporte Bienestar Estudiantil", "26000");
//$details[] = array("6630B5BC340BE", "005", "Inscripción para estudiantes en articulación", "0");


$y = $y + 18;
$tx = $x - 25;
$pdf->SetFont('Arial', 'B', 8);
$total_cargos = 0;
foreach ($details as $detail) {
    $y = $y + 4;
    $x = $tx;
    /** [Detalles] */
    $concept = $detail[2];
    $text = is_array($program) ? mb_convert_encoding($concept, 'ISO-8859-1', 'UTF-8') : "";
    $pdf->SetXY($x, $y);
    $pdf->Cell(0, 1, $text, 0, 1, 'L');

    $x = $x + 110;
    //$text = mb_convert_encoding($detail[3], 'ISO-8859-1', 'UTF-8');
    $pdf->SetXY($x, $y);
    $price = "$" . number_format($detail[3], 0, ",", ".");
    $pdf->Cell(30, 1, $price, 0, 1, 'R');
    $total_cargos += intval($detail[3]);
    /** [/Detalles] */
}
$pdf->SetXY($x, $y + 15.5);
$price = "$" . number_format($total_cargos, 0, ",", ".");
$pdf->Cell(30, 1, $price, 0, 1, 'R');
//[descuentos]----------------------------------------------------------------------------------------------------------
$mdiscounts = model("App\Modules\Sie\Models\Sie_Discounts");
$mdiscounteds = model("App\Modules\Sie\Models\Sie_Discounteds");
$mapplieds = model("App\Modules\Sie\Models\Sie_Applieds");
$discounteds = $mdiscounteds->where("object", $registration['registration'])->findAll();

$y = $y + 30;
$total_discounts = 0;
foreach ($discounteds as $discounted) {
    $discount = $mdiscounts->getDiscount($discounted['discount']);
    $y = $y + 4;
    $x = $tx;
    $concept = $discount['name'];
    $text = is_array($program) ? mb_convert_encoding($concept, 'ISO-8859-1', 'UTF-8') : "";
    $pdf->SetXY($x, $y);
    $pdf->Cell(0, 1, $text, 0, 1, 'L');
    //[prices]----------------------------------------------------------------------------------------------------------
    if ($discount['character'] == "PERCENTAGE") {
        $price = $matricula * $discount['value'] / 100;
    } else {
        $price = $discount['value'];
    }
    $x = $x + 110;
    $pdf->SetXY($x, $y);
    $tprice = "$" . number_format($price, 0, ",", ".");
    $pdf->Cell(30, 1, $tprice, 0, 1, 'R');
    $total_discounts += intval($price);
}
$pdf->SetXY($x, 192);
$price = "$" . number_format($total_discounts, 0, ",", ".");
$pdf->Cell(30, 1, $price, 0, 1, 'R');
//[total]---------------------------------------------------------------------------------------------------------------
$pdf->SetXY($x, 202);
$total = $total_cargos - $total_discounts;
if ($total < 0) {
    $total = 0;
}
$price = "$" . number_format($total, 0, ",", ".");
$pdf->Cell(30, 1, $price, 0, 1, 'R');
//----------------------------------------------------------------------------------------------------------------------
$x = 43;
$y = 214;
$pdf->SetFont('Arial', 'B', 10);
$concept = "15 de Agosto ";
$text = is_array($program) ? mb_convert_encoding($concept, 'ISO-8859-1', 'UTF-8') : "";
$pdf->SetXY($x, $y);
$pdf->Cell(50, 0, $text, 0, 1, 'R');

//[dodebar]-------------------------------------------------------------------------------------------------------------
$gs1_data = "(415){$entidad}(8020){$convenido}{$cedula}{$ticket}(3900){$total}(96){$fecha}";
$pdf->Image("https://intranet.utede.edu.co/codebar/GS1/test.php?cb={$gs1_data}", 15, 255, 180, 19, 'PNG');

$y = 275;
$x = 120;
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