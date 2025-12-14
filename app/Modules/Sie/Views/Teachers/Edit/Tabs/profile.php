<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-12-18 11:03:17
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Security\Views\Users\Editor\form.php]
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
 * █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[services]------------------------------------------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Sie_Teachers."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Security\Models\Security_Users");
$musers = model("App\Modules\Sie\Models\Sie_Users");
$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');
$mattachments = model("App\Modules\Security\Models\Security_Attachments");
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$magreements = model("App\Modules\Sie\Models\Sie_Agreements");
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$mcountries = model("App\Modules\Sie\Models\Sie_Countries");
$mregions = model("App\Modules\Sie\Models\Sie_Regions");
$mcities = model("App\Modules\Sie\Models\Sie_Cities");
$minstitutions = model("App\Modules\Sie\Models\Sie_Institutions");
$mgroups = model("App\Modules\Sie\Models\Sie_Groups");
//[vars]----------------------------------------------------------------------------------------------------------------

//$p=$musers->getProfile($oid);

$profile = $musers->getCachedProfile($oid);
//echo(safe_dump($profile));

$r["alias"] = $f->get_Value("alias", $profile["alias"]);
$r["type"] = $f->get_Value("type", "TEACHER");

$r["birthday"] = $f->get_Value("birthday", $profile["birthday"]);
$r["birth_country"] = $f->get_Value("birth_country", @$profile["birth_country"]);
$r["birth_region"] = $f->get_Value("birth_region", @$profile["birth_region"]);
$r["birth_city"] = $f->get_Value("birth_city", @$profile["birth_city"]);

$r["citizenshipcard"] = $f->get_Value("citizenshipcard", $profile["citizenshipcard"]);
$r["email"] = $f->get_Value("email", $profile["email"]);
$r["email_personal"] = $f->get_Value("email_personal", @$profile["email_personal"]);
$r["firstname"] = $f->get_Value("firstname", $profile["firstname"]);
$r["lastname"] = $f->get_Value("lastname", $profile["lastname"]);
$r["password"] = $f->get_Value("password", $profile["password"]);
$r["confirm"] = $f->get_Value("confirm", $profile["password"]);
$r["phone"] = $f->get_Value("phone", $profile["phone"]);
$r["whatsapp"] = $f->get_Value("whatsapp", @$profile["whatsapp"]);
$r["address"] = $f->get_Value("address", $profile["address"]);
$r["reference"] = $f->get_Value("reference", $profile["reference"]);
$r["notes"] = $f->get_Value("notes", $profile["notes"]);
$r["expedition_date"] = $f->get_Value("expedition_date", $mfields->get_Field($oid, "expedition_date"));
$r["expedition_place"] = $f->get_Value("expedition_place", $mfields->get_Field($oid, "expedition_place"));
$r["moodle-username"] = $f->get_Value("moodle-username", $mfields->get_Field($oid, "moodle-username"));
$r["moodle-password"] = $f->get_Value("moodle-password", $mfields->get_Field($oid, "moodle-password"));
$row = $musers->where("user", $oid)->first();
$r["user"] = $f->get_Value("user", $row["user"]);
$r["author"] = $f->get_Value("author", $authentication->get_User());
$r["created_at"] = $f->get_Value("created_at", @$row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", @$row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", @$row["deleted_at"]);

$r["gender"] = $f->get_Value("gender", @$profile["gender"]);
$r["marital_status"] = $f->get_Value("marital_status", @$profile["marital_status"]);
$r["institutional_address"] = $f->get_Value("institutional_address", @$profile["institutional_address"]);

$r["participant_teacher"] = $f->get_Value("participant_teacher", $mfields->get_Field($oid, "participant_teacher"));
$r["participant_executive"] = $f->get_Value("participant_executive", $mfields->get_Field($oid, "participant_executive"));
$r["participant_authority"] = $f->get_Value("participant_authority", $mfields->get_Field($oid, "participant_authority"));

