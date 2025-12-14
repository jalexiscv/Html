<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Vulnerabilities\Editor\index.php]
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
$data['model'] = model("App\Modules\C4isr\Models\C4isr_Vulnerabilities");
$data['permissions'] = array('singular' => 'c4isr-vulnerabilities-edit', "plural" => 'c4isr-vulnerabilities-edit-all');
$singular = $authentication->has_Permission($data['permissions']['singular']);
$plural = $authentication->has_Permission($data['permissions']['plural']);
$author = $data['model']->get_Authority($oid, $authentication->get_User());
$authority = ($singular && $author) ? true : false;
$submited = $request->getPost("submited");
$header = $component . '\breadcrumb';
$validator = $component . '\validator';
$form = $component . '\form';
$deny = $component . '\deny';
/*
* -----------------------------------------------------------------------------
* [Evaluate]
* -----------------------------------------------------------------------------
*/
if ($plural || $authority) {
    if (!empty($submited)) {
        $c = view($validator, $data);
    } else {
        $c = view($form, $data);
    }
} else {
    $c = view($deny, $data);
}
/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
session()->set('page_template', 'page');
session()->set('page_header', view($header, $data));
\session()->set('main_template', 'c9c3');
session()->set('messenger', true);
session()->set('main', $c);
session()->set('right', '');
?>
