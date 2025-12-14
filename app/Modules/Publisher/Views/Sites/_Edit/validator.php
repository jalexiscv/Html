<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-01-14 23:48:16
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Publisher\Views\Sites\Editor\validator.php]
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
$bootstrap = service('bootstrap');
$f = service("forms", array("lang" => "Publisher.sites-"));
//[Request]-----------------------------------------------------------------------------
$f->set_ValidationRule("site", "trim|required");
$f->set_ValidationRule("image", "trim|required");
$f->set_ValidationRule("name", "trim|required");
$f->set_ValidationRule("description", "trim|required");
$f->set_ValidationRule("max_links", "trim|required");
$f->set_ValidationRule("links_type", "trim|required");
$f->set_ValidationRule("sponsored", "trim|required");
$f->set_ValidationRule("post_cover", "trim|required");
$f->set_ValidationRule("categories", "trim|required");
$f->set_ValidationRule("min_traffic", "trim|required");
$f->set_ValidationRule("max_traffic", "trim|required");
$f->set_ValidationRule("type", "trim|required");
$f->set_ValidationRule("themes", "trim|required");
$f->set_ValidationRule("moz_da", "trim|required");
$f->set_ValidationRule("moz_pa", "trim|required");
$f->set_ValidationRule("moz_links", "trim|required");
$f->set_ValidationRule("moz_rank", "trim|required");
$f->set_ValidationRule("majestic_cf", "trim|required");
$f->set_ValidationRule("majestic_tf", "trim|required");
$f->set_ValidationRule("majestic_links", "trim|required");
$f->set_ValidationRule("majestic_rd", "trim|required");
$f->set_ValidationRule("ahrefs_dr", "trim|required");
$f->set_ValidationRule("ahrefs_bl", "trim|required");
$f->set_ValidationRule("ahrefs_rd", "trim|required");
$f->set_ValidationRule("ahrefs_obl", "trim|required");
$f->set_ValidationRule("ahrefs_otm", "trim|required");
$f->set_ValidationRule("sistrix", "trim|required");
$f->set_ValidationRule("price", "trim|required");
$f->set_ValidationRule("author", "trim|required");
$f->set_ValidationRule("created_at", "trim|required");
$f->set_ValidationRule("updated_at", "trim|required");
$f->set_ValidationRule("deleted_at", "trim|required");
//[build]---------------------------------------------------------------------------------------------------------------
if ($f->run_Validation()) {
    $c = view($component . '\processor', $parent->get_Array());
} else {
    $c = $bootstrap->get_Card('validator-error', array(
        'class' => 'card-danger',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'text' => lang("App.validator-errors-message"),
        'errors' => $f->validation->listErrors(),
        'footer-class' => 'text-center',
        'voice' => "app/validator-errors-message.mp3",
    ));
    $c .= view($component . '\form', $parent->get_Array());
}
echo($c);
?>
