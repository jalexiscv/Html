<?php

require_once(APPPATH . 'ThirdParty/PHPOffice/autoload.php');

use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\JcTable;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\TemplateProcessor;

$request = service("request");
$enrollment = $request->getVar("enrollment");
$period = $request->getVar("period");

// Validar parámetros requeridos
if (empty($enrollment) || empty($period)) {
    die("Error: Faltan parámetros requeridos (enrollment y period)");
}

//[models]--------------------------------------------------------------------------------------------------------------
$menrollments = model('App\Modules\Sie\Models\Sie_Enrollments');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
$mprogress = model('App\Modules\Sie\Models\Sie_Progress');
$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
$mexecutions = model('App\Modules\Sie\Models\Sie_Executions');
/**
 * 1. Se recibe los datos correspondientes a la matrícula y periodo académico de intéres
 * 2. Se consulta el "enrollment" para a travez de sus datos localizar los datos de "registration" del estudiante.
 * 3. Se consulta el registro del estudiante para obtener el conjunto de datos necesarios para la visualización
 * 4. La consulta debera retornar las  "excecutions" por "period" que pertenezcan a cualquier "progress"
 *    del estudiante, en la matrícula "enrollment" consultada.
 */
$enrollment = $menrollments->get_Enrollment($enrollment);
$program = $mprograms->getProgram($enrollment["program"]);
$registration = $mregistrations->getRegistration($enrollment["registration"]);
$registration_registration = @$registration["registration"];
$enrollment_enrollment = @$enrollment["enrollment"];
$fullname = @$registration["first_name"] . " " . @$registration["second_name"] . " " . @$registration["first_surname"] . " " . @$registration["second_surname"];
$identification_number = @$registration["identification_number"];
$cycle = "";//El ciclo del estado "matrículado" más reciente en el programa académico especifico.
$period = $period;
$program_name = $program["name"];

$excecutions = $mexecutions->get_ExecutionsByPeriodByEnrollment($registration_registration, $period, $enrollment_enrollment);

/**
 * Los resultados estaran en forma de vector con las siguientes posiciones
 * $sie_progress = [
 * [
 * 'progress1' => '67801FC7E4D6B',
 * 'enrollment' => '67801FB7B8E39',
 * 'progress2' => '67801FC7E4D6B',
 * 'c31' => 94,
 * 'c21' => 89,
 * 'c11' => 91,
 * 'total1' => 91.33,
 * 'registration' => '6705258D8AF7F',
 * 'course1' => '679D4341CE172',
 * 'period_curso' => '2025A',
 * 'name' => 'Levantamiento de requerimiento de software',
 * 'execution' => '67B9FA0EA0AF8',
 * 'deleted_at' => null,
 * 'pensum' => '6716BFE8143EE',
 * 'level' => 'TP',
 * 'credits' => 2,
 * 'cycle' => '1',
 * 'moment' => '1',
 * 'module' => '6716BFD667C71',
 * 'version' => '6716BDFF2BA07',
 * ],
 * ];
 * **/

