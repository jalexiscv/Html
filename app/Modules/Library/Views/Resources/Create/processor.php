<?php
require_once(APPPATH . 'ThirdParty/Google/autoload.php');

use Google\Cloud\Storage\StorageClient;

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-04-29 08:30:36
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Library\Views\Resources\Creator\processor.php]
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
 * █ @var object $mresources Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[Services]-----------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
$server = service('server');
//[Models]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Resources."));
$mresources = model("App\Modules\Library\Models\Library_Resources");
$d = array(
    "resource" => $f->get_Value("resource"),
    "title" => $f->get_Value("title"),
    "description" => $f->get_Value("description"),
    "authors" => $f->get_Value("authors"),
    "use" => $f->get_Value("use"),
    "category" => $f->get_Value("category"),
    "level" => $f->get_Value("level"),
    "objective" => $f->get_Value("objective"),
    "program" => $f->get_Value("program"),
    "type" => $f->get_Value("type"),
    "format" => $f->get_Value("format"),
    "language" => $f->get_Value("language"),
    "file" => $f->get_Value("file"),
    "url" => $f->get_Value("url"),
    "keywords" => $f->get_Value("keywords"),
    "author" => safe_get_user(),
    "editorial" => $f->get_Value("editorial"),
    "publication" => $f->get_Value("publication"),
);
$row = $mresources->find($d["resource"]);
$l["back"] = "/library/resources/list/" . lpk();
$l["edit"] = "/library/resources/edit/{$d["resource"]}";
$asuccess = "library/resources-create-success-message.mp3";
$aexist = "library/resources-create-exist-message.mp3";
if (is_array($row)) {
    $c = $card = $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Resources.create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Resources.create-duplicate-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $aexist,
    ));
} else {
    //[file]-----------------------------------------------------------------------------------------------------------
    $file = $request->getFile($f->get_fieldId("file"));
    $path = "/storages/" . md5($server::get_FullName()) . "/library/{$d['resource']}";
    $realpath = ROOTPATH . "public" . $path;
    if (!file_exists($realpath)) {
        mkdir($realpath, 0777, true);
    }
    if ($file->isValid()) {
        $rname = $file->getRandomName();
        $file->move($realpath, $rname);
        $name = $file->getClientName();
        $type = $file->getClientMimeType();
        $d['type'] = $type;
        $d['file'] = "{$path}/{$rname}";
        if ($d['format'] == "GENIALLY") {
            $zip = new ZipArchive();
            $zip->open($realpath . "/" . $rname);
            $zip->extractTo($realpath);
            $zip->close();
            //unlink($realpath . "/" . $rname);
            $d['url'] = "{$path}/genially.html";
        } elseif ($d['format'] == "H5P") {
            $zip = new ZipArchive();
            $zip->open($realpath . "/" . $rname);
            $zip->extractTo($realpath);
            $zip->close();
            //unlink($realpath . "/" . $rname);
            $d['url'] = "{$path}/index.html";
        } else {

        }
        //[storage]-----------------------------------------------------------------------------------------------------
        $fullpath = "{$realpath}/{$rname}";
        $spath = substr("{$path}/{$rname}", 1);
        $storage = new StorageClient(['keyFilePath' => APPPATH . 'ThirdParty/Google/keys.json']);
        $bucket = $storage->bucket("cloud-engine");
        $bucket->upload(fopen($fullpath, 'r'), ['name' => $spath, 'predefinedAcl' => 'publicRead']);
        //[/storage]-----------------------------------------------------------------------------------------------------
    }
    //[/file]----------------------------------------------------------------------------------------------------------
    $create = $mresources->insert($d);
    //echo($mresources->getLastQuery()->getQuery());
    $c = $card = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Resources.create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Resources.create-success-message"), $d['resource']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
}
echo($c);
?>