$countries = array(array("value" => "", "label" => "Seleccione un país"));
$countries = array_merge($countries, $mcountries->get_SelectData());
$birth_region = array(array("value" => "", "label" => "Seleccione una región"),);
$cities_birth = array(array("value" => "", "label" => "Seleccione una ciudad"),);
$birth_region = array_merge($birth_region, $mregions->get_SelectData($r["birth_country"]));
$cities_birth = array_merge($cities_birth, $mcities->get_SelectData($r["birth_region"]));


$status = array(
        array("value" => "", "label" => "Seleccione una opción"),
        array("value" => "Y", "label" => "Si"),
        array("value" => "N", "label" => "No"),
);


/**
 * 1. Masculino
 * 2. Femenino
 * 3. No binario
 * 4. Trans
 **/
$genders = array(
        array("value" => "1", "label" => "Masculino"),
        array("value" => "2", "label" => "Femenino"),
        array("value" => "3", "label" => "No binario"),
        array("value" => "4", "label" => "Trans")
);

/**
 * 1. Soltero(a)
 * 2. Casado(a)
 * 3. Divorciado(a)
 * 4. Viudo(a)
 * 5. Unión libre
 * 6. Religioso(a)
 * 8. Separado(a)
 */

$marital_statuses = array(
        array("value" => "1", "label" => "Soltero(a)"),
        array("value" => "2", "label" => "Casado(a)"),
        array("value" => "3", "label" => "Divorciado(a)"),
        array("value" => "4", "label" => "Viudo(a)"),
        array("value" => "5", "label" => "Unión libre"),
        array("value" => "6", "label" => "Religioso(a)"),
        array("value" => "8", "label" => "Separado(a)")
);

//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("user", $r["user"]);
$f->add_HiddenField("form", "profile");
$f->add_HiddenField("author", $r["author"]);
$f->fields["alias"] = $f->get_FieldAlias("alias", array("value" => $r["alias"], "proportion" => "col-xl-3 col-md-12 col-12"));
$f->fields["type"] = $f->get_FieldText("type", array("value" => $r["type"], "proportion" => "col-xl-3 col-md-12 col-12", "readonly" => true));

