<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-05-01 08:14:09
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Registrations\Editor\form.php]
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
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @var object $parent Trasferido desde el controlador
 * █ @var object $authentication Trasferido desde el controlador
 * █ @var object $request Trasferido desde el controlador
 * █ @var object $dates Trasferido desde el controlador
 * █ @var string $component Trasferido desde el controlador
 * █ @var string $view Trasferido desde el controlador
 * █ @var string $oid Trasferido desde el controlador
 * █ @var string $views Trasferido desde el controlador
 * █ @var string $prefix Trasferido desde el controlador
 * █ @var array $data Trasferido desde el controlador
 * █ @var object $mregistrations Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[services]------------------------------------------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Sie_Registrations."));
//[models]--------------------------------------------------------------------------------------------------------------
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$mcountries = model("App\Modules\Sie\Models\Sie_Countries");
$mregions = model("App\Modules\Sie\Models\Sie_Regions");
$mcities = model("App\Modules\Sie\Models\Sie_Cities");
//[vars]----------------------------------------------------------------------------------------------------------------
$row = $mregistrations->getRegistration($oid);
$r["registration"] = $f->get_Value("registration", $row["registration"]);
$r["first_name"] = $f->get_Value("first_name", $row["first_name"]);
$r["second_name"] = $f->get_Value("second_name", $row["second_name"]);
$r["first_surname"] = $f->get_Value("first_surname", $row["first_surname"]);
$r["second_surname"] = $f->get_Value("second_surname", $row["second_surname"]);
$r["identification_type"] = $f->get_Value("identification_type", $row["identification_type"]);
$r["identification_number"] = $f->get_Value("identification_number", $row["identification_number"]);
$r["gender"] = $f->get_Value("gender", $row["gender"]);
$r["email_address"] = $f->get_Value("email_address", $row["email_address"]);
$r["phone"] = $f->get_Value("phone", $row["phone"]);
$r["mobile"] = $f->get_Value("mobile", $row["mobile"]);
$r["birth_date"] = $f->get_Value("birth_date", $row["birth_date"]);
$r["address"] = $f->get_Value("address", $row["address"]);
$r["residence_city"] = $f->get_Value("residence_city", $row["residence_city"]);
$r["neighborhood"] = $f->get_Value("neighborhood", $row["neighborhood"]);
$r["area"] = $f->get_Value("area", $row["area"]);
$r["stratum"] = $f->get_Value("stratum", $row["stratum"]);
$r["transport_method"] = $f->get_Value("transport_method", $row["transport_method"]);
$r["sisben_group"] = $f->get_Value("sisben_group", $row["sisben_group"]);
$r["sisben_subgroup"] = $f->get_Value("sisben_subgroup", $row["sisben_subgroup"]);
$r["document_issue_place"] = $f->get_Value("document_issue_place", $row["document_issue_place"]);
$r["birth_city"] = $f->get_Value("birth_city", $row["birth_city"]);
$r["blood_type"] = $f->get_Value("blood_type", $row["blood_type"]);
$r["marital_status"] = $f->get_Value("marital_status", $row["marital_status"]);
$r["number_children"] = $f->get_Value("number_children", $row["number_children"]);
$r["military_card"] = $f->get_Value("military_card", $row["military_card"]);
$r["ars"] = $f->get_Value("ars", $row["ars"]);
$r["insurer"] = $f->get_Value("insurer", $row["insurer"]);
$r["eps"] = $f->get_Value("eps", $row["eps"]);
$r["education_level"] = $f->get_Value("education_level", $row["education_level"]);
$r["occupation"] = $f->get_Value("occupation", $row["occupation"]);
$r["health_regime"] = $f->get_Value("health_regime", $row["health_regime"]);
$r["document_issue_date"] = $f->get_Value("document_issue_date", $row["document_issue_date"]);
$r["saber11"] = $f->get_Value("saber11", $row["saber11"]);
$r["observations"] = $f->get_Value("observations", $row["observations"]);
$r["status"] = $f->get_Value("status", $row["status"]);
$r["period"] = $f->get_Value("period", $row["period"]);
$r["journey"] = $f->get_Value("journey", $row["journey"]);
$r["program"] = $f->get_Value("program", $row["program"]);

if (!empty($r["birth_city"])) {
    $city = $mcities->get_City($r["birth_city"]);
    $r["regions_birth"] = $city["region"];
    $r["countries_birth"] = $city["country"];
} else {
    $r["countries_birth"] = $f->get_Value("countries_birth", "CO");
    $r["regions_birth"] = $f->get_Value("regions_birth", "076");
}

