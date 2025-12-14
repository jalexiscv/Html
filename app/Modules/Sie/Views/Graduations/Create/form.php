<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-11-06 13:55:37
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Graduations\Creator\form.php]
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
$b = service("bootstrap");
$f = service("forms", array("lang" => "Sie_Graduations."));
$server = service("server");
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sie\Models\Sie_Graduations");
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
$r["graduation"] = $f->get_Value("graduation", pk());
$r["city"] = $f->get_Value("city");
$r["selected_city"] = $f->get_Value("selected_city");
$r["selected_country"] = $f->get_Value("selected_country");
$r["date"] = $f->get_Value("date", service("dates")::get_Date());
$r["application_type"] = $f->get_Value("application_type");
$r["full_name"] = $f->get_Value("full_name");
$r["document_type"] = $f->get_Value("document_type");
$r["document_number"] = $f->get_Value("document_number");
$r["expedition_place"] = $f->get_Value("expedition_place");
$r["address"] = $f->get_Value("address");
$r["phone_1"] = $f->get_Value("phone_1");
$r["email"] = $f->get_Value("email");
$r["phone_2"] = $f->get_Value("phone_2");
$r["degree"] = $f->get_Value("degree");
$r["doc_id"] = $f->get_Value("doc_id");
$r["highschool_diploma"] = $f->get_Value("highschool_diploma");
$r["highschool_graduation_act"] = $f->get_Value("highschool_graduation_act");
$r["icfes_results"] = $f->get_Value("icfes_results");
$r["saber_pro"] = $f->get_Value("saber_pro");
$r["academic_clearance"] = $f->get_Value("academic_clearance");
$r["financial_clearance"] = $f->get_Value("financial_clearance");
$r["graduation_fee_receipt"] = $f->get_Value("graduation_fee_receipt");
$r["graduation_request"] = $f->get_Value("graduation_request");
$r["admin_graduation_request"] = $f->get_Value("admin_graduation_request");
$r["ac"] = $f->get_Value("ac");
$r["ac_score"] = $f->get_Value("ac_score");
$r["ek"] = $f->get_Value("ek");
$r["ek_score"] = $f->get_Value("ek_score");
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
$back = $server->get_Referer();
//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("back", $back);
$f->add_HiddenField("selected_city", $back);
$f->add_HiddenField("selected_country", $back);
$f->fields["graduation"] = $f->get_FieldText("graduation", array("value" => $r["graduation"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["city"] = $f->get_FieldCitySearch("city", array("value" => $r["city"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["date"] = $f->get_FieldText("date", array("value" => $r["date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["application_type"] = $f->get_FieldSelect("application_type", array("selected" => $r["application_type"], "data" => LIST_APPLICATION_TYPES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["full_name"] = $f->get_FieldText("full_name", array("value" => $r["full_name"], "proportion" => "col-sm-8 col-12"));
$f->fields["document_type"] = $f->get_FieldSelect("document_type", array("selected" => $r["document_type"], "data" => LIST_IDENTIFICATION_TYPES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["document_number"] = $f->get_FieldText("document_number", array("value" => $r["document_number"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["expedition_place"] = $f->get_FieldCitySearch("expedition_place", array("value" => $r["expedition_place"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["address"] = $f->get_FieldText("address", array("value" => $r["address"], "proportion" => "col-sm-8 col-12"));
$f->fields["phone_1"] = $f->get_FieldText("phone_1", array("value" => $r["phone_1"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["email"] = $f->get_FieldText("email", array("value" => $r["email"], "proportion" => "col-sm-8 col-12"));
$f->fields["phone_2"] = $f->get_FieldText("phone_2", array("value" => $r["phone_2"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["degree"] = $f->get_FieldSelect("degree", array("selected" => $r["degree"], "data" => LIST_DEGREES_TYPES, "proportion" => "col-12"));
$f->fields["ac"] = $f->get_FieldText("ac", array("value" => $r["ac"], "proportion" => "col-sm-3 col-12"));
$f->fields["ac_score"] = $f->get_FieldText("ac_score", array("value" => $r["ac_score"], "proportion" => "col-sm-3 col-12"));
$f->fields["ek"] = $f->get_FieldText("ek", array("value" => $r["ek"], "proportion" => "col-sm-3 col-12"));
$f->fields["ek_score"] = $f->get_FieldText("ek_score", array("value" => $r["ek_score"], "proportion" => "col-sm-3 col-12"));

$f->fields["doc_id"] = $f->get_FieldUploader("doc_id", array("value" => $r["doc_id"], "proportion" => "col-sm-6 col-12", "object" => $r["graduation"]));
$f->fields["highschool_diploma"] = $f->get_FieldUploader("highschool_diploma", array("value" => $r["highschool_diploma"], "proportion" => "col-sm-6 col-12", "object" => $r["graduation"]));
$f->fields["highschool_graduation_act"] = $f->get_FieldUploader("highschool_graduation_act", array("value" => $r["highschool_graduation_act"], "proportion" => "col-sm-6 col-12", "object" => $r["graduation"]));
$f->fields["icfes_results"] = $f->get_FieldUploader("icfes_results", array("value" => $r["icfes_results"], "proportion" => "col-sm-6 col-12", "object" => $r["graduation"]));
$f->fields["saber_pro"] = $f->get_FieldUploader("saber_pro", array("value" => $r["saber_pro"], "proportion" => "col-sm-6 col-12", "object" => $r["graduation"]));
$f->fields["academic_clearance"] = $f->get_FieldUploader("academic_clearance", array("value" => $r["academic_clearance"], "proportion" => "col-sm-6 col-12", "object" => $r["graduation"]));
$f->fields["financial_clearance"] = $f->get_FieldUploader("financial_clearance", array("value" => $r["financial_clearance"], "proportion" => "col-sm-6 col-12", "object" => $r["graduation"]));
$f->fields["graduation_fee_receipt"] = $f->get_FieldUploader("graduation_fee_receipt", array("value" => $r["graduation_fee_receipt"], "proportion" => "col-sm-6 col-12", "object" => $r["graduation"]));
$f->fields["graduation_request"] = $f->get_FieldUploader("graduation_request", array("value" => $r["graduation_request"], "proportion" => "col-sm-6 col-12", "object" => $r["graduation"]));
//$f->fields["admin_graduation_request"] = $f->get_FieldUploader("admin_graduation_request", array("value" => $r["admin_graduation_request"],"proportion"=>"col-sm-6 col-12","object"=>$r["graduation"]));

$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g01"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["graduation"] . $f->fields["city"] . $f->fields["date"])));
$f->groups["g02"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["document_type"] . $f->fields["document_number"] . $f->fields["expedition_place"])));
$f->groups["g03"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["application_type"] . $f->fields["full_name"])));
$f->groups["g04"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["address"] . $f->fields["phone_1"])));
$f->groups["g05"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["email"] . $f->fields["phone_2"])));
$f->groups["g06"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["ac"] . $f->fields["ac_score"] . $f->fields["ek"] . $f->fields["ek_score"])));

$f->groups["g07"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["degree"])));
$f->groups["g08"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["doc_id"] . $f->fields["highschool_diploma"])));
$f->groups["g09"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["highschool_graduation_act"] . $f->fields["icfes_results"])));
$f->groups["g10"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["saber_pro"] . $f->fields["academic_clearance"])));
$f->groups["g13"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["financial_clearance"] . $f->fields["graduation_fee_receipt"])));
$f->groups["g14"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["graduation_request"])));

//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card2("create", array(
    "header-title" => lang("Sie_Graduations.create-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>