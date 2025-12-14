<?php

/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */
//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Sie_Registrations."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sie\Models\Sie_Registrations");
$mprogams = model("App\Modules\Sie\Models\Sie_Programs");
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
//[vars]----------------------------------------------------------------------------------------------------------------
/** @var TYPE_NAME $oid */
$r["registration"] = $oid;
$registration = $mregistrations->getRegistration($oid);
$r["area"] = $f->get_Value("area", @$registration['area']);
$r["stratum"] = $f->get_Value("stratum", @$registration['stratum']);
$r["transport_method"] = $f->get_Value("transport_method", @$registration['transport_method']);
$r["sisben_group"] = $f->get_Value("sisben_group", @$registration['sisben_group']);
$r["sisben_subgroup"] = $f->get_Value("sisben_subgroup", @$registration['sisben_subgroup']);
$r["document_issue_place"] = $f->get_Value("document_issue_place", @$registration['document_issue_place']);
$r["birth_city"] = $f->get_Value("birth_city", @$registration['birth_city']);
$r["blood_type"] = $f->get_Value("blood_type", @$registration['blood_type']);
$r["marital_status"] = $f->get_Value("marital_status", @$registration['marital_status']);
$r["number_children"] = $f->get_Value("number_children", @$registration['number_children']);
$r["military_card"] = $f->get_Value("military_card", @$registration['military_card']);
$r["ars"] = $f->get_Value("ars", @$registration['ars']);
$r["insurer"] = $f->get_Value("insurer", @$registration['insurer']);
$r["eps"] = $f->get_Value("eps", @$registration['eps']);
$r["education_level"] = $f->get_Value("education_level", @$registration['education_level']);
$r["occupation"] = $f->get_Value("occupation", @$registration['occupation']);
$r["health_regime"] = $f->get_Value("health_regime", @$registration['health_regime']);
$r["document_issue_date"] = $f->get_Value("document_issue_date", @$registration['document_issue_date']);
$r["saber11"] = $f->get_Value("saber11", @$registration['saber11']);

$r["college"] = $f->get_Value("college", @$registration["college"]);
$r["college_year"] = $f->get_Value("college_year", @$registration["college_year"]);

$r["ac"] = $f->get_Value("ac", @$registration["ac"]);
$r["ac_score"] = $f->get_Value("ac_score", @$registration["ac_score"]);
$r["ek"] = $f->get_Value("ek", @$registration["ek"]);
$r["ek_score"] = $f->get_Value("ek_score", @$registration["ek_score"]);
$r["ac_date"] = $f->get_Value("ac_date", @$registration["ac_date"]);
$r["ac_document_type"] = $f->get_Value("ac_document_type", @$registration["ac_document_type"]);
$r["ac_document_number"] = $f->get_Value("ac_document_number", @$registration["ac_document_number"]);

$r["linkage_type"] = $f->get_Value("linkage_type", $registration['linkage_type']);

$r["indigenous_people"] = $f->get_Value("indigenous_people", @$registration['indigenous_people']);
$r["afro_descendant"] = $f->get_Value("afro_descendant", @$registration['afro_descendant']);
$r["disability"] = $f->get_Value("disability", @$registration['disability']);
$r["disability_type"] = $f->get_Value("disability_type", @$registration['disability_type']);
$r["exceptional_ability"] = $f->get_Value("exceptional_ability", @$registration['exceptional_ability']);

$r["responsible"] = $f->get_Value("responsible", @$registration['responsible']);
$r["responsible_relationship"] = $f->get_Value("responsible_relationship", @$registration['responsible_relationship']);
$r["responsible_phone"] = $f->get_Value("responsible_phone", @$registration['responsible_phone']);

$r["num_people_living_with_you"] = $f->get_Value("num_people_living_with_you", @$registration['num_people_living_with_you']);
$r["num_people_contributing_economically"] = $f->get_Value("num_people_contributing_economically", @$registration['num_people_contributing_economically']);
$r["num_people_depending_on_you"] = $f->get_Value("num_people_depending_on_you", @$registration['num_people_depending_on_you']);