if (!empty($r["residence_city"])) {
    $city = $mcities->get_City($r["residence_city"]);
    $r["regions_residence"] = $city["region"];
    $r["countries_residence"] = $city["country"];
} else {
    $r["countries_residence"] = $f->get_Value("countries_residence", "CO");
    $r["regions_residence"] = $f->get_Value("regions_residence", "076");
}


$back = "/sie/agreements/list/" . lpk();

$programs = array(array("value" => "", "label" => "Seleccione un programa"),);

$countries = array(
        array("value" => "", "label" => "Seleccione un país"),
        array("value" => "CO", "label" => "Colombia"),
        array("value" => "VE", "label" => "Venezuela"),
);
$regions_birth = array(array("value" => "", "label" => "Seleccione una región"),);
$cities_birth = array(array("value" => "", "label" => "Seleccione una ciudad"),);
$regions_birth = array_merge($regions_birth, $mregions->get_SelectData($r["countries_birth"]));
$cities_birth = array_merge($cities_birth, $mcities->get_SelectData($r["regions_birth"]));

$regions_residence = array(array("value" => "", "label" => "Seleccione una región"),);
$cities_residence = array(array("value" => "", "label" => "Seleccione una ciudad"),);
$regions_residence = array_merge($regions_residence, $mregions->get_SelectData($r["countries_residence"]));
$cities_residence = array_merge($cities_residence, $mcities->get_SelectData($r["regions_residence"]));

$programs = array_merge($programs, $mprograms->get_SelectData());

