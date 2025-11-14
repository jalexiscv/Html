<?php
// Código corregido para calcular cambios porcentuales con orden descendente

$periods = $mcourses->getPeriodsWithCourseCount();

// Crear datos de períodos académicos dinámicos con cálculo de cambio porcentual
$academicPeriodsData = [];
$gradients = [
    'linear-gradient(135deg, #059669, #047857)', // Verde
    'linear-gradient(135deg, #0891b2, #0e7490)', // Azul
    'linear-gradient(135deg, #7c3aed, #6d28d9)', // Púrpura
    'linear-gradient(135deg, #dc2626, #b91c1c)', // Rojo
    'linear-gradient(135deg, #f59e0b, #d97706)', // Amarillo
    'linear-gradient(135deg, #10b981, #059669)', // Verde claro
];

// Invertir el array para calcular cambios de antiguo a reciente
$periodsReversed = array_reverse($periods);

foreach ($periodsReversed as $index => $period) {
    // Extraer año y letra del período (ej: 2024A -> año: 2024, letra: A)
    $periodCode = $period['period'];
    $year = substr($periodCode, 0, 4);
    $letter = substr($periodCode, 4, 1);

    // Calcular cambio porcentual comparado con el período anterior (cronológicamente)
    $change = 0.0;
    if ($index > 0) {
        $previousCount = $periodsReversed[$index - 1]['total_courses'];
        $currentCount = $period['total_courses'];

        if ($previousCount > 0) {
            $change = round((($currentCount - $previousCount) / $previousCount) * 100, 1);
        } elseif ($currentCount > 0) {
            $change = 100.0; // Si anterior era 0 y actual > 0, es 100% de incremento
        }
    }

    $academicPeriodsData[] = [
        'code' => strtolower($periodCode),
        'short_code' => substr($year, 2) . $letter, // 24A, 24B, etc.
        'name' => $periodCode,
        'courses_count' => $period['total_courses'],
        'change' => $change,
        'gradient' => $gradients[$index % count($gradients)]
    ];
}

// Invertir el resultado final para mostrar en orden descendente (más reciente primero)
$academicPeriodsData = array_reverse($academicPeriodsData);

// Generar y mostrar la card de períodos académicos
echo sie_widget_academic_periods($academicPeriodsData, $bootstrap);
?>