$r["first_in_family_to_study_university"] = @$registration['first_in_family_to_study_university'];
$r["border_population"] = @$registration['border_population'];
$r["identified_population_group"] = @$registration['identified_population_group'];
$r["highlighted_population"] = @$registration['highlighted_population'];

// Nuevos campos
$r["ethnic_group"] = $f->get_Value("ethnic_group", @$registration['ethnic_group']);
$r["education_level_father"] = $f->get_Value("education_level_father", @$registration['education_level_father']);
$r["education_level_mother"] = $f->get_Value("education_level_mother", @$registration['education_level_mother']);
$r["economic_dependency"] = $f->get_Value("economic_dependency", @$registration['economic_dependency']);
$r["type_of_housing"] = $f->get_Value("type_of_housing", @$registration['type_of_housing']);
$r["type_of_funding"] = $f->get_Value("type_of_funding", @$registration['type_of_funding']);
$r["current_occupation"] = $f->get_Value("current_occupation", @$registration['current_occupation']);
$r["type_of_work"] = $f->get_Value("type_of_work", @$registration['type_of_work']);
$r["weekly_hours_worked"] = $f->get_Value("weekly_hours_worked", @$registration['weekly_hours_worked']);
$r["monthly_income"] = $f->get_Value("monthly_income", @$registration['monthly_income']);
$r["company_name"] = $f->get_Value("company_name", @$registration['company_name']);
$r["company_position"] = $f->get_Value("company_position", @$registration['company_position']);
$r["productive_sector"] = $f->get_Value("productive_sector", @$registration['productive_sector']);

$back = (($oid == "fullscreen") ? "/sie/registrations/cancel/fullscreen" : "/sie/registrations/list/" . lpk());

if ($r["sisben_group"] == "A" || empty($r["sisben_group"]) || is_null($r["sisben_group"])) {
    $subgroups = array(
            array("label" => "A1", "value" => "A1"),
            array("label" => "A2", "value" => "A2"),
            array("label" => "A3", "value" => "A3"),
            array("label" => "A4", "value" => "A4"),
            array("label" => "A5", "value" => "A5")
    );
} elseif ($r["sisben_group"] == "B") {
    $subgroups = array(
            array("label" => "B1", "value" => "B1"),
            array("label" => "B2", "value" => "B2"),
            array("label" => "B3", "value" => "B3"),
            array("label" => "B4", "value" => "B4"),
            array("label" => "B5", "value" => "B5"),
            array("label" => "B6", "value" => "B6"),
            array("label" => "B7", "value" => "B7"),
    );
} elseif ($r["sisben_group"] == "C") {
    $subgroups = array(
            array("label" => "C1", "value" => "C1"),
            array("label" => "C2", "value" => "C2"),
            array("label" => "C3", "value" => "C3"),
            array("label" => "C4", "value" => "C4"),
            array("label" => "C5", "value" => "C5"),
            array("label" => "C6", "value" => "C6"),
            array("label" => "C7", "value" => "C7"),
            array("label" => "C8", "value" => "C8"),
            array("label" => "C9", "value" => "C9"),
            array("label" => "C10", "value" => "C10"),
            array("label" => "C11", "value" => "C11"),
            array("label" => "C12", "value" => "C12"),
            array("label" => "C13", "value" => "C13"),
            array("label" => "C14", "value" => "C14"),
            array("label" => "C15", "value" => "C15"),
            array("label" => "C16", "value" => "C16"),
            array("label" => "C17", "value" => "C17"),
            array("label" => "C18", "value" => "C18"),
    );
} elseif ($r["sisben_group"] == "D") {
    $subgroups = array(
            array("label" => "D1", "value" => "D1"),
            array("label" => "D2", "value" => "D2"),
            array("label" => "D3", "value" => "D3"),
            array("label" => "D4", "value" => "D4"),
            array("label" => "D5", "value" => "D5"),
            array("label" => "D6", "value" => "D6"),
            array("label" => "D7", "value" => "D7"),
            array("label" => "D8", "value" => "D8"),
            array("label" => "D9", "value" => "D9"),
            array("label" => "D10", "value" => "D10"),
            array("label" => "D11", "value" => "D11"),
            array("label" => "D12", "value" => "D12"),
            array("label" => "D13", "value" => "D13"),
            array("label" => "D14", "value" => "D14"),
            array("label" => "D15", "value" => "D15"),
            array("label" => "D16", "value" => "D16"),
            array("label" => "D17", "value" => "D17"),
            array("label" => "D18", "value" => "D18"),
            array("label" => "D19", "value" => "D19"),
            array("label" => "D20", "value" => "D20"),
            array("label" => "D21", "value" => "D21"),
    );
}

