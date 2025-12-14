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
$f = service("forms", array("lang" => "Resources."));
$model = model("App\Modules\Screens\Models\Screens_Resources");
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
    "author" => $authentication->get_User(),
    "created_date" => $f->get_Value("created_date"),
    "updated_date" => $f->get_Value("updated_date"),
    "deleted_date" => $f->get_Value("deleted_date"),
);
$row = $model->find($d["resource"]);
if (isset($row["resource"])) {
    $edit = $model->update($d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Resources.view-success-title"));
    $smarty->assign("message", sprintf(lang("Resources.view-success-message"), $d['resource']));
    $smarty->assign("edit", base_url("/Screens/resources/edit/{$d['resource']}/" . lpk()));
    $smarty->assign("continue", base_url("/Screens/resources/view/{$d["resource"]}/" . lpk()));
    $smarty->assign("voice", "Screens/resources-view-success-message.mp3");
    $c = $smarty->view('alerts/success.tpl');
} else {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Resources.view-noexist-title"));
    $smarty->assign("message", lang("Resources.view-noexist-message"));
    $smarty->assign("continue", base_url("/Screens/resources"));
    $smarty->assign("voice", "Screens/resources-view-noexist-message.mp3");
    $c = $smarty->view('alerts/warning.tpl');
}
echo($c);
?>