try {
    // TODO: Aquí harás las consultas a la base de datos usando $enrollment y $period
    // Por ahora uso datos de ejemplo

    // Consulta de datos del estudiante (reemplazar con consultas reales a la BD)
    $studentData = [
        'resgistration' => $registration_registration,
        'fullname' => $fullname, // Consultar de BD usando $enrollment
        'identification_number' => $identification_number, // Consultar de BD usando $enrollment
        'cycle' => $cycle, // Consultar de BD usando $enrollment
        'program' => safe_strtoupper($program_name), // Consultar de BD usando $enrollment
        'period' => $period,
    ];

    // Procesar los datos reales de ejecuciones para el certificado de notas
    $gradesData = [];

    if (!empty($excecutions) && is_array($excecutions)) {
        foreach ($excecutions as $execution) {
            // Determinar el estado basado en las calificaciones
            $c1 = (float)$execution['c11'];
            $c2 = (float)$execution['c21'];
            $c3 = (float)$execution['c31'];
            $total = (float)$execution['total1'];

            // Lógica de estado: Aprobado si todas las calificaciones >= 80
            $estado = ($c1 >= 80 && $c2 >= 80 && $c3 >= 80) ? 'Aprobado' : 'Reprobado';

            // Usar valores originales de las UC (0-100)
            $primera = $c1 > 0 ? number_format($c1, 1) : '0.0';
            $segunda = $c2 > 0 ? number_format($c2, 1) : '0.0';
            $tercera = $c3 > 0 ? number_format($c3, 1) : '0.0';
            $definitiva = $total > 0 ? number_format($total, 1) : '0.0';

            $gradesData[] = [
                'execution' => $execution['execution'], // Código de la ejecución
                'modulo' => $execution['name_module'], // Nombre del curso
                'nivel' => 'Ciclo ' . $execution['cycle'], // Ciclo real desde pensum
                'estado' => $estado,
                'primera' => $primera,
                'segunda' => $segunda,
                'tercera' => $tercera,
                'definitiva' => $definitiva,
                'creditos' => $execution['credits'] // Créditos reales desde pensum
            ];
        }
    }

    // Si no hay datos, usar mensaje informativo
    if (empty($gradesData)) {
        $gradesData = [
            ['execution' => '-', 'modulo' => 'No se encontraron registros académicos', 'nivel' => '-', 'estado' => '-', 'primera' => '0.0', 'segunda' => '0.0', 'tercera' => '0.0', 'definitiva' => '0.0', 'creditos' => '0']
        ];
    }

    // Ruta de la plantilla
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

    // Calcular totales antes de procesar la tabla
    $totalCreditos = 0;
    $totalCreditosAprobados = 0;
    $totalNotas = 0;

    foreach ($gradesData as $grade) {
        $creditos = (float)$grade['creditos'];
        $totalCreditos += $creditos;
        // Usar la nota definitiva en su escala original (0-100) para el promedio
        $totalNotas += (float)$grade['definitiva'] * $creditos;

        // Sumar créditos aprobados (estado = 'Aprobado')
        if (strtolower($grade['estado']) === 'aprobado') {
            $totalCreditosAprobados += $creditos;
        }
    }

    $promedioGeneral = $totalCreditos > 0 ? round($totalNotas / $totalCreditos, 2) : 0;

    // Intentar reemplazar la tabla usando diferentes métodos

    // Método 1: Usar cloneRowAndSetValues si existe una tabla template en el documento
    $variables = $template->getVariables();

    // Verificar si existen variables de tabla en el template (la forma correcta)
    if (in_array('execution', $variables) && in_array('modulo', $variables) && in_array('nivel', $variables)) {
        // La plantilla tiene una tabla con variables, usar cloneRowAndSetValues
        // Este es el método CORRECTO para tablas dinámicas con formato
        $template->cloneRowAndSetValues('execution', $gradesData);

        // Agregar totales si existen variables para ello
        if (in_array('total_creditos', $variables)) {
            $template->setValue('total_creditos', $totalCreditos);
        }
        if (in_array('total_creditos_aprobados', $variables)) {
            $template->setValue('total_creditos_aprobados', $totalCreditosAprobados);
        }
        if (in_array('promedio_general', $variables)) {
            $template->setValue('promedio_general', $promedioGeneral);
        }

    } elseif (in_array('table', $variables)) {
        // Método 2: Usar setComplexBlock para insertar una tabla completa programáticamente
        // Crear tabla usando PHPWord Element\Table

// ... código anterior hasta la creación de la tabla ...

// Crear tabla usando PHPWord Element\Table
        $table = new Table([
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 40,  // Reducir margen de celda aún más
        ]);

// Aplicar estilo a la tabla para ancho completo
        $tableStyle = $table->getStyle();
        $tableStyle->setWidth(100);
        $tableStyle->setUnit(TblWidth::PERCENT);
        $tableStyle->setAlignment(JcTable::CENTER);

// Estilo para encabezados con centrado vertical correcto
        $headerStyle = [
            'valign' => 'center',
            'bgColor' => 'CCCCCC',
            'cellMargin' => 40,  // Margen interno reducido
        ];

        $headerFontStyle = [
            'bold' => true,
            'size' => 10,
            'name' => 'Arial'
        ];

// Agregar fila de encabezados con altura REDUCIDA
        $table->addRow(280, ['tblHeader' => true]);  // Altura reducida de 360 a 280
        $table->addCell(null, $headerStyle)->addText('#', $headerFontStyle, [
            'alignment' => Jc::CENTER,
            'spaceBefore' => 0,
            'spaceAfter' => 0
        ]);
        $table->addCell(null, $headerStyle)->addText('CÓDIGO', $headerFontStyle, [
            'alignment' => Jc::CENTER,
            'spaceBefore' => 0,
            'spaceAfter' => 0
        ]);
        $table->addCell(null, $headerStyle)->addText('MÓDULO', $headerFontStyle, [
            'alignment' => Jc::CENTER,
            'spaceBefore' => 0,
            'spaceAfter' => 0
        ]);
        $table->addCell(null, $headerStyle)->addText('CICLO', $headerFontStyle, [
            'alignment' => Jc::CENTER,
            'spaceBefore' => 0,
            'spaceAfter' => 0
        ]);
        $table->addCell(null, $headerStyle)->addText('ESTADO', $headerFontStyle, [
            'alignment' => Jc::CENTER,
            'spaceBefore' => 0,
            'spaceAfter' => 0
        ]);
        $table->addCell(null, $headerStyle)->addText('UC1', $headerFontStyle, [
            'alignment' => Jc::CENTER,
            'spaceBefore' => 0,
            'spaceAfter' => 0
        ]);
        $table->addCell(null, $headerStyle)->addText('UC2', $headerFontStyle, [
            'alignment' => Jc::CENTER,
            'spaceBefore' => 0,
            'spaceAfter' => 0
        ]);
        $table->addCell(null, $headerStyle)->addText('UC3', $headerFontStyle, [
            'alignment' => Jc::CENTER,
            'spaceBefore' => 0,
            'spaceAfter' => 0
        ]);
        $table->addCell(null, $headerStyle)->addText('T', $headerFontStyle, [
            'alignment' => Jc::CENTER,
            'spaceBefore' => 0,
            'spaceAfter' => 0
        ]);
        $table->addCell(null, $headerStyle)->addText('C', $headerFontStyle, [
            'alignment' => Jc::CENTER,
            'spaceBefore' => 0,
            'spaceAfter' => 0
        ]);

// Agregar filas de datos con altura REDUCIDA y centrado vertical
        foreach ($gradesData as $index => $grade) {
            $table->addRow(240);  // Altura REDUCIDA de 320 a 240

            // Estilo de celda con centrado vertical y márgenes reducidos
            $cellStyle = [
                'valign' => 'center',  // Centrado vertical
                'cellMargin' => 40     // Margen interno reducido
            ];

            if ($index % 2 == 1) {
                $cellStyle['bgColor'] = 'F9F9F9';
            }

            $fontStyle = [
                'size' => 9,
                'name' => 'Arial'
            ];

            // Estilo de párrafo con espaciado reducido
            $paragraphStyle = [
                'alignment' => Jc::CENTER,
                'spaceBefore' => 0,
                'spaceAfter' => 0,
                'lineHeight' => 1.0  // Interlineado ajustado
            ];

            // Número de fila - centrado
            $table->addCell(null, $cellStyle)->addText(($index + 1), $fontStyle, $paragraphStyle);

            // Código de ejecución - centrado
            $table->addCell(null, $cellStyle)->addText($grade['execution'], $fontStyle, $paragraphStyle);

            // Módulo - alineado a la izquierda
            $paragraphStyleLeft = array_merge($paragraphStyle, ['alignment' => Jc::LEFT]);
            $table->addCell(null, $cellStyle)->addText($grade['modulo'], $fontStyle, $paragraphStyleLeft);

            // Nivel - centrado
            $table->addCell(null, $cellStyle)->addText($grade['nivel'], $fontStyle, $paragraphStyle);

            // Estado con color - centrado
            $estadoFontStyle = $fontStyle;
            if (strtolower($grade['estado']) == 'aprobado') {
                $estadoFontStyle['color'] = '008000'; // Verde
                $estadoFontStyle['bold'] = true;
            } elseif (strtolower($grade['estado']) == 'reprobado') {
                $estadoFontStyle['color'] = 'CC0000'; // Rojo
                $estadoFontStyle['bold'] = true;
            } else {
                $estadoFontStyle['color'] = 'FF8800'; // Naranja
                $estadoFontStyle['bold'] = true;
            }
            $table->addCell(null, $cellStyle)->addText($grade['estado'], $estadoFontStyle, $paragraphStyle);

            // Calificaciones - todas centradas
            $table->addCell(null, $cellStyle)->addText($grade['primera'], $fontStyle, $paragraphStyle);
            $table->addCell(null, $cellStyle)->addText($grade['segunda'], $fontStyle, $paragraphStyle);
            $table->addCell(null, $cellStyle)->addText($grade['tercera'], $fontStyle, $paragraphStyle);

            // Nota definitiva con negrita - centrado
            $definitovaFontStyle = array_merge($fontStyle, ['bold' => true]);
            $table->addCell(null, $cellStyle)->addText($grade['definitiva'], $definitovaFontStyle, $paragraphStyle);

            // Créditos - centrado
            $table->addCell(null, $cellStyle)->addText($grade['creditos'], $fontStyle, $paragraphStyle);
        }

// Fila de totales con altura REDUCIDA y centrado vertical
        $totalCellStyle = [
            'valign' => 'center',  // Centrado vertical
            'bgColor' => 'E6E6E6',
            'cellMargin' => 40     // Margen interno reducido
        ];

        $totalFontStyle = array_merge($fontStyle, ['bold' => true]);
        $totalParagraphStyle = [
            'alignment' => Jc::CENTER,
            'spaceBefore' => 0,
            'spaceAfter' => 0,
            'lineHeight' => 1.0
        ];

        // Fila de totales - una sola fila con todas las totalizaciones
        $table->addRow(260);  // Altura REDUCIDA de 380 a 260
        $table->addCell(null, $totalCellStyle)->addText('', $totalFontStyle, $totalParagraphStyle); // # (vacío)
        $table->addCell(null, $totalCellStyle)->addText('', $totalFontStyle, $totalParagraphStyle); // CÓDIGO (vacío)
        $table->addCell(null, $totalCellStyle)->addText('TOTALES', $totalFontStyle, $totalParagraphStyle); // MÓDULO (label)
        $table->addCell(null, $totalCellStyle)->addText('', $totalFontStyle, $totalParagraphStyle); // CICLO (vacío)
        $table->addCell(null, $totalCellStyle)->addText('', $totalFontStyle, $totalParagraphStyle); // ESTADO (vacío)
        $table->addCell(null, $totalCellStyle)->addText('', $totalFontStyle, $totalParagraphStyle); // UC1 (vacío)
        $table->addCell(null, $totalCellStyle)->addText('', $totalFontStyle, $totalParagraphStyle); // UC2 (vacío)
        $table->addCell(null, $totalCellStyle)->addText('', $totalFontStyle, $totalParagraphStyle); // UC3 (vacío)
        $table->addCell(null, $totalCellStyle)->addText($promedioGeneral, $totalFontStyle, $totalParagraphStyle); // T (promedio general)
        $table->addCell(null, $totalCellStyle)->addText($totalCreditos, $totalFontStyle, $totalParagraphStyle); // CRÉDITOS (total créditos)

        $template->setComplexBlock('table', $table);

// ... resto del código ...


    } else {
        // Método 3: Fallback - texto plano formateado
        $tablaTexto = "";

        // Encabezados
        $tablaTexto .= str_pad("#", 4) . str_pad("CÓDIGO", 15) . str_pad("MÓDULO", 25) . str_pad("NIVEL", 10) . str_pad("ESTADO", 12) . str_pad("1ª", 6) . str_pad("2ª", 6) . str_pad("3ª", 6) . str_pad("DEF", 6) . "CRÉD\n";
        $tablaTexto .= str_repeat("=", 120) . "\n";

        // Filas de datos
        foreach ($gradesData as $index => $grade) {
            $tablaTexto .= str_pad(($index + 1), 4) .
                str_pad(substr($grade['execution'], 0, 13), 15) .
                str_pad(substr($grade['modulo'], 0, 23), 25) .
                str_pad($grade['nivel'], 10) .
                str_pad($grade['estado'], 12) .
                str_pad($grade['primera'], 6) .
                str_pad($grade['segunda'], 6) .
                str_pad($grade['tercera'], 6) .
                str_pad($grade['definitiva'], 6) .
                $grade['creditos'] . "\n";
        }

        // Línea separadora
        $tablaTexto .= str_repeat("=", 100) . "\n";

        // Totales
        $tablaTexto .= str_pad("TOTALES", 85) .
            str_pad($promedioGeneral, 6) .
            $totalCreditos . "\n";

        // Créditos aprobados
        $tablaTexto .= str_pad("APROBADOS", 85) .
            str_pad("", 6) .
            $totalCreditosAprobados;

        $template->setValue('table', $tablaTexto);
    }

} catch (Exception $e) {
    // Método 4: Fallback simple en caso de error
    $tablaSimple = "REGISTRO ACADÉMICO\n\n";
    foreach ($gradesData as $grade) {
        $tablaSimple .= $grade['codigo'] . " - " . $grade['materia'] .
            " (" . $grade['creditos'] . " créditos) - " .
            $grade['nota'] . " - " . $grade['estado'] . "\n";
    }
    $tablaSimple .= "\nTOTAL CRÉDITOS: " . $totalCreditos . "\n";
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
$filename = "certificado_notas_{$enrollment_enrollment}_{$period}_{$timestamp}.docx";
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