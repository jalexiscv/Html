<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-05-01 08:14:05
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Registrations\List\table.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @var object $parent Trasferido desde el controlador
 * █ @var object $authentication Trasferido desde el controlador
 * █ @var object $request Trasferido desde el controlador
 * █ @var object $dates Trasferido desde el controlador
 * █ @var string $component Trasferido desde el controlador
 * █ @var string $view Trasferido desde el controlador
 * █ @var string $oid Trasferido desde el controlador
 * █ @var string $views Trasferido desde el controlador
 * █ @var string $prefix Trasferido desde el controlador
 * █ @var array $data Trasferido desde el controlador
 * █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/

//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/sie/tools/home/" . lpk();
//[models]--------------------------------------------------------------------------------------------------------------
$mq10files = model("App\Modules\Sie\Models\Sie_Q10files");
$mattachments = model('App\Modules\Storage\Models\Storage_Attachments', true);
//[request]-------------------------------------------------------------------------------------------------------------
$content = "";
//[build]---------------------------------------------------------------------------------------------------------------

$files = $mq10files->get_FilesAndAttachments(100000, 0);

$content = "<div class='table-responsive'>";
$content .= "<table class='table table-striped table-hover'>";
$content .= "<thead>";
$content .= "<tr>";
$content .= "<th>#</th>";
$content .= "<th>Archivo</th>";
$content .= "<th>Adjunto</th>";
$content .= "<th>Tamaño</th>";
$content .= "</tr>";
$content .= "</thead>";
$content .= "<tbody>";
$count = 0;
foreach ($files as $file) {
    $count++;
    $size = @$file['size'];
    $attachment = "";
    if (!empty($file['attachment'])) {
        $url = cdn_url($file["uri"]);
        $attachment = "<a href=\"{$url}\"target=\"_blank\">{$file['attachment']}</a>";
    }
    $content .= "<tr>";
    $content .= "<td>{$count}</td>";
    $content .= "<td>{$file['file']}</td>";
    $content .= "<td>{$attachment}</td>";
    $content .= "<td>{$size}</td>";
    $content .= "</tr>";
    if ($size == "54201") {
        $mq10files->delete($file['file']);
        $mattachments->delete($file['attachment']);
    }
}
$content .= "</tbody>";
$content .= "</table>";
$content .= "</div>";


$card = $bootstrap->get_Card("card-view-service", array(
    "title" => "Q10/Limpieza de archivos",
    "header-back" => $back,
    "header-add" => "/sie/q10files/list/" . lpk(),
    "content" => $content,
));
echo($card);
?>