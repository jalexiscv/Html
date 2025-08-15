<?php
require_once(APPPATH . 'ThirdParty/FPDF/fpdf.php');
require_once(APPPATH . 'ThirdParty/FPDI/autoload.php');
require_once(APPPATH . 'ThirdParty/Bacon/autoload.php');

//[services]------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$server = service("server");
$f = service("forms", array("lang" => "Journalists_Invitations."));
//[models]--------------------------------------------------------------------------------------------------------------
//[vars]----------------------------------------------------------------------------------------------------------------
$row = $model->getInvitation($oid);
$r["invitation"] = $row["invitation"];
$r["to"] = $row["to"];
$r["tel"] = $row["tel"];
$r["reference"] = $row["reference"];
$r["observation"] = $row["observation"];
$r["author"] = $row["author"];
$r["created_at"] = $row["created_at"];
$r["updated_at"] = $row["updated_at"];
$r["deleted_at"] = $row["deleted_at"];
$back = $f->get_Value("back", $server->get_Referer());


// --- Variables de entrada ---
$background_image_url = "https://intranet.feriadebuga.com/themes/assets/images/feriadebuga2025-invitacion.jpg";

// Modificamos el valor 'to' del array $r existente para ponerlo en mayúsculas.
// Esto asume que la variable $r con los datos del periodista ya existe.
if (isset($r) && is_array($r)) {
    $r['to'] = safe_strtoupper($r['to']);
    if (strlen($r['to']) > 25) {
        $r['to'] = $strings->get_Wrap($r['to'], 23);
    }
} else {
    // Si $r no existe, creamos datos de ejemplo para evitar errores.
    $r = [
        'to' => 'NOMBRE DE EJEMPLO',
        'tel' => '123-456-7890'
    ];
}

// --- Configuración ---
// Ruta a un archivo de fuente local del proyecto.
// Asegúrate de que 'arial.ttf' exista en la carpeta /public/assets/fonts/
$font_path = ROOTPATH . 'public_html/themes/assets/fonts/mono/SpaceMono-Bold.ttf';

// Comprobar si el archivo de fuente existe para evitar errores.
if (!file_exists($font_path)) {
    die('Error: No se pudo encontrar el archivo de fuente en ' . $font_path . '. Por favor, asegúrate de que el archivo .ttf exista en la carpeta public/assets/fonts/ de tu proyecto.');
}

$font_size_to = 50;
$font_size_tel = 34; // Ajustado a un tamaño visible, cámbialo si es necesario.
$text_color_hex = "#000000"; // Color negro

