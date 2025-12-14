<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-11-06 13:55:38
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Graduations\Editor\processor.php]
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
//[services]------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[vars]----------------------------------------------------------------------------------------------------------------
/**
 * @var object $authentication Authentication service from the ModuleController.
 * @var object $bootstrap Instance of the Bootstrap class from the ModuleController.
 * @var string $component Complete URI to the requested component.
 * @var object $dates Date service from the ModuleController.
 * @var string $oid String representing the object received, usually an object/data to be viewed, transferred from the ModuleController.
 * @var object $parent Represents the ModuleController.
 * @var object $request Request service from the ModuleController.
 * @var object $strings String service from the ModuleController.
 * @var string $view String passed to the view defined in the viewer for evaluation.
 * @var string $viewer Complete URI to the view responsible for evaluating each requested view.
 * @var string $views Complete URI to the module views.
 **/
$f = service("forms", array("lang" => "Graduations."));
$model = model("App\Modules\Sie\Models\Sie_Graduations");
$d = array(
    "graduation" => $f->get_Value("graduation"),
    "city" => $f->get_Value("city"),
    "date" => $f->get_Value("date"),
    "application_type" => $f->get_Value("application_type"),
    "full_name" => $f->get_Value("full_name"),
    "document_type" => $f->get_Value("document_type"),
    "document_number" => $f->get_Value("document_number"),
    "expedition_place" => $f->get_Value("expedition_place"),
    "address" => $f->get_Value("address"),
    "phone_1" => $f->get_Value("phone_1"),
    "email" => $f->get_Value("email"),
    "phone_2" => $f->get_Value("phone_2"),
    "degree" => $f->get_Value("degree"),
    "doc_id" => $f->get_Value("doc_id"),
    "highschool_diploma" => $f->get_Value("highschool_diploma"),
    "highschool_graduation_act" => $f->get_Value("highschool_graduation_act"),
    "icfes_results" => $f->get_Value("icfes_results"),
    "saber_pro" => $f->get_Value("saber_pro"),
    "academic_clearance" => $f->get_Value("academic_clearance"),
    "financial_clearance" => $f->get_Value("financial_clearance"),
    "graduation_fee_receipt" => $f->get_Value("graduation_fee_receipt"),
    "graduation_request" => $f->get_Value("graduation_request"),
    "admin_graduation_request" => $f->get_Value("admin_graduation_request"),
    "ac" => $f->get_Value("ac"),
    "ac_score" => $f->get_Value("ac_score"),
    "ek" => $f->get_Value("ek"),
    "ek_score" => $f->get_Value("ek_score"),
    "author" => safe_get_user(),
);
//[build]---------------------------------------------------------------------------------------------------------------
$row = $model->find($d["graduation"]);
if (isset($row["graduation"])) {
//$edit = $model->update($d);
    $c = $bootstrap->get_Card('warning', array(
        'class' => 'card-warning',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'title' => lang("Sie_Graduations.view-success-title"),
        'text' => lang("Sie_Graduations.view-success-message"),
        'footer-class' => 'text-center',
        'footer-continue' => base_url("/sie/graduations/view/{$d["graduation"]}/" . lpk()),
        'voice' => "sie/graduations-view-success-message.mp3",
    ));
} else {
    $c = $bootstrap->get_Card('success', array(
        'class' => 'card-success',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'title' => lang("Sie_Graduations.view-noexist-title"),
        'text' => lang("Sie_Graduations.view-noexist-message"),
        'footer-class' => 'text-center',
        'footer-continue' => base_url("/sie/graduations"),
        'voice' => "sie/graduations-view-noexist-message.mp3",
    ));
}
echo($c);
?>