$linkage_type = "NO DEFINIDA";
if (!empty($r['linkage_type'])) {
    foreach (LIST_LINKAGE_TYPES as $type) {
        if ($type['value'] == $r['linkage_type']) {
            $linkage_type = $type['label'];
        }
    }
}

$value_disability = "NINGUNA";
if (!empty($r['disability'])) {
    foreach (LIST_YN as $disability) {
        if ($disability['value'] == $r['disability']) {
            $value_disability = $disability['label'];
        }
    }
}

$disability_type = "NINGUNA";
if (!empty($r['disability_type'])) {
    foreach (LIST_TYPES_OF_DISABILITIES as $disabilitytype) {
        if ($disabilitytype['value'] == $r['disability_type']) {
            $disability_type = $disabilitytype['label'];
        }
    }
}

$label_identified_population_group = "N/A";
if (!empty($r['identified_population_group'])) {
    foreach (LIST_IDENTIFIED_POPULATION_GROUP as $identified_population_group) {
        if ($identified_population_group['value'] == $r['identified_population_group']) {
            $label_identified_population_group = @$r['identified_population_group'] . " - " . @$identified_population_group['label'];
        }
    }
}

$label_highlighted_population = "N/A";
if (!empty($r['highlighted_population'])) {
    foreach (LIST_HIGHLIGHTED_POPULATION as $highlighted_population) {
        if ($highlighted_population['value'] == $r['highlighted_population']) {
            $label_highlighted_population = @$r['highlighted_population'] . " - " . @$highlighted_population['label'];
        }
    }
}

$label_border_population = "NO";
if (!empty($r['border_population'])) {
    foreach (LIST_YN as $border_population) {
        if ($border_population['value'] == $r['border_population']) {
            $label_border_population = $border_population['label'];
        }
    }
}

$label_first_in_family_to_study_university = "NO";
if (!empty($r['first_in_family_to_study_university'])) {
    foreach (LIST_YN as $first_in_family_to_study_university) {
        if ($first_in_family_to_study_university['value'] == $r['first_in_family_to_study_university']) {
            $label_first_in_family_to_study_university = $first_in_family_to_study_university['label'];
        }
    }
}

foreach (LIST_TRANSPORTS as $transport) {
    if ($transport["value"] == $r["transport_method"]) {
        $r["transport_method"] .= ": {$transport["label"]}";
    }
}

foreach (LIST_MARITALS as $marital) {
    if ($marital["value"] == $r["marital_status"]) {
        $r["marital_status"] .= ": {$marital["label"]}";
    }
}

foreach (LIST_EDUCATION_LEVELS as $education) {
    if ($education["value"] == $r["education_level"]) {
        $r["education_level"] .= ": {$education["label"]}";
    }
}

foreach (LIST_OCCUPATIONS as $occupations) {
    if ($occupations["value"] == $r["occupation"]) {
        $r["occupation"] .= ": {$occupations["label"]}";
    }
}

