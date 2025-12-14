<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-10-21 21:56:09
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Registrations\Creator\processor.php]
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
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Registrations."));
$model = model("App\Modules\Sie\Models\Sie_Registrations");
//[Vars]-----------------------------------------------------------------------------
$back = "https://www.utede.edu.co";
$d = array(
    "registration" => $f->get_Value("registration"),
    "country" => $f->get_Value("country"),
    "region" => $f->get_Value("region"),
    "city" => $f->get_Value("city"),
    "agreement" => $f->get_Value("agreement"),
    "agreement_country" => $f->get_Value("agreement_country"),
    "agreement_region" => $f->get_Value("agreement_region"),
    "agreement_city" => $f->get_Value("agreement_city"),
    "agreement_institution" => $f->get_Value("agreement_institution"),
    "campus" => $f->get_Value("campus"),
    "shifts" => $f->get_Value("shifts"),
    "group" => $f->get_Value("group"),
    "period" => $f->get_Value("period"),
    "journey" => $f->get_Value("journey"),
    "program" => $f->get_Value("program"),
    "first_name" => $f->get_Value("first_name"),
    "second_name" => $f->get_Value("second_name"),
    "first_surname" => $f->get_Value("first_surname"),
    "second_surname" => $f->get_Value("second_surname"),
    "identification_type" => $f->get_Value("identification_type"),
    "identification_number" => $f->get_Value("identification_number"),
    "identification_place" => $f->get_Value("identification_place"),
    "identification_date" => $f->get_Value("identification_date"),
    "gender" => $f->get_Value("gender"),
    "email_address" => $f->get_Value("email_address"),
    "phone" => $f->get_Value("phone"),
    "mobile" => $f->get_Value("mobile"),
    "birth_date" => $f->get_Value("birth_date"),
    "birth_country" => $f->get_Value("birth_country"),
    "birth_region" => $f->get_Value("birth_region"),
    "birth_city" => $f->get_Value("birth_city"),
    "address" => $f->get_Value("address"),
    "residence_country" => $f->get_Value("residence_country"),
    "residence_region" => $f->get_Value("residence_region"),
    "residence_city" => $f->get_Value("residence_city"),
    "neighborhood" => $f->get_Value("neighborhood"),
    "area" => $f->get_Value("area"),
    "stratum" => $f->get_Value("stratum"),
    "transport_method" => $f->get_Value("transport_method"),
    "sisben_group" => $f->get_Value("sisben_group"),
    "sisben_subgroup" => $f->get_Value("sisben_subgroup"),
    "document_issue_place" => $f->get_Value("document_issue_place"),
    "blood_type" => $f->get_Value("blood_type"),
    "marital_status" => $f->get_Value("marital_status"),
    "number_children" => $f->get_Value("number_children"),
    "military_card" => $f->get_Value("military_card"),
    "ars" => $f->get_Value("ars"),
    "insurer" => $f->get_Value("insurer"),
    "eps" => $f->get_Value("eps"),
    "education_level" => $f->get_Value("education_level"),
    "occupation" => $f->get_Value("occupation"),
    "health_regime" => $f->get_Value("health_regime"),
    "document_issue_date" => $f->get_Value("document_issue_date"),
    "saber11" => $f->get_Value("saber11"),
    "graduation_certificate" => $f->get_Value("graduation_certificate"),
    "military_id" => $f->get_Value("military_id"),
    "diploma" => $f->get_Value("diploma"),
    "icfes_certificate" => $f->get_Value("icfes_certificate"),
    "utility_bill" => $f->get_Value("utility_bill"),
    "sisben_certificate" => $f->get_Value("sisben_certificate"),
    "address_certificate" => $f->get_Value("address_certificate"),
    "electoral_certificate" => $f->get_Value("electoral_certificate"),
    "photo_card" => $f->get_Value("photo_card"),
    "observations" => $f->get_Value("observations"),
    "status" => $f->get_Value("status"),
    "author" => safe_get_user(),
    "ticket" => $f->get_Value("ticket"),
    "interview" => $f->get_Value("interview"),
    "linkage_type" => $f->get_Value("linkage_type"),
    "ethnic_group" => $f->get_Value("ethnic_group"),
    "indigenous_people" => $f->get_Value("indigenous_people"),
    "afro_descendant" => $f->get_Value("afro_descendant"),
    "disability" => $f->get_Value("disability"),
    "disability_type" => $f->get_Value("disability_type"),
    "exceptional_ability" => $f->get_Value("exceptional_ability"),
    "responsible" => $f->get_Value("responsible"),
    "responsible_relationship" => $f->get_Value("responsible_relationship"),
    "identified_population_group" => $f->get_Value("identified_population_group"),
    "highlighted_population" => $f->get_Value("highlighted_population"),
    "num_people_depending_on_you" => $f->get_Value("num_people_depending_on_you"),
    "num_people_living_with_you" => $f->get_Value("num_people_living_with_you"),
    "responsible_phone" => $f->get_Value("responsible_phone"),
    "num_people_contributing_economically" => $f->get_Value("num_people_contributing_economically"),
    "first_in_family_to_study_university" => $f->get_Value("first_in_family_to_study_university"),
    "border_population" => $f->get_Value("border_population"),
    "observations_academic" => $f->get_Value("observations_academic"),
    "import" => $f->get_Value("import"),
    "moment" => $f->get_Value("moment"),
    "snies_updated_at" => $f->get_Value("snies_updated_at"),
    "photo" => $f->get_Value("photo"),
);
$row = $model->find($d["registration"]);
$l["back"] = "$back";
$l["edit"] = "/sie/registrations/edit/{$d["registration"]}";
$asuccess = "sie/registrations-create-success-message.mp3";
$aexist = "sie/registrations-create-exist-message.mp3";