//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("tab", "1");
$f->fields["registration"] = $f->get_FieldText("registration", array("value" => $r["registration"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => "readonly"));
$f->fields["first_name"] = $f->get_FieldText("first_name", array("value" => $r["first_name"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["second_name"] = $f->get_FieldText("second_name", array("value" => $r["second_name"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["first_surname"] = $f->get_FieldText("first_surname", array("value" => $r["first_surname"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["second_surname"] = $f->get_FieldText("second_surname", array("value" => $r["second_surname"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["identification_type"] = $f->get_FieldSelect("identification_type", array("selected" => $r["identification_type"], "data" => LIST_IDENTIFICATION_TYPES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["identification_number"] = $f->get_FieldText("identification_number", array("value" => $r["identification_number"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["gender"] = $f->get_FieldSelect("gender", array("selected" => $r["gender"], "data" => LIST_SEX, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["email_address"] = $f->get_FieldText("email_address", array("value" => $r["email_address"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));

$f->fields["birth_date"] = $f->get_FieldDate("birth_date", array("value" => $r["birth_date"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["countries_birth"] = $f->get_FieldSelect("countries_birth", array("selected" => $r["countries_birth"], "data" => $countries, "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["regions_birth"] = $f->get_FieldSelect("regions_birth", array("selected" => $r["regions_birth"], "data" => $regions_birth, "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["birth_city"] = $f->get_FieldSelect("birth_city", array("selected" => $r["birth_city"], "data" => $cities_birth, "proportion" => "col-md-3 col-sm-12 col-12"));

$f->fields["phone"] = $f->get_FieldText("phone", array("value" => $r["phone"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["mobile"] = $f->get_FieldText("mobile", array("value" => $r["mobile"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["countries_residence"] = $f->get_FieldSelect("countries_residence", array("selected" => $r["countries_residence"], "data" => $countries, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["regions_residence"] = $f->get_FieldSelect("regions_residence", array("selected" => $r["regions_residence"], "data" => $regions_residence, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["residence_city"] = $f->get_FieldSelect("residence_city", array("selected" => $r["residence_city"], "data" => $cities_residence, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["address"] = $f->get_FieldText("address", array("value" => $r["address"], "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["neighborhood"] = $f->get_FieldText("neighborhood", array("value" => $r["neighborhood"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["area"] = $f->get_FieldText("area", array("value" => $r["area"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["stratum"] = $f->get_FieldSelect("stratum", array("selected" => $r["stratum"], "data" => LIST_STRATUMS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["transport_method"] = $f->get_FieldText("transport_method", array("value" => $r["transport_method"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sisben_group"] = $f->get_FieldText("sisben_group", array("value" => $r["sisben_group"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sisben_subgroup"] = $f->get_FieldText("sisben_subgroup", array("value" => $r["sisben_subgroup"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["document_issue_place"] = $f->get_FieldText("document_issue_place", array("value" => $r["document_issue_place"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["period"] = $f->get_FieldSelect("period", array("selected" => $r["period"], "data" => LIST_PERIODS, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["journey"] = $f->get_FieldSelect("journey", array("selected" => $r["journey"], "data" => LIST_JOURNEYS, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["program"] = $f->get_FieldSelect("program", array("selected" => $r["program"], "data" => $programs, "proportion" => "col-12"));
$f->fields["blood_type"] = $f->get_FieldText("blood_type", array("value" => $r["blood_type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["marital_status"] = $f->get_FieldText("marital_status", array("value" => $r["marital_status"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["number_children"] = $f->get_FieldText("number_children", array("value" => $r["number_children"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["military_card"] = $f->get_FieldText("military_card", array("value" => $r["military_card"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ars"] = $f->get_FieldText("ars", array("value" => $r["ars"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["insurer"] = $f->get_FieldText("insurer", array("value" => $r["insurer"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["eps"] = $f->get_FieldText("eps", array("value" => $r["eps"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["education_level"] = $f->get_FieldText("education_level", array("value" => $r["education_level"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["occupation"] = $f->get_FieldText("occupation", array("value" => $r["occupation"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["health_regime"] = $f->get_FieldText("health_regime", array("value" => $r["health_regime"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["document_issue_date"] = $f->get_FieldText("document_issue_date", array("value" => $r["document_issue_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["saber11"] = $f->get_FieldText("saber11", array("value" => $r["saber11"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["observations"] = $f->get_FieldTextArea("observations", array("value" => $r["observations"], "proportion" => "col-12"));
$f->fields["status"] = $f->get_FieldSelect("status", array("selected" => $r["status"], "data" => LIST_STATUSES, "proportion" => "col-12"));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g01"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["registration"] . $f->fields["identification_type"] . $f->fields["identification_number"])));
$f->groups["g02"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["document_issue_place"] . $f->fields["period"] . $f->fields["journey"])));
$f->groups["g03"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["program"])));
$f->groups["g04"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["first_name"] . $f->fields["second_name"] . $f->fields["first_surname"] . $f->fields["second_surname"])));
$f->groups["g05"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["gender"] . $f->fields["email_address"])));
$f->groups["g06"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["birth_date"] . $f->fields["countries_birth"] . $f->fields["regions_birth"] . $f->fields["birth_city"])));
$f->groups["g07"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["phone"] . $f->fields["mobile"])));
$f->groups["g08"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["countries_residence"] . $f->fields["regions_residence"] . $f->fields["residence_city"])));
$f->groups["g09"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["address"] . $f->fields["neighborhood"])));
$f->groups["g10"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["status"])));
$f->groups["g11"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["observations"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
        "content" => $f,
));
echo($card);
$fid = $f->get_fid();
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var countries_birth = document.getElementById('<?php echo($fid);?>_countries_birth');
        var regions_birth = document.getElementById('<?php echo($fid);?>_regions_birth');
        var birth_city = document.getElementById('<?php echo($fid);?>_birth_city');
        var countries_residence = document.getElementById('<?php echo($fid);?>_countries_residence');
        var regions_residence = document.getElementById('<?php echo($fid);?>_regions_residence');
        var residence_city = document.getElementById('<?php echo($fid);?>_residence_city');

        countries_birth.addEventListener('change', function () {
            var country = this.value;
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/sie/api/registrations/json/regions/' + country, true);
            xhr.onload = function () {
                if (this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    regions_birth.innerHTML = '<option value="">Seleccione una región</option>';
                    data.forEach(function (region) {
                        var option = document.createElement('option');
                        option.value = region.value;
                        option.text = region.label;
                        regions_birth.add(option);
                    });
                }
            }
            xhr.send();
        });

        regions_birth.addEventListener('change', function () {
            var region = this.value;
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
            }
            xhr.send();
        });

        countries_residence.addEventListener('change', function () {
            var country = this.value;
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/sie/api/registrations/json/regions/' + country, true);
            xhr.onload = function () {
                if (this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    regions_residence.innerHTML = '<option value="">Seleccione una región</option>';
                    data.forEach(function (region) {
                        var option = document.createElement('option');
                        option.value = region.value;
                        option.text = region.label;
                        regions_residence.add(option);
                    });
                }
            }
            xhr.send();
        });

        regions_residence.addEventListener('change', function () {
            var region = this.value;
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
            }
            xhr.send();
        });


    });
</script>
