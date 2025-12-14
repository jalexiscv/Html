<?php
require_once(APPPATH . 'ThirdParty/FPDF/fpdf.php');
require_once(APPPATH . 'ThirdParty/FPDI/autoload.php');
require_once(APPPATH . 'ThirdParty/Barcode/autoload.php');
require_once(APPPATH . 'ThirdParty/GS1/autoload.php');
require_once(APPPATH . 'ThirdParty/Bacon/autoload.php');

use setasign\Fpdi\Fpdi;

/** @var string $oid * */
/** @var array $r * */
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');

//[models]--------------------------------------------------------------------------------------------------------------
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$morders = model("App\Modules\Sie\Models\Sie_Orders");
$mitems = model("App\Modules\Sie\Models\Sie_Orders_Items");
$mdiscounts = model("App\Modules\Sie\Models\Sie_Discounts");
$mdiscounteds = model("App\Modules\Sie\Models\Sie_Discounteds");
$msettings = model("App\Modules\Sie\Models\Sie_Settings");
$mformats = model("App\Modules\Sie\Models\Sie_Formats");
//[vars]-----------------------------------------------------------------------------------------------------------
$format = $mformats->getFormat($r["format"]);
$registration = $mregistrations->getRegistration($r["registration"]);
$instructions = json_decode($format["instructions"]);
//print_r($instructions);
$data = [];
foreach ($instructions as $instruction) {
    $key = strtolower($instruction->variable);
    $data[$key] = [
        'value' => $instruction->variable,
        'x' => $instruction->x,
        'y' => $instruction->y,
        'fontSize' => $instruction->fontSize,
        'fontType' => $instruction->fontType,
        'color' => $instruction->color
    ];
}
// Extraer con extract() para crear variables automáticamente
extract($data);
// Ahora tienes directamente:
//echo $fullname['x'];  // 777
//echo $idnumber['x'];  // 100
$fullname["value"] = @$registration["first_name"] . " " . @$registration["second_name"] . " " . @$registration["first_surname"] . " " . @$registration["second_surname"];
$idnumber['value'] = @$registration["identification_type"] . " " . @$registration["identification_number"];
//$identification_type=@$registration["first_name"];
//$identification_number=@$registration["identification_number"];
$fullname["value"]=safe_strtoupper($fullname["value"]);
//[pdf]-----------------------------------------------------------------------------------------------------------------
$pdf = new Fpdi();

// Obtener el contenido del PDF desde la URL
$pdfUrl = cdn_url($format["file"]);
$pdfContent = file_get_contents($pdfUrl);
// Crear un archivo temporal para guardar el PDF
$tmpFile = tempnam(sys_get_temp_dir(), 'FPDI');
file_put_contents($tmpFile, $pdfContent);
$pdf->setSourceFile($tmpFile);
$tplId = $pdf->importPage(1);
// Obtener el tamaño de la página de la plantilla
$templateSize = $pdf->getTemplateSize($tplId);
// Agregar una página con el mismo tamaño que la plantilla
$pdf->AddPage($templateSize['orientation'], [$templateSize['width'], $templateSize['height']]);
// Usar la plantilla, cubriendo toda la nueva página
$pdf->useTemplate($tplId, 0, 0, $templateSize['width'], $templateSize['height']);

// Dibujaremos el nombre en el certificado
$fontType = !empty($fullname['fontType']) ? $fullname['fontType'] : "Arial";
$fontSize = !empty($fullname['fontSize']) ? $fullname['fontSize'] : "14";
$pdf->SetFont($fontType, 'B', $fontSize);
$pdf->SetXY($fullname['x'], $fullname['y']);
$pdf->Cell(0, 1, mb_convert_encoding($fullname['value'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
// Dibujaremos el ID
$fontType = !empty($idnumber['fontType']) ? $idnumber['fontType'] : "Arial";
$fontSize = !empty($idnumber['fontSize']) ? $idnumber['fontSize'] : "14";
$pdf->SetFont($fontType, 'B', $fontSize);
$pdf->SetXY($idnumber['x'], $idnumber['y']);
$pdf->Cell(0, 1, $idnumber['value'], 0, 1, 'C');


//[build]---------------------------------------------------------------------------------------------------------------
$pdf->SetDrawColor(0, 0, 0); // Color del borde de la cuadrícula
$buffer = $pdf->Output('', 'S');

// Eliminar el archivo temporal
unlink($tmpFile);

$pdf_base64 = base64_encode($buffer);
$code = '<iframe width="100%" height="1200" src="data:application/pdf;base64,' . $pdf_base64 . '"></iframe>';
?>