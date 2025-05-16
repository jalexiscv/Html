<?php

//[services]------------------------------------------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Sie_Registrations."));
//[models]--------------------------------------------------------------------------------------------------------------
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$magreements = model("App\Modules\Sie\Models\Sie_Agreements");
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$mcountries = model("App\Modules\Sie\Models\Sie_Countries");
$mregions = model("App\Modules\Sie\Models\Sie_Regions");
$mcities = model("App\Modules\Sie\Models\Sie_Cities");
$minstitutions = model("App\Modules\Sie\Models\Sie_Institutions");
$mgroups = model("App\Modules\Sie\Models\Sie_Groups");
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
$r["registration"] = $f->get_Value("registration", pk());
$r["country"] = $f->get_Value("country");
$r["region"] = $f->get_Value("region");
$r["city"] = $f->get_Value("city");
$r["agreement"] = $f->get_Value("agreement");
$r["agreement_country"] = $f->get_Value("agreement_country");
$r["agreement_region"] = $f->get_Value("agreement_region");
$r["agreement_city"] = $f->get_Value("agreement_city");
$r["agreement_institution"] = $f->get_Value("agreement_institution");
$r["agreement_group"] = $f->get_Value("agreement_group");

$r["campus"] = $f->get_Value("campus");
$r["shifts"] = $f->get_Value("shifts");
$r["group"] = $f->get_Value("group");
$r["period"] = $f->get_Value("period");
$r["journey"] = $f->get_Value("journey");
$r["program"] = $f->get_Value("program");
$r["first_name"] = $f->get_Value("first_name");
$r["second_name"] = $f->get_Value("second_name");
$r["first_surname"] = $f->get_Value("first_surname");
$r["second_surname"] = $f->get_Value("second_surname");

$r["identification_type"] = $f->get_Value("identification_type");
$r["identification_number"] = $f->get_Value("identification_number");
$r["identification_place"] = $f->get_Value("identification_place");
$r["identification_date"] = $f->get_Value("identification_date");
$r["identification_country"] = $f->get_Value("identification_country", "CO");
$r["identification_region"] = $f->get_Value("identification_region");
$r["identification_city"] = $f->get_Value("identification_city");

$r["gender"] = $f->get_Value("gender");

$r["email_address"] = $f->get_Value("email_address");
$r["email_institutional"] = $f->get_Value("email_institutional");

$r["phone"] = $f->get_Value("phone");
$r["mobile"] = $f->get_Value("mobile");
$r["birth_date"] = $f->get_Value("birth_date");
$r["birth_country"] = $f->get_Value("birth_country", "CO");
$r["birth_region"] = $f->get_Value("birth_region");
$r["birth_city"] = $f->get_Value("birth_city");
$r["address"] = $f->get_Value("address");
$r["residence_country"] = $f->get_Value("residence_country");
$r["residence_region"] = $f->get_Value("residence_region");
$r["residence_city"] = $f->get_Value("residence_city");
$r["neighborhood"] = $f->get_Value("neighborhood");
$r["area"] = $f->get_Value("area");
$r["stratum"] = $f->get_Value("stratum");
$r["transport_method"] = $f->get_Value("transport_method");
$r["sisben_group"] = $f->get_Value("sisben_group");
$r["sisben_subgroup"] = $f->get_Value("sisben_subgroup");
$r["document_issue_place"] = $f->get_Value("document_issue_place");
$r["blood_type"] = $f->get_Value("blood_type");
$r["marital_status"] = $f->get_Value("marital_status");
$r["number_children"] = $f->get_Value("number_children");
$r["military_card"] = $f->get_Value("military_card");
$r["ars"] = $f->get_Value("ars");
$r["insurer"] = $f->get_Value("insurer");
$r["eps"] = $f->get_Value("eps");
$r["education_level"] = $f->get_Value("education_level");
$r["occupation"] = $f->get_Value("occupation");
$r["health_regime"] = $f->get_Value("health_regime");
$r["document_issue_date"] = $f->get_Value("document_issue_date");
$r["saber11"] = $f->get_Value("saber11");
$r["graduation_certificate"] = $f->get_Value("graduation_certificate");
$r["military_id"] = $f->get_Value("military_id");
$r["diploma"] = $f->get_Value("diploma");
$r["icfes_certificate"] = $f->get_Value("icfes_certificate");
$r["utility_bill"] = $f->get_Value("utility_bill");
$r["sisben_certificate"] = $f->get_Value("sisben_certificate");
$r["address_certificate"] = $f->get_Value("address_certificate");
$r["electoral_certificate"] = $f->get_Value("electoral_certificate");
$r["photo_card"] = $f->get_Value("photo_card");
$r["observations"] = $f->get_Value("observations");
$r["status"] = $f->get_Value("status");
$r["author"] = $f->get_Value("author", safe_get_user());
$r["ticket"] = $f->get_Value("ticket");
$r["interview"] = $f->get_Value("interview");
$r["linkage_type"] = $f->get_Value("linkage_type");
$r["ethnic_group"] = $f->get_Value("ethnic_group");
$r["indigenous_people"] = $f->get_Value("indigenous_people");
$r["afro_descendant"] = $f->get_Value("afro_descendant");
$r["disability"] = $f->get_Value("disability");
$r["disability_type"] = $f->get_Value("disability_type");
$r["exceptional_ability"] = $f->get_Value("exceptional_ability");
$r["responsible"] = $f->get_Value("responsible");
$r["responsible_relationship"] = $f->get_Value("responsible_relationship");
$r["identified_population_group"] = $f->get_Value("identified_population_group");
$r["highlighted_population"] = $f->get_Value("highlighted_population");
$r["num_people_depending_on_you"] = $f->get_Value("num_people_depending_on_you");
$r["num_people_living_with_you"] = $f->get_Value("num_people_living_with_you");
$r["responsible_phone"] = $f->get_Value("responsible_phone");
$r["num_people_contributing_economically"] = $f->get_Value("num_people_contributing_economically");
$r["first_in_family_to_study_university"] = $f->get_Value("first_in_family_to_study_university");
$r["border_population"] = $f->get_Value("border_population");
$r["observations_academic"] = $f->get_Value("observations_academic");
$r["import"] = $f->get_Value("import");
$r["moment"] = $f->get_Value("moment");
$r["snies_updated_at"] = $f->get_Value("snies_updated_at");
$r["photo"] = $f->get_Value("photo");
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");

