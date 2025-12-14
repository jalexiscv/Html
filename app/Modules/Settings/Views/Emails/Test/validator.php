<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-10-28 01:11:42
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Application\Views\Clients\Editor\validator.php]
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
 * █ @link https://www.higgs.com.co
 * █ @Version 1.5.1 @since PHP 8,PHP 9
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
$bootstrap = service('bootstrap');
$f = service("forms", array("lang" => "Clients."));
//[Request]-----------------------------------------------------------------------------
$f->set_ValidationRule("client", "trim|required");
//$f->set_ValidationRule("name","trim|required");
//$f->set_ValidationRule("rut","trim|required");
//$f->set_ValidationRule("vpn","trim|required");
//$f->set_ValidationRule("users","trim|required");
//$f->set_ValidationRule("domain","trim|required");
//$f->set_ValidationRule("default_url","trim|required");
//$f->set_ValidationRule("db_host","trim|required");
//$f->set_ValidationRule("db_port","trim|required");
//$f->set_ValidationRule("db","trim|required");
//$f->set_ValidationRule("db_user","trim|required");
//$f->set_ValidationRule("db_password","trim|required");
//$f->set_ValidationRule("status","trim|required");
//$f->set_ValidationRule("logo","trim|required");
//$f->set_ValidationRule("logo_portrait","trim|required");
//$f->set_ValidationRule("logo_portrait_light","trim|required");
//$f->set_ValidationRule("logo_landscape","trim|required");
//$f->set_ValidationRule("logo_landscape_light","trim|required");
//$f->set_ValidationRule("theme","trim|required");
//$f->set_ValidationRule("theme_color","trim|required");
//$f->set_ValidationRule("fb_app_id","trim|required");
//$f->set_ValidationRule("fb_app_secret","trim|required");
//$f->set_ValidationRule("fb_page","trim|required");
//$f->set_ValidationRule("footer","trim|required");
//$f->set_ValidationRule("google_trackingid","trim|required");
//$f->set_ValidationRule("google_ad_client","trim|required");
//$f->set_ValidationRule("google_ad_display_square","trim|required");
//$f->set_ValidationRule("google_ad_display_rectangle","trim|required");
//$f->set_ValidationRule("google_ad_links_retangle","trim|required");
//$f->set_ValidationRule("google_ad_display_vertical","trim|required");
//$f->set_ValidationRule("google_ad_infeed","trim|required");
//$f->set_ValidationRule("google_ad_inarticle","trim|required");
//$f->set_ValidationRule("google_ad_matching_content","trim|required");
//$f->set_ValidationRule("google_ad_links_square","trim|required");
//$f->set_ValidationRule("arc_id","trim|required");
//$f->set_ValidationRule("matomo","trim|required");
//$f->set_ValidationRule("2fa","trim|required");
$f->set_ValidationRule("smtp_to", "trim|required");
$f->set_ValidationRule("smtp_subjet", "trim|required");
$f->set_ValidationRule("smtp_message", "trim|required");
//$f->set_ValidationRule("author","trim|required");
//$f->set_ValidationRule("created_at","trim|required");
//$f->set_ValidationRule("updated_at","trim|required");
//$f->set_ValidationRule("deleted_at","trim|required");
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
