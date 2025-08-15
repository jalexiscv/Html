<?php
require_once(APPPATH . 'ThirdParty/FPDF/fpdf.php');
require_once(APPPATH . 'ThirdParty/FPDI/autoload.php');
require_once(APPPATH . 'ThirdParty/Bacon/autoload.php');

use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

// Configuración inicial
$pdf = new FPDF('P', 'mm', 'A4');
$renderer = new ImageRenderer(
    new RendererStyle(250, 4),
    new ImagickImageBackEnd('png', 100)
);
$writer = new Writer($renderer);

// Configuración de la grilla
$qrSize = 27;
$cellPadding = 2;
$cellWidth = $qrSize + ($cellPadding * 2);
$cellHeight = $qrSize + ($cellPadding * 2) + 5;
$marginX = 10;
$marginY = 15;
$codesPerRow = 6;
$codesPerPage = 42;

// Variables de posicionamiento
$currentX = $marginX;
$currentY = $marginY;
$count = 0;
$pageCount = 1;

// Configuración de estilo
$pdf->SetDrawColor(200, 200, 200); // Color gris claro para bordes
$pdf->SetLineWidth(0.2); // Línea fina para los bordes

// Generar 100 códigos QR
for ($i = 101; $i <= 300; $i++) {
    // Crear nueva página si es necesario
    if ($count % $codesPerPage == 0) {
        if ($count > 0) {
            $pdf->AddPage();
            $pageCount++;
        } else {
            $pdf->AddPage();
        }
        $currentX = $marginX;
        $currentY = $marginY;
    }

    // Generar QR
    $qrTempFile = WRITEPATH . 'temp/qr_' . time() . '_' . $i . '.png';
    if (!is_dir(dirname($qrTempFile))) {
        mkdir(dirname($qrTempFile), 0777, true);
    }

    try {
        // Generar URL y QR
        $qrUrl = 'https://intranet.feriadebuga.com/journalists/invitations/check/' . $i;
        $writer->writeFile($qrUrl, $qrTempFile);

        // Procesar imagen con Imagick
        $imagick = new Imagick($qrTempFile);
        $imagick->setImageFormat('png');
        $imagick->setImageType(Imagick::IMGTYPE_GRAYSCALE);
        $imagick->setImageDepth(8);
        $imagick->setImageCompression(Imagick::COMPRESSION_ZIP);
        $imagick->setImageCompressionQuality(100);

        // Optimizar apariencia del QR
        $imagick->negateImage(false);
        $imagick->setImageBackgroundColor('white');
        $imagick->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);

        // Guardar imagen procesada
        $processedQrFile = WRITEPATH . 'temp/processed_qr_' . time() . '_' . $i . '.png';
        $imagick->writeImage($processedQrFile);
        $imagick->clear();
        $imagick->destroy();

        // Eliminar archivo temporal original
        @unlink($qrTempFile);

        // Dibujar celda con borde suave
        $pdf->Rect($currentX, $currentY, $cellWidth, $cellHeight);

        // Insertar QR centrado
        $qrX = $currentX + $cellPadding;
        $qrY = $currentY + $cellPadding;
        $pdf->Image($processedQrFile, $qrX, $qrY, $qrSize);

        // Agregar número
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetTextColor(100, 100, 100); // Gris oscuro para el texto
        $number = sprintf('%03d', $i);
        $pdf->SetXY($currentX, $qrY + $qrSize);
        $pdf->Cell($cellWidth, 5, $number, 0, 0, 'C');

        // Eliminar archivo procesado
        @unlink($processedQrFile);

    } catch (Exception $e) {
        error_log("Error procesando QR $i: " . $e->getMessage());
        continue;
    }

    // Actualizar posición
    $count++;
    $currentX += $cellWidth;

    // Nueva fila
    if ($count % $codesPerRow == 0) {
        $currentX = $marginX;
        $currentY += $cellHeight;
    }
}

// Generar salida
$buffer = $pdf->Output('', 'S');
$pdf_base64 = base64_encode($buffer);
$code = '<iframe width="100%" height="1200" src="data:application/pdf;base64,' . $pdf_base64 . '"></iframe>';

// Construir la tarjeta
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card2("card-view-Journalists", array(
    "class" => "mb-3",
    "header-title" => "Códigos QR de Invitaciones",
    "header-back" => "/",
    "content" => $code
));
echo($card);
?>