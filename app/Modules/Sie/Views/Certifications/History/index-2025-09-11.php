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
//[vars]----------------------------------------------------------------------------------------------------------------
$periodo_actual = date("Y") . (date("n") <= 6 ? "A" : "B");

// Obtener datos de matrícula y estudiante
$enrollment_data = $menrollments->get_Enrollment($enrollment);
$program = $mprograms->getProgram($enrollment_data["program"]);
$registration = $mregistrations->getRegistration($enrollment_data["registration"]);
$registration_registration = @$registration["registration"];
$enrollment_enrollment = @$enrollment_data["enrollment"];
$fullname = @$registration["first_name"] . " " . @$registration["second_name"] . " " . @$registration["first_surname"] . " " . @$registration["second_surname"];
$identification_number = @$registration["identification_number"];
$program_name = $program["name"];

// Obtener todos los períodos para esta matrícula
$periods = $mexecutions->getPeriodsByEnrollment2($enrollment);

if (empty($periods)) {
    die("Error: No se encontraron períodos para esta matrícula");
}
//echo(safe_dump($periods));
//exit();


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
        $executions = $mexecutions->get_ExecutionsByPeriodByEnrollment4($registration_registration, $period, $enrollment_enrollment);

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

            // Lógica de estado: Aprobado si nota final >= 80.0 (base 100)
            // Si es el período actual y la nota es < 80.0, marcar como "En Curso" en lugar de "Reprobado"
            if ($execution['status'] == "HOMOLOGATION") {
                $estado = 'Homologado';
            } elseif ($total >= 80.0) {
                $estado = 'Aprobado';
            } elseif ($period === $periodo_actual) {
                $estado = 'En Curso';
            } else {
                $estado = 'Reprobado';
            }

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
    $templatePath = PUBLICPATH . 'formats/certificado-historial-academico-v2.docx';

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
        // Método 2: Crear tablas independientes para cada período y resumen
        // Array para almacenar todas las tablas independientes
        $allTables = [];

        // Configuración común para todas las tablas
        $tableConfig = [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 40,
        ];

        // Función para configurar estilo de tabla
        $configureTableStyle = function ($table) {
            $tableStyle = $table->getStyle();
            $tableStyle->setWidth(10773); // 19 cm
            $tableStyle->setUnit(TblWidth::TWIP);
            $tableStyle->setAlignment(JcTable::CENTER);
            $tableStyle->setLayout('fixed');
        };

        // Estilos comunes
        $headerStyle = [
            'valign' => 'center',
            'bgColor' => 'CCCCCC',
            'cellMargin' => 40,
        ];

        $headerFontStyle = [
            'bold' => true,
            'size' => 8,
            'name' => 'Arial'
        ];

        $fontStyle = [
            'size' => 7,
            'name' => 'Arial'
        ];

        $paragraphStyle = [
            'alignment' => Jc::CENTER,
            'spaceBefore' => 0,
            'spaceAfter' => 0,
            'lineHeight' => 1.0
        ];

        // Procesar cada período y crear tablas independientes
        foreach ($periodSummaries as $periodSummary) {
            $currentPeriod = $periodSummary['period'];

            // Filtrar datos solo para este período
            $periodGrades = array_filter($allGradesData, function ($grade) use ($currentPeriod) {
                return $grade['periodo'] === $currentPeriod;
            });

            if (empty($periodGrades)) {
                continue;
            }

            // Crear tabla independiente para este período
            $periodTable = new Table($tableConfig);
            $configureTableStyle($periodTable);

            // Título del período (fila especial)
            $periodTable->addRow(320);
            $periodTable->addCell(null, [
                'gridSpan' => 10,
                'valign' => 'center',
                'bgColor' => '4472C4',
                'cellMargin' => 40,
            ])->addText('PERÍODO ACADÉMICO: ' . $currentPeriod, [
                'bold' => true,
                'size' => 9,
                'name' => 'Arial',
                'color' => 'FFFFFF'
            ], [
                'alignment' => Jc::CENTER,
                'spaceBefore' => 0,
                'spaceAfter' => 0
            ]);

            // Agregar fila de encabezados para este período con anchos específicos (total: 10773 twips = 19 cm)
            $periodTable->addRow(220, ['tblHeader' => true]);
            $periodTable->addCell(300, $headerStyle)->addText('#', $headerFontStyle, $paragraphStyle);
            $periodTable->addCell(1500, $headerStyle)->addText('CÓDIGO', $headerFontStyle, $paragraphStyle);
            $periodTable->addCell(4673, $headerStyle)->addText('MÓDULO', $headerFontStyle, $paragraphStyle);
            $periodTable->addCell(900, $headerStyle)->addText('CICLO', $headerFontStyle, $paragraphStyle);
            $periodTable->addCell(1000, $headerStyle)->addText('ESTADO', $headerFontStyle, $paragraphStyle);
            $periodTable->addCell(600, $headerStyle)->addText('C1', $headerFontStyle, $paragraphStyle);
            $periodTable->addCell(600, $headerStyle)->addText('C2', $headerFontStyle, $paragraphStyle);
            $periodTable->addCell(600, $headerStyle)->addText('C3', $headerFontStyle, $paragraphStyle);
            $periodTable->addCell(600, $headerStyle)->addText('T', $headerFontStyle, $paragraphStyle);
            $periodTable->addCell(300, $headerStyle)->addText('C', $headerFontStyle, $paragraphStyle);

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

                // Número de fila
                $periodTable->addCell(300, $cellStyle)->addText($rowIndex, $fontStyle, $paragraphStyle);

                // Código de ejecución
                $periodTable->addCell(1500, $cellStyle)->addText($grade['execution'], $fontStyle, $paragraphStyle);

                // Módulo - alineado a la izquierda
                $paragraphStyleLeft = array_merge($paragraphStyle, ['alignment' => Jc::LEFT]);
                $periodTable->addCell(4673, $cellStyle)->addText($grade['modulo'], $fontStyle, $paragraphStyleLeft);

                // Nivel
                $periodTable->addCell(900, $cellStyle)->addText($grade['nivel'], $fontStyle, $paragraphStyle);

                // Estado con color
                $estadoFontStyle = $fontStyle;
                if (strtolower($grade['estado']) == 'aprobado') {
                    $estadoFontStyle['color'] = '008000'; // Verde
                    $estadoFontStyle['bold'] = true;
                    $periodApprovedCredits += (float)$grade['creditos'];
                } elseif (strtolower($grade['estado']) == 'reprobado') {
                    $estadoFontStyle['color'] = 'CC0000'; // Rojo
                    $estadoFontStyle['bold'] = true;
                } elseif (strtolower($grade['estado']) == 'en curso') {
                    $estadoFontStyle['color'] = 'FF8800'; // Naranja
                    $estadoFontStyle['bold'] = true;
                }
                $periodTable->addCell(1000, $cellStyle)->addText($grade['estado'], $estadoFontStyle, $paragraphStyle);

                // Calificaciones
                $periodTable->addCell(600, $cellStyle)->addText($grade['primera'], $fontStyle, $paragraphStyle);
                $periodTable->addCell(600, $cellStyle)->addText($grade['segunda'], $fontStyle, $paragraphStyle);
                $periodTable->addCell(600, $cellStyle)->addText($grade['tercera'], $fontStyle, $paragraphStyle);

                // Nota definitiva con negrita
                $definitovaFontStyle = array_merge($fontStyle, ['bold' => true]);
                $periodTable->addCell(600, $cellStyle)->addText($grade['definitiva'], $definitovaFontStyle, $paragraphStyle);

                // Créditos
                $periodTable->addCell(300, $cellStyle)->addText($grade['creditos'], $fontStyle, $paragraphStyle);

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

            // Fila de totales del período
            $periodTable->addRow(260);
            $periodTable->addCell(300, $totalCellStyle)->addText('', $totalFontStyle, $paragraphStyle); // # (vacío)
            $periodTable->addCell(1500, $totalCellStyle)->addText('', $totalFontStyle, $paragraphStyle); // CÓDIGO (vacío)
            $periodTable->addCell(4673, $totalCellStyle)->addText('TOTALES DEL PERÍODO', $totalFontStyle, $paragraphStyle); // MÓDULO (label)
            $periodTable->addCell(900, $totalCellStyle)->addText('', $totalFontStyle, $paragraphStyle); // CICLO (vacío)
            $periodTable->addCell(1000, $totalCellStyle)->addText('', $totalFontStyle, $paragraphStyle); // ESTADO (vacío)
            $periodTable->addCell(600, $totalCellStyle)->addText('', $totalFontStyle, $paragraphStyle); // C1 (vacío)
            $periodTable->addCell(600, $totalCellStyle)->addText('', $totalFontStyle, $paragraphStyle); // C2 (vacío)
            $periodTable->addCell(600, $totalCellStyle)->addText('', $totalFontStyle, $paragraphStyle); // C3 (vacío)
            $periodTable->addCell(600, $totalCellStyle)->addText($periodAverage, [
                'bold' => true,
                'size' => 7,
                'name' => 'Arial',
                'color' => $periodAverage >= 3.0 ? '008000' : 'CC0000'
            ], $paragraphStyle); // FINAL (promedio del período)
            $periodTable->addCell(300, $totalCellStyle)->addText($periodCredits, $totalFontStyle, $paragraphStyle); // CRÉDITOS (total del período)

            // Agregar esta tabla de período al array de tablas
            $allTables[] = $periodTable;
        }

        // Crear tabla independiente para el resumen general
        $summaryTable = new Table($tableConfig);
        $configureTableStyle($summaryTable);

        // Título del resumen
        $summaryTable->addRow(220);
        $summaryTable->addCell(null, [
            'gridSpan' => 10,
            'valign' => 'center',
            'bgColor' => '70AD47',
            'cellMargin' => 40,
        ])->addText('RESUMEN GENERAL DEL HISTORIAL ACADÉMICO', [
            'bold' => true,
            'size' => 9,
            'name' => 'Arial',
            'color' => 'FFFFFF'
        ], [
            'alignment' => Jc::CENTER,
            'spaceBefore' => 0,
            'spaceAfter' => 0
        ]);

        // Filas de resumen - Total créditos cursados
        $summaryTable->addRow(220);
        $summaryTable->addCell(null, [
            'gridSpan' => 8,
            'valign' => 'center',
            'bgColor' => 'CCCCCC',
            'cellMargin' => 40,
        ])->addText('TOTAL CRÉDITOS CURSADOS', [
            'bold' => true,
            'size' => 8,
            'name' => 'Arial'
        ], ['alignment' => Jc::CENTER]);
        $summaryTable->addCell(null, [
            'gridSpan' => 2,
            'valign' => 'center',
            'bgColor' => 'F0F0F0',
            'cellMargin' => 40,
        ])->addText($totalGeneralCredits, [
            'bold' => true,
            'size' => 8,
            'name' => 'Arial'
        ], ['alignment' => Jc::CENTER]);

        // Créditos aprobados
        $summaryTable->addRow(220);
        $summaryTable->addCell(null, [
            'gridSpan' => 8,
            'valign' => 'center',
            'bgColor' => 'CCCCCC',
            'cellMargin' => 40,
        ])->addText('CRÉDITOS APROBADOS', [
            'bold' => true,
            'size' => 8,
            'name' => 'Arial'
        ], ['alignment' => Jc::CENTER]);
        $summaryTable->addCell(null, [
            'gridSpan' => 2,
            'valign' => 'center',
            'bgColor' => 'F0F0F0',
            'cellMargin' => 40,
        ])->addText($totalCreditosAprobados, [
            'bold' => true,
            'size' => 8,
            'name' => 'Arial'
        ], ['alignment' => Jc::CENTER]);

        // Promedio general acumulado
        $summaryTable->addRow(220);
        $summaryTable->addCell(null, [
            'gridSpan' => 8,
            'valign' => 'center',
            'bgColor' => 'CCCCCC',
            'cellMargin' => 40,
        ])->addText('PROMEDIO GENERAL ACUMULADO', [
            'bold' => true,
            'size' => 8,
            'name' => 'Arial'
        ], ['alignment' => Jc::CENTER]);
        $summaryTable->addCell(null, [
            'gridSpan' => 2,
            'valign' => 'center',
            'bgColor' => 'F0F0F0',
            'cellMargin' => 40,
        ])->addText($promedioGeneral, [
            'bold' => true,
            'size' => 8,
            'name' => 'Arial',
            'color' => $promedioGeneral >= 3.0 ? '008000' : 'CC0000'
        ], ['alignment' => Jc::CENTER]);

        // Crear tabla principal única que contenga todas las secciones como filas
        $mainTable = new Table($tableConfig);
        $configureTableStyle($mainTable);

        // Procesar cada período y agregarlo como secciones a la tabla principal
        foreach ($periodSummaries as $periodSummary) {
            $currentPeriod = $periodSummary['period'];

            // Filtrar datos solo para este período
            $periodGrades = array_filter($allGradesData, function ($grade) use ($currentPeriod) {
                return $grade['periodo'] === $currentPeriod;
            });

            if (empty($periodGrades)) {
                continue;
            }

            // Título del período (fila especial)
            $mainTable->addRow(238);
            $mainTable->addCell(null, [
                'gridSpan' => 10,
                'valign' => 'center',
                'bgColor' => '4472C4',
                'cellMargin' => 40,
            ])->addText('PERÍODO ACADÉMICO: ' . $currentPeriod, [
                'bold' => true,
                'size' => 9,
                'name' => 'Arial',
                'color' => 'FFFFFF'
            ], [
                'alignment' => Jc::CENTER,
                'spaceBefore' => 0,
                'spaceAfter' => 0
            ]);

            // Agregar fila de encabezados para este período
            $mainTable->addRow(238, ['tblHeader' => true]);
            $mainTable->addCell(300, $headerStyle)->addText('#', $headerFontStyle, $paragraphStyle);
            $mainTable->addCell(1500, $headerStyle)->addText('CÓDIGO', $headerFontStyle, $paragraphStyle);
            $mainTable->addCell(4673, $headerStyle)->addText('MÓDULO', $headerFontStyle, $paragraphStyle);
            $mainTable->addCell(900, $headerStyle)->addText('CICLO', $headerFontStyle, $paragraphStyle);
            $mainTable->addCell(1000, $headerStyle)->addText('ESTADO', $headerFontStyle, $paragraphStyle);
            $mainTable->addCell(600, $headerStyle)->addText('C1', $headerFontStyle, $paragraphStyle);
            $mainTable->addCell(600, $headerStyle)->addText('C2', $headerFontStyle, $paragraphStyle);
            $mainTable->addCell(600, $headerStyle)->addText('C3', $headerFontStyle, $paragraphStyle);
            $mainTable->addCell(600, $headerStyle)->addText('T', $headerFontStyle, $paragraphStyle);
            $mainTable->addCell(300, $headerStyle)->addText('C', $headerFontStyle, $paragraphStyle);

            // Variables para consolidados del período
            $periodCredits = 0;
            $periodWeightedGrades = 0;
            $periodApprovedCredits = 0;
            $rowIndex = 0;

            // Agregar filas de datos para este período
            foreach ($periodGrades as $grade) {
                $rowIndex++;
                $mainTable->addRow(238);

                // Estilo de celda con centrado vertical
                $cellStyle = [
                    'valign' => 'center',
                    'cellMargin' => 40
                ];

                // Alternar colores de filas
                if ($rowIndex % 2 == 0) {
                    $cellStyle['bgColor'] = 'F9F9F9';
                }

                // Agregar datos de la fila
                $mainTable->addCell(300, $cellStyle)->addText($rowIndex, $fontStyle, $paragraphStyle);
                $mainTable->addCell(1500, $cellStyle)->addText($grade['execution'], $fontStyle, $paragraphStyle);

                $paragraphStyleLeft = array_merge($paragraphStyle, ['alignment' => Jc::LEFT]);
                $mainTable->addCell(4673, $cellStyle)->addText($grade['modulo'], $fontStyle, $paragraphStyleLeft);
                $mainTable->addCell(900, $cellStyle)->addText($grade['nivel'], $fontStyle, $paragraphStyle);

                // Estado con color
                $estadoFontStyle = $fontStyle;
                if (strtolower($grade['estado']) == 'aprobado') {
                    $estadoFontStyle['color'] = '008000'; // Verde
                    $estadoFontStyle['bold'] = true;
                    $periodApprovedCredits += (float)$grade['creditos'];
                } elseif (strtolower($grade['estado']) == 'homologado') {
                    $estadoFontStyle['color'] = '008000'; // Verde
                    $estadoFontStyle['bold'] = true;
                    $periodApprovedCredits += (float)$grade['creditos'];
                } elseif (strtolower($grade['estado']) == 'reprobado') {
                    $estadoFontStyle['color'] = 'CC0000'; // Rojo
                    $estadoFontStyle['bold'] = true;
                } elseif (strtolower($grade['estado']) == 'en curso') {
                    $estadoFontStyle['color'] = 'FF8800'; // Naranja
                    $estadoFontStyle['bold'] = true;
                }
                $mainTable->addCell(1000, $cellStyle)->addText($grade['estado'], $estadoFontStyle, $paragraphStyle);

                // Calificaciones
                $mainTable->addCell(600, $cellStyle)->addText($grade['primera'], $fontStyle, $paragraphStyle);
                $mainTable->addCell(600, $cellStyle)->addText($grade['segunda'], $fontStyle, $paragraphStyle);
                $mainTable->addCell(600, $cellStyle)->addText($grade['tercera'], $fontStyle, $paragraphStyle);

                // Nota definitiva con negrita
                $definitovaFontStyle = array_merge($fontStyle, ['bold' => true]);
                $mainTable->addCell(600, $cellStyle)->addText($grade['definitiva'], $definitovaFontStyle, $paragraphStyle);

                // Créditos
                $mainTable->addCell(300, $cellStyle)->addText($grade['creditos'], $fontStyle, $paragraphStyle);

                // Acumular para consolidados del período
                $credits = (float)$grade['creditos'];
                $finalGrade = (float)$grade['definitiva'];
                $periodCredits += $credits;
                $periodWeightedGrades += ($finalGrade * $credits);
            }

            // Calcular promedio del período
            $periodAverage = $periodCredits > 0 ? round($periodWeightedGrades / $periodCredits, 2) : 0;

            // Fila de totales del período
            $totalCellStyle = [
                'valign' => 'center',
                'bgColor' => 'E6E6E6',
                'cellMargin' => 40
            ];

            $totalFontStyle = array_merge($fontStyle, ['bold' => true]);

            $mainTable->addRow(238);
            $mainTable->addCell(300, $totalCellStyle)->addText('', $totalFontStyle, $paragraphStyle);
            $mainTable->addCell(1500, $totalCellStyle)->addText('', $totalFontStyle, $paragraphStyle);
            $mainTable->addCell(4673, $totalCellStyle)->addText('TOTALES DEL PERÍODO', $totalFontStyle, $paragraphStyle);
            $mainTable->addCell(900, $totalCellStyle)->addText('', $totalFontStyle, $paragraphStyle);
            $mainTable->addCell(1000, $totalCellStyle)->addText('', $totalFontStyle, $paragraphStyle);
            $mainTable->addCell(600, $totalCellStyle)->addText('', $totalFontStyle, $paragraphStyle);
            $mainTable->addCell(600, $totalCellStyle)->addText('', $totalFontStyle, $paragraphStyle);
            $mainTable->addCell(600, $totalCellStyle)->addText('', $totalFontStyle, $paragraphStyle);
            $mainTable->addCell(600, $totalCellStyle)->addText($periodAverage, [
                'bold' => true,
                'size' => 7,
                'name' => 'Arial',
                'color' => $periodAverage >= 3.0 ? '008000' : 'CC0000'
            ], $paragraphStyle);
            $mainTable->addCell(300, $totalCellStyle)->addText($periodCredits, $totalFontStyle, $paragraphStyle);

            // Agregar separación entre períodos
            $mainTable->addRow(238);
            $mainTable->addCell(null, [
                'gridSpan' => 10,
                'valign' => 'center',
                'bgColor' => 'FFFFFF',
                'cellMargin' => 40,
            ])->addText('', ['size' => 1], $paragraphStyle);
        }

        // Agregar sección de resumen general
        $mainTable->addRow(238);
        $mainTable->addCell(null, [
            'gridSpan' => 10,
            'valign' => 'center',
            'bgColor' => '70AD47',
            'cellMargin' => 40,
        ])->addText('RESUMEN GENERAL DEL HISTORIAL ACADÉMICO', [
            'bold' => true,
            'size' => 9,
            'name' => 'Arial',
            'color' => 'FFFFFF'
        ], [
            'alignment' => Jc::CENTER,
            'spaceBefore' => 0,
            'spaceAfter' => 0
        ]);

        // Filas de resumen
        $mainTable->addRow(238);
        $mainTable->addCell(null, [
            'gridSpan' => 8,
            'valign' => 'center',
            'bgColor' => 'CCCCCC',
            'cellMargin' => 40,
        ])->addText('TOTAL CRÉDITOS CURSADOS', [
            'bold' => true,
            'size' => 8,
            'name' => 'Arial'
        ], ['alignment' => Jc::CENTER]);
        $mainTable->addCell(null, [
            'gridSpan' => 2,
            'valign' => 'center',
            'bgColor' => 'F0F0F0',
            'cellMargin' => 40,
        ])->addText($totalGeneralCredits, [
            'bold' => true,
            'size' => 8,
            'name' => 'Arial'
        ], ['alignment' => Jc::CENTER]);

        $mainTable->addRow(238);
        $mainTable->addCell(null, [
            'gridSpan' => 8,
            'valign' => 'center',
            'bgColor' => 'CCCCCC',
            'cellMargin' => 40,
        ])->addText('CRÉDITOS APROBADOS', [
            'bold' => true,
            'size' => 8,
            'name' => 'Arial'
        ], ['alignment' => Jc::CENTER]);
        $mainTable->addCell(null, [
            'gridSpan' => 2,
            'valign' => 'center',
            'bgColor' => 'F0F0F0',
            'cellMargin' => 40,
        ])->addText($totalCreditosAprobados, [
            'bold' => true,
            'size' => 8,
            'name' => 'Arial'
        ], ['alignment' => Jc::CENTER]);

        $mainTable->addRow(238);
        $mainTable->addCell(null, [
            'gridSpan' => 8,
            'valign' => 'center',
            'bgColor' => 'CCCCCC',
            'cellMargin' => 40,
        ])->addText('PROMEDIO GENERAL ACUMULADO', [
            'bold' => true,
            'size' => 8,
            'name' => 'Arial'
        ], ['alignment' => Jc::CENTER]);
        $mainTable->addCell(null, [
            'gridSpan' => 2,
            'valign' => 'center',
            'bgColor' => 'F0F0F0',
            'cellMargin' => 40,
        ])->addText($promedioGeneral, [
            'bold' => true,
            'size' => 8,
            'name' => 'Arial',
            'color' => $promedioGeneral >= 3.0 ? '008000' : 'CC0000'
        ], ['alignment' => Jc::CENTER]);

        // Enviar la tabla principal única al template
        $template->setComplexBlock('table', $mainTable);

    } else {
        // Método 3: Fallback - texto plano formateado con múltiples períodos
        $tablaTexto = "HISTORIAL ACADÉMICO COMPLETO\n\n";

        // Agrupar por período
        $currentPeriod = '';
        foreach ($allGradesData as $grade) {
            if ($grade['periodo'] !== $currentPeriod) {
                if ($currentPeriod !== '') {
                    $tablaTexto .= str_repeat("-", 120) . "\n";
                }
                $currentPeriod = $grade['periodo'];
                $tablaTexto .= "\nPERÍODO: " . $currentPeriod . "\n";
                $tablaTexto .= str_pad("CÓDIGO", 15) . str_pad("MÓDULO", 25) . str_pad("CICLO", 8) . str_pad("ESTADO", 12) . str_pad("C1", 6) . str_pad("C2", 6) . str_pad("C3", 6) . str_pad("FINAL", 8) . "CRÉD\n";
                $tablaTexto .= str_repeat("=", 100) . "\n";
            }

            $tablaTexto .= str_pad(substr($grade['execution'], 0, 13), 15) .
                str_pad(substr($grade['modulo'], 0, 23), 25) .
                str_pad($grade['nivel'], 8) .
                str_pad($grade['estado'], 12) .
                str_pad($grade['primera'], 6) .
                str_pad($grade['segunda'], 6) .
                str_pad($grade['tercera'], 6) .
                str_pad($grade['definitiva'], 8) .
                $grade['creditos'] . "\n";
        }

        // Totales generales
        $tablaTexto .= "\n" . str_repeat("=", 120) . "\n";
        $tablaTexto .= "TOTALES GENERALES\n";
        $tablaTexto .= "TOTAL CRÉDITOS: " . $totalGeneralCredits . "\n";
        $tablaTexto .= "CRÉDITOS APROBADOS: " . $totalCreditosAprobados . "\n";
        $tablaTexto .= "PROMEDIO GENERAL: " . $promedioGeneral;

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
