<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-11-06 13:55:38
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Graduations\Editor\form.php]
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
$f = service("forms", array("lang" => "Sie_Graduations."));
//[models]--------------------------------------------------------------------------------------------------------------
$mattachments = model("App\Modules\Sie\Models\Sie_Attachments");
//[Request]-----------------------------------------------------------------------------
$row = $model->get_Graduation($oid);
$r["graduation"] = $row["graduation"];
$r["city"] = $row["city"];
$r["date"] = $row["date"];
$r["application_type"] = $row["application_type"];
$r["full_name"] = $row["full_name"];
$r["document_type"] = $row["document_type"];
$r["document_number"] = $row["document_number"];
$r["expedition_place"] = $row["expedition_place"];
$r["address"] = $row["address"];
$r["phone_1"] = $row["phone_1"];
$r["email"] = $row["email"];
$r["phone_2"] = $row["phone_2"];
$r["degree"] = $row["degree"];

$r["doc_id"] = $row["doc_id"];
$r["highschool_diploma"] = $row["highschool_diploma"];
$r["highschool_graduation_act"] = $row["highschool_graduation_act"];
$r["icfes_results"] = $row["icfes_results"];
$r["saber_pro"] = $row["saber_pro"];
$r["academic_clearance"] = $row["academic_clearance"];
$r["financial_clearance"] = $row["financial_clearance"];
$r["graduation_fee_receipt"] = $row["graduation_fee_receipt"];
$r["graduation_request"] = $row["graduation_request"];
$r["admin_graduation_request"] = $row["admin_graduation_request"];

if (!empty($row["doc_id"])) {
    $r["doc_id"] = $mattachments->get_File($row["doc_id"]);
}
if (!empty($row["highschool_diploma"])) {
    $r["highschool_diploma"] = $mattachments->get_File($row["highschool_diploma"]);
}
if (!empty($row["highschool_graduation_act"])) {
    $r["highschool_graduation_act"] = $mattachments->get_File($row["highschool_graduation_act"]);
}
if (!empty($row["icfes_results"])) {
    $r["icfes_results"] = $mattachments->get_File($row["icfes_results"]);
}
if (!empty($row["saber_pro"])) {
    $r["saber_pro"] = $mattachments->get_File($row["saber_pro"]);
}
if (!empty($row["academic_clearance"])) {
    $r["academic_clearance"] = $mattachments->get_File($row["academic_clearance"]);
}
if (!empty($row["financial_clearance"])) {
    $r["financial_clearance"] = $mattachments->get_File($row["financial_clearance"]);
}
if (!empty($row["graduation_fee_receipt"])) {
    $r["graduation_fee_receipt"] = $mattachments->get_File($row["graduation_fee_receipt"]);
}
if (!empty($row["graduation_request"])) {
    $r["graduation_request"] = $mattachments->get_File($row["graduation_request"]);
}
if (!empty($row["admin_graduation_request"])) {
    $r["admin_graduation_request"] = $mattachments->get_File($row["admin_graduation_request"]);
}


$r["ac"] = $row["ac"];
$r["ac_score"] = $row["ac_score"];
$r["ek"] = $row["ek"];
$r["ek_score"] = $row["ek_score"];
$r["author"] = $row["author"];
$r["created_at"] = $row["created_at"];
$r["updated_at"] = $row["updated_at"];
$r["deleted_at"] = $row["deleted_at"];

$back = "/sie/graduations/list/" . lpk();

