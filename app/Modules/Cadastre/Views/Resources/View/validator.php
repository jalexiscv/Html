<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Cadastre\Views\Resources\Editor\validator.php]
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
/*
* -----------------------------------------------------------------------------
* [Request]
* -----------------------------------------------------------------------------
*/
$f->set_ValidationRule("resource", "trim|required");
$f->set_ValidationRule("title", "trim|required");
$f->set_ValidationRule("description", "trim|required");
$f->set_ValidationRule("authors", "trim|required");
$f->set_ValidationRule("use", "trim|required");
$f->set_ValidationRule("category", "trim|required");
$f->set_ValidationRule("level", "trim|required");
$f->set_ValidationRule("objective", "trim|required");
$f->set_ValidationRule("program", "trim|required");
$f->set_ValidationRule("type", "trim|required");
$f->set_ValidationRule("format", "trim|required");
$f->set_ValidationRule("language", "trim|required");
$f->set_ValidationRule("file", "trim|required");
$f->set_ValidationRule("url", "trim|required");
$f->set_ValidationRule("keywords", "trim|required");
$f->set_ValidationRule("author", "trim|required");
$f->set_ValidationRule("created_date", "trim|required");
$f->set_ValidationRule("updated_date", "trim|required");
$f->set_ValidationRule("deleted_date", "trim|required");
/*
* -----------------------------------------------------------------------------
* [Validation]
* -----------------------------------------------------------------------------
*/
if ($f->run_Validation()) {
    $c = view($component . '\processor', $parent->get_Array());
} else {
    $errors = $f->validation->listErrors();
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Resources.view-errors-title"));
    $smarty->assign("message", lang("Resources.view-errors-message"));
    $smarty->assign("errors", $errors);
    $smarty->assign("continue", null);
    $smarty->assign("voice", "cadastre/resources-view-errors-message.mp3");
    $c = $smarty->view('alerts/card/danger.tpl');
    $c .= view($component . '\form', $parent->get_Array());
}
/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
echo($c);
?>