foreach (LIST_EPS as $eps) {
    if ($eps["value"] == $r["eps"]) {
        $r["eps"] .= ": {$eps["label"]}";
    }
}


foreach (LIST_RESPONSIBLE_RELATIONSHIP as $relationship) {
    if ($relationship["value"] == $r["responsible_relationship"]) {
        $r["responsible_relationship"] .= ": {$relationship["label"]}";
    }
}


$r["ethnic_group"] = empty($r["ethnic_group"]) ? "0" : $r["ethnic_group"];
foreach (LIST_ETHNIC_GROUPS as $ethnic) {
    if ($ethnic["value"] == $r["ethnic_group"]) {
        $r["ethnic_group"] .= ": {$ethnic["label"]}";
    }
}

foreach (LIST_PARENTS_EDUCATION_LEVELS as $elfather) {
    if ($elfather["value"] == $r["education_level_father"]) {
        $r["education_level_father"] .= ": {$elfather["label"]}";
    }
}

foreach (LIST_PARENTS_EDUCATION_LEVELS as $elmother) {
    if ($elmother["value"] == $r["education_level_mother"]) {
        $r["education_level_mother"] .= ": {$elmother["label"]}";
    }
}

foreach (LIST_DEPENDENCY_ECONOMIC as $economic) {
    if ($economic["value"] == $r["economic_dependency"]) {
        $r["economic_dependency"] .= ": {$economic["label"]}";
    }
}

foreach (LIST_HOUSING_TYPE as $housing) {
    if ($housing["value"] == $r["type_of_housing"]) {
        $r["type_of_housing"] .= ": {$housing["label"]}";
    }
}

foreach (LIST_FUNDING as $funding) {
    if ($funding["value"] == $r["type_of_funding"]) {
        $r["type_of_funding"] .= ": {$funding["label"]}";
    }
}

foreach (LIST_CURRENT_OCCUPATIONS as $current_occupation) {
    if ($current_occupation["value"] == $r["current_occupation"]) {
        $r["current_occupation"] .= ": {$current_occupation["label"]}";
    }
}

foreach (LIST_WORK_TYPES as $work) {
    if ($work["value"] == $r["type_of_work"]) {
        $r["type_of_work"] .= ": {$work["label"]}";
    }
}

foreach (LIST_HOURS_WORK as $hours) {
    if ($hours["value"] == $r["weekly_hours_worked"]) {
        $r["weekly_hours_worked"] .= ": {$hours["label"]}";
    }
}

foreach (LIST_MONTHLY_INCOMES as $income) {
    if ($income["value"] == $r["monthly_income"]) {
        $r["monthly_income"] .= ": {$income["label"]}";
    }
}

foreach (LIST_PRODUCTIVE_SECTORS as $sector) {
    if ($sector["value"] == $r["productive_sector"]) {
        $r["productive_sector"] .= ": {$sector["label"]}";
    }
}

foreach (LIST_JOB_POSITIONS as $job) {
    if ($job["value"] == $r["company_position"]) {
        $r["company_position"] .= ": {$job["label"]}";
    }
}


