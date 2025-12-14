<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-11-10 06:42:40
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Cadastre\Views\Georeferences\Editor\validator.php]
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
$f = service("forms", array("lang" => "Cadastre.georeferences-"));
/*
* -----------------------------------------------------------------------------
* [Request]
* -----------------------------------------------------------------------------
*/
$f->set_ValidationRule("georeference", "trim|required");
$f->set_ValidationRule("profile", "trim|required");
$f->set_ValidationRule("latitud", "trim|required");
$f->set_ValidationRule("latitude_degrees", "trim|required");
$f->set_ValidationRule("latitude_minutes", "trim|required");
$f->set_ValidationRule("latitude_seconds", "trim|required");
$f->set_ValidationRule("latitude_decimal", "trim|required");
$f->set_ValidationRule("longitude", "trim|required");
$f->set_ValidationRule("longitude_degrees", "trim|required");
$f->set_ValidationRule("longitude_minutes", "trim|required");
$f->set_ValidationRule("longitude_seconds", "trim|required");
$f->set_ValidationRule("longitude_decimal", "trim|required");
$f->set_ValidationRule("date", "trim|required");
$f->set_ValidationRule("time", "trim|required");
$f->set_ValidationRule("author", "trim|required");
$f->set_ValidationRule("created_at", "trim|required");
$f->set_ValidationRule("updated_at", "trim|required");
$f->set_ValidationRule("deleted_at", "trim|required");
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
    $smarty->assign("title", lang("Cadastre.georeferences-view-errors-title"));
    $smarty->assign("message", lang("Cadastre.georeferences-view-errors-message"));
    $smarty->assign("errors", $errors);
    $smarty->assign("continue", null);
    $smarty->assign("voice", "cadastre/georeferences-view-errors-message.mp3");
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
