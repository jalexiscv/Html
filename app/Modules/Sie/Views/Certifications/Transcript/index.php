<?php

require_once(APPPATH . 'ThirdParty/PHPOffice/autoload.php');

use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\SimpleType\Jc;
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
/**
 * 1. Se recibe los datos correspondientes a la matrícula y periodo académico de intéres
 * 2. Se consulta la matrícula para a travez de sus datos localizar los datos de registro del estudiante.
 * 3. Se consulta el registro del estudiante para obtener el conjunto de datos necesarios para la visualización
 */
$enrollment = $menrollments->get_Enrollment($enrollment);
$program = $mprograms->getProgram($enrollment["program"]);
$registration = $mregistrations->get_Registration($enrollment["student"]);
$registration_registration = @$registration["registration"];
$enrollment_enrollment = @$enrollment["enrollment"];
$fullname = @$registration["first_name"] . " " . @$registration["second_name"] . " " . @$registration["first_surname"] . " " . @$registration["second_surname"];
$identification_number = @$registration["identification_number"];
$cycle = "";//El ciclo del estado "matrículado" más reciente en el programa académico especifico.
$period = $period;
$program_name = $program["name"];


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

    // Consulta de materias y notas (reemplazar con consulta real a la BD)
    $gradesData = [
        ['codigo' => 'MAT101', 'materia' => 'Matemáticas I', 'creditos' => '3', 'nota' => '4.2', 'estado' => 'Aprobado'],
        ['codigo' => 'FIS101', 'materia' => 'Física I', 'creditos' => '4', 'nota' => '3.8', 'estado' => 'Aprobado'],
        ['codigo' => 'QUI101', 'materia' => 'Química General', 'creditos' => '3', 'nota' => '4.5', 'estado' => 'Aprobado'],
        ['codigo' => 'ING101', 'materia' => 'Inglés I', 'creditos' => '2', 'nota' => '4.0', 'estado' => 'Aprobado'],
        ['codigo' => 'PRG101', 'materia' => 'Programación I', 'creditos' => '4', 'nota' => '4.8', 'estado' => 'Aprobado'],
    ];

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
    $totalNotas = 0;

    foreach ($gradesData as $grade) {
        $totalCreditos += (float)$grade['creditos'];
        $totalNotas += (float)$grade['nota'] * (float)$grade['creditos'];
    }

    $promedioGeneral = $totalCreditos > 0 ? round($totalNotas / $totalCreditos, 2) : 0;

    // Intentar reemplazar la tabla usando diferentes métodos

    // Método 1: Usar cloneRowAndSetValues si existe una tabla template en el documento
    $variables = $template->getVariables();

    // Verificar si existen variables de tabla en el template (la forma correcta)
    if (in_array('codigo', $variables) && in_array('materia', $variables)) {
        // La plantilla tiene una tabla con variables, usar cloneRowAndSetValues
        // Este es el método CORRECTO para tablas dinámicas con formato
        $template->cloneRowAndSetValues('codigo', $gradesData);

        // Agregar totales si existen variables para ello
        if (in_array('total_creditos', $variables)) {
            $template->setValue('total_creditos', $totalCreditos);
        }
        if (in_array('promedio_general', $variables)) {
            $template->setValue('promedio_general', $promedioGeneral);
        }

    } elseif (in_array('table', $variables)) {
        // Método 2: Usar setComplexBlock para insertar una tabla completa programáticamente
        // Crear tabla usando PHPWord Element\Table
        $table = new Table([
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 0,
            'width' => 100,
            'unit' => TblWidth::PERCENT
        ]);

        // Estilo para encabezados
        $headerStyle = [
            'bgColor' => 'CCCCCC',
            'valign' => 'center'
        ];

        $headerFontStyle = [
            'bold' => true,
            'size' => 10,
            'name' => 'Arial'
        ];

        // Agregar fila de encabezados
        $table->addRow(500);
        $table->addCell(1500, $headerStyle)->addText('CÓDIGO', $headerFontStyle, ['alignment' => Jc::CENTER]);
        $table->addCell(4000, $headerStyle)->addText('MATERIA', $headerFontStyle, ['alignment' => Jc::CENTER]);
        $table->addCell(1200, $headerStyle)->addText('CRÉDITOS', $headerFontStyle, ['alignment' => Jc::CENTER]);
        $table->addCell(1200, $headerStyle)->addText('NOTA', $headerFontStyle, ['alignment' => Jc::CENTER]);
        $table->addCell(1500, $headerStyle)->addText('ESTADO', $headerFontStyle, ['alignment' => Jc::CENTER]);

        // Agregar filas de datos
        foreach ($gradesData as $index => $grade) {
            $table->addRow(400);

            // Alternar color de fondo
            $cellStyle = ['valign' => 'center'];
            if ($index % 2 == 1) {
                $cellStyle['bgColor'] = 'F9F9F9';
            }

            $fontStyle = ['size' => 9, 'name' => 'Arial'];

            // Código
            $table->addCell(1500, $cellStyle)->addText($grade['codigo'], array_merge($fontStyle, ['bold' => true]), ['alignment' => Jc::CENTER]);

            // Materia
            $table->addCell(4000, $cellStyle)->addText($grade['materia'], $fontStyle, ['alignment' => Jc::LEFT]);

            // Créditos
            $table->addCell(1200, $cellStyle)->addText($grade['creditos'], $fontStyle, ['alignment' => Jc::CENTER]);

            // Nota
            $table->addCell(1200, $cellStyle)->addText($grade['nota'], array_merge($fontStyle, ['bold' => true]), ['alignment' => Jc::CENTER]);

            // Estado con color
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

            $table->addCell(1500, $cellStyle)->addText($grade['estado'], $estadoFontStyle, ['alignment' => Jc::CENTER]);
        }

        // Fila de totales
        $totalCellStyle = array_merge(['valign' => 'center'], ['bgColor' => 'E6E6E6']);
        $totalFontStyle = array_merge($fontStyle, ['bold' => true]);

        $table->addRow(500);
        $table->addCell(5500, $totalCellStyle)->addText('TOTALES', $totalFontStyle, ['alignment' => Jc::CENTER]);
        $table->addCell(1200, $totalCellStyle)->addText($totalCreditos, $totalFontStyle, ['alignment' => Jc::CENTER]);
        $table->addCell(1200, $totalCellStyle)->addText($promedioGeneral, $totalFontStyle, ['alignment' => Jc::CENTER]);
        $table->addCell(1500, $totalCellStyle)->addText('PROMEDIO', $totalFontStyle, ['alignment' => Jc::CENTER]);

        // Insertar la tabla completa en el template
        $template->setComplexBlock('table', $table);

    } else {
        // Método 3: Fallback - texto plano formateado
        $tablaTexto = "";

        // Encabezados
        $tablaTexto .= str_pad("CÓDIGO", 12) . str_pad("MATERIA", 35) . str_pad("CRÉDITOS", 12) . str_pad("NOTA", 8) . "ESTADO\n";
        $tablaTexto .= str_repeat("=", 80) . "\n";

        // Filas de datos
        foreach ($gradesData as $grade) {
            $tablaTexto .= str_pad($grade['codigo'], 12) .
                str_pad(substr($grade['materia'], 0, 33), 35) .
                str_pad($grade['creditos'], 12) .
                str_pad($grade['nota'], 8) .
                $grade['estado'] . "\n";
        }

        // Línea separadora
        $tablaTexto .= str_repeat("=", 80) . "\n";

        // Totales
        $tablaTexto .= str_pad("TOTALES", 47) .
            str_pad($totalCreditos, 12) .
            str_pad($promedioGeneral, 8) .
            "PROMEDIO";

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