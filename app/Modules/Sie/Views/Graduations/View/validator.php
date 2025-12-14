<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-11-06 13:55:38
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Graduations\Creator\validator.php]
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
$f = service("forms", array("lang" => "Graduations."));
//[Request]-----------------------------------------------------------------------------
//$f->set_ValidationRule("graduation","trim|required");
//$f->set_ValidationRule("city","trim|required");
//$f->set_ValidationRule("date","trim|required");
//$f->set_ValidationRule("application_type","trim|required");
//$f->set_ValidationRule("full_name","trim|required");
//$f->set_ValidationRule("document_type","trim|required");
//$f->set_ValidationRule("document_number","trim|required");
//$f->set_ValidationRule("expedition_place","trim|required");
//$f->set_ValidationRule("address","trim|required");
//$f->set_ValidationRule("phone_1","trim|required");
//$f->set_ValidationRule("email","trim|required");
//$f->set_ValidationRule("phone_2","trim|required");
//$f->set_ValidationRule("degree","trim|required");
//$f->set_ValidationRule("doc_id","trim|required");
//$f->set_ValidationRule("highschool_diploma","trim|required");
//$f->set_ValidationRule("highschool_graduation_act","trim|required");
//$f->set_ValidationRule("icfes_results","trim|required");
//$f->set_ValidationRule("saber_pro","trim|required");
//$f->set_ValidationRule("academic_clearance","trim|required");
//$f->set_ValidationRule("financial_clearance","trim|required");
//$f->set_ValidationRule("graduation_fee_receipt","trim|required");
//$f->set_ValidationRule("graduation_request","trim|required");
//$f->set_ValidationRule("admin_graduation_request","trim|required");
//$f->set_ValidationRule("ac","trim|required");
//$f->set_ValidationRule("ac_score","trim|required");
//$f->set_ValidationRule("ek","trim|required");
//$f->set_ValidationRule("ek_score","trim|required");
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
