<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Screens\Views\Resources\Editor\processor.php]
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
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$server = service('Server');
//[Models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Screens\Models\Screens_Resources");
//[Process]-------------------------------------------------------------------------------------------------------------
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
    "editorial" => $f->get_Value("editorial"),
    "publication" => $f->get_Value("publication"),
    "file" => $f->get_Value("file"),
    "url" => $f->get_Value("url"),
    "keywords" => $f->get_Value("keywords"),
    "author" => $authentication->get_User(),
);
//[Elements]------------------------------------------------------------------------------------------------------------
$row = $model->find($d["resource"]);
$continue = "/Screens/resources/list/{$d["title"]}/";
$edit = "/Screens/resources/edit/{$d["resource"]}/";
$asuccess = "Screens/resources-edit-success-message.mp3";
$anoexist = "Screens/resources-edit-noexist-message.mp3";
//[Build]---------------------------------------------------------------------------------------------------------------
if (isset($row["resource"])) {
    $file = $request->getFile($f->get_fieldId("file"));
    if ($file->isValid()) {
        if ($d['format'] == "GENIALLY") {
            $c = view('App\Modules\Screens\Views\Resources\Edit\Processors\genially', array('resource' => $d));
        } elseif ($d['format'] == "H5P") {
            $c = view('App\Modules\Screens\Views\Resources\Edit\Processors\h5p', array('resource' => $d));
        } else {
            $c = view('App\Modules\Screens\Views\Resources\Edit\Processors\attachment', array('resource' => $d));
        }
    } else {
        $c = view('App\Modules\Screens\Views\Resources\Edit\Processors\general', array('resource' => $d));
    }
} else {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Resources.edit-noexist-title"));
    $smarty->assign("message", lang("Resources.edit-noexist-message"));
    $smarty->assign("continue", $continue);
    $smarty->assign("voice", $anoexist);
    $c = $smarty->view('alerts/card/warning.tpl');
}
echo($c);
?>