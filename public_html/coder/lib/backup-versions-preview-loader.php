<?php
/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */

// Load common functions
include "headers.php";
include "settings.php";

$file = str_replace("|", "/", xssClean($_GET['file'], 'html'));

// Get contents
$loadedFile = toUTF8noBOM(getData("../data/backups/" . $file), true);
$encoding = ini_get("default_charset");
if ($encoding == "") {
    $encoding = "UTF-8";
}

// Set content in a textarea
echo '<textarea name="loadedFile" id="loadedFile">' . htmlentities($loadedFile, ENT_COMPAT, $encoding) . '</textarea>';

// Get bytes for this file
$bytes = filesize("../data/backups/" . $file);
// Change into kilobytes
$outputSize = ($bytes / 1024);
$outputUnit = "kb";
// Maybe we should show in megabytes?
if ($outputSize >= 1024) {
    $outputSize = ($outputSize / 1024);
    $outputUnit = "mb";
}
$size = number_format($outputSize, 2, '.', '') . $outputUnit . " (" . number_format($bytes) . " bytes)";

// Get date & time of file
$datetime = str_replace("-", "<br>", date("D jS M Y-g:i:sa", filemtime("../data/backups/" . $file)));
?>
<script>
    parent.document.getElementById('buttonsContainer').style.display = 'inline-block';
    parent.editor.setValue(document.getElementById('loadedFile').value);
    parent.document.getElementById('infoContainer').innerHTML = 'Date & Time:<br><?php echo $datetime;?><br><br>Size:<br><?php echo $size;?>';
</script>
