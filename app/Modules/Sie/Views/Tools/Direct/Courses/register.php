<?php

//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Sie_Registrations."));
$server = service("server");
$request = service("request");
//[models]--------------------------------------------------------------------------------------------------------------
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$magreements = model("App\Modules\Sie\Models\Sie_Agreements");
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$mcountries = model("App\Modules\Sie\Models\Sie_Countries");
$mregions = model("App\Modules\Sie\Models\Sie_Regions");
$mcities = model("App\Modules\Sie\Models\Sie_Cities");
$minstitutions = model("App\Modules\Sie\Models\Sie_Institutions");
$mgroups = model("App\Modules\Sie\Models\Sie_Groups");
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
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


$rcourse = $request->getVar("course");

if (!empty($rcourse)) {
    $course = $mcourses->getCourse($rcourse);
    $course_name = $course["name"];
    $r['course'] = $f->get_Value("course", $course["course"]);
} else {
    $r['course'] = $f->get_Value("course");
    $course = $mcourses->getCourse($r['course']);
    $course_name = $course["name"];
}

$r['option'] = $f->get_Value("option", $request->getVar("option"));

$r["registration"] = $f->get_Value("registration", pk());
$r["country"] = $f->get_Value("country");
$r["region"] = $f->get_Value("region");
$r["city"] = $f->get_Value("city");
$r["agreement"] = $f->get_Value("agreement");
$r["agreement_country"] = $f->get_Value("agreement_country");
$r["agreement_region"] = $f->get_Value("agreement_region");
$r["agreement_city"] = $f->get_Value("agreement_city");
$r["agreement_institution"] = $f->get_Value("agreement_institution");
$r["campus"] = $f->get_Value("campus");
$r["shifts"] = $f->get_Value("shifts");
$r["group"] = $f->get_Value("group");
$r["period"] = $f->get_Value("period");
$r["journey"] = $f->get_Value("journey", "PA");
$r["program"] = $f->get_Value("program");
$r["first_name"] = $f->get_Value("first_name");
$r["second_name"] = $f->get_Value("second_name");
$r["first_surname"] = $f->get_Value("first_surname");
$r["second_surname"] = $f->get_Value("second_surname");

$r["identification_type"] = $f->get_Value("identification_type");
$r["identification_number"] = $f->get_Value("identification_number");
$r["identification_place"] = $f->get_Value("identification_place");
$r["identification_date"] = $f->get_Value("identification_date");

$r["gender"] = $f->get_Value("gender");

$r["email_address"] = $f->get_Value("email_address");
$r["confirm_email_address"] = $f->get_Value("confirm_email_address");

$r["phone"] = $f->get_Value("phone");
$r["mobile"] = $f->get_Value("mobile");
$r["birth_date"] = $f->get_Value("birth_date");
$r["birth_country"] = $f->get_Value("birth_country");
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

$r["number_children"] = $f->get_Value("number_children", "0");
$r["military_card"] = $f->get_Value("military_card");
$r["ars"] = $f->get_Value("ars");
$r["insurer"] = $f->get_Value("insurer");
$r["eps"] = $f->get_Value("eps");
$r["education_level"] = $f->get_Value("education_level");
$r["occupation"] = $f->get_Value("occupation");
$r["health_regime"] = $f->get_Value("health_regime");
$r["document_issue_date"] = $f->get_Value("document_issue_date");

$r["saber11"] = $f->get_Value("saber11");
$r["saber11_date"] = $f->get_Value("saber11_date");
$r["saber11_value"] = $f->get_Value("saber11_value");

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
$back = "/sie/tools/direct/courses/" . lpk();

$programs = array(array("value" => "", "label" => "Seleccione un programa"),);
$programs = array_merge($programs, $mprograms->get_SelectPreregistration());

$r["birth_city"] = $f->get_Value("birth_city");
if (!empty($r["birth_city"])) {
    $city = $mcities->get_City($r["birth_city"]);
    $r["birth_region"] = $city["region"];
    $r["birth_country"] = $city["country"];
} else {
    $r["birth_country"] = $f->get_Value("birth_country", "CO");
    $r["birth_region"] = $f->get_Value("birth_region", "076");
}

