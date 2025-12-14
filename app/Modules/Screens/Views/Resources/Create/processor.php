<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Screens\Views\Resources\Creator\processor.php]
*  ╩ ╩╝╚╝╚═╝╚═╝╩╚═╝╩═╝╚═╝
* -----------------------------------------------------------------------------
* Copyright 2021 - Higgs Bigdata S.A.S., Inc. <admin@Higgs.com>
* Este archivo es parte de Higgs Bigdata Framework 7.1
* Para obtener información completa sobre derechos de autor y licencia, consulte
* la LICENCIA archivo que se distribuyó con este código fuente.
* -----------------------------------------------------------------------------
* EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
* IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
* APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
* LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
* RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
* AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
* O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
* -----------------------------------------------------------------------------
* @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
* @link https://www.Higgs.com
* @Version 1.5.0
* @since PHP 7, PHP 8
* -----------------------------------------------------------------------------
* Datos recibidos desde el controlador - @ModuleController
* -----------------------------------------------------------------------------
* @Authentication
* @request
* @dates
* @view
* @oid
* @component
* @views
* @prefix
* @parent
* -----------------------------------------------------------------------------
*/
//[Services]-----------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
$server = service('server');

//[Models]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Resources."));
$model = model("App\Modules\Screens\Models\Screens_Resources");
$d = array(
    "resource" => $f->get_Value("resource"),
    "title" => urlencode($f->get_Value("title")),
    "description" => urlencode($f->get_Value("description")),
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
    "editorial" => $f->get_Value("editorial"),
    "publication" => $f->get_Value("publication"),
    "keywords" => $f->get_Value("keywords"),
    "author" => $authentication->get_User(),
);
$row = $model->find($d["resource"]);
$l["back"] = "/Screens/resources/list/" . lpk();
$l["edit"] = "/Screens/resources/edit/{$d["resource"]}";
if (isset($row["resource"])) {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Resources.create-duplicate-title"));
    $smarty->assign("message", lang("Resources.create-duplicate-message"));
    $smarty->assign("continue", $l["back"]);
    $smarty->assign("voice", "Screens/resources-create-duplicate-message.mp3");
    $c = $smarty->view('alerts/card/warning.tpl');
} else {
    //[Storage]-----------------------------------------------------------------------------------------------------------
    $file = $request->getFile($f->get_fieldId("file"));
    $path = "/storages/" . md5($server::get_FullName()) . "/Screens/{$d['resource']}";
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
    }
    //[/Storage]----------------------------------------------------------------------------------------------------------
    $create = $model->insert($d);
    //cho($model->getLastQuery()->getQuery());
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Resources.create-success-title"));
    $smarty->assign("message", sprintf(lang("Resources.create-success-message"), $d['resource']));
    //$smarty->assign("edit", $l["edit"]);
    $smarty->assign("continue", $l["back"]);
    $smarty->assign("voice", "Screens/resources-create-success-message.mp3");
    $c = $smarty->view('alerts/card/success.tpl');
}
echo($c);
?>