$r["college"] = $f->get_Value("college");
$r["college_year"] = $f->get_Value("college_year");

$r["ac"] = $f->get_Value("ac");
$r["ac_score"] = $f->get_Value("ac_score");
$r["ek"] = $f->get_Value("ek");
$r["ek_score"] = $f->get_Value("ek_score");
$r["ac_date"] = $f->get_Value("ac_date");
$r["ac_document_type"] = $f->get_Value("ac_document_type");
$r["ac_document_number"] = $f->get_Value("ac_document_number");

$r["snies_id_validation_requisite"] = $f->get_Value("snies_id_validation_requisite");

$back = "/sie/students/list/{$oid}";

$agreements = array(array("value" => "", "label" => "- No aplica"));
$agreements = array_merge($agreements, $magreements->get_SelectData());

$countries = array(array("value" => "", "label" => "Seleccione un país"));
$countries = array_merge($countries, $mcountries->get_SelectData());

$regions = array(array("value" => "", "label" => "Seleccione un region"));
$cities = array(array("value" => "", "label" => "Seleccione un ciudad"));

$institutions = array(array("value" => "", "label" => "Seleccione una institución"));
$institutions = array_merge($institutions, $minstitutions->get_SelectData());

$groups = array(array("value" => "", "label" => "Seleccione un grupo"));
$groups = array_merge($groups, $mgroups->getSelectData($r["agreement_institution"]));

$programs = array(array("value" => "", "label" => "Seleccione un programa"),);
$programs = array_merge($programs, $mprograms->get_SelectData());

$birth_region = array(array("value" => "", "label" => "Seleccione una región"),);
$cities_birth = array(array("value" => "", "label" => "Seleccione una ciudad"),);
$birth_region = array_merge($birth_region, $mregions->get_SelectData($r["birth_country"]));
$cities_birth = array_merge($cities_birth, $mcities->get_SelectData($r["birth_region"]));

$regions_residence = array(array("value" => "", "label" => "Seleccione una región"),);
$cities_residence = array(array("value" => "", "label" => "Seleccione una ciudad"),);
$regions_residence = array_merge($regions_residence, $mregions->get_SelectData($r["residence_country"]));
$cities_residence = array_merge($cities_residence, $mcities->get_SelectData($r["residence_region"]));


$subgroups = array();
if ($r["sisben_group"] == "A") {
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
} else {
    $subgroups = array(
        array("label" => "No aplica", "value" => ""),
    );
}


$agreement_regions = array(array("value" => "", "label" => "Seleccione una región"));
$agreement_regions = array_merge($agreement_regions, $mregions->get_SelectData($r["agreement_country"]));
$agreement_cities = array(array("value" => "", "label" => "Seleccione una ciudad"));
$agreement_cities = array_merge($agreement_cities, $mcities->get_SelectData($r["agreement_region"]));


$identification_regions = array(array("value" => "", "label" => "Seleccione una región"));
$identification_regions = array_merge($identification_regions, $mregions->get_SelectData($r["identification_country"]));
$identification_cities = array(array("value" => "", "label" => "Seleccione una ciudad"));
$identification_cities = array_merge($identification_cities, $mcities->get_SelectData($r["identification_region"]));