$regions_birth = array(array("value" => "", "label" => "Seleccione una región"),);
$cities_birth = array(array("value" => "", "label" => "Seleccione una ciudad"),);
$regions_birth = array_merge($regions_birth, $mregions->get_SelectData($r["birth_country"]));
$cities_birth = array_merge($cities_birth, $mcities->get_SelectData($r["birth_region"]));

$r["residence_city"] = $f->get_Value("residence_city");
if (!empty($r["residence_city"])) {
    $city = $mcities->get_City($r["residence_city"]);
    $r["residence_region"] = $city["region"];
    $r["residence_country"] = $city["country"];
} else {
    $r["residence_country"] = $f->get_Value("residence_country", "CO");
    $r["residence_region"] = $f->get_Value("residence_region", "076");
}

$regions_residence = array(array("value" => "", "label" => "Seleccione una región"),);
$cities_residence = array(array("value" => "", "label" => "Seleccione una ciudad"),);
$regions_residence = array_merge($regions_residence, $mregions->get_SelectData($r["residence_country"]));
$cities_residence = array_merge($cities_residence, $mcities->get_SelectData($r["residence_region"]));


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

$countries = array(array("value" => "", "label" => "Seleccione un país"));
$countries = array_merge($countries, $mcountries->get_SelectData());

$institutions = array(array("value" => "", "label" => "Seleccione una institución"));
$institutions = array_merge($institutions, $minstitutions->get_SelectData());

$groups = array(array("value" => "", "label" => "Seleccione un grupo"));
$groups = array_merge($groups, $mgroups->getSelectData($r["agreement_institution"]));

$agreements = array(array("value" => "", "label" => "- No aplica"));
$agreements = array_merge($agreements, $magreements->get_SelectData());
$agreement_regions = array(array("value" => "", "label" => "Seleccione una región"));
$agreement_regions = array_merge($agreement_regions, $mregions->get_SelectData($r["agreement_country"]));
$agreement_cities = array(array("value" => "", "label" => "Seleccione una ciudad"));
$agreement_cities = array_merge($agreement_cities, $mcities->get_SelectData($r["agreement_region"]));

