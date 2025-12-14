<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-07-17 08:23:10
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Journalists\Views\Journalists\Creator\validator.php]
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
//[models]--------------------------------------------------------------------------------------------------------------
$mjournalists = model('App\Modules\Journalists\Models\Journalists_Journalists');
//[Form]--------------------------------------------------------------------------------------------------------------
$f = service("forms", array("lang" => "Journalists_Journalists."));
$photo = $f->get_FieldId("photo");
//[Request]-----------------------------------------------------------------------------
$f->set_ValidationRule("journalist", "trim|required");
$f->set_ValidationRule("citizenshipcard", "trim|required");
$f->set_ValidationRule("firstname", "trim|required");
$f->set_ValidationRule("lastname", "trim|required");
$f->set_ValidationRule("email", "trim|required");
$f->set_ValidationRule("phone", "trim|required");
$f->set_ValidationRule("media", "trim|required");
$f->set_ValidationRule("photo", "uploaded[{$photo}]|max_size[{$photo},1024000]");

$exist_citizenshipcard = $mjournalists->where('citizenshipcard', $f->get_Value('citizenshipcard'))->first();
$exist_email = $mjournalists->where('email', $f->get_Value('email'))->first();
$exist_phone = $mjournalists->where('phone', $f->get_Value('phone'))->first();

if ($exist_citizenshipcard) {
    $f->validation->setError('citizenshipcard', 'La <b>cedula de ciudadanía</b> ya se encuentra registrada');
}


if ($exist_email) {
    $f->validation->setError('email', 'El <b>correo electrónico</b> ya se encuentra registrado');
}

if ($exist_phone) {
    $f->validation->setError('phone', 'El <b>El teléfono</b> ya se encuentra registrado');
}

//$f->set_ValidationRule("date","trim|required");
//$f->set_ValidationRule("time","trim|required");
$f->set_ValidationRule("status", "trim|required");
$f->set_ValidationRule("position", "trim|required");
//[Validation]-----------------------------------------------------------------------------
if ($f->run_Validation()) {
    $c = view($component . '\processor', $parent->get_Array());
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
    $c .= view($component . '\form', $parent->get_Array());
}
//[Build]-----------------------------------------------------------------------------
echo($c);
?>