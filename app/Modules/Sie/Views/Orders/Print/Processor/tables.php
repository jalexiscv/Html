<?php

function createTableNormal($pdf, $data, $startY, $maxWidth = null)
{
    // Si no se especifica un ancho máximo, usar un porcentaje del ancho de página
    if ($maxWidth === null) {
        $maxWidth = $pdf->GetPageWidth() * 0.8; // 80% del ancho de la página
    }
    // Establecer la posición Y inicial
    $pdf->SetY($startY);
    // Calcular proporciones de las columnas (70% concepto, 30% valor)
    $conceptColumnWidth = $maxWidth * 0.6;
    $amountColumnWidth = $maxWidth * 0.2;
    $valueColumnWidth = $maxWidth * 0.2;
    // Calcular posición X para centrar la tabla
    $pageWidth = $pdf->GetPageWidth();
    $tableWidth = $conceptColumnWidth + $valueColumnWidth;
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

        // Concepto (alineado a la izquierda)
        $pdf->Cell($conceptColumnWidth, 7, mb_convert_encoding($item['concepto'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
        // Valor (alineado a la derecha)
        $pdf->Cell($amountColumnWidth, 7, '$' . number_format($item['count'], 2, ',', '.'), 1, 1, 'R');
        $pdf->Cell($valueColumnWidth, 7, '$' . number_format($item['valor'], 2, ',', '.'), 1, 1, 'R');

        // Sumar al total
        $total += $item['valor'];
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
    // Fila del total
    $pdf->Cell($conceptColumnWidth, 7, 'TOTAL', 1, 0, 'L', true);
    $pdf->Cell($valueColumnWidth, 7, '$' . number_format($total, 2, ',', '.'), 1, 1, 'R', true);
    // Restaurar fuente norma
    $pdf->SetFont('helvetica', '', 10);
    // Retornar la posición Y final de la tabla
    return $pdf->GetY();
}


function ImprovedTable($pdf, $y, $header, $data, $maxWidth = null)
{
    $mdiscounts = model("App\Modules\Sie\Models\Sie_Discounts");

    // Set default max width if none provided
    if ($maxWidth === null) {
        $maxWidth = $pdf->GetPageWidth() * 0.77; // 80% of page width
    }
    // Calculate page center
    $pageWidth = $pdf->GetPageWidth();
    $startX = ($pageWidth - $maxWidth) / 2;
    // Set initial Y position
    $pdf->SetY($y + 5);
    $pdf->SetX($startX);
    // Add the note text with proper encoding
    $note = "Nota: Los descuentos aplicables al presente estudiante, son efectivos bajo los siguientes criterios.";
    $pdf->MultiCell($maxWidth, 5, mb_convert_encoding($note, 'ISO-8859-1', 'UTF-8'), 0, 'L');
    // Reset to original font and move to position for table
    $pdf->SetY($pdf->GetY() + 3);
    $pdf->SetX($startX);
    // Define column width proportions
    $proportions = array(7, 45, 28, 20); // Proportional widths
    $totalProportion = array_sum($proportions);
    // Calculate actual column widths based on maxWidth
    $w = array();
    foreach ($proportions as $proportion) {
        $w[] = ($proportion / $totalProportion) * $maxWidth;
    }
    // Draw header
    for ($i = 0; $i < count($header); $i++) {
        $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
    }
    $pdf->Ln();
    // Draw data rows
    $count = 0;
    foreach ($data as $row) {
        $count++;
        $discount = $mdiscounts->getDiscount($row['discount']);
        $pdf->SetX($startX); // Reset X position for each row
        $pdf->Cell($w[0], 6, $count, 'LR', 0, 'C');
        $pdf->Cell($w[1], 6, mb_convert_encoding($discount['name'], 'ISO-8859-1', 'UTF-8'), 'LR', 0, 'L');
        $type = "";
        if ($discount['type'] == "SCHOLARSHIP") {
            $type = "Beca";
        } else if ($discount['type'] == "REGISTRATION") {
            $type = "Inscripción";
        } else {
            $type = "Descuento";
        }

        $value = "";
        if ($discount['character'] == "PERCENTAGE") {
            $value = "{$discount['value']}%";
        } else {
            $value = "$ {$discount['value']}";
        }

        $pdf->Cell($w[2], 6, $type, 'LR', 0, 'C');
        $pdf->Cell($w[3], 6, $value, 'LR', 0, 'R');
        $pdf->Ln();
    }
    // Draw closing line
    $pdf->SetX($startX);
    $pdf->Cell(array_sum($w), 0, '', 'T');
}


?>