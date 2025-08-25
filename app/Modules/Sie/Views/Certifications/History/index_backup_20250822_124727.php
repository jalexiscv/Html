<?php

require_once(APPPATH . 'ThirdParty/PHPOffice/autoload.php');

use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\JcTable;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\TemplateProcessor;

$request = service("request");
$enrollment = $request->getVar("enrollment");

// Validar parámetros requeridos
if (empty($enrollment)) {
    die("Error: Faltan parámetros requeridos (enrollment)");
}

//[models]--------------------------------------------------------------------------------------------------------------
$menrollments = model('App\Modules\Sie\Models\Sie_Enrollments');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
$mprogress = model('App\Modules\Sie\Models\Sie_Progress');
$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
$mexecutions = model('App\Modules\Sie\Models\Sie_Executions');

// Obtener datos de matrícula y estudiante
$enrollment_data = $menrollments->get_Enrollment($enrollment);
$program = $mprograms->getProgram($enrollment_data["program"]);
$registration = $mregistrations->get_Registration($enrollment_data["student"]);
$registration_registration = @$registration["registration"];
$enrollment_enrollment = @$enrollment_data["enrollment"];
$fullname = @$registration["first_name"] . " " . @$registration["second_name"] . " " . @$registration["first_surname"] . " " . @$registration["second_surname"];
$identification_number = @$registration["identification_number"];
$program_name = $program["name"];

// Obtener todos los períodos para esta matrícula
$periods = $mexecutions->getPeriodsByEnrollment($enrollment);

if (empty($periods)) {
    die("Error: No se encontraron períodos para esta matrícula");
}

