<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Macroprocesses\List\index.php]
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
/*
* -----------------------------------------------------------------------------
* [Vars]
* -----------------------------------------------------------------------------
*/
$data = $parent->get_Array();
$data['permissions'] = array('singular' => false, "plural" => 'disa-macroprocesses-view-all');
$plural = $authentication->has_Permission($data['permissions']['plural']);
$submited = $request->getPost("submited");
$validator = $component . '\validator';
$list = $component . '\List\table';
$deny = $component . '\List\deny';
/*
* -----------------------------------------------------------------------------
* [Evaluate]
* -----------------------------------------------------------------------------
*/
if ($plural) {
    if (!empty($submited)) {
        $c = view($validator, $data);
    } else {
        $c = view($list, $data);
        /** Logger **/
        history_logger(array(
            "log" => pk(),
            "module" => "DISA",
            "author" => $authentication->get_User(),
            "description" => "El usuario <b>@" . $authentication->get_Alias() . "</b> accedio al listado general de macroprocesos.",
            "code" => "",
        ));
    }
} else {
    $c = view($deny, $data);
    /** Logger **/
    history_logger(array(
        "log" => pk(),
        "module" => "DISA",
        "author" => $authentication->get_User(),
        "description" => "El usuario <b>@" . $authentication->get_Alias() . "</b> se le nego el acceso al listado general macroprocesos.",
        "code" => "",
    ));
}
/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
$header = view($component . '\List\breadcrumb', $data);
session()->set('page_template', 'page');
session()->set('page_header', $header);
session()->set('main_template', 'c12');
session()->set('messenger', true);
session()->set('main', $c);
session()->set('right', '');
?>
