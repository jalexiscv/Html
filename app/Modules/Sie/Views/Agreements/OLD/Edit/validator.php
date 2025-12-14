<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-05-01 08:14:09
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Registrations\Editor\validator.php]
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
 * █ @var object $parent Trasferido desde el controlador
 * █ @var object $authentication Trasferido desde el controlador
 * █ @var object $request Trasferido desde el controlador
 * █ @var object $dates Trasferido desde el controlador
 * █ @var string $component Trasferido desde el controlador
 * █ @var string $view Trasferido desde el controlador
 * █ @var string $oid Trasferido desde el controlador
 * █ @var string $views Trasferido desde el controlador
 * █ @var string $prefix Trasferido desde el controlador
 * █ @var array $data Trasferido desde el controlador
 * █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
$bootstrap = service('bootstrap');
$f = service("forms", array("lang" => "Sie_Registrations."));
$tab = $f->get_Value("tab");
//[Request]-----------------------------------------------------------------------------
if ($tab == "1") {
    $f->set_ValidationRule("registration", "trim|required");
    $f->set_ValidationRule("email_address", "trim|required");
    $f->set_ValidationRule("program", "trim|required");
} elseif ($tab == "2") {
    $f->set_ValidationRule("registration", "trim|required");
} elseif ($tab == "3") {
    $f->set_ValidationRule("interview", "trim|required");
}

//$f->set_ValidationRule("first_name","trim|required");
//$f->set_ValidationRule("second_name","trim|required");
//$f->set_ValidationRule("first_surname","trim|required");
//$f->set_ValidationRule("second_surname","trim|required");
//$f->set_ValidationRule("identification_type","trim|required");
//$f->set_ValidationRule("identification_number","trim|required");
//$f->set_ValidationRule("gender","trim|required");

//$f->set_ValidationRule("mobile","trim|required");
//$f->set_ValidationRule("birth_date","trim|required");
//$f->set_ValidationRule("address","trim|required");
//$f->set_ValidationRule("residence_city","trim|required");
//$f->set_ValidationRule("neighborhood","trim|required");
//$f->set_ValidationRule("area","trim|required");
//$f->set_ValidationRule("stratum","trim|required");
//$f->set_ValidationRule("transport_method","trim|required");
//$f->set_ValidationRule("sisben_group","trim|required");
//$f->set_ValidationRule("sisben_subgroup","trim|required");
//$f->set_ValidationRule("document_issue_place","trim|required");
//$f->set_ValidationRule("birth_city","trim|required");
//$f->set_ValidationRule("blood_type","trim|required");
//$f->set_ValidationRule("marital_status","trim|required");
//$f->set_ValidationRule("number_children","trim|required");
//$f->set_ValidationRule("military_card","trim|required");
//$f->set_ValidationRule("ars","trim|required");
//$f->set_ValidationRule("insurer","trim|required");
//$f->set_ValidationRule("eps","trim|required");
//$f->set_ValidationRule("education_level","trim|required");
//$f->set_ValidationRule("occupation","trim|required");
//$f->set_ValidationRule("health_regime","trim|required");
//$f->set_ValidationRule("document_issue_date","trim|required");
//$f->set_ValidationRule("saber11","trim|required");
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
    $c .= view($component . '\Tabs\profile', $parent->get_Array());
}
echo($c);
?>
