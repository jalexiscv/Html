<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-05-01 08:14:06
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Registrations\Creator\validator.php]
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
$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');
$f = service("forms", array("lang" => "Sie_Registrations."));
$step = $f->get_Value("step");
$email = $f->get_Value("email_address");
$mobile = $f->get_Value("mobile");

//[Request]-------------------------------------------------------------------------------------------------------------
$f->set_ValidationRule("email_address", "trim|required");
$f->set_ValidationRule("registration", "trim|required");
$f->set_ValidationRule("identification_type", "trim|required");
$f->set_ValidationRule("identification_number", "trim|required");
$f->set_ValidationRule("period", "trim|required");
$f->set_ValidationRule("journey", "trim|required");
$f->set_ValidationRule("first_name", "trim|required");
$f->set_ValidationRule("first_surname", "trim|required");
$f->set_ValidationRule("gender", "trim|required");
$f->set_ValidationRule("phone", "trim|required");
$f->set_ValidationRule("mobile", "trim|required");
$f->set_ValidationRule("birth_date", "trim|required");
$f->set_ValidationRule("birth_city", "trim|required");
$f->set_ValidationRule("address", "trim|required");
$f->set_ValidationRule("residence_city", "trim|required");
$f->set_ValidationRule("neighborhood", "trim|required");
$f->set_ValidationRule("linkage_type", "trim|required");
//[Validation]-----------------------------------------------------------------------------
if ($f->run_Validation()) {
    if ($step == 1) {
        $c = view($component . '\Processors\processor1', $parent->get_Array());
    } elseif ($step == 2) {
        $c = view($component . '\Processors\processor2', $parent->get_Array());
    } elseif ($step == 3) {
        $c = view($component . '\Processors\processor3', $parent->get_Array());
    } elseif ($step == 4) {
        $c = view($component . '\Processors\processor4', $parent->get_Array());
    }
} else {
    $c = $bootstrap->get_Card('access-denied', array(
        'class' => 'card-danger',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'text' => lang('App.validator-errors-message'),
        'errors' => $f->validation->listErrors(),
        'footer-class' => 'text-center',
        'voice' => "app/validator-errors-message.mp3",
    ));
    if ($step == 1) {
        $c .= view($component . '\Forms\form1', $parent->get_Array());
    } elseif ($step == 2) {
        $c .= view($component . '\Forms\form2', $parent->get_Array());
    } elseif ($step == 3) {
        $c .= view($component . '\Forms\form3', $parent->get_Array());
    }
}
//[Build]-----------------------------------------------------------------------------
echo($c);
?>