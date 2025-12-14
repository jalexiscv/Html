<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-04-29 08:30:38
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Library\Views\Resources\Editor\processor.php]
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
//[Services]-----------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
//[services]------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Library\Models\Library_Resources");
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Resources."));
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
    "editorial" => $f->get_Value("editorial"),
    "publication" => $f->get_Value("publication"),
);
//[Elements]-----------------------------------------------------------------------------
$row = $model->find($d["resource"]);
$l["back"] = "/library/resources/list/" . lpk();
$l["edit"] = "/library/resources/edit/{$d["resource"]}";
$asuccess = "library/resources-edit-success-message.mp3";
$anoexist = "library/resources-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
    $file = $request->getFile($f->get_fieldId("file"));
    if ($file->isValid()) {
        if ($d['format'] == "GENIALLY") {
            $c = view('App\Modules\Library\Views\Resources\Edit\Processors\genially', array('resource' => $d));
        } elseif ($d['format'] == "H5P") {
            $c = view('App\Modules\Library\Views\Resources\Edit\Processors\h5p', array('resource' => $d));
        } else {
            $c = view('App\Modules\Library\Views\Resources\Edit\Processors\attachment', array('resource' => $d));
        }
    } else {
        $c = view('App\Modules\Library\Views\Resources\Edit\Processors\general', array('resource' => $d));
    }

} else {
    //echo($model->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("warning", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Resources.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Resources.edit-noexist-message"), $d['resource']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
?>
