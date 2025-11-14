<?php
// Activar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(APPPATH . 'ThirdParty/Bacon/autoload.php');

use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

$strings = service("strings");
$server = service('server');

$mregistrations = model('App\Modules\Sgd\Models\Sgd_Registrations');
$musers = model("App\Modules\Sgd\Models\Sgd_Users");
$mfields = model("App\Modules\Sgd\Models\Sgd_Users_Fields");

$reference = isset($_GET['oid']) ? $_GET['oid'] : '0000000000';

$registration = $mregistrations->getRegistration($reference);

$profile_from = @$registration["from_name"];
if (!empty($registration["from_user"])) {
    $from_profile = $musers->getProfile($registration["from_user"]);
    $fullname = @$from_profile["firstname"] . " " . @$from_profile["lastname"];
    $profile_from = safe_strtoupper($fullname);
}

$profile_to = @$registration["to_name"];
if (!empty($registration["to_user"])) {
    $to_profile = $musers->getProfile($registration["to_user"]);
    $fullname = @$to_profile["firstname"] . " " . @$to_profile["lastname"];
    $profile_to = safe_strtoupper($fullname);
}


$date = @$registration["date"];
$time = @$registration["time"];
$ref_detalle = @$registration["reference"];
$tipo_tramite = 'OTROS';
$folios = @$registration["folios"];


// Parámetros de la imagen
$width = 390;
$height = 390;

// Obtener parámetros de la URL o usar valores por defecto
$entidad = isset($_GET['entidad']) ? $_GET['entidad'] : 'BENEFICENCIA DEL VALLE DEL CAUCA';
$entidad2 = isset($_GET['entidad']) ? $_GET['entidad'] : '';
$referencia = isset($_GET['referencia']) ? $_GET['referencia'] : $reference;
$fecha = $date;
$hora = $time;

$server = $server->getURL();
$qrradication = ($server . "/sgd/external/view/{$reference}");
// Generar código QR
$renderer = new ImageRenderer(new RendererStyle(128), new ImagickImageBackEnd());
$writer = new Writer($renderer);
$qrCode = $writer->writeString($qrradication);
// Guardar el QR temporalmente y convertirlo a formato compatible
$qrFile = tempnam(sys_get_temp_dir(), 'qr_') . '.png';
file_put_contents($qrFile, $qrCode);
// Convertir a 8-bit usando Imagick
$imagick = new \Imagick($qrFile);
$imagick->setImageFormat('png');
$imagick->setImageDepth(8); // Convertir a 8-bit
$imagick->setImageType(\Imagick::IMGTYPE_GRAYSCALE);
$imagick->writeImage($qrFile);
$imagick->clear();

// Crear una imagen en blanco
$image = imagecreatetruecolor($width, $height);
// Colores
$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);
$blue = imagecolorallocate($image, 0, 0, 128);
// Rellenar el fondo con blanco
imagefill($image, 0, 0, $white);
// Dibujar un borde negro
imagerectangle($image, 0, 0, $width - 1, $height - 1, $black);
// Incluir el código QR existente
if (file_exists($qrFile)) {
    $qr = imagecreatefrompng($qrFile); // Cargar el QR como imagen
    $qr_width = imagesx($qr);
    $qr_height = imagesy($qr);
    // Copiar el QR a la esquina superior izquierda
    imagecopy($image, $qr, 3, 3, 0, 0, $qr_width, $qr_height);
    imagedestroy($qr);
} else {
    // Si no hay QR, dibujar un rectángulo para representarlo
    imagerectangle($image, 20, 20, 120, 120, $black);
    imagestring($image, 3, 30, 60, 'QR Code', $black);
}


