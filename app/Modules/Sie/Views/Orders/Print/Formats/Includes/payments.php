<?php


use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

function payments($pdf, $params)
{
    $msettings = model('App\Modules\Sie\Models\Sie_Settings');
    $emailTreasury = $msettings->getSetting("EMAIL-TREASURY");
    $server = service("server");
    // Parámetros por defecto
    $limit = isset($params['limit']) ? mb_convert_encoding($params['limit'], 'ISO-8859-1', 'UTF-8') : 0;
    $y = isset($params['y']) ? $params['y'] : 0;
    $maxWidth = isset($params['maxWidth']) ? $params['maxWidth'] : 0;
    $y += 5;
    $pageWidth = $pdf->GetPageWidth();
    $maxWidth = is_null($maxWidth) ? $pdf->GetPageWidth() * 0.77 : $maxWidth;
    $pdf->SetFont('Arial', '', 10);
    $x = ($pageWidth - $maxWidth) / 2;
    $pdf->SetXY($x, $y);
    $col1Width = $maxWidth / 2;  // ancho de la primera columna
    $col2Width = $maxWidth / 2; // ancho de la segunda columna
    $lineHeight = 5; // altura de cada línea
    $cellHeight = $lineHeight * 7;
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell($col1Width, $cellHeight, '', 1, 0, 'C');
    $pdf->Cell($col2Width, $cellHeight, '', 1, 1, 'C');
    //Celdas de la columna 1
    $pdf->SetXY($x + 34, $y + 1);
    $pdf->SetFont('Arial', 'B', 11.2);
    $lineHeight = 7;
    $pdf->Cell($col1Width, $lineHeight, 'Formas de pago', 0, 1, 'L');
    $lineHeight = 5;
    $y += 2;
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetXY($x + 34, $y + 4);
    $pdf->Cell($col1Width, $lineHeight, 'Banco de Bogota:', 0, 1);
    $pdf->SetXY($x + 34, $y + 8);
    $pdf->Cell($col1Width, $lineHeight, 'CTA CTE 188293294', 0, 1);
    $pdf->SetXY($x + 34, $y + 12);
    $pdf->Cell($col1Width, $lineHeight, 'Banco de Occidente:', 0, 1);
    $pdf->SetXY($x + 34, $y + 16);
    $pdf->Cell($col1Width, $lineHeight, 'CTA CTE 034056739', 0, 1);
    $pdf->SetXY($x + 34, $y + 20);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell($col1Width, $lineHeight, mb_convert_encoding('Pago en línea PSE', 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->SetXY($x + 34, $y + 24);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell($col1Width, $lineHeight, mb_convert_encoding('Usando el QR', 'ISO-8859-1', 'UTF-8'), 0, 1);

    //$pdf->SetXY($x+34, $y + ($lineHeight * 2));
    //$pdf->Cell($col1Width, $lineHeight, 'Banco de Occidente: CTA CTE 034056739', 0, 1);
    //$pdf->SetXY($x+34, $y + ($lineHeight * 3));
    //$pdf->Cell($col1Width, $lineHeight, 'Puedes pagar en linea a traves del', 0, 1);
    //$pdf->SetXY($x+34, $y + ($lineHeight * 4));
    //$pdf->Cell($col1Width, $lineHeight, 'siguiente enlace:', 0, 1);
    //$pdf->SetXY($x+34, $y + ($lineHeight * 4));
    $pdf->Cell(50, 0, "", 0, 1, 'R');
    // Generar código QR

    $renderer = new ImageRenderer(
        new RendererStyle(128),
        new ImagickImageBackEnd()
    );
    $writer = new Writer($renderer);

    $qrCode = $writer->writeString("https://micrositios.avalpaycenter.com/utede-ma");
    $qrFile = tempnam(sys_get_temp_dir(), 'qr_') . '.png';
    file_put_contents($qrFile, $qrCode);
    $imagick = new Imagick($qrFile);
    $imagick->setImageFormat('png');
    $imagick->setImageDepth(8); // Convertir a 8-bit
    $imagick->setImageType(Imagick::IMGTYPE_GRAYSCALE);
    $imagick->writeImage($qrFile);
    $imagick->clear();
    // Agregar QR al PDF
    $pdf->Image($qrFile, $x + 0.2, $y - 1.8, 34, 34, 'PNG');
    unlink($qrFile); // Eliminar archivo temporal
    //$pdf->Image("https://intranet.utede.edu.co/themes/assets/images/avalpay-color.png", $x + ($col1Width / 2) - 10, $y + ($lineHeight * 4), 35, 10);

    //Celdas de la columna 2

    $x2 = $x + $col1Width;
    $pdf->SetXY($x2, $y + 1);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell($col2Width, $lineHeight, 'Pagar hasta:', 0, 1, 'L');
    $pdf->SetXY($x2, $y + 1);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell($col2Width, $lineHeight, $limit, 0, 1, 'R');
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetXY($x2, $y + ($lineHeight * 1));
    $pdf->Cell($col2Width, $lineHeight, 'Extraordinario:', 0, 1);
    $pdf->SetXY($x2, $y + ($lineHeight * 1));
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell($col2Width, $lineHeight, '--', 0, 1, 'R');
    $pdf->SetXY($x2, $y + ($lineHeight * 2));
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell($col2Width, $lineHeight, 'Nota:', 0, 1);
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetXY($x2, $y + ($lineHeight * 3));
    $pdf->MultiCell($col2Width, 4, 'Si realizaste el pago por medio de transferencia electronica o por corresponsal bancario, por favor enviar copia del soporte a:', 0, 'L');
    $pdf->SetXY($x2, $y + ($lineHeight * 3) + ($lineHeight * 4));
    $pdf->SetFont('Arial', 'B', 10); // Subrayado para el correo electrónico
    $pdf->SetXY($x2, $y + ($lineHeight * 3) + ($lineHeight * 2.4));

    $pdf->Cell($col2Width, 5, $emailTreasury["value"], 0, 1, 'L');
    return ($y + 36);
}
?>