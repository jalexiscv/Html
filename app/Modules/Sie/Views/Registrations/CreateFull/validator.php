<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-10-21 21:56:09
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
 * █ @link https://www.higgs.com.co
 * █ @Version 1.5.1 @since PHP 8,PHP 9
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
$bootstrap = service('bootstrap');
$f = service("forms", array("lang" => "Sie_Registrations."));
//[Request]-----------------------------------------------------------------------------
$f->set_ValidationRule("registration", "trim|required");
//$f->set_ValidationRule("country","trim|required");
//$f->set_ValidationRule("region","trim|required");
//$f->set_ValidationRule("city","trim|required");
//$f->set_ValidationRule("agreement","trim|required");
//$f->set_ValidationRule("agreement_country","trim|required");
//$f->set_ValidationRule("agreement_region","trim|required");
//$f->set_ValidationRule("agreement_city","trim|required");
//$f->set_ValidationRule("agreement_institution","trim|required");
//$f->set_ValidationRule("campus","trim|required");
//$f->set_ValidationRule("shifts","trim|required");
//$f->set_ValidationRule("group","trim|required");
//$f->set_ValidationRule("period","trim|required");
$f->set_ValidationRule("journey", "trim|required");
$f->set_ValidationRule("program", "trim|required");
$f->set_ValidationRule("first_name", "trim|required");
//$f->set_ValidationRule("second_name","trim|required");
$f->set_ValidationRule("first_surname", "trim|required");
//$f->set_ValidationRule("second_surname","trim|required");
$f->set_ValidationRule("identification_type", "trim|required");
$f->set_ValidationRule("identification_number", "trim|required");
$f->set_ValidationRule("identification_place", "trim|required");
$f->set_ValidationRule("identification_date", "trim|required");
$f->set_ValidationRule("gender", "trim|required");
$f->set_ValidationRule("email_address", "trim|required");
$f->set_ValidationRule("phone", "trim|required");
$f->set_ValidationRule("mobile", "trim|required");
$f->set_ValidationRule("birth_date", "trim|required");
$f->set_ValidationRule("birth_country", "trim|required");
$f->set_ValidationRule("birth_region", "trim|required");
$f->set_ValidationRule("birth_city", "trim|required");
$f->set_ValidationRule("address", "trim|required");
$f->set_ValidationRule("residence_country", "trim|required");
$f->set_ValidationRule("residence_region", "trim|required");
$f->set_ValidationRule("residence_city", "trim|required");
$f->set_ValidationRule("neighborhood", "trim|required");
$f->set_ValidationRule("area", "trim|required");
$f->set_ValidationRule("stratum", "trim|required");
//$f->set_ValidationRule("transport_method","trim|required");
//$f->set_ValidationRule("sisben_group","trim|required");
//$f->set_ValidationRule("sisben_subgroup","trim|required");
//$f->set_ValidationRule("document_issue_place","trim|required");
$f->set_ValidationRule("blood_type", "trim|required");
$f->set_ValidationRule("marital_status", "trim|required");
$f->set_ValidationRule("number_children", "trim|required");
//$f->set_ValidationRule("military_card","trim|required");
//$f->set_ValidationRule("ars","trim|required");
//$f->set_ValidationRule("insurer","trim|required");
$f->set_ValidationRule("eps", "trim|required");
$f->set_ValidationRule("education_level", "trim|required");
//$f->set_ValidationRule("occupation","trim|required");
//$f->set_ValidationRule("health_regime","trim|required");
//$f->set_ValidationRule("document_issue_date","trim|required");
//$f->set_ValidationRule("saber11","trim|required");
//$f->set_ValidationRule("graduation_certificate","trim|required");
//$f->set_ValidationRule("military_id","trim|required");
//$f->set_ValidationRule("diploma","trim|required");
//$f->set_ValidationRule("icfes_certificate","trim|required");
//$f->set_ValidationRule("utility_bill","trim|required");
//$f->set_ValidationRule("sisben_certificate","trim|required");
//$f->set_ValidationRule("address_certificate","trim|required");
//$f->set_ValidationRule("electoral_certificate","trim|required");
//$f->set_ValidationRule("photo_card","trim|required");
//$f->set_ValidationRule("observations","trim|required");
//$f->set_ValidationRule("status","trim|required");
//$f->set_ValidationRule("author","trim|required");
//$f->set_ValidationRule("ticket","trim|required");
//$f->set_ValidationRule("interview","trim|required");
$f->set_ValidationRule("linkage_type", "trim|required");
//$f->set_ValidationRule("ethnic_group","trim|required");
//$f->set_ValidationRule("indigenous_people","trim|required");
//$f->set_ValidationRule("afro_descendant","trim|required");
//$f->set_ValidationRule("disability","trim|required");
//$f->set_ValidationRule("disability_type","trim|required");
//$f->set_ValidationRule("exceptional_ability","trim|required");
//$f->set_ValidationRule("responsible","trim|required");
//$f->set_ValidationRule("responsible_relationship","trim|required");
//$f->set_ValidationRule("identified_population_group","trim|required");
//$f->set_ValidationRule("highlighted_population","trim|required");
//$f->set_ValidationRule("num_people_depending_on_you","trim|required");
//$f->set_ValidationRule("num_people_living_with_you","trim|required");
//$f->set_ValidationRule("responsible_phone","trim|required");
//$f->set_ValidationRule("num_people_contributing_economically","trim|required");
//$f->set_ValidationRule("first_in_family_to_study_university","trim|required");
//$f->set_ValidationRule("border_population","trim|required");
//$f->set_ValidationRule("observations_academic","trim|required");
//$f->set_ValidationRule("import","trim|required");
//$f->set_ValidationRule("moment","trim|required");
//$f->set_ValidationRule("snies_updated_at","trim|required");
//$f->set_ValidationRule("photo","trim|required");
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
