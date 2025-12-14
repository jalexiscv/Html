<?php
require_once(APPPATH . 'ThirdParty/FPDF/fpdf.php');
require_once(APPPATH . 'ThirdParty/FPDI/autoload.php');
require_once(APPPATH . 'ThirdParty/Barcode/autoload.php');
require_once(APPPATH . 'ThirdParty/GS1/autoload.php');
require_once(APPPATH . 'ThirdParty/Bacon/autoload.php');

use setasign\Fpdi\Fpdi;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

$request = service('request');
$bootstrap = service('bootstrap');

$mregistrations = model('App\Modules\Sgd\Models\Sgd_Registrations');
$muser = model("App\Modules\Sgd\Models\Sgd_Users");
$mfields = model("App\Modules\Sgd\Models\Sgd_Users_Fields");

$position = intval($request->getVar("position"));
$number=$oid;

$registration = $mregistrations->getRegistration($number);

$profile_from=$mfields->get_FullName($registration["from_user"]);
$profile_to=$mfields->get_FullName($registration["to_user"]);

$radication = ("https://benevalle.xn--cm-fka.co/sgd/external/view/{$number}");
$date=$registration["date"];
$time=$registration["time"];

$reference =mb_convert_encoding($registration["reference"], 'ISO-8859-1', 'UTF-8');
$observation = mb_convert_encoding($registration["observations"], 'ISO-8859-1', 'UTF-8');

$from=$profile_from;

if(empty($from)){
    $from="{$registration["from_identification"]} - {$registration["from_name"]}";
}

$to=$profile_to;
if(empty($to)){
    $to="{$registration["to_identification"]} - {$registration["to_name"]}";
}

//Definir dimensiones del sticker y márgenes
$pageWidth = 215.9;    // Ancho de página carta en mm
$pageHeight = 279.4;   // Alto de página carta en mm
$stickerWidth = 65;    // Reducido para mejor ajuste
$stickerHeight = 80;   // Reducido para mejor ajuste
$marginLeft = 10;      // Margen izquierdo
$marginTop = 1;       // Margen superior
$spacingX = 69;        // Espacio entre stickers horizontal
$spacingY = 43;        // Espacio entre stickers vertical

// Calcular la posición X,Y basada en el número de posición (1-15)
$row = ceil($position / 3) - 1;
$col = ($position - 1) % 3;

$x = $marginLeft + ($col * $spacingX);
$y = $marginTop + ($row * $spacingY);

// Crear PDF
$pdf = new Fpdi('P', 'mm', 'Letter');
$pdf->AddPage();
//$pdf->setSourceFile(PUBLICPATH . "pdfs/radicado-sgd2.pdf");
//$tplId = $pdf->importPage(1);
//$pdf->useTemplate($tplId, 10, 10, 195.9);

// Dibujar el sticker en la posición calculada
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetFillColor(255, 255, 255);
$pdf->Rect($x, $y, $stickerWidth, $stickerHeight, 'DF');

// Generar código QR
$renderer = new ImageRenderer(
    new RendererStyle(128), 
    new ImagickImageBackEnd()
);
$writer = new Writer($renderer);
$qrCode = $writer->writeString($radication);
// Guardar el QR temporalmente y convertirlo a formato compatible
$qrFile = tempnam(sys_get_temp_dir(), 'qr_') . '.png';
file_put_contents($qrFile, $qrCode); 
// Convertir a 8-bit usando Imagick
$imagick = new \Imagick($qrFile);
$imagick->setImageFormat('png');
$imagick->setImageDepth(8); // Convertir a 8-bit
$imagick->setImageType(\Imagick::IMGTYPE_GRAYSCALE);
$imagick->writeImage($qrFile);
$imagick->clear();

// Agregar QR al PDF
$pdf->Image($qrFile, $x + 2, $y + 2, 20, 20, 'PNG'); 
unlink($qrFile); // Eliminar archivo temporal

// Función helper para agregar texto
function addText($pdf, $x, $y, $text, $size = 10, $style = '', $width = 0) { 
    $text = mb_convert_encoding($text, 'ISO-8859-1', 'UTF-8');
    $pdf->SetFont('Arial', $style, $size);
    $pdf->SetXY($x, $y);
    if ($width > 0) {
        $pdf->Cell($width, 3.5, $text, 0, 1, 'L'); 
    } else {
        $pdf->Cell(0, 3.5, $text, 0, 1); 
    }
}

// Agregar contenido al sticker
// Título y código de barras
addText($pdf, $x + 22, $y + 3, 'BENEFICENCIA DEL', 10, 'B', 39);
addText($pdf, $x + 22, $y + 6.2, 'VALLE DEL CAUCA.', 10, 'B', 39);
addText($pdf, $x + 22, $y + 10, $number, 14, '', 39);
addText($pdf, $x + 22, $y + 14, "Fecha: {$date}", 10, '', 39);
addText($pdf, $x + 22, $y + 17.3, "Hora: {$time}", 10, '', 39);
addText($pdf, $x + 2, $y + 22, 'REFERENCIA:', 10, 'B');
$pdf->SetFont('Arial', '', 7);
$pdf->SetXY($x + 2, $y + 26);
$pdf->MultiCell(62, 3.0, $reference.": ".$observation, 0, 'L');
// Datos de radicación



$pdf->SetFont('Arial', '', 9);
addText($pdf, $x + 2, $y + 45, 'TIPO TRÁMITE: OTROS', 10);
addText($pdf, $x + 2, $y + 49, 'FOLIOS: '.@$registration["folios"], 10);
//addText($pdf, $x + 2, $y + 54, 'MEDIO: CORREO ELECTRÓNICO', 10);

// Remitente
$pdf->SetFont('Arial', '', 9);
addText($pdf, $x + 2, $y + 53, 'REMITENTE:', 10, 'B');
$pdf->SetFont('Arial', '', 7);
$pdf->SetXY($x + 2, $y + 56);
$pdf->MultiCell($stickerWidth-2, 3.0, $from, 0, 'L');

// Destinatario
$pdf->SetFont('Arial', '', 9);
addText($pdf, $x + 2, $y + 61, 'DESTINATARIO:', 10, 'B');
$pdf->SetFont('Arial', '', 7);
$pdf->SetXY($x + 2, $y + 64);
$pdf->MultiCell($stickerWidth-2, 3.0, safe_strtoupper($to), 0, 'L');

// Generar salida
$buffer = $pdf->Output('', 'S');
$pdf_base64 = base64_encode($buffer);
$code = '<iframe width="100%" height="1200" src="data:application/pdf;base64,' . $pdf_base64 . '"></iframe>';

$back = "/sgd/registrations/print/".$oid;
$card = $bootstrap->get_Card2("card-view-service", array(
    "header-title" => "Versión imprimible",
    "header-back" => $back,
    "content" => $code,
));
echo($card);
?>