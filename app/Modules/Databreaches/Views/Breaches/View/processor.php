<?php
set_time_limit(0);
/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-04-03 07:01:44
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Databreaches\Views\Breaches\Editor\processor.php]
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
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$server = service('server');
//[vars]----------------------------------------------------------------------------------------------------------------
$f = service("forms", array("lang" => "Breaches."));
$breach = $f->get_Value("breach");
$code = "";
$back = "/databreaches/breaches/view/{$breach}";
//[models]---------------------------------------------------------------------------------------------------------------
$mdatabreaches = model("App\Modules\Databreaches\Models\Databreaches_Mongo");
$mattachments = model("App\Modules\Storage\Models\Storage_Attachments");
//[file]---------------------------------------------------------------------------------------------------------------
$path = '/storages/' . md5($server->get_FullName()) . "/databreaches/{$breach}";
$file = $request->getFile($f->get_fieldId('file'));
if (!is_null($file) && $file->isValid()) {
    $rname = $file->getRandomName();
    $file->move(ROOTPATH . 'public' . $path, $rname);
    $name = $file->getClientName();
    $type = $file->getClientMimeType();
    $url = $path . "/" . $rname;
    //[axe]-------------------------------------------------------------------------------------------------------------
    $fileHandle = fopen(ROOTPATH . 'public' . $url, "r");
    if ($fileHandle) {
        $lineCount = 0;
        $fileCount = 1;
        $newFile = null;
        while (($line = fgets($fileHandle)) !== false) {
            // Crea un nuevo archivo cada 1000 líneas
            if ($lineCount % 250 == 0) {
                if ($newFile) {
                    fclose($newFile);
                    $d = array(
                        "attachment" => pk(),
                        "object" => $breach,
                        "file" => $uri,
                        "type" => "TXT",
                        "date" => $dates->get_Date(),
                        "time" => $dates->get_Time(),
                        "alt" => "",
                        "title" => "",
                        "size" => $file->getSize(),
                        "reference" => "ATTACHMENT",
                        "author" => safe_get_user(),
                    );
                    $create = $mattachments->insert($d);

                }
                $uri = $path . "/split_" . $fileCount . "-" . time() . ".txt";
                $newFileName = ROOTPATH . 'public' . $uri;
                $newFile = fopen($newFileName, "w");
                $fileCount++;
            }
            // Escribe la línea en el nuevo archivo
            fwrite($newFile, $line);
            $lineCount++;
        }
        // Cierra el último archivo
        if ($newFile) {
            fclose($newFile);
            $d = array(
                "attachment" => pk(),
                "object" => $breach,
                "file" => $uri,
                "type" => "TXT",
                "date" => $dates->get_Date(),
                "time" => $dates->get_Time(),
                "alt" => "",
                "title" => "",
                "size" => $file->getSize(),
                "reference" => "ATTACHMENT",
                "author" => safe_get_user(),
            );
            $create = $mattachments->insert($d);
        }
        fclose($fileHandle);
        unlink(ROOTPATH . 'public' . $url);//Borra el original
    } else {
        // Error al abrir el archivo
        echo "Error al abrir el archivo.";
    }
    //[db]-------------------------------------------------------------------------------------------------------------


    $card = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Attachments.create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Attachments.create-success-message"), $breach),
        "footer-continue" => $back,
        "footer-class" => "text-center",
        "voice" => false,
    ));
    echo($card);
} else {

}
//[build]---------------------------------------------------------------------------------------------------------------
$back = "/databreaches/breaches/list/" . lpk();
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => "Importado",
    "header-back" => $back,
    "content" => $code,
    "content-class" => "px-2",
));
//echo($card);
?>