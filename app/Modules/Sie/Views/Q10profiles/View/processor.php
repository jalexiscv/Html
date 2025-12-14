<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-10-15 22:17:31
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Q10profiles\Editor\processor.php]
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
//[services]------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[vars]----------------------------------------------------------------------------------------------------------------
// @var string view cadena que se pasa a la vista definida en viewer para su evaluación
// @var string views Uri completa hasta las vistas de modulo.
// @var string viewer URI completa hasta la vista encargada de evaluar cada view solicitado.
// @var string component URI completa hasta el componente solicitado.
// @var string oid valor de objeto recibido generalmente objeto / dato a visualizar
// @var string authentication  el servicio de autenticación desde el ModuleController
// @var string dates el servicio de fechas desde el ModuleController
// @var string strings el servicio de cadenas desde el ModuleController
// @var string request el servicio de solicitud desde el ModuleController
$f = service("forms", array("lang" => "Q10profiles."));
$model = model("App\Modules\Sie\Models\Sie_Q10profiles");
$d = array(
    "profile" => $f->get_Value("profile"),
    "first_name" => $f->get_Value("first_name"),
    "last_name" => $f->get_Value("last_name"),
    "id_number" => $f->get_Value("id_number"),
    "phone" => $f->get_Value("phone"),
    "mobile_phone" => $f->get_Value("mobile_phone"),
    "email" => $f->get_Value("email"),
    "residence_location" => $f->get_Value("residence_location"),
    "birth_date" => $f->get_Value("birth_date"),
    "blood_type" => $f->get_Value("blood_type"),
    "campus_shift" => $f->get_Value("campus_shift"),
    "address" => $f->get_Value("address"),
    "neighborhood" => $f->get_Value("neighborhood"),
    "birth_place" => $f->get_Value("birth_place"),
    "registration_date" => $f->get_Value("registration_date"),
    "program" => $f->get_Value("program"),
    "health_provider" => $f->get_Value("health_provider"),
    "ars_provider" => $f->get_Value("ars_provider"),
    "insurance_provider" => $f->get_Value("insurance_provider"),
    "civil_status" => $f->get_Value("civil_status"),
    "education_level" => $f->get_Value("education_level"),
    "institution" => $f->get_Value("institution"),
    "municipality" => $f->get_Value("municipality"),
    "academic_level" => $f->get_Value("academic_level"),
    "graduated" => $f->get_Value("graduated"),
    "degree_earned" => $f->get_Value("degree_earned"),
    "graduation_date" => $f->get_Value("graduation_date"),
    "family_member_full_name" => $f->get_Value("family_member_full_name"),
    "family_member_id_number" => $f->get_Value("family_member_id_number"),
    "family_member_phone" => $f->get_Value("family_member_phone"),
    "family_member_mobile_phone" => $f->get_Value("family_member_mobile_phone"),
    "family_member_email" => $f->get_Value("family_member_email"),
    "family_relationship" => $f->get_Value("family_relationship"),
    "company" => $f->get_Value("company"),
    "company_municipality" => $f->get_Value("company_municipality"),
    "job_position" => $f->get_Value("job_position"),
    "company_phone" => $f->get_Value("company_phone"),
    "company_address" => $f->get_Value("company_address"),
    "job_start_date" => $f->get_Value("job_start_date"),
    "job_end_date" => $f->get_Value("job_end_date"),
    "source" => $f->get_Value("source"),
    "print_date" => $f->get_Value("print_date"),
    "author" => safe_get_user(),
);
//[build]---------------------------------------------------------------------------------------------------------------
$row = $model->find($d["profile"]);
if (isset($row["profile"])) {
//$edit = $model->update($d);
    $c = $bootstrap->get_Card('warning', array(
        'class' => 'card-warning',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'title' => lang("Q10profiles.view-success-title"),
        'text' => lang("Q10profiles.view-success-message"),
        'footer-class' => 'text-center',
        'footer-continue' => base_url("/sie/q10profiles/view/{$d["profile"]}/" . lpk()),
        'voice' => "sie/q10profiles-view-success-message.mp3",
    ));
} else {
    $c = $bootstrap->get_Card('success', array(
        'class' => 'card-success',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'title' => lang("Q10profiles.view-noexist-title"),
        'text' => lang("Q10profiles.view-noexist-message"),
        'footer-class' => 'text-center',
        'footer-continue' => base_url("/sie/q10profiles"),
        'voice' => "sie/q10profiles-view-noexist-message.mp3",
    ));
}
echo($c);
?>