//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("tab", "2");
$f->add_HiddenField("registration", $r["registration"]);
$f->fields["area"] = $f->get_FieldView("area", array("value" => $r["area"], "data" => LIST_AREAS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["stratum"] = $f->get_FieldView("stratum", array("value" => $r["stratum"], "data" => LIST_STRATUMS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["transport_method"] = $f->get_FieldView("transport_method", array("value" => @$r["transport_method"], "data" => LIST_TRANSPORTS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sisben_group"] = $f->get_FieldView("sisben_group", array("value" => @$r["sisben_group"], "data" => LIST_SISBEN_GROUPS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sisben_subgroup"] = $f->get_FieldView("sisben_subgroup", array("value" => @$r["sisben_subgroup"], "data" => @$r["sisben_subgroup"], "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["document_issue_place"] = $f->get_FieldView("document_issue_place", array("value" => $r["document_issue_place"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["birth_city"] = $f->get_FieldView("birth_city", array("value" => @$r["birth_city"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["blood_type"] = $f->get_FieldView("blood_type", array("value" => @$r["blood_type"], "data" => LIST_BLOOD, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["marital_status"] = $f->get_FieldView("marital_status", array("value" => @$r["marital_status"], "data" => LIST_MARITALS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["number_children"] = $f->get_FieldNumber("number_children", array("value" => @$r["number_children"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["military_card"] = $f->get_FieldView("military_card", array("value" => @$r["military_card"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ars"] = $f->get_FieldView("ars", array("value" => $r["ars"], "data" => LIST_ARS, "proportion" => "col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12"));
$f->fields["insurer"] = $f->get_FieldView("insurer", array("value" => $r["insurer"], "data" => LIST_INSURANCES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["eps"] = $f->get_FieldView("eps", array("value" => $r["eps"], "data" => LIST_EPS, "proportion" => "col-12"));
$f->fields["education_level"] = $f->get_FieldView("education_level", array("value" => @$r["education_level"], "data" => LIST_EDUCATION_LEVELS, "proportion" => "col-md-8  col-12"));
$f->fields["occupation"] = $f->get_FieldView("occupation", array("value" => @$r["occupation"], "data" => LIST_OCCUPATIONS, "proportion" => "col-12"));
$f->fields["health_regime"] = $f->get_FieldView("health_regime", array("value" => @$r["health_regime"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["document_issue_date"] = $f->get_FieldDate("document_issue_date", array("value" => $r["document_issue_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["college"] = $f->get_FieldView("college", array("value" => @$r["college"], "proportion" => "col-md-8 col-sm-12 col-12"));
$f->fields["college_year"] = $f->get_FieldView("college_year", array("value" => @$r["college_year"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["ac"] = $f->get_FieldView("ac", array("value" => @$r["ac"], "proportion" => "col-sm-3 col-12"));
$f->fields["ac_score"] = $f->get_FieldView("ac_score", array("value" => @$r["ac_score"], "proportion" => "col-sm-3 col-12"));
$f->fields["ac_date"] = $f->get_FieldView("ac_date", array("value" => $r["ac_date"], "proportion" => "col-sm-3 col-12"));
$f->fields["ac_document_type"] = $f->get_FieldView("ac_document_type", array("value" => @$r["ac_document_type"], "proportion" => "col-sm-3 col-12"));
$f->fields["ac_document_number"] = $f->get_FieldView("ac_document_number", array("value" => @$r["ac_document_number"], "proportion" => "col-sm-3 col-12"));
$f->fields["ek"] = $f->get_FieldView("ek", array("value" => @$r["ek"], "proportion" => "col-sm-3 col-12"));
$f->fields["ek_score"] = $f->get_FieldView("ek_score", array("value" => @$r["ek_score"], "proportion" => "col-sm-3 col-12"));


$f->fields["linkage_type"] = $f->get_FieldView("linkage_type", array("value" => @$linkage_type, "data" => LIST_LINKAGE_TYPES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["indigenous_people"] = $f->get_FieldView("indigenous_people", array("value" => @$r["indigenous_people"], "data" => LIST_INDIGENOUS_PEOPLE, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["afro_descendant"] = $f->get_FieldView("afro_descendant", array("value" => $r["afro_descendant"], "data" => LIST_BLACK_COMMUNITY, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["disability"] = $f->get_FieldView("disability", array("value" => @$value_disability, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["disability_type"] = $f->get_FieldView("disability_type", array("value" => @$disability_type, "data" => LIST_TYPES_OF_DISABILITIES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["exceptional_ability"] = $f->get_FieldView("exceptional_ability", array("value" => @$r["exceptional_ability"], "data" => LIST_OF_EXCEPTIONAL_CAPABILITIES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields['responsible'] = $f->get_FieldView("responsible", array("value" => @$r["responsible"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields['responsible_relationship'] = $f->get_FieldView("responsible_relationship", array("value" => @$r["responsible_relationship"], "data" => LIST_RESPONSIBLE_RELATIONSHIP, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields['responsible_phone'] = $f->get_FieldView("responsible_phone", array("value" => @$r["responsible_phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields['num_people_living_with_you'] = $f->get_FieldView("num_people_living_with_you", array("value" => @$r["num_people_living_with_you"], "data" => LIST_0_10, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields['num_people_contributing_economically'] = $f->get_FieldView("num_people_contributing_economically", array("value" => $r["num_people_contributing_economically"], "data" => LIST_0_10, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields['num_people_depending_on_you'] = $f->get_FieldView("num_people_depending_on_you", array("value" => @$r["num_people_depending_on_you"], "data" => LIST_0_10, "proportion" => "col-md-6 col-sm-12 col-12"));

$f->fields['first_in_family_to_study_university'] = $f->get_FieldView("first_in_family_to_study_university", array("value" => $label_first_in_family_to_study_university, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields['border_population'] = $f->get_FieldView("border_population", array("value" => $label_border_population, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields['identified_population_group'] = $f->get_FieldView("identified_population_group", array("value" => $label_identified_population_group, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields['highlighted_population'] = $f->get_FieldView("highlighted_population", array("value" => $label_highlighted_population, "proportion" => "col-md-6 col-sm-12 col-12"));

// Nuevos campos 2025
$f->fields["ethnic_group"] = $f->get_FieldView("ethnic_group", array("value" => @$r["ethnic_group"], "data" => LIST_ETHNIC_GROUPS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["education_level_father"] = $f->get_FieldView("education_level_father", array("value" => @$r["education_level_father"], "data" => LIST_PARENTS_EDUCATION_LEVELS, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["education_level_mother"] = $f->get_FieldView("education_level_mother", array("value" => @$r["education_level_mother"], "data" => LIST_PARENTS_EDUCATION_LEVELS, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["economic_dependency"] = $f->get_FieldView("economic_dependency", array("value" => @$r["economic_dependency"], "data" => LIST_DEPENDENCY_ECONOMIC, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["type_of_housing"] = $f->get_FieldView("type_of_housing", array("value" => @$r["type_of_housing"], "data" => LIST_HOUSING_TYPE, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["type_of_funding"] = $f->get_FieldView("type_of_funding", array("value" => @$r["type_of_funding"], "data" => LIST_FUNDING, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["current_occupation"] = $f->get_FieldView("current_occupation", array("value" => @$r["current_occupation"], "data" => LIST_CURRENT_OCCUPATIONS, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["type_of_work"] = $f->get_FieldView("type_of_work", array("value" => @$r["type_of_work"], "data" => LIST_WORK_TYPES, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["weekly_hours_worked"] = $f->get_FieldView("weekly_hours_worked", array("value" => @$r["weekly_hours_worked"], "data" => LIST_HOURS_WORK, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["monthly_income"] = $f->get_FieldView("monthly_income", array("value" => @$r["monthly_income"], "data" => LIST_MONTHLY_INCOMES, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["company_name"] = $f->get_FieldView("company_name", array("value" => @$r["company_name"], "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["company_position"] = $f->get_FieldView("company_position", array("value" => @$r["company_position"], "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["productive_sector"] = $f->get_FieldView("productive_sector", array("value" => @$r["productive_sector"], "data" => LIST_PRODUCTIVE_SECTORS, "proportion" => "col-md-4 col-sm-12 col-12"));


$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Continue"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g01"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["disability"] . $f->fields["disability_type"])));
$f->groups["g02"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["area"] . $f->fields["stratum"] . $f->fields["transport_method"])));
$f->groups["g03"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["sisben_group"] . $f->fields["sisben_subgroup"] . $f->fields["document_issue_place"])));
$f->groups["g04"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["blood_type"] . $f->fields["marital_status"] . $f->fields["number_children"])));
$f->groups["g05"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["eps"])));
$f->groups["g06"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["military_card"] . $f->fields["education_level"])));


$f->groups["g518"] = $f->get_Group(array("legend" => "2.1. Pruebas Saber 11 y Competencias", "fields" => ($f->fields["college"] . $f->fields["college_year"])));
$f->groups["g519"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["ac"] . $f->fields["ac_score"] . $f->fields["ac_date"] . $f->fields["ac_document_type"])));
$f->groups["g520"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["ac_document_number"] . $f->fields["ek"] . $f->fields["ek_score"])));

$f->groups["g10"] = $f->get_Group(array("legend" => "3. Contacto de emergencia / Responsable legal", "fields" => ($f->fields["responsible"] . $f->fields["responsible_relationship"] . $f->fields["responsible_phone"])));

$f->groups["g101"] = $f->get_Group(array("legend" => "3.1. Información familiar", "fields" => ($f->fields["num_people_living_with_you"] . $f->fields["num_people_contributing_economically"])));
$f->groups["g102"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["num_people_depending_on_you"] . $f->fields["education_level_father"] . $f->fields["education_level_mother"] . $f->fields["type_of_housing"])));

$f->groups["g401"] = $f->get_Group(array("legend" => "4. Información Laboral", "fields" => ($f->fields["economic_dependency"] . $f->fields["type_of_funding"] . $f->fields["current_occupation"])));
$f->groups["g402"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["type_of_work"] . $f->fields["weekly_hours_worked"] . $f->fields["monthly_income"])));
$f->groups["g403"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["company_name"] . $f->fields["company_position"] . $f->fields["productive_sector"])));

$f->groups["g501"] = $f->get_Group(array("legend" => "5. Información adicional", "fields" => ($f->fields["first_in_family_to_study_university"] . $f->fields["border_population"])));
$f->groups["g502"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["identified_population_group"] . $f->fields["highlighted_population"])));
$f->groups["g503"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["ethnic_group"])));

//$f->groups["g15"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["saber11"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
//$f->groups["gy"] = $f->get_GroupSeparator();
//$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
echo($f);
?>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const sisbenGroup = document.getElementById("<?php echo($f->get_FieldId("sisben_group")); ?>");
        const sisbenSubgroup = document.getElementById("<?php echo($f->get_FieldId("sisben_subgroup")); ?>");
        sisbenGroup.addEventListener("change", (e) => {
            const valueSisbenGroup = e.target.value;
            let sisbenSubgroups = [];
            switch (valueSisbenGroup) {
                case "A":
                    sisbenSubgroups = ["A1", "A2", "A3", "A4", "A5"];
                    break;
                case "B":
                    sisbenSubgroups = ["B1", "B2", "B3", "B4", "B5", "B6", "B7"];
                    break;
                case "C":
                    sisbenSubgroups = ["C1", "C2", "C3", "C4", "C5", "C6", "C7", "C8", "C9", "C10", "C11", "C12", "C13", "C14", "C15", "C16", "C17", "C18"];
                    break;
                case "D":
                    sisbenSubgroups = ["D1", "D2", "D3", "D4", "D5", "D6", "D7", "D8", "D9", "D10", "D11", "D12", "D13", "D14", "D15", "D16", "D17", "D18", "D19", "D20", "D21"];
                    break;
            }
            sisbenSubgroup.innerHTML = "";
            sisbenSubgroups.forEach((subgroup) => {
                const option = document.createElement("option");
                option.value = subgroup;
                option.textContent = subgroup;
                sisbenSubgroup.appendChild(option);
            });
        });
    });
</script>
