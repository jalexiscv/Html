<?php
// Establecer la fuente

function barcode($pdf, $params = [])
{
    $pageWidth = $pdf->GetPageWidth();
    $maxWidth = isset($params['maxWidth']) ? $params['maxWidth'] : 0;
    $x = ($pageWidth - $maxWidth) / 2;
    $y = $params['startY'] + 2;
    $height = isset($params['height']) ? $params['height'] : 30;

    $pdf->SetXY($x, $y);
    $pdf->Cell($maxWidth, $height, "", 1, 1, 'C');

    // Parámetros por defecto
    $defaults = [
        'gs1_data' => '', // Datos para el código de barras
        'startY' => $y + 10, // Posición inicial Y
        'barcode_width' => 158, // Ancho del código de barras
        'barcode_height' => 20, // Alto del código de barras
        'text_size' => 9, // Tamaño de la fuente para el texto del código
        'text_offset_y' => 25, // Distancia vertical entre código y texto
        'barcode_url' => 'https://intranet.utede.edu.co/codebar/GS1/test.php' // URL base del generador de códigos
    ];

    $params = array_merge($defaults, $params);
    $startX = ($pageWidth - $params['barcode_width']) / 2;
    // Imprimir código de barras
    $y += 3;
    $barcodeUrl = $params['barcode_url'] . "?cb=" . $params['gs1_data'];
    $pdf->Image($barcodeUrl, $startX, $y, $params['barcode_width'], $params['barcode_height'], 'PNG');
    $y += $params['barcode_height'] + 0;
    $pdf->SetFont('Arial', 'B', $params['text_size']);
    $text = mb_convert_encoding($params['gs1_data'], 'ISO-8859-1', 'UTF-8');
    $pdf->SetXY($x, $y);
    $pdf->Cell($maxWidth, 5, $text, 0, 1, 'C');
    return [
        'finalY' => $params['startY'] + $params['text_offset_y']
    ];
}


?>