<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-11-10 06:42:49
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Cadastre\Views\Georeferences\Editor\index.php]
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
 * █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
/*
* -----------------------------------------------------------------------------
* [Vars]
* -----------------------------------------------------------------------------
*/
$data = $parent->get_Array();
$data['model'] = model("App\Modules\Cadastre\Models\Cadastre_Georeferences");
$data['permissions'] = array('singular' => 'cadastre-georeferences-edit', "plural" => 'cadastre-georeferences-edit-all');
$singular = $authentication->has_Permission($data['permissions']['singular']);
$plural = $authentication->has_Permission($data['permissions']['plural']);
$author = $data['model']->get_Authority($oid, safe_get_user());
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
