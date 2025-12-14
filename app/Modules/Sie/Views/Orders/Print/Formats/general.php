<?php
require_once(APPPATH . 'ThirdParty/FPDF/fpdf.php');
require_once(APPPATH . 'ThirdParty/FPDI/autoload.php');
require_once(APPPATH . 'ThirdParty/Barcode/autoload.php');
require_once(APPPATH . 'ThirdParty/GS1/autoload.php');
require_once(APPPATH . 'ThirdParty/Bacon/autoload.php');

use setasign\Fpdi\Fpdi;

/** @var string $oid */

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
$morders = model("App\Modules\Sie\Models\Sie_Orders");
$mitems = model("App\Modules\Sie\Models\Sie_Orders_Items");
$mdiscounts = model("App\Modules\Sie\Models\Sie_Discounts");
$mdiscounteds = model("App\Modules\Sie\Models\Sie_Discounteds");
$msettings = model("App\Modules\Sie\Models\Sie_Settings");
//[Variables]-----------------------------------------------------------------------------------------------------------
$format = $msettings->getSetting("FACTURA-GENERAL");

$order = $morders->get_Order($oid);
$registration = $mregistrations->getRegistration($order['user']);
$fecha = "";
$fecha = "20241130";//Fecha maxima de pago $dateTime->format('Ymd');
$limit = $order['expiration'];
//[codebar]-------------------------------------------------------------------------------------------------------------
$price = $order['total'];
$entidad = "7709998818828";
$convenido = "0700";
$cedula = safe_str_pad(@$registration['identification_number'], 10, "0", STR_PAD_LEFT);// 11 espacios
$pago = round(safe_str_pad($price, 8, "0", STR_PAD_LEFT), precision: 0);

$ticket = safe_str_pad($order['ticket'], 6, "0", STR_PAD_LEFT);// 6 espacios
$dateTime = new DateTime($order['expiration']);
$fecha = $dateTime->format('Ymd');


$limitegs1 = str_replace('-', '', $limit);
$gs1_data = "(415){$entidad}(8020){$convenido}{$cedula}{$ticket}(3900){$pago}(96){$limitegs1}";

//[includes]------------------------------------------------------------------------------------------------------------
include("Includes/payments.php");
include("Includes/barcode.php");
//[pdf]-----------------------------------------------------------------------------------------------------------------
$pdf = new Fpdi();
$pdf->AddPage();
$pdf->setSourceFile(PUBLICPATH . $format["value"]);
$tplId = $pdf->importPage(1);
$pdf->useTemplate($tplId, 10, 10, 190);

$x = 116.5;
$y = 40;
$text = @$order['ticket'];
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetXY($x, $y);
$pdf->Cell(0, 1, $text, 0, 1, 'L');

$x = 54;
$y = 53;
$dateTime = new DateTime($order['created_at']);
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
if (!empty($order['program'])) {
    $program = $mprograms->getProgram($order['program']);
}


$text = is_array($program) ? mb_convert_encoding(substr($program['name'], 0, 64) . "...", 'ISO-8859-1', 'UTF-8') : "";
$pdf->SetXY($x, $y);
$pdf->Cell(0, 1, $text, 0, 1, 'L');

$y = $y + 5.5;
$pdf->SetFont('Arial', 'B', 12);
$text = is_array($program) ? mb_convert_encoding(@$order['period'], 'ISO-8859-1', 'UTF-8') : "";
$pdf->SetXY($x, $y);
$pdf->Cell(0, 1, $text, 0, 1, 'L');

//[detalle]-------------------------------------------------------------------------------------------------------------
$items = $mitems->get_ItemsByOrder($order['order']);
$y = $y + 17;
$conceptos = [];
foreach ($items as $item) {
    $len = strlen($item['description']);
    if ($len > 70) {
        $description = $strings->get_WordWrap($item['description'], 70) . "...";
    } else {
        $description = $item['description'];
    }
    $concepto = $description;
    $amount = $item['amount'];
    $valor = $item['value'];
    $conceptos[] = [
        'concepto' => $concepto,
        'amount' => $amount,
        'valor' => $valor
    ];
}
$y = createTable($pdf, $conceptos, $y, 160);
$y = payments($pdf, array('y' => $y, 'maxWidth' => 160, 'limit' => $limit));

//$params=array('y' => $y, 'maxWidth' => 160, 'limit' => $limit);
//include("Includes/payments.php");


$y = barcode($pdf, array('gs1_data' => $gs1_data, 'startY' => $y, 'limit' => $limit, 'maxWidth' => 160));
//[build]---------------------------------------------------------------------------------------------------------------
$pdf->SetDrawColor(0, 0, 0); // Color del borde de la cuadrícula
$buffer = $pdf->Output('', 'S');
$pdf_base64 = base64_encode($buffer);
$code = '<iframe width="100%" height="1200" src="data:application/pdf;base64,' . $pdf_base64 . '"></iframe>';