// Fuentes
$boldFont = PUBLICPATH . 'themes/assets/fonts/mono/SpaceMono-Bold.ttf'; // Fuente negrita
// Configurar la fuente
$fsTitle = 14; // Tamaño de fuente para el título
$fsTitleX2 = 20; // Tamaño de fuente para el título
$font = 5; // Tamaño de fuente grande (tallas disponibles: 1-5)
$fontTitle = 4; // Tamaño de fuente para el título
$smallFont = 2;
// Entidad (título)
$wrapstring = $strings->getWraps($entidad, 20);
if (count($wrapstring) > 1) {
    $part1 = $wrapstring[0];
    $part2 = $wrapstring[1];
    $y = 35;
    imagettftext($image, $fsTitle, 0, 130, $y, $black, $boldFont, $part1);
    imagettftext($image, $fsTitle, 0, 130, $y + ($fsTitle * 1) + 3, $black, $boldFont, $part2);
    imagettftext($image, $fsTitleX2, 0, 130, $y + ($fsTitle * 3) + 1, $black, $boldFont, $reference);
    // Fecha y hora
    $y = 100;
    imagettftext($image, $fsTitle, 0, 130, $y, $black, $boldFont, "Fecha: {$fecha}");
    imagettftext($image, $fsTitle, 0, 130, $y + ($fsTitle * 1) + 3, $black, $boldFont, "Hora: {$hora}");
} else {
    $part1 = $wrapstring[0];
    $y = 30;
    imagettftext($image, $fsTitle, 0, 130, $y, $black, $boldFont, $part1);
    // Fecha y hora
    imagestring($image, $smallFont, 120, 60, 'Fecha: ' . $fecha, $black);
    imagestring($image, $smallFont, 120, 75, 'Hora: ' . $hora, $black);
}
// Línea de separación
imageline($image, 10, 135, $width - 10, 135, $black);
// Referencia
imagettftext($image, 12, 0, 10, 160, $black, $boldFont, 'REFERENCIA:');
$wrapreferencia = $strings->getWraps($ref_detalle, 37);
if (count($wrapreferencia) > 1) {
    $y = 180;
    for ($i = 0; $i < min(count($wrapreferencia), 6); $i++) {
        if (!empty($wrapreferencia[$i])) {
            imagettftext($image, 12, 0, 10, $y + ($fsTitle * $i) + 1, $black, $boldFont, $wrapreferencia[$i]);
        }
    }
    imageline($image, 10, 275, $width - 10, 275, $black);
} else {
    $part1 = !empty($wrapreferencia[0]) ? $wrapreferencia[0] : " ";
    $y = 180;
    imagettftext($image, 12, 0, 10, $y, $black, $boldFont, $part1);
}

// Otra línea de separación


// Tipo de trámite y folios
$y = 300;
imagettftext($image, 12, 0, 20, $y, $black, $boldFont, "Folios");
imagettftext($image, 12, 0, 20, $y + 13, $black, $boldFont, safe_strtoupper($folios));

$y = 300;
imagettftext($image, 12, 0, 100, $y, $black, $boldFont, "Tipo de trámite");
imagettftext($image, 12, 0, 100, $y + 13, $black, $boldFont, safe_strtoupper($tipo_tramite));

// Remitente
$y = 330;
imagettftext($image, 12, 0, 20, $y, $black, $boldFont, "Remitente");
imagettftext($image, 12, 0, 20, $y + 13, $black, $boldFont, safe_strtoupper($profile_from));

// Destinatario
$y = 360;
imagettftext($image, 12, 0, 20, $y, $black, $boldFont, "Destinatario");
imagettftext($image, 12, 0, 20, $y + 13, $black, $boldFont, safe_strtoupper($profile_to));

// Enviar la imagen

imagepng($image);

// Liberar memoria
imagedestroy($image);


function drawBoldText($image, $size, $x, $y, $text, $color)
{
    // Dibujar el texto varias veces con un ligero desplazamiento para crear efecto de negrita
    imagestring($image, $size, $x, $y, $text, $color);
    imagestring($image, $size, $x + 1, $y, $text, $color);
    imagestring($image, $size, $x, $y + 1, $text, $color);
}

function safe_strtoupper($string)
{
    $s = service('strings');
    return ($s->get_Strtoupper($string));
}


?>