$f->fields["birthday"] = $f->get_FieldDate("birthday", array("value" => $r["birthday"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["birth_country"] = $f->get_FieldSelect("birth_country", array("selected" => @$r["birth_country"], "data" => $countries, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["birth_region"] = $f->get_FieldSelect("birth_region", array("selected" => @$r["birth_region"], "data" => $birth_region, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["birth_city"] = $f->get_FieldSelect("birth_city", array("selected" => @$r["birth_city"], "data" => $cities_birth, "proportion" => "col-md-4 col-sm-12 col-12"));

$f->fields["institutional_address"] = $f->get_FieldText("institutional_address", array("value" => $r["institutional_address"], "proportion" => "col-md-12 col-12"));


$f->fields["citizenshipcard"] = $f->get_FieldCitizenShipcard("citizenshipcard", array("value" => $r["citizenshipcard"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["expedition_date"] = $f->get_FieldDate("expedition_date", array("value" => $r["expedition_date"], "proportion" => "col-xl-6 col-md-6 col-12", "required" => true));
$f->fields["expedition_place"] = $f->get_FieldText("expedition_place", array("value" => $r["expedition_place"], "proportion" => "col-xl-6 col-md-6 col-12"));


$f->fields["password"] = $f->get_FieldPassword("password", array("value" => $r["password"], "proportion" => "col-xl-3 col-md-12 col-12"));
$f->fields["confirm"] = $f->get_FieldPassword("confirm", array("value" => $r["confirm"], "proportion" => "col-xl-3 col-md-12 col-12"));
$f->fields["email"] = $f->get_FieldEmail("email", array("value" => $r["email"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["email_personal"] = $f->get_FieldEmail("email_personal", array("value" => $r["email_personal"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["firstname"] = $f->get_FieldText("firstname", array("value" => $r["firstname"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["lastname"] = $f->get_FieldText("lastname", array("value" => $r["lastname"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["phone"] = $f->get_FieldText("phone", array("value" => $r["phone"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["whatsapp"] = $f->get_FieldText("whatsapp", array("value" => $r["whatsapp"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["address"] = $f->get_FieldText("address", array("value" => $r["address"], "proportion" => "col-xl-12 col-md-12 col-12"));
$f->fields["reference"] = $f->get_FieldText("reference", array("value" => $r["reference"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["notes"] = $f->get_FieldCKEditor("notes", array("value" => $r["notes"], "proportion" => "col-xl-12 col-md-12 col-12"));
$f->fields["moodle-username"] = $f->get_FieldText("moodle-username", array("value" => $r["moodle-username"], "proportion" => "col-xl-6 col-md-12 col-12"));
$f->fields["moodle-password"] = $f->get_FieldText("moodle-password", array("value" => $r["moodle-password"], "proportion" => "col-xl-6 col-md-12 col-12"));

$f->fields["gender"] = $f->get_FieldSelect("gender", array("selected" => $r["gender"], "data" => $genders, "proportion" => "col-md-6 col-12", "required" => true));
$f->fields["marital_status"] = $f->get_FieldSelect("marital_status", array("selected" => $r["marital_status"], "data" => $marital_statuses, "proportion" => "col-md-6 col-12", "required" => true));

$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => "/sie/teachers/list/" . lpk(), "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));

$f->fields["participant_teacher"] = $f->get_FieldSelect("participant_teacher", array("selected" => $r["participant_teacher"], "data" => $status, "proportion" => "col-md-4 col-12", "required" => true));
$f->fields["participant_executive"] = $f->get_FieldSelect("participant_executive", array("selected" => $r["participant_executive"], "data" => $status, "proportion" => "col-md-4 col-12", "required" => true));
$f->fields["participant_authority"] = $f->get_FieldSelect("participant_authority", array("selected" => $r["participant_authority"], "data" => $status, "proportion" => "col-md-4 col-12", "required" => true));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g01"] = $f->get_Group(array("legend" => "1. Datos de usuario", "fields" => $f->fields["alias"] . $f->fields["type"] . $f->fields["password"] . $f->fields["confirm"]));
$f->groups["g02"] = $f->get_Group(array("legend" => "2. Información personal", "fields" => $f->fields["firstname"] . $f->fields["lastname"]));
$f->groups["g03"] = $f->get_Group(array("fields" => $f->fields["gender"] . $f->fields["marital_status"]));
$f->groups["g04"] = $f->get_Group(array("legend" => "3. Origen & Residencia", "fields" => ($f->fields["birth_country"] . $f->fields["birth_region"] . $f->fields["birth_city"])));
$f->groups["g05"] = $f->get_Group(array("fields" => $f->fields["address"]));
$f->groups["g06"] = $f->get_Group(array("legend" => "4. Información de contacto", "fields" => $f->fields["email"] . $f->fields["email_personal"]));
$f->groups["g07"] = $f->get_Group(array("fields" => $f->fields["phone"] . $f->fields["whatsapp"]));
$f->groups["g08"] = $f->get_Group(array("fields" => $f->fields["birthday"]));
$f->groups["g09"] = $f->get_Group(array("legend" => "5. Datos de identificación", "fields" => $f->fields["citizenshipcard"] . $f->fields["expedition_date"]));
$f->groups["g10"] = $f->get_Group(array("fields" => $f->fields["expedition_place"] . $f->fields["reference"]));
$f->groups["g11"] = $f->get_Group(array("legend" => "6. Reporte de participantes", "fields" => $f->fields["participant_teacher"] . $f->fields["participant_executive"] . $f->fields["participant_authority"]));
$f->groups["g12"] = $f->get_Group(array("fields" => $f->fields["institutional_address"]));
$f->groups["g13"] = $f->get_Group(array("legend" => "7. Integración con el moodle", "fields" => $f->fields["moodle-username"] . $f->fields["moodle-password"]));
$f->groups["g14"] = $f->get_Group(array("fields" => $f->fields["notes"]));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
echo($f);
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