function createTable($pdf, $data, $startY, $maxWidth = null)
{
    // Si no se especifica un ancho máximo, usar un porcentaje del ancho de página
    if ($maxWidth === null) {
        $maxWidth = $pdf->GetPageWidth() * 0.8; // 80% del ancho de la página
    }

    // Establecer la posición Y inicial
    $pdf->SetY($startY);

    // Calcular proporciones de las columnas (70% concepto, 30% valor)
    $conceptColumnWidth = $maxWidth * 0.71;
    $amountColumnWidth = $maxWidth * 0.12;
    $valueColumnWidth = $maxWidth * 0.17;
    // Calcular posición X para centrar la tabla
    $pageWidth = $pdf->GetPageWidth();
    $tableWidth = $conceptColumnWidth + $amountColumnWidth + $valueColumnWidth;
    $startX = ($pageWidth - $tableWidth) / 2;
    // Color de fondo de la cabecera
    $pdf->SetFillColor(230, 230, 230);
    // Establecer posición X,Y para comenzar la tabla centrada
    $pdf->SetXY($startX, $startY);

    // Configurar fuente en negrita para los encabezados
    $pdf->SetFont('helvetica', 'B', 10);

    // Cabecera de la tabla (centrada)
    $pdf->Cell($conceptColumnWidth, 7, 'Concepto', 1, 0, 'C', true);
    $pdf->Cell($amountColumnWidth, 7, 'Cantidad', 1, 0, 'C', true);
    $pdf->Cell($valueColumnWidth, 7, 'Valor', 1, 1, 'C', true);

    // Restaurar fuente normal para el contenido
    $pdf->SetFont('helvetica', '', 10);

    // Restaurar color de fondo
    $pdf->SetFillColor(255, 255, 255);

    // Variable para calcular el total
    $total = 0;

    // Iterar sobre los datos
    foreach ($data as $item) {
        // Verificar si queda espacio suficiente en la página
        if ($pdf->GetY() + 7 > $pdf->GetPageHeight() - 20) {
            $pdf->AddPage();
            $pdf->SetX($startX);
        }

        // Volver a establecer X para mantener el centrado en cada línea
        $pdf->SetX($startX);

        // Concepto (alineado a la izquierda) siempre en negro
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell($conceptColumnWidth, 7, mb_convert_encoding($item['concepto'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
        $pdf->Cell($amountColumnWidth, 7, mb_convert_encoding($item['amount'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'R');
        // Valor en verde solo si es negativo
        if ($item['valor'] < 0) {
            $pdf->SetTextColor(0, 128, 0); // Verde para valores negativos
        } else {
            $pdf->SetTextColor(0, 0, 0); // Negro para valores positivos o cero
        }
        // Valor (alineado a la derecha)
        if (is_numeric($item['valor'])) {
            $pdf->Cell($valueColumnWidth, 7, '$' . number_format($item['valor'], 2, ',', '.'), 1, 1, 'R');
            $total += $item['valor'];// Sumar al final
        } else {
            // Manejar el caso en que $item['valor'] no sea un número
            $pdf->Cell($valueColumnWidth, 7, 'N/A', 1, 1, 'R');
            $total += 0;// Sumar al final
        }
        //$pdf->Cell($valueColumnWidth, 7, '$' . number_format($item['valor'], 2, ',', '.'), 1, 1, 'R');
    }
    // Verificar si queda espacio suficiente para la fila del total
    if ($pdf->GetY() + 7 > $pdf->GetPageHeight() - 20) {
        $pdf->AddPage();
        $pdf->SetX($startX);
    }
    // Establecer fuente en negrita para el total
    $pdf->SetFont('helvetica', 'B', 10);

    // Volver a establecer X para mantener el centrado
    $pdf->SetX($startX);

    // Color de fondo para la fila del total
    $pdf->SetFillColor(230, 230, 230);

    // Establecer color del total en verde solo si es negativo
    if ($total < 0) {
        $pdf->SetTextColor(0, 128, 0); // Verde para total negativo
    } else {
        $pdf->SetTextColor(0, 0, 0); // Negro para total positivo o cero
    }
    // Fila del total
    $pdf->Cell($conceptColumnWidth, 7, '', 1, 0, 'L', true);
    $pdf->Cell($amountColumnWidth, 7, 'Total', 1, 0, 'C', true);
    $pdf->Cell($valueColumnWidth, 7, '$' . number_format($total, 2, ',', '.'), 1, 1, 'R', true);
    // Restaurar color de texto y fuente normal
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('helvetica', '', 10);
    // Retornar la posición Y final de la tabla
    return $pdf->GetY();
}


?>