//[fields]----------------------------------------------------------------------------------------------------------------
$f->fields["registration"] = $f->get_FieldText("registration", array("value" => @$r["registration"], "proportion" => "col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["country"] = $f->get_FieldText("country", array("value" => @$r["country"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["region"] = $f->get_FieldText("region", array("value" => @$r["region"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["city"] = $f->get_FieldText("city", array("value" => @$r["city"], "proportion" => "col-md-3 col-sm-12 col-12"));

$f->fields["agreement"] = $f->get_FieldSelect("agreement", array("selected" => @$r["agreement"], "data" => $agreements, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["agreement_country"] = $f->get_FieldSelect("agreement_country", array("selected" => @$r["agreement_country"], "data" => $countries, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["agreement_region"] = $f->get_FieldSelect("agreement_region", array("selected" => @$r["agreement_region"], "data" => $agreement_regions, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["agreement_city"] = $f->get_FieldSelect("agreement_city", array("selected" => @$r["agreement_city"], "data" => $agreement_cities, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["agreement_institution"] = $f->get_FieldSelect("agreement_institution", array("selected" => @$r["agreement_institution"], "data" => $institutions, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["agreement_group"] = $f->get_FieldSelect("agreement_group", array("selected" => @$r["agreement_group"], "data" => $groups, "proportion" => "col-md-4 col-sm-12 col-12"));


//$f->fields["campus"] = $f->get_FieldText("campus", array("value" => @$r["campus"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
//$f->fields["shifts"] = $f->get_FieldText("shifts", array("value" => @$r["shifts"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
//$f->fields["group"] = $f->get_FieldText("group", array("value" => @$r["group"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["period"] = $f->get_FieldSelect("period", array("selected" => @$r["period"], "data" => LIST_PERIODS, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["journey"] = $f->get_FieldSelect("journey", array("selected" => @$r["journey"], "data" => LIST_JOURNEYS, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["program"] = $f->get_FieldSelect("program", array("selected" => @$r["program"], "data" => $programs, "proportion" => "col-12"));

$f->fields["first_name"] = $f->get_FieldText("first_name", array("value" => @$r["first_name"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["second_name"] = $f->get_FieldText("second_name", array("value" => @$r["second_name"], "proportion" => "col-md-3  col-sm-12 col-12"));
$f->fields["first_surname"] = $f->get_FieldText("first_surname", array("value" => @$r["first_surname"], "proportion" => "col-md-3  col-sm-12 col-12"));
$f->fields["second_surname"] = $f->get_FieldText("second_surname", array("value" => @$r["second_surname"], "proportion" => "col-md-3  col-sm-12 col-12"));

//1.1. Identificación
$f->fields["identification_type"] = $f->get_FieldSelect("identification_type", array("selected" => @$r["identification_type"], "data" => LIST_IDENTIFICATION_TYPES, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["identification_number"] = $f->get_FieldText("identification_number", array("value" => @$r["identification_number"], "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["identification_date"] = $f->get_FieldDate("identification_date", array("value" => @$r["identification_date"], "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["identification_place"] = $f->get_FieldText("identification_place", array("value" => @$r["identification_place"], "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["identification_country"] = $f->get_FieldSelect("identification_country", array("selected" => @$r["identification_country"], "data" => $countries, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["identification_region"] = $f->get_FieldSelect("identification_region", array("selected" => @$r["identification_region"], "data" => $identification_regions, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["identification_city"] = $f->get_FieldSelect("identification_city", array("selected" => @$r["identification_city"], "data" => $identification_cities, "proportion" => "col-md-4 col-sm-12 col-12"));


$f->fields["gender"] = $f->get_FieldSelect("gender", array("selected" => @$r["gender"], "data" => LIST_SEX, "proportion" => "col-md-3 col-sm-12 col-12"));

$f->fields["email_address"] = $f->get_FieldText("email_address", array("value" => @$r["email_address"], "proportion" => "col-md-4 col-12"));
$f->fields["email_institutional"] = $f->get_FieldText("email_institutional", array("value" => @$r["email_institutional"], "proportion" => "col-md-4 col-12"));

$f->fields["phone"] = $f->get_FieldText("phone", array("value" => @$r["phone"], "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["mobile"] = $f->get_FieldText("mobile", array("value" => @$r["mobile"], "proportion" => "col-md-4 col-sm-12 col-12"));

$f->fields["birth_date"] = $f->get_FieldDate("birth_date", array("value" => @$r["birth_date"], "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["birth_country"] = $f->get_FieldSelect("birth_country", array("selected" => @$r["birth_country"], "data" => $countries, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["birth_region"] = $f->get_FieldSelect("birth_region", array("selected" => @$r["birth_region"], "data" => $birth_region, "proportion" => "col-md-4 col-sm-12 col-12"));

$f->fields["birth_city"] = $f->get_FieldSelect("birth_city", array("selected" => @$r["birth_city"], "data" => $cities_birth, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["address"] = $f->get_FieldText("address", array("value" => @$r["address"], "proportion" => "col-md-8 col-sm-12 col-12"));

$f->fields["residence_country"] = $f->get_FieldSelect("residence_country", array("selected" => @$r["residence_country"], "data" => $countries, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["residence_region"] = $f->get_FieldSelect("residence_region", array("selected" => @$r["residence_region"], "data" => $regions_residence, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["residence_city"] = $f->get_FieldSelect("residence_city", array("selected" => @$r["residence_city"], "data" => $cities_residence, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["neighborhood"] = $f->get_FieldText("neighborhood", array("value" => @$r["neighborhood"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["area"] = $f->get_FieldSelect("area", array("selected" => @$r["area"], "data" => LIST_AREAS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["stratum"] = $f->get_FieldSelect("stratum", array("selected" => @$r["stratum"], "data" => LIST_STRATUMS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["transport_method"] = $f->get_FieldSelect("transport_method", array("selected" => @$r["transport_method"], "data" => LIST_TRANSPORTS, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["sisben_group"] = $f->get_FieldSelect("sisben_group", array("selected" => @$r["sisben_group"], "data" => LIST_SISBEN_GROUPS, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["sisben_subgroup"] = $f->get_FieldSelect("sisben_subgroup", array("selected" => @$r["sisben_subgroup"], "data" => $subgroups, "proportion" => "col-md-4 col-sm-12 col-12"));

$f->fields["document_issue_place"] = $f->get_FieldText("document_issue_place", array("value" => @$r["document_issue_place"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["blood_type"] = $f->get_FieldSelect("blood_type", array("selected" => @$r["blood_type"], "data" => LIST_BLOOD, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["marital_status"] = $f->get_FieldSelect("marital_status", array("selected" => @$r["marital_status"], "data" => LIST_MARITALS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["number_children"] = $f->get_FieldNumber("number_children", array("value" => @$r["number_children"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["military_card"] = $f->get_FieldText("military_card", array("value" => @$r["military_card"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ars"] = $f->get_FieldSelect("ars", array("selected" => @$r["ars"], "data" => LIST_ARS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["insurer"] = $f->get_FieldSelect("insurer", array("selected" => @$r["insurer"], "data" => LIST_INSURANCES, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["eps"] = $f->get_FieldSelect("eps", array("selected" => @$r["eps"], "data" => LIST_EPS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["education_level"] = $f->get_FieldSelect("education_level", array("selected" => @$r["education_level"], "data" => LIST_EDUCATION_LEVELS, "proportion" => "col-md-4 col-sm-12 col-12"));

$f->fields["occupation"] = $f->get_FieldSelect("occupation", array("selected" => @$r["occupation"], "data" => LIST_OCCUPATIONS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["health_regime"] = $f->get_FieldText("health_regime", array("value" => @$r["health_regime"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["document_issue_date"] = $f->get_FieldDate("document_issue_date", array("value" => @$r["document_issue_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["saber11"] = $f->get_FieldText("saber11", array("value" => @$r["saber11"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["graduation_certificate"] = $f->get_FieldText("graduation_certificate", array("value" => @$r["graduation_certificate"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["military_id"] = $f->get_FieldText("military_id", array("value" => @$r["military_id"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["diploma"] = $f->get_FieldText("diploma", array("value" => @$r["diploma"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["icfes_certificate"] = $f->get_FieldText("icfes_certificate", array("value" => @$r["icfes_certificate"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["utility_bill"] = $f->get_FieldText("utility_bill", array("value" => @$r["utility_bill"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sisben_certificate"] = $f->get_FieldText("sisben_certificate", array("value" => @$r["sisben_certificate"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["address_certificate"] = $f->get_FieldText("address_certificate", array("value" => @$r["address_certificate"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["electoral_certificate"] = $f->get_FieldText("electoral_certificate", array("value" => @$r["electoral_certificate"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["photo_card"] = $f->get_FieldText("photo_card", array("value" => @$r["photo_card"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["observations"] = $f->get_FieldText("observations", array("value" => @$r["observations"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["status"] = $f->get_FieldText("status", array("value" => @$r["status"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["ticket"] = $f->get_FieldText("ticket", array("value" => @$r["ticket"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["interview"] = $f->get_FieldText("interview", array("value" => @$r["interview"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["linkage_type"] = $f->get_FieldSelect("linkage_type", array("selected" => @$r["linkage_type"], "data" => LIST_LINKAGE_TYPES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["indigenous_people"] = $f->get_FieldText("indigenous_people", array("value" => @$r["indigenous_people"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["afro_descendant"] = $f->get_FieldText("afro_descendant", array("value" => @$r["afro_descendant"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["disability"] = $f->get_FieldSelect("disability", array("selected" => @$r["disability"], "data" => LIST_NY, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["disability_type"] = $f->get_FieldSelect("disability_type", array("selected" => @$r["disability_type"], "data" => LIST_TYPES_OF_DISABILITIES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["exceptional_ability"] = $f->get_FieldSelect("exceptional_ability", array("selected" => @$r["exceptional_ability"], "data" => LIST_OF_EXCEPTIONAL_CAPABILITIES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields['responsible'] = $f->get_FieldText("responsible", array("value" => @$r["responsible"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields['responsible_relationship'] = $f->get_FieldSelect("responsible_relationship", array("selected" => @$r["responsible_relationship"], "data" => LIST_RESPONSIBLE_RELATIONSHIP, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields['responsible_phone'] = $f->get_FieldText("responsible_phone", array("value" => @$r["responsible_phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields['num_people_living_with_you'] = $f->get_FieldText("num_people_living_with_you", array("value" => @$r["num_people_living_with_you"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields['num_people_contributing_economically'] = $f->get_FieldSelect("num_people_contributing_economically", array("selected" => @$r["num_people_contributing_economically"], "data" => LIST_0_10, "proportion" => "col-md-8 col-sm-12 col-12"));
$f->fields['num_people_depending_on_you'] = $f->get_FieldSelect("num_people_depending_on_you", array("selected" => @$r["num_people_depending_on_you"], "data" => LIST_0_10, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields['first_in_family_to_study_university'] = $f->get_FieldSelect("first_in_family_to_study_university", array("selected" => @$r["first_in_family_to_study_university"], "data" => LIST_YN, "proportion" => "col-md-8 col-sm-12 col-12"));
$f->fields['border_population'] = $f->get_FieldSelect("border_population", array("selected" => @$r["border_population"], "data" => LIST_YN, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields['identified_population_group'] = $f->get_FieldSelect("identified_population_group", array("selected" => @$r["identified_population_group"], "data" => LIST_IDENTIFIED_POPULATION_GROUP, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields['highlighted_population'] = $f->get_FieldSelect("highlighted_population", array("selected" => @$r["highlighted_population"], "data" => LIST_HIGHLIGHTED_POPULATION, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["college"] = $f->get_FieldText("college", array("value" => @$r["college"], "proportion" => "col-md-8 col-sm-12 col-12"));
$f->fields["college_year"] = $f->get_FieldText("college_year", array("value" => @$r["college_year"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["observations_academic"] = $f->get_FieldText("observations_academic", array("value" => @$r["observations_academic"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["import"] = $f->get_FieldText("import", array("value" => @$r["import"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["moment"] = $f->get_FieldText("moment", array("value" => @$r["moment"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["snies_updated_at"] = $f->get_FieldText("snies_updated_at", array("value" => @$r["snies_updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["photo"] = $f->get_FieldText("photo", array("value" => @$r["photo"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => @$r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => @$r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => @$r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["ac"] = $f->get_FieldText("ac", array("value" => @$r["ac"], "proportion" => "col-sm-3 col-12"));
$f->fields["ac_score"] = $f->get_FieldText("ac_score", array("value" => @$r["ac_score"], "proportion" => "col-sm-3 col-12"));
$f->fields["ac_date"] = $f->get_FieldDate("ac_date", array("value" => @$r["ac_date"], "proportion" => "col-sm-3 col-12"));
$f->fields["ac_document_type"] = $f->get_FieldSelect("ac_document_type", array("selected" => @$r["ac_document_type"], "data" => LIST_IDENTIFICATION_TYPES, "proportion" => "col-sm-3 col-12"));
$f->fields["ac_document_number"] = $f->get_FieldText("ac_document_number", array("value" => @$r["ac_document_number"], "proportion" => "col-sm-3 col-12"));
$f->fields["ek"] = $f->get_FieldText("ek", array("value" => @$r["ek"], "proportion" => "col-sm-3 col-12"));
$f->fields["ek_score"] = $f->get_FieldText("ek_score", array("value" => @$r["ek_score"], "proportion" => "col-sm-3 col-12"));

$f->fields["snies_id_validation_requisite"] = $f->get_FieldSelect("snies_id_validation_requisite", array("selected" => @$r["snies_id_validation_requisite"], "data" => LIST_SNIES_ID_VALIDATION_REQUISITE, "proportion" => "col-sm-4 col-12"));

// Nuevos campos 2025
$f->fields["ethnic_group"] = $f->get_FieldSelect("ethnic_group", array("selected" => @$r["ethnic_group"], "data" => LIST_ETHNIC_GROUPS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["education_level_father"] = $f->get_FieldSelect("education_level_father", array("selected" => @$r["education_level_father"], "data" => LIST_PARENTS_EDUCATION_LEVELS, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["education_level_mother"] = $f->get_FieldSelect("education_level_mother", array("selected" => @$r["education_level_mother"], "data" => LIST_PARENTS_EDUCATION_LEVELS, "proportion" => "col-md-6 col-sm-12 col-12"));

$f->fields["economic_dependency"] = $f->get_FieldSelect("economic_dependency", array("selected" => @$r["economic_dependency"], "data" => LIST_DEPENDENCY_ECONOMIC, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["type_of_funding"] = $f->get_FieldSelect("type_of_funding", array("selected" => @$r["type_of_funding"], "data" => LIST_FUNDING, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["current_occupation"] = $f->get_FieldSelect("current_occupation", array("selected" => @$r["current_occupation"], "data" => LIST_CURRENT_OCCUPATIONS, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["type_of_work"] = $f->get_FieldSelect("type_of_work", array("selected" => @$r["type_of_work"], "data" => LIST_WORK_TYPES, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["weekly_hours_worked"] = $f->get_FieldSelect("weekly_hours_worked", array("selected" => @$r["weekly_hours_worked"], "data" => LIST_HOURS_WORK, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["monthly_income"] = $f->get_FieldSelect("monthly_income", array("selected" => @$r["monthly_income"], "data" => LIST_MONTHLY_INCOMES, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["company_name"] = $f->get_FieldText("company_name", array("value" => @$r["company_name"], "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["company_position"] = $f->get_FieldSelect("company_position", array("selected" => @$r["company_position"], "data" => LIST_JOB_POSITIONS, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["productive_sector"] = $f->get_FieldSelect("productive_sector", array("selected" => @$r["productive_sector"], "data" => LIST_PRODUCTIVE_SECTORS, "proportion" => "col-md-4 col-sm-12 col-12"));

$f->fields["type_of_housing"] = $f->get_FieldSelect("type_of_housing", array("value" => @$r["type_of_housing"], "data" => LIST_HOUSING_TYPE, "proportion" => "col-md-6 col-sm-12 col-12"));


$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g011"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["registration"] . $f->fields["period"] . $f->fields["journey"])));
$f->groups["g012"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["agreement"] . $f->fields["agreement_country"] . $f->fields["agreement_region"])));
$f->groups["g013"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["agreement_city"] . $f->fields["agreement_institution"] . $f->fields["agreement_group"])));
//$f->groups["g4"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["campus"].$f->fields["shifts"].$f->fields["group"])));
$f->groups["g15"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["program"])));

$f->groups["g026"] = $f->get_Group(array("legend" => "1. Perfil Personal", "fields" => ($f->fields["first_name"] . $f->fields["second_name"] . $f->fields["first_surname"] . $f->fields["second_surname"])));
$f->groups["g028"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["email_address"] . $f->fields["email_institutional"] . $f->fields["phone"])));
$f->groups["g029"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["mobile"] . $f->fields["gender"] . $f->fields["blood_type"])));

$f->groups["g11f1"] = $f->get_Group(array("legend" => "1.1. Identificación", "fields" => ($f->fields["identification_type"] . $f->fields["identification_number"] . $f->fields["identification_date"])));
$f->groups["g11f2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["identification_country"] . $f->fields["identification_region"] . $f->fields["identification_city"])));

$f->groups["g039"] = $f->get_Group(array("legend" => "1.2. Procedencia", "fields" => ($f->fields["birth_date"] . $f->fields["birth_country"] . $f->fields["birth_region"])));
$f->groups["g310"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["birth_city"])));

$f->groups["g311"] = $f->get_Group(array("legend" => "1.3. Residencia", "fields" => ($f->fields["residence_country"] . $f->fields["residence_region"] . $f->fields["residence_city"])));
$f->groups["g312"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["address"] . $f->fields["neighborhood"])));
$f->groups["g313"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["area"] . $f->fields["stratum"])));

$f->groups["g413"] = $f->get_Group(array("legend" => "2. Información de la Educación Superior (SNIES)", "fields" => ($f->fields["linkage_type"] . $f->fields["disability"] . $f->fields["disability_type"])));
$f->groups["g414"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["transport_method"] . $f->fields["sisben_group"] . $f->fields["sisben_subgroup"])));
$f->groups["g415"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["document_issue_place"] . $f->fields["marital_status"] . $f->fields["number_children"])));
$f->groups["g416"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["military_card"] . $f->fields["eps"] . $f->fields["education_level"])));
$f->groups["g418"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["health_regime"] . $f->fields["document_issue_date"] . $f->fields["snies_id_validation_requisite"])));

$f->groups["g518"] = $f->get_Group(array("legend" => "2.1. Pruebas Saber 11 y Competencias", "fields" => ($f->fields["college"] . $f->fields["college_year"])));
$f->groups["g519"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["ac"] . $f->fields["ac_score"] . $f->fields["ac_date"] . $f->fields["ac_document_type"])));
$f->groups["g520"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["ac_document_number"] . $f->fields["ek"] . $f->fields["ek_score"])));

$f->groups["g620"] = $f->get_Group(array("legend" => "3. Contacto de emergencia / Responsable legal", "fields" => ($f->fields["responsible"] . $f->fields["responsible_relationship"] . $f->fields["responsible_phone"])));

$f->groups["gf301"] = $f->get_Group(array("legend" => "3.1. Información familiar", "fields" => ($f->fields["num_people_living_with_you"] . $f->fields["num_people_contributing_economically"])));
$f->groups["gf302"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["num_people_depending_on_you"] . $f->fields["education_level_father"] . $f->fields["education_level_mother"] . $f->fields["type_of_housing"])));

$f->groups["g401"] = $f->get_Group(array("legend" => "4. Información Laboral", "fields" => ($f->fields["economic_dependency"] . $f->fields["type_of_funding"] . $f->fields["current_occupation"])));
$f->groups["g402"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["type_of_work"] . $f->fields["weekly_hours_worked"] . $f->fields["monthly_income"])));
$f->groups["g403"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["company_name"] . $f->fields["company_position"] . $f->fields["productive_sector"])));

$f->groups["g622"] = $f->get_Group(array("legend" => "5. Información adicional", "fields" => ($f->fields["first_in_family_to_study_university"] . $f->fields["border_population"])));
$f->groups["g623"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["highlighted_population"] . $f->fields["ethnic_group"] . $f->fields["identified_population_group"])));


//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("create", array(
    "header-title" => "Crear estudiante",
    "content" => $f,
    "header-back" => $back
));
echo($card);
$fid = $f->get_fid();
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var agreement_country = document.getElementById('<?php echo($fid);?>_agreement_country');
        var agreement_region = document.getElementById('<?php echo($fid);?>_agreement_region');
        var agreement_city = document.getElementById('<?php echo($fid);?>_agreement_city');
        var agreement_institution = document.getElementById('<?php echo($fid);?>_agreement_institution');
        var agreement_group = document.getElementById('<?php echo($fid);?>_agreement_group');
        var identification_country = document.getElementById('<?php echo($fid);?>_identification_country');
        var identification_region = document.getElementById('<?php echo($fid);?>_identification_region');
        var identification_city = document.getElementById('<?php echo($fid);?>_identification_city');

        function showLoading() {
            const overlay = document.getElementById('loading-overlay');
            overlay.style.display = 'flex'; // Mostrar el overlay
        }

        function hideLoading() {
            const overlay = document.getElementById('loading-overlay');
            overlay.style.display = 'none'; // Ocultar el overlay
        }

        agreement_institution.addEventListener('change', function () {
            var institution = this.value;
            showLoading();
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/sie/api/registrations/json/groups/' + institution, true);
            xhr.onload = function () {
                if (this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    agreement_group.innerHTML = '<option value="">Seleccione un grupo</option>'; // Inicializar opciones
                    data.forEach(function (group) {
                        var option = document.createElement('option');
                        option.value = group.value;
                        option.text = group.label;
                        agreement_group.add(option);
                    });
                }
                hideLoading();
            };
            xhr.onerror = function () {
                console.error("Error al cargar los grupos.");
                hideLoading();
            };
            xhr.send();
        });

        agreement_country.addEventListener('change', function () {
            var country = this.value;
            showLoading();
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/sie/api/registrations/json/regions/' + country, true);
            xhr.onload = function () {
                if (this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    agreement_region.innerHTML = '<option value="">Seleccione una región</option>';
                    data.forEach(function (region) {
                        var option = document.createElement('option');
                        option.value = region.value;
                        option.text = region.label;
                        agreement_region.add(option);
                    });
                    // Reset agreement_city cuando se cambia el país
                    agreement_city.innerHTML = '<option value="">Seleccione una ciudad</option>';
                }
                hideLoading();
            };
            xhr.onerror = function () {
                console.error("Error al cargar las regiones.");
                hideLoading();
            };
            xhr.send();
        });

        agreement_region.addEventListener('change', function () {
            var region = this.value;
            showLoading();
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/sie/api/registrations/json/cities/' + region, true);
            xhr.onload = function () {
                if (this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    agreement_city.innerHTML = '<option value="">Seleccione una ciudad</option>';
                    data.forEach(function (city) {
                        var option = document.createElement('option');
                        option.value = city.value;
                        option.text = city.label;
                        agreement_city.add(option);
                    });
                }
                hideLoading();
            };
            xhr.onerror = function () {
                console.error("Error al cargar las ciudades.");
                hideLoading();
            };
            xhr.send();
        });

        identification_country.addEventListener('change', function () {
            var country = this.value;
            showLoading();
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/sie/api/registrations/json/regions/' + country, true);
            xhr.onload = function () {
                if (this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    identification_region.innerHTML = '<option value="">Seleccione una región</option>';
                    data.forEach(function (region) {
                        var option = document.createElement('option');
                        option.value = region.value;
                        option.text = region.label;
                        identification_region.add(option);
                    });
                    // Reset agreement_city cuando se cambia el país
                    identification_city.innerHTML = '<option value="">Seleccione una ciudad</option>';
                }
                hideLoading();
            };
            xhr.onerror = function () {
                console.error("Error al cargar las regiones.");
                hideLoading();
            };
            xhr.send();
        });

        identification_region.addEventListener('change', function () {
            var region = this.value;
            showLoading();
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/sie/api/registrations/json/cities/' + region, true);
            xhr.onload = function () {
                if (this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    identification_city.innerHTML = '<option value="">Seleccione una ciudad</option>';
                    data.forEach(function (city) {
                        var option = document.createElement('option');
                        option.value = city.value;
                        option.text = city.label;
                        identification_city.add(option);
                    });
                }
                hideLoading();
            };
            xhr.onerror = function () {
                console.error("Error al cargar las ciudades.");
                hideLoading();
            };
            xhr.send();
        });

        // Residencia - Procedencia
        var residence_country = document.getElementById('<?php echo($fid);?>_residence_country');
        var residence_region = document.getElementById('<?php echo($fid);?>_residence_region');
        var residence_city = document.getElementById('<?php echo($fid);?>_residence_city');

        residence_country.addEventListener('change', function () {
            var country = this.value;
            showLoading();
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/sie/api/registrations/json/regions/' + country, true);
            xhr.onload = function () {
                if (this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    residence_region.innerHTML = '<option value="">Seleccione una región</option>';
                    data.forEach(function (region) {
                        var option = document.createElement('option');
                        option.value = region.value;
                        option.text = region.label;
                        residence_region.add(option);
                    });
                    // Reset agreement_city cuando se cambia el país
                    residence_city.innerHTML = '<option value="">Seleccione una ciudad</option>';
                }
                hideLoading();
            };
            xhr.onerror = function () {
                console.error("Error al cargar las regiones.");
                hideLoading();
            };
            xhr.send();
        });

        residence_region.addEventListener('change', function () {
            var region = this.value;
            showLoading();
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/sie/api/registrations/json/cities/' + region, true);
            xhr.onload = function () {
                if (this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    residence_city.innerHTML = '<option value="">Seleccione una ciudad</option>';
                    data.forEach(function (city) {
                        var option = document.createElement('option');
                        option.value = city.value;
                        option.text = city.label;
                        residence_city.add(option);
                    });
                }
                hideLoading();
            };
            xhr.onerror = function () {
                console.error("Error al cargar las ciudades.");
                hideLoading();
            };
            xhr.send();
        });


        var birth_country = document.getElementById('<?php echo($fid);?>_birth_country');
        var birth_region = document.getElementById('<?php echo($fid);?>_birth_region');
        var birth_city = document.getElementById('<?php echo($fid);?>_birth_city');

        birth_country.addEventListener('change', function () {
            var country = this.value;
            showLoading();
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/sie/api/registrations/json/regions/' + country, true);
            xhr.onload = function () {
                if (this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    birth_region.innerHTML = '<option value="">Seleccione una región</option>';
                    data.forEach(function (region) {
                        var option = document.createElement('option');
                        option.value = region.value;
                        option.text = region.label;
                        birth_region.add(option);
                    });
                    // Reset agreement_city cuando se cambia el país
                    birth_city.innerHTML = '<option value="">Seleccione una ciudad</option>';
                }
                hideLoading();
            };
            xhr.onerror = function () {
                console.error("Error al cargar las regiones.");
                hideLoading();
            };
            xhr.send();
        });

        birth_region.addEventListener('change', function () {
            var region = this.value;
            showLoading();
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/sie/api/registrations/json/cities/' + region, true);
            xhr.onload = function () {
                if (this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    birth_city.innerHTML = '<option value="">Seleccione una ciudad</option>';
                    data.forEach(function (city) {
                        var option = document.createElement('option');
                        option.value = city.value;
                        option.text = city.label;
                        birth_city.add(option);
                    });
                }
                hideLoading();
            };
            xhr.onerror = function () {
                console.error("Error al cargar las ciudades.");
                hideLoading();
            };
            xhr.send();
        });

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
                default:
                    sisbenSubgroups = ["No aplica"];
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
<div id="loading-overlay" class="loading-overlay">
    <div class="spinner"></div>
</div>

<style>
    /* CSS */
    .loading-overlay {
        display: none; /* Oculto por defecto */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Fondo semitransparente */
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3; /* Color del borde */
        border-top: 5px solid #3498db; /* Color del spinner */
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>