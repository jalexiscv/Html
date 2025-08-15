<?php
require_once(APPPATH . 'ThirdParty/FPDF/fpdf.php');
require_once(APPPATH . 'ThirdParty/FPDI/autoload.php');
require_once(APPPATH . 'ThirdParty/Bacon/autoload.php');

use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use setasign\Fpdi\Fpdi;

//[vars]----------------------------------------------------------------------------------------------------------------
/** @var object $parent */
/** @var string $component */
/** @var string $view */
/** @var object $authentication */
/** @var object $request */
$bootstrap = service("bootstrap");
$server = service("server");

$mjournalists = model('App\Modules\Journalists\Models\Journalists_Journalists');
$mattachments = model('App\Modules\Storage\Models\Storage_Attachments');

$page = $request->getVar("page");
$page = !empty($page) ? $page * 4 : 0;
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 4;
$format = !empty($request->getVar("format")) ? $request->getVar("format") : "2025b";

$journalists = $mjournalists
    ->orderBy("journalist", "ASC")
    ->limit(4, $page)
    ->find();

$code = "";
$pdf = new Fpdi('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->setSourceFile(PUBLICPATH . "pdfs/carnets-feria-{$format}.pdf");
$tplId = $pdf->importPage(1);
$pdf->useTemplate($tplId, 5, 5, 200, 277);

$p = [];

// Corrección en la obtención de las fotos
$attachment0 = $mattachments->get_AttachmentByObject(@$journalists[0]["journalist"]);
$photo0 = cdn_url(@$attachment0["file"]); // Era $attachments en lugar de $attachment0
$attachment1 = $mattachments->get_AttachmentByObject(@$journalists[1]["journalist"]);
$photo1 = cdn_url(@$attachment1["file"]); // Era $attachments en lugar de $attachment1
$attachment2 = $mattachments->get_AttachmentByObject(@$journalists[2]["journalist"]);
$photo2 = cdn_url(@$attachment2["file"]); // Era $attachments en lugar de $attachment2
$attachment3 = $mattachments->get_AttachmentByObject(@$journalists[3]["journalist"]);
$photo3 = cdn_url(@$attachment3["file"]); // Era $attachments en lugar de $attachment3

$p[0] = [
    "qr" => ["x" => 17, "y" => 20, "journalist" => @$journalists[0]["journalist"]],
    "np" => ["x" => 10, "y" => 109],
    "name" => ["firstname" => @$journalists[0]["firstname"], "lastname" => @$journalists[0]["lastname"]],
    "photo" => ["x" => 17, "y" => 54, "src" => @$photo0],
    "citizenshipcard" => ["x" => 54, "y" => 30, "src" => @$journalists[0]["citizenshipcard"]],
];
$p[1] = [
    "qr" => ["x" => 111, "y" => 20, "journalist" => @$journalists[1]["journalist"]],
    "np" => ["x" => 107, "y" => 109],
    "name" => ["firstname" => @$journalists[1]["firstname"], "lastname" => @$journalists[1]["lastname"]],
    "photo" => ["x" => 111, "y" => 54, "src" => @$photo1],
    "citizenshipcard" => ["x" => 150, "y" => 30, "src" => @$journalists[1]["citizenshipcard"]],
];

$p[2] = [
    "qr" => ["x" => 17, "y" => 154, "journalist" => @$journalists[2]["journalist"]],
    "np" => ["x" => 10, "y" => 240],
    "name" => ["firstname" => @$journalists[2]["firstname"], "lastname" => @$journalists[2]["lastname"]],
    "photo" => ["x" => 17, "y" => 188, "src" => @$photo2],
    "citizenshipcard" => ["x" => 54, "y" => 163, "src" => @$journalists[2]["citizenshipcard"]],
];
$p[3] = [
    "qr" => ["x" => 111, "y" => 154, "journalist" => @$journalists[3]["journalist"]],
    "np" => ["x" => 107, "y" => 240],
    "name" => ["firstname" => @$journalists[3]["firstname"], "lastname" => @$journalists[3]["lastname"]],
    "photo" => ["x" => 111, "y" => 188, "src" => @$photo3],
    "citizenshipcard" => ["x" => 150, "y" => 163, "src" => @$journalists[3]["citizenshipcard"]],
];

$p = array_slice($p, 0, $limit);


for ($i = 0; $i < count($p); $i++) {
    // CodigoQR
    $renderer = new ImageRenderer(new RendererStyle(400, 4), new ImagickImageBackEnd('png', 100));
    $writer = new Writer($renderer);
    $qrTempFile = WRITEPATH . 'temp/qr_' . time() . '_' . $i . '.png'; // Añadido $i para evitar colisiones
    if (!is_dir(dirname($qrTempFile))) {
        mkdir(dirname($qrTempFile), 0777, true);
    }

    // URL única para cada periodista usando su ID específico
    $qrUrl = 'https://intranet.feriadebuga.com/journalists/check/' . @$p[$i]["qr"]['journalist'];
    $writer->writeFile($qrUrl, $qrTempFile);

    $imagick = new Imagick($qrTempFile);
    $imagick->setImageFormat('png');
    $imagick->setImageCompression(Imagick::COMPRESSION_ZIP);
    $imagick->setImageCompressionQuality(100);
    $imagick->setImageDepth(8);
    $imagick->writeImage($qrTempFile);
    $imagick->clear();

    $pdf->Image($qrTempFile, $p[$i]["qr"]['x'], $p[$i]["qr"]['y'], 30);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetXY($p[$i]["qr"]['x'] - 7, $p[$i]["qr"]['y'] + 28);
    $pdf->Cell(45, 8, $p[$i]["qr"]['journalist'], 0, 1, 'C');
    unlink($qrTempFile);
}

for ($i = 0; $i < count($p); $i++) {
    $x = $p[$i]["np"]['x'];
    $y = $p[$i]["np"]['y'];
    $text1 = mb_convert_encoding(safe_strtoupper($p[$i]["name"]['firstname']), 'ISO-8859-1', 'UTF-8');
    $text2 = mb_convert_encoding(safe_strtoupper($p[$i]["name"]['lastname']), 'ISO-8859-1', 'UTF-8');
    $text3 = "CC " . $p[$i]["citizenshipcard"]['src'];
    $pdf->SetFont('Arial', 'B', 18);
    $pdf->SetXY($x, $y);
    $pdf->Cell(93, 8, $text1, 0, 1, 'C');
    $pdf->SetXY($x, $y + 6);
    $pdf->Cell(93, 8, $text2, 0, 1, 'C');
    $pdf->SetXY($p[$i]["citizenshipcard"]['x'], $p[$i]["citizenshipcard"]['y']);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(40, 4.5, $text3, 1, 1, 'C');
}

for ($i = 0; $i < count($p); $i++) {
    $x = $p[$i]["photo"]['x'];
    $y = $p[$i]["photo"]['y'];
    $src = $p[$i]["photo"]['src'];

    if ($src && filter_var($src, FILTER_VALIDATE_URL)) {
        try {
            $headers = get_headers($src);
            if ($headers && strpos($headers[0], '200') !== false) {
                $image_content = @file_get_contents($src);
                if ($image_content) {
                    // Detectar el tipo de imagen
                    $image_info = getimagesizefromstring($image_content);
                    $extension = image_type_to_extension($image_info[2], false);

                    // Crear archivo temporal con la extensión correcta
                    $photoTempFile = WRITEPATH . 'temp/photo_' . uniqid() . '_' . $i . '.' . $extension;

                    if (file_put_contents($photoTempFile, $image_content)) {
                        if (file_exists($photoTempFile)) {
                            // Si es PNG, convertir a JPG para mejor compatibilidad con FPDF
                            if ($extension === 'png') {
                                $png = imagecreatefrompng($photoTempFile);
                                $jpgTempFile = WRITEPATH . 'temp/photo_' . uniqid() . '_' . $i . '.jpg';

                                // Manejar transparencia
                                $width = imagesx($png);
                                $height = imagesy($png);
                                $white = imagecreatetruecolor($width, $height);
                                $bgColor = imagecolorallocate($white, 255, 255, 255);
                                imagefill($white, 0, 0, $bgColor);
                                imagealphablending($white, true);
                                imagecopy($white, $png, 0, 0, 0, 0, $width, $height);

                                imagejpeg($white, $jpgTempFile, 100);
                                imagedestroy($png);
                                imagedestroy($white);

                                @unlink($photoTempFile);
                                $photoTempFile = $jpgTempFile;
                            }

                            $pdf->Image($photoTempFile, $x, $y, 30);
                            @unlink($photoTempFile);
                        }
                    }
                }
            }
        } catch (Exception $e) {
            // Silenciosamente continúa si hay error
            continue;
        }
    }
}

$buffer = $pdf->Output('', 'S');
$pdf_base64 = base64_encode($buffer);
$code = '<iframe width="100%" height="1200" src="data:application/pdf;base64,' . $pdf_base64 . '"></iframe>';

//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("card-view-Journalists", array(
    "class" => "mb-3",
    "header-title" => "Impresion de Acreditaciones",
    "header-back" => "/",
    "content" => $code
));
echo($card);
?>