if (is_array($row)) {
    $back = "https://www.utede.edu.co";
    $edit = $model->update($d['registration'], $d);
    $c = $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Registrations.create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Sie_Registrations.create-duplicate-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $aexist,
    ));
} else {
    $create = $model->insert($d);
    $back = "https://intranet.utede.edu.co/sie/pdf/registration/billing/{$d['registration']}";
    $code = "";
    $code .= "<img src=\"/themes/assets/images/start.png\" style=\"height: 100px;\" alt=\"\"/i>\n";
    $code .= "\t\t\t\t\t\t\t\t<div class=\"pt-4 text-center\">\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t<p class=\"m-0\">¡La preinscripción se ha realizado con éxito! Puedes realizar el pago a través de AvalPay, usando como\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\"número de desprendible\" el código de la orden de pago, que te damos a continuación. Además, te\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\trecordamos el valor de la inscripción.</p>\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t<p class=\"m-0 fs-3 m-1\">\$91.000</p>\n";
    //$code.="\t\t\t\t\t\t\t\t\t\t<p class=\"m-0\">Su numero de orden de pago:</p>\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t<p class=\"m-0 fs-3 m-1\"><?php echo(@\$row_registration['ticket']); ?> </p>\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t<p class=\"m-0\">También puedes descargar la orden, ver en ella otros métodos de pago para\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t inscribirte. Además, hemos enviado un correo electrónico con la misma orden a la dirección que\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t registraste. ¡Revisa tu bandeja de entrada y prepárate para comenzar esta nueva etapa en\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t Utedé!</p>\n";
    $code .= "\t\t\t\t\t\t\t\t</div>\n";
    $c = $bootstrap->get_Card("success", array(
        "class" => "card",
        "title" => "Preinscripción exitosa!",
        "text-class" => "text-center",
        "text" => $code,
        "footer-continue" => array("text" => "Descargar", "href" => $back, "target" => "_blank"),
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
}
echo($c);
?>