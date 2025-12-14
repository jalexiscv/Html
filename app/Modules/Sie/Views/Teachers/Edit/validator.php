<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-12-18 11:03:17
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Security\Views\Users\Editor\validator.php]
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
$request = service('request');
$f = service("forms", array("lang" => "Sie_Teachers."));
$form = $f->get_Value("form");
//[Request]-----------------------------------------------------------------------------
$f->set_ValidationRule("user", "trim|required");
if ($form == "profile") {
    $f->set_ValidationRule("alias", "trim|required");
    $f->set_ValidationRule("type", "trim|required");
    $f->set_ValidationRule("birthday", "trim|required");
    $f->set_ValidationRule("citizenshipcard", "trim|required");
    $f->set_ValidationRule("email", "trim|required|valid_email");
    $f->set_ValidationRule("firstname", "trim|required");
    $f->set_ValidationRule("lastname", "trim|required");
    $f->set_ValidationRule("gender", "trim|required");
    $f->set_ValidationRule("marital_status", "trim|required");
    $f->set_ValidationRule("birth_country", "trim|required");
    $f->set_ValidationRule("birth_region", "trim|required");
    $f->set_ValidationRule("birth_city", "trim|required");
    $f->set_ValidationRule("address", "trim|required");
    $f->set_ValidationRule("institutional_address", "trim|required");
    $f->set_ValidationRule("participant_teacher", "trim|required");
    $f->set_ValidationRule("participant_executive", "trim|required");
    $f->set_ValidationRule("participant_authority", "trim|required");
}
//$f->set_ValidationRule("author", "trim|required");
//$f->set_ValidationRule("address", "trim|required");
//[build]---------------------------------------------------------------------------------------------------------------
if ($f->run_Validation()) {
    $c = view($component . '\processor', $parent->get_Array());
} else {
    $c = $bootstrap->get_Card('access-denied', array(
        'class' => 'card-danger mb-3',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'text' => lang("App.validator-errors-message"),
        'errors' => $f->validation->listErrors(),
        'footer-class' => 'text-center',
        'voice' => "app/validator-errors-message.mp3",
    ));
    $c .= view($component . '\Tabs\profile', $parent->get_Array());
}
echo($c);
?>