//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("back", $back);
$f->add_HiddenField("option", $r['option']);
$f->fields["registration"] = $f->get_FieldText("registration", array("value" => $r["registration"], "proportion" => "col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["course"] = $f->get_FieldText("course", array("value" => $r["course"], "proportion" => "col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["journey"] = $f->get_FieldText("journey", array("value" => $r["journey"], "proportion" => "col-md-4 col-sm-12 col-12", "readonly" => true));

$f->fields["identification_type"] = $f->get_FieldSelect("identification_type", array("selected" => $r["identification_type"], "data" => LIST_IDENTIFICATION_TYPES, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["identification_number"] = $f->get_FieldText("identification_number", array("value" => $r["identification_number"], "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["first_name"] = $f->get_FieldText("first_name", array("value" => $r["first_name"], "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["second_name"] = $f->get_FieldText("second_name", array("value" => $r["second_name"], "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["first_surname"] = $f->get_FieldText("first_surname", array("value" => $r["first_surname"], "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["second_surname"] = $f->get_FieldText("second_surname", array("value" => $r["second_surname"], "proportion" => "col-md-4 col-sm-12 col-12"));


$f->fields["country"] = $f->get_FieldText("country", array("value" => $r["country"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["region"] = $f->get_FieldText("region", array("value" => $r["region"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["city"] = $f->get_FieldText("city", array("value" => $r["city"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["agreement"] = $f->get_FieldSelect("agreement", array("selected" => @$r["agreement"], "data" => $agreements, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["agreement_country"] = $f->get_FieldSelect("agreement_country", array("selected" => @$r["agreement_country"], "data" => $countries, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["agreement_region"] = $f->get_FieldSelect("agreement_region", array("selected" => @$r["agreement_region"], "data" => $agreement_regions, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["agreement_city"] = $f->get_FieldSelect("agreement_city", array("selected" => @$r["agreement_city"], "data" => $agreement_cities, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["agreement_institution"] = $f->get_FieldSelect("agreement_institution", array("selected" => @$r["agreement_institution"], "data" => $institutions, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["agreement_group"] = $f->get_FieldSelect("agreement_group", array("selected" => @$r["agreement_group"], "data" => $groups, "proportion" => "col-md-4 col-sm-12 col-12"));

$f->fields["campus"] = $f->get_FieldText("campus", array("value" => $r["campus"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["shifts"] = $f->get_FieldText("shifts", array("value" => $r["shifts"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["group"] = $f->get_FieldText("group", array("value" => $r["group"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["period"] = $f->get_FieldSelect("period", array("selected" => $r["period"], "data" => LIST_PERIODS_PREREGISTRATIONS, "proportion" => "col-md-4 col-sm-12 col-12"));

$f->fields["program"] = $f->get_FieldSelect("program", array("selected" => $r["program"], "data" => $programs, "proportion" => "col-md-6 col-12"));


$f->fields["identification_place"] = $f->get_FieldText("identification_place", array("value" => $r["identification_place"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["identification_date"] = $f->get_FieldDate("identification_date", array("value" => $r["identification_date"], "proportion" => "col-md-3 col-sm-12 col-12"));


$f->fields["email_address"] = $f->get_FieldText("email_address", array("value" => $r["email_address"], "proportion" => "col-md-6 col-12"));
$f->fields["confirm_email_address"] = $f->get_FieldText("confirm_email_address", array("value" => $r["confirm_email_address"], "proportion" => "col-md-6 col-12"));

$f->fields["gender"] = $f->get_FieldSelect("gender", array("selected" => $r["gender"], "data" => LIST_SEX, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["phone"] = $f->get_FieldText("phone", array("value" => $r["phone"], "proportion" => "col-md-4 col-12"));
$f->fields["mobile"] = $f->get_FieldText("mobile", array("value" => $r["mobile"], "proportion" => "col-md-4 col-sm-12 col-12"));

$f->fields["birth_date"] = $f->get_FieldDate("birth_date", array("value" => $r["birth_date"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["birth_country"] = $f->get_FieldSelect("birth_country", array("selected" => $r["birth_country"], "data" => $countries, "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["birth_region"] = $f->get_FieldSelect("birth_region", array("selected" => $r["birth_region"], "data" => $regions_birth, "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["birth_city"] = $f->get_FieldSelect("birth_city", array("selected" => $r["birth_city"], "data" => $cities_birth, "proportion" => "col-md-3 col-sm-12 col-12"));

$f->fields["address"] = $f->get_FieldText("address", array("value" => $r["address"], "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["residence_country"] = $f->get_FieldSelect("residence_country", array("selected" => $r["residence_country"], "data" => $countries, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["residence_region"] = $f->get_FieldSelect("residence_region", array("selected" => $r["residence_region"], "data" => $regions_residence, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["residence_city"] = $f->get_FieldSelect("residence_city", array("selected" => $r["residence_city"], "data" => $cities_residence, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["neighborhood"] = $f->get_FieldText("neighborhood", array("value" => $r["neighborhood"], "proportion" => "col-md-6 col-sm-12 col-12"));

$f->fields["area"] = $f->get_FieldSelect("area", array("selected" => $r["area"], "data" => LIST_AREAS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["stratum"] = $f->get_FieldSelect("stratum", array("selected" => $r["stratum"], "data" => LIST_STRATUMS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["transport_method"] = $f->get_FieldSelect("transport_method", array("selected" => $r["transport_method"], "data" => LIST_TRANSPORTS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["sisben_group"] = $f->get_FieldSelect("sisben_group", array("selected" => $r["sisben_group"], "data" => LIST_SISBEN_GROUPS, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["sisben_subgroup"] = $f->get_FieldSelect("sisben_subgroup", array("selected" => $r["sisben_subgroup"], "data" => $subgroups, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["document_issue_place"] = $f->get_FieldText("document_issue_place", array("value" => $r["document_issue_place"], "proportion" => "col-md-4 col-sm-12 col-12"));

$f->fields["blood_type"] = $f->get_FieldSelect("blood_type", array("selected" => $r["blood_type"], "data" => LIST_BLOOD, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["marital_status"] = $f->get_FieldSelect("marital_status", array("selected" => $r["marital_status"], "data" => LIST_MARITALS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["eps"] = $f->get_FieldSelect("eps", array("selected" => $r["eps"], "data" => LIST_EPS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));


$f->fields["number_children"] = $f->get_FieldNumber("number_children", array("value" => $r["number_children"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["military_card"] = $f->get_FieldText("military_card", array("value" => $r["military_card"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ars"] = $f->get_FieldSelect("ars", array("selected" => $r["ars"], "data" => LIST_ARS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["insurer"] = $f->get_FieldText("insurer", array("value" => $r["insurer"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["education_level"] = $f->get_FieldSelect("education_level", array("selected" => $r["education_level"], "data" => LIST_EDUCATION_LEVELS, "proportion" => "col-md-6 col-12"));
$f->fields["occupation"] = $f->get_FieldSelect("occupation", array("selected" => $r["occupation"], "data" => LIST_OCCUPATIONS, "proportion" => "col-xl-6 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["health_regime"] = $f->get_FieldText("health_regime", array("value" => $r["health_regime"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["document_issue_date"] = $f->get_FieldText("document_issue_date", array("value" => $r["document_issue_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["saber11"] = $f->get_FieldText("saber11", array("value" => $r["saber11"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["saber11_date"] = $f->get_FieldDate("saber11_date", array("value" => $r["saber11_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["saber11_value"] = $f->get_FieldText("saber11_value", array("value" => $r["saber11_value"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));


$f->fields["graduation_certificate"] = $f->get_FieldText("graduation_certificate", array("value" => $r["graduation_certificate"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["military_id"] = $f->get_FieldText("military_id", array("value" => $r["military_id"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["diploma"] = $f->get_FieldText("diploma", array("value" => $r["diploma"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["icfes_certificate"] = $f->get_FieldText("icfes_certificate", array("value" => $r["icfes_certificate"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["utility_bill"] = $f->get_FieldText("utility_bill", array("value" => $r["utility_bill"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sisben_certificate"] = $f->get_FieldText("sisben_certificate", array("value" => $r["sisben_certificate"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["address_certificate"] = $f->get_FieldText("address_certificate", array("value" => $r["address_certificate"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["electoral_certificate"] = $f->get_FieldText("electoral_certificate", array("value" => $r["electoral_certificate"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["photo_card"] = $f->get_FieldText("photo_card", array("value" => $r["photo_card"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["observations"] = $f->get_FieldText("observations", array("value" => $r["observations"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["status"] = $f->get_FieldText("status", array("value" => $r["status"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["ticket"] = $f->get_FieldText("ticket", array("value" => $r["ticket"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["interview"] = $f->get_FieldText("interview", array("value" => $r["interview"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["linkage_type"] = $f->get_FieldSelect("linkage_type", array("selected" => $r["linkage_type"], "data" => LIST_LINKAGE_TYPES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ethnic_group"] = $f->get_FieldSelect("ethnic_group", array("selected" => $r["ethnic_group"], "data" => LIST_ETHNIC_GROUPS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["indigenous_people"] = $f->get_FieldSelect("indigenous_people", array("selected" => $r["indigenous_people"], "data" => LIST_INDIGENOUS_PEOPLE, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["afro_descendant"] = $f->get_FieldSelect("afro_descendant", array("selected" => $r["afro_descendant"], "data" => LIST_BLACK_COMMUNITY, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["disability"] = $f->get_FieldSelect("disability", array("selected" => $r["disability"], "data" => LIST_YN, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["disability_type"] = $f->get_FieldSelect("disability_type", array("selected" => $r["disability_type"], "data" => LIST_TYPES_OF_DISABILITIES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["exceptional_ability"] = $f->get_FieldSelect("exceptional_ability", array("selected" => $r["exceptional_ability"], "data" => LIST_OF_EXCEPTIONAL_CAPABILITIES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["responsible"] = $f->get_FieldText("responsible", array("value" => $r["responsible"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["responsible_relationship"] = $f->get_FieldText("responsible_relationship", array("value" => $r["responsible_relationship"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["num_people_depending_on_you"] = $f->get_FieldNumber("num_people_depending_on_you", array("value" => $r["num_people_depending_on_you"], "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["num_people_living_with_you"] = $f->get_FieldNumber("num_people_living_with_you", array("value" => $r["num_people_living_with_you"], "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["responsible_phone"] = $f->get_FieldText("responsible_phone", array("value" => $r["responsible_phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["num_people_contributing_economically"] = $f->get_FieldNumber("num_people_contributing_economically", array("value" => $r["num_people_contributing_economically"], "proportion" => "col-md-6 col-sm-12 col-12"));

$f->fields['first_in_family_to_study_university'] = $f->get_FieldSelect("first_in_family_to_study_university", array("selected" => $r["first_in_family_to_study_university"], "data" => LIST_YN, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields['border_population'] = $f->get_FieldSelect("border_population", array("selected" => $r["border_population"], "data" => LIST_YN, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields['identified_population_group'] = $f->get_FieldSelect("identified_population_group", array("selected" => $r["identified_population_group"], "data" => LIST_IDENTIFIED_POPULATION_GROUP, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields['highlighted_population'] = $f->get_FieldSelect("highlighted_population", array("selected" => $r["highlighted_population"], "data" => LIST_HIGHLIGHTED_POPULATION, "proportion" => "col-md-6 col-sm-12 col-12"));

$f->fields["observations_academic"] = $f->get_FieldText("observations_academic", array("value" => $r["observations_academic"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["import"] = $f->get_FieldText("import", array("value" => $r["import"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["moment"] = $f->get_FieldText("moment", array("value" => $r["moment"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["snies_updated_at"] = $f->get_FieldText("snies_updated_at", array("value" => $r["snies_updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["photo"] = $f->get_FieldText("photo", array("value" => $r["photo"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Continue"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));


//Convenio


//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g01"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["registration"] . $f->fields["course"] . $f->fields["journey"])));

$f->groups["g04"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["identification_type"] . $f->fields["identification_number"] . $f->fields["first_name"])));
$f->groups["g05"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["second_name"] . $f->fields["first_surname"] . $f->fields["second_surname"])));
$f->groups["g06"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["email_address"] . $f->fields["confirm_email_address"])));
$f->groups["g07"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["gender"] . $f->fields["phone"] . $f->fields["mobile"])));
$f->groups["g08"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["residence_country"] . $f->fields["residence_region"] . $f->fields["residence_city"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
//$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------

$title = "Matricula Directa - Para Cursos";

$card = $b->get_Card2("create", array(
        "header-title" => $title,
        "content" => $f,
        "alert" => array(
                "icon" => ICON_INFO,
                "type" => "info",
                "title" => lang('Sie_Registrations.direct-registration-courses-title'),
                "message" => sprintf(lang('Sie_Registrations.direct-registration-courses-description'), $course_name)
        ),
        "header-back" => $back
));
echo($card);
$fidentification_number = $f->get_FieldID("identification_number");
$fid = $f->get_fid();
?>
<span id="identification_status"></span>
<script>
    document.addEventListener('DOMContentLoaded', function () {

            const API_URL = '/sie/api/registrations/json/identification/';
            let debounceTimer;
            // Obtener elementos del DOM
            const identificationInput = document.getElementById('<?php echo($fid);?>_identification_number');
            const statusSpan = document.getElementById('identification_status');
            const form = document.getElementById('<?php echo($fid);?>');
            // Campos que se llenarán automáticamente
            const fieldsToFill = [
                '<?php echo($fid);?>_first_name',
                '<?php echo($fid);?>_first_surname',
                '<?php echo($fid);?>_email_address',
                '<?php echo($fid);?>_gender',
                '<?php echo($fid);?>_phone',
                '<?php echo($fid);?>_residence_country',
                '<?php echo($fid);?>_residence_region',
                '<?php echo($fid);?>_residence_city'
            ];

            // Evento de input con debounce
            identificationInput.addEventListener('input', function (e) {
                const value = e.target.value.trim();
                clearTimeout(debounceTimer);
                statusSpan.textContent = '';
                statusSpan.className = '';
                if (value === '') {
                    return;
                }
                debounceTimer = setTimeout(() => {
                    searchUser(value);
                }, 500);
            });

            function searchUser(identificationNumber) {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', '/sie/api/registrations/json/identification/' + identificationNumber, true);
                xhr.onload = function () {
                    if (this.status == 200) {
                        var data = JSON.parse(this.responseText);
                        if (data.registration) {
                            document.getElementById('<?php echo($fid);?>_registration').value = data.registration;
                        }
                        if (data.first_name) {
                            document.getElementById('<?php echo($fid);?>_first_name').value = data.first_name;
                        }

                        if (data.second_name) {
                            document.getElementById('<?php echo($fid);?>_second_name').value = data.second_name;
                        }
                        if (data.first_surname) {
                            document.getElementById('<?php echo($fid);?>_first_surname').value = data.first_surname;
                        }
                        if (data.second_surname) {
                            document.getElementById('<?php echo($fid);?>_second_surname').value = data.second_surname;
                        }
                        if (data.identification_type) {
                            document.getElementById('<?php echo($fid);?>_identification_type').value = data.identification_type;
                        }
                        if (data.gender) {
                            document.getElementById('<?php echo($fid);?>_gender').value = data.gender;
                        }
                        if (data.email_address) {
                            document.getElementById('<?php echo($fid);?>_email_address').value = data.email_address;
                        }
                        if (data.phone) {
                            document.getElementById('<?php echo($fid);?>_phone').value = data.phone;
                        }
                        if (data.mobile) {
                            document.getElementById('<?php echo($fid);?>_mobile').value = data.mobile;
                        }

                    }
                }
                xhr.send();

            }

















                <?php if($r['option'] == 'agreements') {?>
            var agreement_country = document.getElementById('<?php echo($fid);?>_agreement_country');
            var agreement_region = document.getElementById('<?php echo($fid);?>_agreement_region');
            var agreement_city = document.getElementById('<?php echo($fid);?>_agreement_city');
            var agreement_institution = document.getElementById('<?php echo($fid);?>_agreement_institution');
            var agreement_group = document.getElementById('<?php echo($fid);?>_agreement_group');


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

                <?php }?>

            function showLoading() {
                const overlay = document.getElementById('loading-overlay');
                overlay.style.display = 'flex'; // Mostrar el overlay
            }

            function hideLoading() {
                const overlay = document.getElementById('loading-overlay');
                overlay.style.display = 'none'; // Ocultar el overlay
            }

            //var birth_country = document.getElementById('<?php echo($fid);?>_birth_country');
            //var birth_region = document.getElementById('<?php echo($fid);?>_birth_region');
            //var birth_city = document.getElementById('<?php echo($fid);?>_birth_city');
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
                    }
                    hideLoading();
                }
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
                }
                xhr.onerror = function () {
                    console.error("Error al cargar las ciudades.");
                    hideLoading();
                };
                xhr.send();
            });


            var disabilitySelect = document.getElementById('<?php echo($fid);?>_disability');
            var disabilityTypeSelect = document.getElementById('<?php echo($fid);?>_disability_type');

            disabilitySelect.addEventListener('change', function () {
                if (this.value === 'N') {
                    for (var i = 0; i < disabilityTypeSelect.options.length; i++) {
                        if (disabilityTypeSelect.options[i].value === "") {
                            disabilityTypeSelect.selectedIndex = i;
                            break;
                        }
                    }
                    disabilityTypeSelect.disabled = true;
                } else if (this.value === 'Y') {
                    disabilityTypeSelect.disabled = false;
                }
            });

            // Initial check in case the page loads with a pre-selected value
            if (disabilitySelect.value === 'N') {
                disabilityTypeSelect.disabled = true;
            } else if (disabilitySelect.value === 'Y') {
                disabilityTypeSelect.disabled = false;
            }


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
                        sisbenSubgroups = [""];
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


        }
    );
</script>
<div id="loading-overlay" class="loading-overlay">
    <div class="spinner"></div>
    <div class="loading-text">Hola espera</div>
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
        flex-direction: column;
    }

    .spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3; /* Color del borde */
        border-top: 5px solid #3498db; /* Color del spinner */
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 15px;
    }

    .loading-text {
        color: white;
        font-size: 18px;
        font-weight: bold;
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