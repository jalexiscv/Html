<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                                                    2024-04-01 21:48:51
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sint\Home\breadcrumb.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2024 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                                                                         consulte la LICENCIA archivo que se distribuyó con este código fuente.
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
 * █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[vars]----------------------------------------------------------------------------------------------------------------
/** @var object $parent */
/** @var string $component */
/** @var string $view */
/** @var object $authentication */
/** @var object $request */

$bootstrap = service("bootstrap");
$strings = service("strings");
$server = service("server");
$msint = model("App\Modules\Sint\Models\Sint_Mongo");
$mattachments = model("App\Modules\Storage\Models\Storage_Attachments");

$code = "";

//[processor]----------------------------------------------------------------------------------------------------------
$file = $mattachments->where("object", $oid)->where("reference", "ATTACHMENT")->orderBy("date,time", "ASC")->first();
$news = 0;
if (!empty($file["file"])) {
    $uri = $file["file"];
    $fileHandle = fopen(ROOTPATH . 'public' . $uri, "r");
    if ($fileHandle) {
        $count = 0;
        while (($line = fgets($fileHandle)) !== false) {
            //echo("{$line}<br>");
            if (strlen($line) < 64) {
                $line = str_replace(array("\n", "\r"), '', $line);
                $data = explode(":", $line);
                $alias = @$data[0];
                $password = @$data[1];
                if (!empty($alias) && !empty($password)) {
                    $count++;
                    //$filter = [
                    //    'email' => new MongoDB\BSON\Regex(preg_quote($alias, '/'), 'i'),
                    //    'password' => new MongoDB\BSON\Regex(preg_quote($password, '/'), 'i'),
                    //];
                    //$exist = $msint->findAll(10, 0, $filter);
                    //if (count($exist) > 0) {
                    //    //$code .= $count . ": " . $line . " - " . strlen($line) . " - [EXISTE]<br>";
                    //    continue;
                    //}
                    try {
                        $msint->insert(array(
                            'breach' => $oid,
                            'alias' => $alias,
                            'password' => $password
                        ));
                        //$code .= $count . ": " . $line . " - " . strlen($line) . "- [REGISTRADO]<br>";
                        $news++;
                    } catch (Exception $e) {
                        //$code .= $count . ": " . $line . " - " . strlen($line) . " -alias:{$alias} -password:{$password} [ERROR]<br>";
                        //$code .= $e->getMessage() . "<br>";
                    }
                }
            }
        }
        fclose($fileHandle);
        echo "<br>Se han registrado {$news} nuevos registros.";
    } else {
        echo "Error al abrir el archivo.";
    }
    $mattachments->update($file["attachment"], array("reference" => "PROCESSED"));
}
//[/processor]----------------------------------------------------------------------------------------------------------
$mattachments = $mattachments->get_List(1000000, 0, $oid);
//$code = "";
if (count($mattachments) > 0) {
    $count = 0;
    $code .= "<div class=\"row\">";
    $code .= "<div class=\"col-12 align-center\">";
    $code .= "<table class='table table-bordered'>";
    foreach ($mattachments as $attachment) {
        $count++;
        $code .= "<tr>";
        $code .= "<td>{$count}</td>";
        $code .= "<td><a href=\"{$attachment['file']}\" target=\"_blank\">{$attachment['file']}</a></td>";
        $code .= "<td>{$attachment['reference']}</td>";
        $code .= "</tr>";
    }
    $code .= "</table>";
    $code .= "</div>";
    $code .= "</div>";
    $code .= "<div class=\"row\">";
    $code .= "</div>";
}
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-Sint", array(
    "class" => "mb-3",
    "title" => "Importardor($oid)",
    "header-back" => "/sint/breaches/view/{$oid}",
    "content" => $code
));
echo($card);
?>
<?php if (!empty($file["file"])) { ?>
    <script>
        window.onload = function () {
            location.reload();
        };
    </script>
<?php } ?>