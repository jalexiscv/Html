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
$r["registration"] = $f->get_Value("registration");
$registration = $mregistrations->getRegistration($r["registration"]);
$r["area"] = $f->get_Value("area", @$registration['area']);
$r["stratum"] = $f->get_Value("stratum", $registration['stratum']);
$r["transport_method"] = $f->get_Value("transport_method", $registration['transport_method']);
$r["sisben_group"] = $f->get_Value("sisben_group", $registration['sisben_group']);
$r["sisben_subgroup"] = $f->get_Value("sisben_subgroup", $registration['sisben_subgroup']);
$r["document_issue_place"] = $f->get_Value("document_issue_place", $registration['document_issue_place']);
$r["birth_city"] = $f->get_Value("birth_city", $registration['birth_city']);
$r["blood_type"] = $f->get_Value("blood_type", $registration['blood_type']);
$r["marital_status"] = $f->get_Value("marital_status", $registration['marital_status']);
$r["number_children"] = $f->get_Value("number_children", $registration['number_children']);
$r["military_card"] = $f->get_Value("military_card", $registration['military_card']);
$r["ars"] = $f->get_Value("ars", $registration['ars']);
$r["insurer"] = $f->get_Value("insurer", $registration['insurer']);
$r["eps"] = $f->get_Value("eps", $registration['eps']);
$r["education_level"] = $f->get_Value("education_level", $registration['education_level']);
$r["occupation"] = $f->get_Value("occupation", $registration['occupation']);
$r["health_regime"] = $f->get_Value("health_regime", $registration['health_regime']);
$r["document_issue_date"] = $f->get_Value("document_issue_date", $registration['document_issue_date']);
$r["saber11"] = $f->get_Value("saber11", $registration['saber11']);

$r["linkage_type"] = $f->get_Value("linkage_type", $registration['linkage_type']);
$r["ethnic_group"] = $f->get_Value("ethnic_group", $registration['ethnic_group']);
$r["indigenous_people"] = $f->get_Value("indigenous_people", $registration['indigenous_people']);
$r["afro_descendant"] = $f->get_Value("afro_descendant", $registration['afro_descendant']);
$r["disability"] = $f->get_Value("disability", $registration['disability']);
$r["disability_type"] = $f->get_Value("disability_type", $registration['disability_type']);
$r["exceptional_ability"] = $f->get_Value("exceptional_ability", $registration['exceptional_ability']);

$r["responsible"] = $f->get_Value("responsible", $registration['responsible']);
$r["responsible_relationship"] = $f->get_Value("responsible_relationship", $registration['responsible_relationship']);
$r["responsible_phone"] = $f->get_Value("responsible_phone", $registration['responsible_phone']);
$r["num_people_living_with_you"] = $f->get_Value("num_people_living_with_you", $registration['num_people_living_with_you']);
$r["num_people_contributing_economically"] = $f->get_Value("num_people_contributing_economically", $registration['num_people_contributing_economically']);
$r["num_people_depending_on_you"] = $f->get_Value("num_people_depending_on_you", $registration['num_people_depending_on_you']);
$r["first_in_family_to_study_university"] = $f->get_Value("first_in_family_to_study_university", $registration['first_in_family_to_study_university']);
$r["border_population"] = $f->get_Value("border_population", $registration['border_population']);
$r["identified_population_group"] = $f->get_Value("identified_population_group", $registration['identified_population_group']);
$r["highlighted_population"] = $f->get_Value("highlighted_population", $registration['highlighted_population']);

$back = (($oid == "fullscreen") ? "/sie/registrations/cancel/fullscreen" : "/sie/agreements/list/" . lpk());

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

