<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-10-15 22:17:31
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Q10profiles\Creator\validator.php]
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
$f = service("forms", array("lang" => "Q10profiles."));
//[Request]-----------------------------------------------------------------------------
//$f->set_ValidationRule("profile","trim|required");
//$f->set_ValidationRule("first_name","trim|required");
//$f->set_ValidationRule("last_name","trim|required");
//$f->set_ValidationRule("id_number","trim|required");
//$f->set_ValidationRule("phone","trim|required");
//$f->set_ValidationRule("mobile_phone","trim|required");
//$f->set_ValidationRule("email","trim|required");
//$f->set_ValidationRule("residence_location","trim|required");
//$f->set_ValidationRule("birth_date","trim|required");
//$f->set_ValidationRule("blood_type","trim|required");
//$f->set_ValidationRule("campus_shift","trim|required");
//$f->set_ValidationRule("address","trim|required");
//$f->set_ValidationRule("neighborhood","trim|required");
//$f->set_ValidationRule("birth_place","trim|required");
//$f->set_ValidationRule("registration_date","trim|required");
//$f->set_ValidationRule("program","trim|required");
//$f->set_ValidationRule("health_provider","trim|required");
//$f->set_ValidationRule("ars_provider","trim|required");
//$f->set_ValidationRule("insurance_provider","trim|required");
//$f->set_ValidationRule("civil_status","trim|required");
//$f->set_ValidationRule("education_level","trim|required");
//$f->set_ValidationRule("institution","trim|required");
//$f->set_ValidationRule("municipality","trim|required");
//$f->set_ValidationRule("academic_level","trim|required");
//$f->set_ValidationRule("graduated","trim|required");
//$f->set_ValidationRule("degree_earned","trim|required");
//$f->set_ValidationRule("graduation_date","trim|required");
//$f->set_ValidationRule("family_member_full_name","trim|required");
//$f->set_ValidationRule("family_member_id_number","trim|required");
//$f->set_ValidationRule("family_member_phone","trim|required");
//$f->set_ValidationRule("family_member_mobile_phone","trim|required");
//$f->set_ValidationRule("family_member_email","trim|required");
//$f->set_ValidationRule("family_relationship","trim|required");
//$f->set_ValidationRule("company","trim|required");
//$f->set_ValidationRule("company_municipality","trim|required");
//$f->set_ValidationRule("job_position","trim|required");
//$f->set_ValidationRule("company_phone","trim|required");
//$f->set_ValidationRule("company_address","trim|required");
//$f->set_ValidationRule("job_start_date","trim|required");
//$f->set_ValidationRule("job_end_date","trim|required");
//$f->set_ValidationRule("source","trim|required");
//$f->set_ValidationRule("print_date","trim|required");
//$f->set_ValidationRule("author","trim|required");
//$f->set_ValidationRule("created_at","trim|required");
//$f->set_ValidationRule("updated_at","trim|required");
//$f->set_ValidationRule("deleted_at","trim|required");
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
