<?php

require_once(APPPATH . 'ThirdParty/PHPOffice/autoload.php');

use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\JcTable;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\TemplateProcessor;

//[models]--------------------------------------------------------------------------------------------------------------
$menrollments = model('App\Modules\Sie\Models\Sie_Enrollments');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
$mprogress = model('App\Modules\Sie\Models\Sie_Progress');
$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
$mexecutions = model('App\Modules\Sie\Models\Sie_Executions');
$mobservations = model('App\Modules\Sie\Models\Sie_Observations');
$mfields = model("\App\Modules\Security\Models\Security_Users_Fields");
//[vars]----------------------------------------------------------------------------------------------------------------
$request = service("request");

$registration = $mregistrations->getRegistration($oid);
$registration_registration = @$registration["registration"];
$fullname = @$registration["first_name"] . " " . @$registration["second_name"] . " " . @$registration["first_surname"] . " " . @$registration["second_surname"];
$identification_number = @$registration["identification_number"];
$program = $mprograms->getProgram($registration["program"]);
$program_name = @$program["name"];

$studentData = [
    'registration' => $registration_registration,
    'fullname' => $fullname,
    'identification_number' => $identification_number,
    'cycle' => '', // Se puede obtener del período más reciente
    'program' => safe_strtoupper($program_name),
    'period' => 'HISTORIAL COMPLETO',
];

// Validar parámetros requeridos
if (is_array($registration) && empty($registration["registration"])) {
    die("Error: Faltan parámetros requeridos (Registration)");
}

$templatePath = PUBLICPATH . 'formats/observaciones-academicas-individuales-v1.docx';

// Verificar que la plantilla existe
if (!file_exists($templatePath)) {
    throw new Exception("La plantilla no existe en: " . $templatePath);
}

// Cargar la plantilla
$template = new TemplateProcessor($templatePath);

// Reemplazar los parámetros básicos
$template->setValue('header', time());
$template->setValue('registration', $registration_registration);
$template->setValue('fullname', @$studentData['fullname']);
$template->setValue('identification_number', @$studentData['identification_number']);
$template->setValue('cycle', @$studentData['cycle']);
$template->setValue('program', @$studentData['program']);
$template->setValue('period', @$studentData['period']);
$template->setValue('footer', time());
$variables = $template->getVariables();

$enrollments = $menrollments->where("registration", $registration["registration"])->findAll();

// Crear tabla usando PHPWord Element\Table
// Ancho de tabla al 100% de la página. 'width' se especifica en 50ths de un porciento.
$table = new Table([
    'borderSize' => 6,
    'borderColor' => '000000',
    'cellMargin' => 40,
    'width' => 100 * 50,
    'unit' => TblWidth::PERCENT
]);

//[styles]--------------------------------------------------------------------------------------------------------------
$tableStyle = $table->getStyle();
$tableStyle->setAlignment(JcTable::CENTER);

$headerStyle = [
    'valign' => 'center',
    'bgColor' => 'CCCCCC',
    'cellMargin' => 40
];

$headerFontStyle = [
    'bold' => true,
    'size' => 10,
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

//[build]---------------------------------------------------------------------------------------------------------------
$table->addRow(280, ['tblHeader' => true]);

// Columna #: ancho fijo pequeño (800 twips ≈ 1.4 cm)
$table->addCell(1100, $headerStyle)
    ->addText('#', $headerFontStyle, [
        'alignment' => Jc::CENTER,
        'spaceBefore' => 20,
        'spaceAfter' => 20
    ]);

// Columna OBSERVACIÓN: ancho fijo medio (2500 twips ≈ 4.4 cm)
$table->addCell(4500, $headerStyle)
    ->addText('OBSERVACIÓN', $headerFontStyle, [
        'alignment' => Jc::CENTER,
        'spaceBefore' => 0,
        'spaceAfter' => 0
    ]);

// Columna TIPO: ancho fijo pequeño (1500 twips ≈ 2.6 cm)
$table->addCell(4500, $headerStyle)
    ->addText('TIPO', $headerFontStyle, [
        'alignment' => Jc::CENTER,
        'spaceBefore' => 0,
        'spaceAfter' => 0
    ]);

// Columna CONTENIDO: el resto del espacio disponible (null = auto)
$table->addCell(null, $headerStyle)
    ->addText('CONTENIDO', $headerFontStyle, [
        'alignment' => Jc::CENTER,
        'spaceBefore' => 0,
        'spaceAfter' => 0
    ]);

$rowIndex = 0;
$observations = $mobservations->get_Observations(1000, 0, array("object" => $oid));

foreach ($observations as $key => $observation) {
    $rowIndex++;
    $table->addRow(280);

    $cellStyle = [
        'valign' => 'center',
        'cellMargin' => 40
    ];

    if ($rowIndex % 2 == 0) {
        $cellStyle['bgColor'] = 'F9F9F9';
    }

    $types = LIST_TYPES_OBSERVATIONS;
    $type = $observation["type"];

    foreach ($types as $t) {
        if ($t['value'] == $type) {
            $type = $t['label'];
            break;
        }
    }

    $details = @$observation['content'];
    $author = @$observation['author'];
    $profile = $mfields->get_Profile($author);
    $author_fullname = $profile["name"];
    $datetime = @$observation['date'] . " - " . @$observation['time'];
    // Columna #
    $table->addCell(800, $cellStyle)
        ->addText($rowIndex, $fontStyle, $paragraphStyle);

    // Columna OBSERVACIÓN
    $table->addCell(2500, $cellStyle)
        ->addText($observation['observation'], $fontStyle, $paragraphStyle);

    // Columna TIPO
    $table->addCell(1500, $cellStyle)
        ->addText($type, $fontStyle, $paragraphStyle);

    // Columna CONTENIDO con formato complejo
    $cellContent = $table->addCell(null, $cellStyle);
    $textRun = $cellContent->addTextRun(['alignment' => Jc::START, 'spaceBefore' => 0, 'spaceAfter' => 0]);
    // Agregar el contenido normal
    $textRun->addText($details, $fontStyle);
    // Agregar salto de línea
    $textRun->addTextBreak();
    // Agregar "Responsable:" en negrilla
    $textRun->addText('Responsable: ', array_merge($fontStyle, ['bold' => true]));
    // Agregar el nombre del autor normal
    $textRun->addText($author_fullname . " - " . $author, $fontStyle);
    // Agregar salto de línea
    $textRun->addTextBreak();
    // Agregar "Fecha:" en negrilla
    $textRun->addText('Fecha: ', array_merge($fontStyle, ['bold' => true]));
    // Agregar el nombre del autor normal
    $textRun->addText($datetime, $fontStyle);
}

// Insertar la tabla en el template
$template->setComplexBlock('table', $table);

// Crear directorio temporal si no existe
$tmpDir = PUBLICPATH . "tmp";
if (!is_dir($tmpDir)) {
    mkdir($tmpDir, 0755, true);
}

// Generar nombre de archivo
$timestamp = date('Y-m-d_H-i-s');
$filename = "certificado_observaciones_{$registration_registration}_{$timestamp}.docx";
$outputPath = $tmpDir . "/" . $filename;

// Guardar el documento
$template->saveAs($outputPath);

// Verificar que el archivo se generó
if (!file_exists($outputPath)) {
    throw new Exception("Error: No se pudo generar el archivo");
}

// Enviar headers para descarga
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($outputPath));

ob_clean();
flush();
readfile($outputPath);

// Opcional: eliminar el archivo temporal después de enviarlo
// unlink($outputPath);
?>