//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("step", "3");
$f->add_HiddenField("registration", $r["registration"]);
$f->fields["area"] = $f->get_FieldSelect("area", array("selected" => $r["area"], "data" => LIST_AREAS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["stratum"] = $f->get_FieldSelect("stratum", array("selected" => $r["stratum"], "data" => LIST_STRATUMS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["transport_method"] = $f->get_FieldSelect("transport_method", array("selected" => $r["transport_method"], "data" => LIST_TRANSPORTS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sisben_group"] = $f->get_FieldSelect("sisben_group", array("selected" => $r["sisben_group"], "data" => LIST_SISBEN_GROUPS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sisben_subgroup"] = $f->get_FieldSelect("sisben_subgroup", array("selected" => $r["sisben_subgroup"], "data" => $subgroups, "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["document_issue_place"] = $f->get_FieldText("document_issue_place", array("value" => $r["document_issue_place"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["birth_city"] = $f->get_FieldText("birth_city", array("value" => $r["birth_city"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["blood_type"] = $f->get_FieldSelect("blood_type", array("selected" => $r["blood_type"], "data" => LIST_BLOOD, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["marital_status"] = $f->get_FieldSelect("marital_status", array("selected" => $r["marital_status"], "data" => LIST_MARITALS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["number_children"] = $f->get_FieldNumber("number_children", array("value" => $r["number_children"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["military_card"] = $f->get_FieldText("military_card", array("value" => $r["military_card"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ars"] = $f->get_FieldSelect("ars", array("selected" => $r["ars"], "data" => LIST_ARS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["insurer"] = $f->get_FieldSelect("insurer", array("selected" => $r["insurer"], "data" => LIST_INSURANCES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["eps"] = $f->get_FieldSelect("eps", array("selected" => $r["eps"], "data" => LIST_EPS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["education_level"] = $f->get_FieldSelect("education_level", array("selected" => $r["education_level"], "data" => LIST_EDUCATION_LEVELS, "proportion" => "col-12"));
$f->fields["occupation"] = $f->get_FieldSelect("occupation", array("selected" => $r["occupation"], "data" => LIST_OCCUPATIONS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["health_regime"] = $f->get_FieldText("health_regime", array("value" => $r["health_regime"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["document_issue_date"] = $f->get_FieldDate("document_issue_date", array("value" => $r["document_issue_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["saber11"] = $f->get_FieldText("saber11", array("value" => $r["saber11"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["linkage_type"] = $f->get_FieldSelect("linkage_type", array("selected" => $r["linkage_type"], "data" => LIST_LINKAGE_TYPES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ethnic_group"] = $f->get_FieldSelect("ethnic_group", array("selected" => $r["ethnic_group"], "data" => LIST_ETHNIC_GROUPS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["indigenous_people"] = $f->get_FieldSelect("indigenous_people", array("selected" => $r["indigenous_people"], "data" => LIST_INDIGENOUS_PEOPLE, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["afro_descendant"] = $f->get_FieldSelect("afro_descendant", array("selected" => $r["afro_descendant"], "data" => LIST_BLACK_COMMUNITY, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["disability"] = $f->get_FieldSelect("disability", array("selected" => $r["disability"], "data" => LIST_YN, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["disability_type"] = $f->get_FieldSelect("disability_type", array("selected" => $r["disability_type"], "data" => LIST_TYPES_OF_DISABILITIES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["exceptional_ability"] = $f->get_FieldSelect("exceptional_ability", array("selected" => $r["exceptional_ability"], "data" => LIST_OF_EXCEPTIONAL_CAPABILITIES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields['responsible'] = $f->get_FieldText("responsible", array("value" => $r["responsible"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields['responsible_relationship'] = $f->get_FieldSelect("responsible_relationship", array("selected" => $r["responsible_relationship"], "data" => LIST_RESPONSIBLE_RELATIONSHIP, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields['responsible_phone'] = $f->get_FieldText("responsible_phone", array("value" => $r["responsible_phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields['num_people_living_with_you'] = $f->get_FieldSelect("num_people_living_with_you", array("selected" => $r["num_people_living_with_you"], "data" => LIST_0_10, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields['num_people_contributing_economically'] = $f->get_FieldSelect("num_people_contributing_economically", array("selected" => $r["num_people_contributing_economically"], "data" => LIST_0_10, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields['num_people_depending_on_you'] = $f->get_FieldSelect("num_people_depending_on_you", array("selected" => $r["num_people_depending_on_you"], "data" => LIST_0_10, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields['first_in_family_to_study_university'] = $f->get_FieldSelect("first_in_family_to_study_university", array("selected" => $r["first_in_family_to_study_university"], "data" => LIST_YN, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields['border_population'] = $f->get_FieldSelect("border_population", array("selected" => $r["border_population"], "data" => LIST_YN, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields['identified_population_group'] = $f->get_FieldSelect("identified_population_group", array("selected" => $r["identified_population_group"], "data" => LIST_IDENTIFIED_POPULATION_GROUP, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields['highlighted_population'] = $f->get_FieldSelect("highlighted_population", array("selected" => $r["highlighted_population"], "data" => LIST_HIGHLIGHTED_POPULATION, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Continue"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g01"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["linkage_type"] . $f->fields["ethnic_group"] . $f->fields["indigenous_people"])));
$f->groups["g03"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["afro_descendant"] . $f->fields["disability"] . $f->fields["disability_type"] . $f->fields["exceptional_ability"])));
$f->groups["g04"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["area"] . $f->fields["stratum"] . $f->fields["transport_method"])));
$f->groups["g05"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["sisben_group"] . $f->fields["sisben_subgroup"] . $f->fields["document_issue_place"])));
$f->groups["g06"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["blood_type"] . $f->fields["marital_status"] . $f->fields["eps"])));
$f->groups["g07"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["number_children"] . $f->fields["military_card"] . $f->fields["ars"])));
$f->groups["g08"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["education_level"])));
$f->groups["g09"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["occupation"] . $f->fields["saber11"] . $f->fields["document_issue_date"])));
$f->groups["g10"] = $f->get_Group(array("legend" => "Contacto de emergencia / Responsable legal", "fields" => ($f->fields["responsible"] . $f->fields["responsible_relationship"] . $f->fields["responsible_phone"])));
$f->groups["g11"] = $f->get_Group(array("legend" => "Información familiar", "fields" => ($f->fields["num_people_living_with_you"] . $f->fields["num_people_contributing_economically"] . $f->fields["num_people_depending_on_you"])));
$f->groups["g12"] = $f->get_Group(array("legend" => "Información adicional", "fields" => ($f->fields["first_in_family_to_study_university"] . $f->fields["border_population"] . $f->fields["identified_population_group"] . $f->fields["highlighted_population"])));

//$f->groups["g15"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["saber11"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card("create", array(
        "title" => "Datos complementarios",
        "content" => $f,
        "header-back" => $back
));
echo($card);
?>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const sisbenGroup = document.getElementById("<?php echo($f->get_FieldId("sisben_group")); ?>");
        const sisbenSubgroup = document.getElementById("<?php echo($f->get_FieldId("sisben_subgroup")); ?>");
        sisbenGroup.addEventListener("change", (e) => {
            const selectedSisbenGroup = e.target.value;
            let sisbenSubgroups = [];
            switch (selectedSisbenGroup) {
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