// --- Procesamiento de la imagen ---
// 1. Cargar la imagen desde la URL
// Usamos @file_get_contents para suprimir errores si la URL no está disponible
$image_data = @file_get_contents($background_image_url);
if ($image_data === false) {
    $img = "";
} else {
    // Crear recurso de imagen desde los datos
    $image = imagecreatefromstring($image_data);
    // 2. Definir el color del texto
    list($r_color, $g_color, $b_color) = sscanf($text_color_hex, "#%02x%02x%02x");
    $text_color = imagecolorallocate($image, $r_color, $g_color, $b_color);
    // 3. Obtener dimensiones de la imagen
    $image_width = imagesx($image);
    $image_height = imagesy($image);
    // 4. Calcular posición y escribir el primer texto ($r["to"])
    $text_box_to = imagettfbbox($font_size_to, 0, $font_path, $r["to"]);
    $text_width_to = $text_box_to[2] - $text_box_to[0];
    $x_to = (int)(($image_width - $text_width_to) / 2);
    $y_to = ($image_height - 435); // Centrado verticalmente
    imagettftext($image, $font_size_to, 0, $x_to, $y_to, $text_color, $font_path, $r["to"]);

    // 5. Calcular posición y escribir el segundo texto ($r["tel"])
    $padding_below_main_text = 60; // Espacio entre los dos textos
    $text_box_tel = imagettfbbox($font_size_tel, 0, $font_path, $r["tel"]);
    $text_width_tel = $text_box_tel[2] - $text_box_tel[0];
    $x_tel = (int)(($image_width - $text_width_tel) / 2);
    $y_tel = $y_to + $padding_below_main_text;
    imagettftext($image, $font_size_tel, 0, $x_tel, $y_tel, $text_color, $font_path, $r["tel"]);

    //[QR]--------------------------------------------------------------------------------------------------------------
    // 1. Generar el código QR y guardarlo en un archivo temporal
    $renderer = new BaconQrCode\Renderer\ImageRenderer(
        new BaconQrCode\Renderer\RendererStyle\RendererStyle(350), // Tamaño del QR en píxeles
        new BaconQrCode\Renderer\Image\ImagickImageBackEnd()
    );
    $writer = new BaconQrCode\Writer($renderer);
    $qrTempFile = WRITEPATH . 'temp/qr_' . $oid . '.png'; // Usamos el OID para un nombre único
    if (!is_dir(dirname($qrTempFile))) {
        mkdir(dirname($qrTempFile), 0777, true);
    }
    $qrUrl = 'https://intranet.feriadebuga.com/journalists/invitations/check/' . $oid;
    $writer->writeFile($qrUrl, $qrTempFile);
    // 2. Cargar la imagen del QR en una variable (recurso de imagen GD)
    $qr_image = imagecreatefrompng($qrTempFile);
    // 3. Obtener las dimensiones del QR
    $qr_width = imagesx($qr_image);
    $qr_height = imagesy($qr_image);
    // 4. Definir la posición del QR en la imagen principal (esquina inferior derecha con un margen)
    $margin = 0; // Margen desde los bordes
    $qr_x = ($image_width - $qr_width) / 2;
    $qr_y = (($image_height - $qr_height) / 2) + 440;
    // 5. Copiar la imagen del QR sobre la imagen principal
    imagecopy($image, $qr_image, $qr_x, $qr_y, 0, 0, $qr_width, $qr_height);
    // 6. Limpiar: eliminar el archivo temporal y la imagen del QR de la memoria
    unlink($qrTempFile);
    imagedestroy($qr_image);
    //[/QR]-------------------------------------------------------------------------------------------------------------

    // 6. Capturar la salida de la imagen en una variable en lugar de mostrarla directamente
    ob_start();
    imagejpeg($image);
    $image_data_final = ob_get_contents();
    ob_end_clean();
    // 7. Convertir los datos de la imagen a Base64
    $image_base64 = base64_encode($image_data_final);
    // 8. Liberar memoria
    imagedestroy($image);
    // 9. Mostrar la imagen embebida en el HTML
    $img = '<img src="data:image/jpeg;base64,' . $image_base64 . '" alt="Invitación generada" style="width:350px; height: auto;" />';
}

//[Fields]-----------------------------------------------------------------------------
$f->fields["invitation"] = $f->get_FieldView("invitation", array("value" => $r["invitation"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["to"] = $f->get_FieldView("to", array("value" => $r["to"], "proportion" => "col-md-8 col-sm-12 col-12"));
$f->fields["tel"] = $f->get_FieldView("tel", array("value" => $r["tel"], "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["reference"] = $f->get_FieldView("reference", array("value" => $r["reference"], "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["observation"] = $f->get_FieldView("observation", array("value" => $r["observation"], "proportion" => "col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldView("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldView("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldView("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["edit"] = $f->get_Button("edit", array("href" => "/journalists/invitations/edit/" . $oid, "text" => lang("App.Edit"), "class" => "btn btn-secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
//[Groups]-----------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["invitation"] . $f->fields["to"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["tel"] . $f->fields["reference"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["observation"])));
//[Buttons]-----------------------------------------------------------------------------
//[build]---------------------------------------------------------------------------------------------------------------

$code = "<table class=\"w-100\">";
$code .= "<tr>";
$code .= "<td>";
$code .= $f;
$code .= "</td>";
$code .= "</tr>";
$code .= "</table>";


$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang("Journalists_Invitations.view-title"),
    "header-back" => $back,
    "content" => $code,
));
echo($card);


?>