try {
    // Datos del estudiante para el template
    $studentData = [
        'registration' => $registration_registration,
        'fullname' => $fullname,
        'identification_number' => $identification_number,
        'cycle' => '', // Se puede obtener del período más reciente
        'program' => safe_strtoupper($program_name),
        'period' => 'HISTORIAL COMPLETO',
    ];

    // Procesar todos los períodos y generar datos consolidados
    $allGradesData = [];
    $totalGeneralCredits = 0;
    $totalGeneralWeightedGrades = 0;
    $periodSummaries = [];

    foreach ($periods as $period_info) {
        $period = $period_info["period_curso"];

        // Obtener las ejecuciones para este período
        $executions = $mexecutions->get_ExecutionsByPeriodByEnrollment($registration_registration, $period, $enrollment_enrollment);

        if (empty($executions)) {
            continue; // Saltar períodos sin ejecuciones
        }

        $periodCredits = 0;
        $periodWeightedGrades = 0;
        $periodData = [];

        foreach ($executions as $execution) {
            // Determinar el estado basado en las calificaciones
            $c1 = (float)$execution['c11'];
            $c2 = (float)$execution['c21'];
            $c3 = (float)$execution['c31'];
            $total = (float)$execution['total1'];

            // Lógica de estado: Aprobado si nota final >= 3.0
            $estado = ($total >= 3.0) ? 'Aprobado' : 'Reprobado';

            // Usar valores de calificaciones (escala 0-5)
            $primera = $c1 > 0 ? number_format($c1, 1) : '0.0';
            $segunda = $c2 > 0 ? number_format($c2, 1) : '0.0';
            $tercera = $c3 > 0 ? number_format($c3, 1) : '0.0';
            $definitiva = $total > 0 ? number_format($total, 1) : '0.0';
            $credits = intval($execution['credits'] ?? 3);

            $gradeData = [
                'execution' => $execution['execution'], // Código de la ejecución
                'modulo' => $execution['name_module'], // Nombre del módulo
                'nivel' => 'Ciclo ' . $execution['cycle'], // Ciclo real desde pensum
                'estado' => $estado,
                'primera' => $primera,
                'segunda' => $segunda,
                'tercera' => $tercera,
                'definitiva' => $definitiva,
                'creditos' => $credits,
                'periodo' => $period // Agregar período para identificación
            ];

            $allGradesData[] = $gradeData;
            $periodData[] = $gradeData;

            // Acumular para totales
            $periodCredits += $credits;
            $periodWeightedGrades += ($total * $credits);
            $totalGeneralCredits += $credits;
            $totalGeneralWeightedGrades += ($total * $credits);
        }

        // Calcular promedio del período
        $periodAverage = $periodCredits > 0 ? $periodWeightedGrades / $periodCredits : 0;

        $periodSummaries[] = [
            'period' => $period,
            'credits' => $periodCredits,
            'average' => $periodAverage,
            'subjects' => count($periodData)
        ];
    }

    // Si no hay datos, usar mensaje informativo
    if (empty($allGradesData)) {
        $allGradesData = [
            ['execution' => '-', 'modulo' => 'No se encontraron registros académicos', 'nivel' => '-', 'estado' => '-', 'primera' => '0.0', 'segunda' => '0.0', 'tercera' => '0.0', 'definitiva' => '0.0', 'creditos' => '0', 'periodo' => '-']
        ];
    }

    // Ruta de la plantilla (usar la misma que certificado de notas)
    $templatePath = PUBLICPATH . 'formats/certificado-notas.docx';

    // Verificar que la plantilla existe
    if (!file_exists($templatePath)) {
        throw new Exception("La plantilla no existe en: " . $templatePath);
    }

    // Cargar la plantilla
    $template = new TemplateProcessor($templatePath);

    // Reemplazar los parámetros básicos
    $template->setValue('header', time());
    $template->setValue('registration', $registration_registration);
    $template->setValue('fullname', $studentData['fullname']);
    $template->setValue('identification_number', $studentData['identification_number']);
    $template->setValue('cycle', $studentData['cycle']);
    $template->setValue('program', $studentData['program']);
    $template->setValue('period', $studentData['period']);
    $template->setValue('footer', time());

    // Calcular promedio general
    $promedioGeneral = $totalGeneralCredits > 0 ? round($totalGeneralWeightedGrades / $totalGeneralCredits, 2) : 0;
    $totalCreditosAprobados = 0;

    foreach ($allGradesData as $grade) {
        if (strtolower($grade['estado']) === 'aprobado') {
            $totalCreditosAprobados += (float)$grade['creditos'];
        }
    }

    // Intentar reemplazar la tabla usando diferentes métodos (igual que Transcript)
    $variables = $template->getVariables();

    // Método 1: Usar cloneRowAndSetValues si existe una tabla template en el documento
    if (in_array('execution', $variables) && in_array('modulo', $variables) && in_array('nivel', $variables)) {
        // La plantilla tiene una tabla con variables, usar cloneRowAndSetValues
        $template->cloneRowAndSetValues('execution', $allGradesData);

        // Agregar totales si existen variables para ello
        if (in_array('total_creditos', $variables)) {
            $template->setValue('total_creditos', $totalGeneralCredits);
        }
        if (in_array('total_creditos_aprobados', $variables)) {
            $template->setValue('total_creditos_aprobados', $totalCreditosAprobados);
        }
        if (in_array('promedio_general', $variables)) {
            $template->setValue('promedio_general', $promedioGeneral);
        }

    } elseif (in_array('table', $variables)) {
        // Método 2: Crear múltiples tablas (una por período) y combinarlas
        // Crear un array para almacenar todas las tablas de períodos
        $allTables = [];

        // Procesar cada período por separado
        foreach ($periodSummaries as $periodSummary) {
            $currentPeriod = $periodSummary['period'];

            // Filtrar datos solo para este período
            $periodGrades = array_filter($allGradesData, function ($grade) use ($currentPeriod) {
                return $grade['periodo'] === $currentPeriod;
            });

            if (empty($periodGrades)) {
                continue;
            }

            // Crear tabla para este período específico
            $periodTable = new Table([
                'borderSize' => 6,
                'borderColor' => '000000',
                'cellMargin' => 40,
            ]);

            // Aplicar estilo a la tabla
            $tableStyle = $periodTable->getStyle();
            $tableStyle->setWidth(100);
            $tableStyle->setUnit(TblWidth::PERCENT);
            $tableStyle->setAlignment(JcTable::CENTER);

            // Estilo para encabezados
            $headerStyle = [
                'valign' => 'center',
                'bgColor' => 'CCCCCC',
                'cellMargin' => 40,
            ];

            $headerFontStyle = [
                'bold' => true,
                'size' => 10,
                'name' => 'Arial'
            ];

            // Título del período (fila especial)
            $periodTable->addRow(320);
            $periodTable->addCell(null, [
                'gridSpan' => 9,
                'valign' => 'center',
                'bgColor' => '4472C4',
                'cellMargin' => 40,
            ])->addText('PERÍODO ACADÉMICO: ' . $currentPeriod, [
                'bold' => true,
                'size' => 12,
                'name' => 'Arial',
                'color' => 'FFFFFF'
            ], [
                'alignment' => Jc::CENTER,
                'spaceBefore' => 0,
                'spaceAfter' => 0
            ]);

            // Agregar fila de encabezados
            $periodTable->addRow(280, ['tblHeader' => true]);
            $periodTable->addCell(null, $headerStyle)->addText('#', $headerFontStyle, [
                'alignment' => Jc::CENTER,
                'spaceBefore' => 0,
                'spaceAfter' => 0
            ]);
            $periodTable->addCell(null, $headerStyle)->addText('CÓDIGO', $headerFontStyle, [
                'alignment' => Jc::CENTER,
                'spaceBefore' => 0,
                'spaceAfter' => 0
            ]);
            $periodTable->addCell(null, $headerStyle)->addText('MÓDULO', $headerFontStyle, [
                'alignment' => Jc::CENTER,
                'spaceBefore' => 0,
                'spaceAfter' => 0
            ]);
            $periodTable->addCell(null, $headerStyle)->addText('CICLO', $headerFontStyle, [
                'alignment' => Jc::CENTER,
                'spaceBefore' => 0,
                'spaceAfter' => 0
            ]);
            $periodTable->addCell(null, $headerStyle)->addText('ESTADO', $headerFontStyle, [
                'alignment' => Jc::CENTER,
                'spaceBefore' => 0,
                'spaceAfter' => 0
            ]);
            $periodTable->addCell(null, $headerStyle)->addText('C1', $headerFontStyle, [
                'alignment' => Jc::CENTER,
                'spaceBefore' => 0,
                'spaceAfter' => 0
            ]);
            $periodTable->addCell(null, $headerStyle)->addText('C2', $headerFontStyle, [
                'alignment' => Jc::CENTER,
                'spaceBefore' => 0,
                'spaceAfter' => 0
            ]);
            $periodTable->addCell(null, $headerStyle)->addText('C3', $headerFontStyle, [
                'alignment' => Jc::CENTER,
                'spaceBefore' => 0,
                'spaceAfter' => 0
            ]);
            $periodTable->addCell(null, $headerStyle)->addText('FINAL', $headerFontStyle, [
                'alignment' => Jc::CENTER,
                'spaceBefore' => 0,
                'spaceAfter' => 0
            ]);
            $periodTable->addCell(null, $headerStyle)->addText('CRÉD', $headerFontStyle, [
                'alignment' => Jc::CENTER,
                'spaceBefore' => 0,
                'spaceAfter' => 0
            ]);

            // Variables para consolidados del período
            $periodCredits = 0;
            $periodWeightedGrades = 0;
            $periodApprovedCredits = 0;
            $rowIndex = 0;

            // Agregar filas de datos para este período
            foreach ($periodGrades as $grade) {
                $rowIndex++;
                $periodTable->addRow(240);

                // Estilo de celda con centrado vertical
                $cellStyle = [
                    'valign' => 'center',
                    'cellMargin' => 40
                ];

                // Alternar colores de filas
                if ($rowIndex % 2 == 0) {
                    $cellStyle['bgColor'] = 'F9F9F9';
                }

                $fontStyle = [
                    'size' => 9,
                    'name' => 'Arial'
                ];

                $paragraphStyle = [
                    'alignment' => Jc::CENTER,
                    'spaceBefore' => 0,
                    'spaceAfter' => 0,
                    'lineHeight' => 1.0
                ];

                // Número de fila
                $periodTable->addCell(null, $cellStyle)->addText($rowIndex, $fontStyle, $paragraphStyle);

                // Código de ejecución
                $periodTable->addCell(null, $cellStyle)->addText($grade['execution'], $fontStyle, $paragraphStyle);

                // Módulo - alineado a la izquierda
                $paragraphStyleLeft = array_merge($paragraphStyle, ['alignment' => Jc::LEFT]);
                $periodTable->addCell(null, $cellStyle)->addText($grade['modulo'], $fontStyle, $paragraphStyleLeft);

                // Nivel
                $periodTable->addCell(null, $cellStyle)->addText($grade['nivel'], $fontStyle, $paragraphStyle);

                // Estado con color
                $estadoFontStyle = $fontStyle;
                if (strtolower($grade['estado']) == 'aprobado') {
                    $estadoFontStyle['color'] = '008000'; // Verde
                    $estadoFontStyle['bold'] = true;
                    $periodApprovedCredits += (float)$grade['creditos'];
                } elseif (strtolower($grade['estado']) == 'reprobado') {
                    $estadoFontStyle['color'] = 'CC0000'; // Rojo
                    $estadoFontStyle['bold'] = true;
                }
                $periodTable->addCell(null, $cellStyle)->addText($grade['estado'], $estadoFontStyle, $paragraphStyle);

                // Calificaciones
                $periodTable->addCell(null, $cellStyle)->addText($grade['primera'], $fontStyle, $paragraphStyle);
                $periodTable->addCell(null, $cellStyle)->addText($grade['segunda'], $fontStyle, $paragraphStyle);
                $periodTable->addCell(null, $cellStyle)->addText($grade['tercera'], $fontStyle, $paragraphStyle);

                // Nota definitiva con negrita
                $definitovaFontStyle = array_merge($fontStyle, ['bold' => true]);
                $periodTable->addCell(null, $cellStyle)->addText($grade['definitiva'], $definitovaFontStyle, $paragraphStyle);

                // Créditos
                $periodTable->addCell(null, $cellStyle)->addText($grade['creditos'], $fontStyle, $paragraphStyle);

                // Acumular para consolidados del período
                $credits = (float)$grade['creditos'];
                $finalGrade = (float)$grade['definitiva'];
                $periodCredits += $credits;
                $periodWeightedGrades += ($finalGrade * $credits);
            }

            // Calcular promedio del período
            $periodAverage = $periodCredits > 0 ? round($periodWeightedGrades / $periodCredits, 2) : 0;

            // Fila de consolidados del período
            $totalCellStyle = [
                'valign' => 'center',
                'bgColor' => 'E6E6E6',
                'cellMargin' => 40
            ];

            $totalFontStyle = array_merge($fontStyle, ['bold' => true]);
            $totalParagraphStyle = [
                'alignment' => Jc::CENTER,
                'spaceBefore' => 0,
                'spaceAfter' => 0,
                'lineHeight' => 1.0
            ];

            // Fila de totales del período
            $periodTable->addRow(260);
            $periodTable->addCell(null, $totalCellStyle)->addText('', $totalFontStyle, $totalParagraphStyle); // # (vacío)
            $periodTable->addCell(null, $totalCellStyle)->addText('', $totalFontStyle, $totalParagraphStyle); // CÓDIGO (vacío)
            $periodTable->addCell(null, $totalCellStyle)->addText('TOTALES DEL PERÍODO', $totalFontStyle, $totalParagraphStyle); // MÓDULO (label)
            $periodTable->addCell(null, $totalCellStyle)->addText('', $totalFontStyle, $totalParagraphStyle); // CICLO (vacío)
            $periodTable->addCell(null, $totalCellStyle)->addText('', $totalFontStyle, $totalParagraphStyle); // ESTADO (vacío)
            $periodTable->addCell(null, $totalCellStyle)->addText('', $totalFontStyle, $totalParagraphStyle); // C1 (vacío)
            $periodTable->addCell(null, $totalCellStyle)->addText('', $totalFontStyle, $totalParagraphStyle); // C2 (vacío)
            $periodTable->addCell(null, $totalCellStyle)->addText('', $totalFontStyle, $totalParagraphStyle); // C3 (vacío)
            $periodTable->addCell(null, $totalCellStyle)->addText($periodAverage, [
                'bold' => true,
                'size' => 9,
                'name' => 'Arial',
                'color' => $periodAverage >= 3.0 ? '008000' : 'CC0000'
            ], $totalParagraphStyle); // FINAL (promedio del período)
            $periodTable->addCell(null, $totalCellStyle)->addText($periodCredits, $totalFontStyle, $totalParagraphStyle); // CRÉDITOS (total del período)

            // Agregar esta tabla al array de tablas
            $allTables[] = $periodTable;
        }

        // Crear tabla final con resumen general
        $summaryTable = new Table([
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 40,
        ]);

        $summaryTableStyle = $summaryTable->getStyle();
        $summaryTableStyle->setWidth(100);
        $summaryTableStyle->setUnit(TblWidth::PERCENT);
        $summaryTableStyle->setAlignment(JcTable::CENTER);

        // Título del resumen
        $summaryTable->addRow(320);
        $summaryTable->addCell(null, [
            'gridSpan' => 2,
            'valign' => 'center',
            'bgColor' => '70AD47',
            'cellMargin' => 40,
        ])->addText('RESUMEN GENERAL DEL HISTORIAL ACADÉMICO', [
            'bold' => true,
            'size' => 12,
            'name' => 'Arial',
            'color' => 'FFFFFF'
        ], [
            'alignment' => Jc::CENTER,
            'spaceBefore' => 0,
            'spaceAfter' => 0
        ]);

        // Filas de resumen
        $summaryTable->addRow(280);
        $summaryTable->addCell(null, [
            'valign' => 'center',
            'bgColor' => 'CCCCCC',
            'cellMargin' => 40,
        ])->addText('TOTAL CRÉDITOS CURSADOS', [
            'bold' => true,
            'size' => 10,
            'name' => 'Arial'
        ], ['alignment' => Jc::CENTER]);
        $summaryTable->addCell(null, [
            'valign' => 'center',
            'bgColor' => 'F0F0F0',
            'cellMargin' => 40,
        ])->addText($totalGeneralCredits, [
            'bold' => true,
            'size' => 10,
            'name' => 'Arial'
        ], ['alignment' => Jc::CENTER]);

        $summaryTable->addRow(280);
        $summaryTable->addCell(null, [
            'valign' => 'center',
            'bgColor' => 'CCCCCC',
            'cellMargin' => 40,
        ])->addText('CRÉDITOS APROBADOS', [
            'bold' => true,
            'size' => 10,
            'name' => 'Arial'
        ], ['alignment' => Jc::CENTER]);
        $summaryTable->addCell(null, [
            'valign' => 'center',
            'bgColor' => 'F0F0F0',
            'cellMargin' => 40,
        ])->addText($totalCreditosAprobados, [
            'bold' => true,
            'size' => 10,
            'name' => 'Arial'
        ], ['alignment' => Jc::CENTER]);

        $summaryTable->addRow(280);
        $summaryTable->addCell(null, [
            'valign' => 'center',
            'bgColor' => 'CCCCCC',
            'cellMargin' => 40,
        ])->addText('PROMEDIO GENERAL ACUMULADO', [
            'bold' => true,
            'size' => 10,
            'name' => 'Arial'
        ], ['alignment' => Jc::CENTER]);
        $summaryTable->addCell(null, [
            'valign' => 'center',
            'bgColor' => 'F0F0F0',
            'cellMargin' => 40,
        ])->addText($promedioGeneral, [
            'bold' => true,
            'size' => 10,
            'name' => 'Arial',
            'color' => $promedioGeneral >= 3.0 ? '008000' : 'CC0000'
        ], ['alignment' => Jc::CENTER]);

        // Agregar tabla de resumen al final
        $allTables[] = $summaryTable;

        // Combinar todas las tablas en una sola variable para el template
        $template->setComplexBlock('table', $allTables);

    } else {
        // Método 3: Fallback - texto plano formateado con múltiples períodos
        $tablaTexto = "HISTORIAL ACADÉMICO COMPLETO\n\n";

        // Encabezados
        $tablaTexto .= str_pad("PERÍODO", 10) . str_pad("CÓDIGO", 15) . str_pad("MÓDULO", 25) . str_pad("CICLO", 8) . str_pad("ESTADO", 12) . str_pad("C1", 6) . str_pad("C2", 6) . str_pad("C3", 6) . str_pad("FINAL", 8) . "CRÉD\n";
        $tablaTexto .= str_repeat("=", 120) . "\n";

        // Agrupar por período
        $currentPeriod = '';
        foreach ($allGradesData as $grade) {
            if ($grade['periodo'] !== $currentPeriod) {
                if ($currentPeriod !== '') {
                    $tablaTexto .= str_repeat("-", 120) . "\n";
                }
                $currentPeriod = $grade['periodo'];
            }

            $tablaTexto .= str_pad($grade['periodo'], 10) .
                str_pad(substr($grade['execution'], 0, 13), 15) .
                str_pad(substr($grade['modulo'], 0, 23), 25) .
                str_pad($grade['nivel'], 8) .
                str_pad($grade['estado'], 12) .
                str_pad($grade['primera'], 6) .
                str_pad($grade['segunda'], 6) .
                str_pad($grade['tercera'], 6) .
                str_pad($grade['definitiva'], 8) .
                $grade['creditos'] . "\n";
        }

        // Línea separadora
        $tablaTexto .= str_repeat("=", 120) . "\n";

        // Totales generales
        $tablaTexto .= str_pad("TOTALES GENERALES", 85) .
            str_pad($promedioGeneral, 8) .
            $totalGeneralCredits . "\n";

        // Créditos aprobados
        $tablaTexto .= str_pad("CRÉDITOS APROBADOS", 85) .
            str_pad("", 8) .
            $totalCreditosAprobados;

        $template->setValue('table', $tablaTexto);
    }

} catch (Exception $e) {
    // Método 4: Fallback simple en caso de error
    $tablaSimple = "HISTORIAL ACADÉMICO COMPLETO\n\n";
    if (!empty($allGradesData)) {
        foreach ($allGradesData as $grade) {
            $tablaSimple .= $grade['periodo'] . " - " . $grade['execution'] . " - " . $grade['modulo'] .
                " (" . $grade['creditos'] . " créditos) - " .
                $grade['definitiva'] . " - " . $grade['estado'] . "\n";
        }
    }
    $tablaSimple .= "\nTOTAL CRÉDITOS: " . $totalGeneralCredits . "\n";
    $tablaSimple .= "CRÉDITOS APROBADOS: " . $totalCreditosAprobados . "\n";
    $tablaSimple .= "PROMEDIO GENERAL: " . $promedioGeneral;

    $template->setValue('table', $tablaSimple);
}

// Crear directorio temporal si no existe
$tmpDir = PUBLICPATH . "tmp";
if (!is_dir($tmpDir)) {
    mkdir($tmpDir, 0755, true);
}

// Generar nombre único para el archivo
$timestamp = date('Y-m-d_H-i-s');
$filename = "historial_academico_{$enrollment_enrollment}_{$timestamp}.docx";
$outputPath = $tmpDir . "/" . $filename;

// Guardar el documento
$template->saveAs($outputPath);

// Verificar que el archivo se creó correctamente
if (!file_exists($outputPath)) {
    throw new Exception("Error: No se pudo generar el archivo");
}

// Configurar headers para descarga
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($outputPath));

// Limpiar buffer de salida
ob_clean();
flush();

// Enviar archivo
readfile($outputPath);

// Limpiar archivo temporal después de un tiempo
register_shutdown_function(function () use ($outputPath) {
    if (file_exists($outputPath)) {
        sleep(1); // Esperar un poco antes de eliminar
        unlink($outputPath);
    }
});

?>