$program = "";
foreach (LIST_DEGREES_TYPES as $degree) {
    if ($degree['value'] === $r['degree']) {
        $program = $degree['label'];
    }
}
//[Fields]-----------------------------------------------------------------------------
$f->fields["graduation"] = $f->get_FieldView("graduation", array("value" => $r["graduation"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["city"] = $f->get_FieldView("city", array("value" => $r["city"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["date"] = $f->get_FieldView("date", array("value" => $r["date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["application_type"] = $f->get_FieldView("application_type", array("value" => $r["application_type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["full_name"] = $f->get_FieldView("full_name", array("value" => $r["full_name"], "proportion" => "col-md-8 col-sm-12 col-12"));
$f->fields["document_type"] = $f->get_FieldView("document_type", array("value" => $r["document_type"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["document_number"] = $f->get_FieldView("document_number", array("value" => $r["document_number"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["expedition_place"] = $f->get_FieldView("expedition_place", array("value" => $r["expedition_place"], "proportion" => "col-md-6 col-sm-12 col-12"));

$f->fields["address"] = $f->get_FieldView("address", array("value" => $r["address"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["phone_1"] = $f->get_FieldView("phone_1", array("value" => $r["phone_1"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["email"] = $f->get_FieldView("email", array("value" => $r["email"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["phone_2"] = $f->get_FieldView("phone_2", array("value" => $r["phone_2"], "proportion" => "col-md-3 col-sm-12 col-12"));

$f->fields["degree"] = $f->get_FieldView("degree", array("value" => $program, "proportion" => "col-12"));

$f->fields["doc_id"] = $f->get_FieldViewFile("doc_id", array("value" => $r["doc_id"], "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["highschool_diploma"] = $f->get_FieldViewFile("highschool_diploma", array("value" => $r["highschool_diploma"], "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["highschool_graduation_act"] = $f->get_FieldViewFile("highschool_graduation_act", array("value" => $r["highschool_graduation_act"], "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["icfes_results"] = $f->get_FieldViewFile("icfes_results", array("value" => $r["icfes_results"], "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["saber_pro"] = $f->get_FieldViewFile("saber_pro", array("value" => $r["saber_pro"], "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["academic_clearance"] = $f->get_FieldViewFile("academic_clearance", array("value" => $r["academic_clearance"], "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["financial_clearance"] = $f->get_FieldViewFile("financial_clearance", array("value" => $r["financial_clearance"], "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["graduation_fee_receipt"] = $f->get_FieldViewFile("graduation_fee_receipt", array("value" => $r["graduation_fee_receipt"], "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["graduation_request"] = $f->get_FieldViewFile("graduation_request", array("value" => $r["graduation_request"], "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["admin_graduation_request"] = $f->get_FieldViewFile("admin_graduation_request", array("value" => $r["admin_graduation_request"], "proportion" => "col-md-6 col-sm-12 col-12"));

$f->fields["ac"] = $f->get_FieldView("ac", array("value" => $r["ac"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["ac_score"] = $f->get_FieldView("ac_score", array("value" => $r["ac_score"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["ek"] = $f->get_FieldView("ek", array("value" => $r["ek"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["ek_score"] = $f->get_FieldView("ek_score", array("value" => $r["ek_score"], "proportion" => "col-md-3 col-sm-12 col-12"));

$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldView("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldView("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldView("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["edit"] = $f->get_Button("edit", array("href" => "/sie/graduations/edit/" . $oid, "text" => lang("App.Edit"), "class" => "btn btn-secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
//[Groups]-----------------------------------------------------------------------------
$f->groups["g01"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["graduation"] . $f->fields["city"] . $f->fields["date"])));
$f->groups["g02"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["document_type"] . $f->fields["document_number"] . $f->fields["expedition_place"])));
$f->groups["g03"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["application_type"] . $f->fields["full_name"])));
$f->groups["g04"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["address"] . $f->fields["phone_1"] . $f->fields["email"] . $f->fields["phone_2"])));
$f->groups["g06"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["ac"] . $f->fields["ac_score"] . $f->fields["ek"] . $f->fields["ek_score"])));
$f->groups["g07"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["degree"])));
$f->groups["g08"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["doc_id"] . $f->fields["highschool_diploma"])));
$f->groups["g09"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["highschool_graduation_act"] . $f->fields["icfes_results"])));
$f->groups["g10"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["saber_pro"] . $f->fields["academic_clearance"])));
$f->groups["g13"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["financial_clearance"] . $f->fields["graduation_fee_receipt"])));
$f->groups["g14"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["graduation_request"] . $f->fields["admin_graduation_request"])));
//[Buttons]-----------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["edit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang("Sie_Graduations.view-title"),
    "header-back" => $back,
    "content" => $f,
));
echo($card);
?>
