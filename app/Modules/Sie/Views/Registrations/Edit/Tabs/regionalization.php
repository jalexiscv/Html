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
$magreements = model("App\Modules\Sie\Models\Sie_Agreements");
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$mcountries = model("App\Modules\Sie\Models\Sie_Countries");
$mregions = model("App\Modules\Sie\Models\Sie_Regions");
$mcities = model("App\Modules\Sie\Models\Sie_Cities");
$minstitutions = model("App\Modules\Sie\Models\Sie_Institutions");
//[data]----------------------------------------------------------------------------------------------------------------
$back = "/sie/registrations/list/" . lpk();

$agreements = array(array("value" => "", "label" => "- No aplica"));
$agreements = array_merge($agreements, $magreements->get_SelectData());

$countries = array(
        array("value" => "", "label" => "Seleccione un país"),
        array("value" => "CO", "label" => "Colombia"),
        array("value" => "VE", "label" => "Venezuela"),
);

$regions = array(array("value" => "", "label" => "Seleccione un region"));
$cities = array(array("value" => "", "label" => "Seleccione un ciudad"));

$institutions = array(array("value" => "", "label" => "Seleccione una institución"));
$institutions = array_merge($institutions, $minstitutions->get_SelectData());
//[vars]----------------------------------------------------------------------------------------------------------------

$row = $mregistrations->getRegistration($oid);
$r["agreement"] = $f->get_Value("agreement", @$row["agreement"]);
$r["agreement_country"] = $f->get_Value("agreement_country", @$row["agreement_country"]);
$r["agreement_region"] = $f->get_Value("agreement_region", @$row["agreement_region"]);
$r["agreement_city"] = $f->get_Value("agreement_city", @$row["agreement_city"]);
$r["agreement_institution"] = $f->get_Value("agreement_institution", @$row["agreement_institution"]);
//[fields]--------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("tab", "regionalization");
$f->add_HiddenField("registration", $oid);
$f->fields["agreement"] = $f->get_FieldSelect("agreement", array("selected" => $r["agreement"], "data" => $agreements, "proportion" => "col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12"));
$f->fields["agreement_country"] = $f->get_FieldSelect("agreement_country", array("selected" => $r["agreement_country"], "data" => $countries, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["agreement_region"] = $f->get_FieldSelect("agreement_region", array("selected" => $r["agreement_region"], "data" => $regions, "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["agreement_city"] = $f->get_FieldSelect("agreement_city", array("selected" => $r["agreement_city"], "data" => $cities, "proportion" => "col-xl-6 col-lg-6 col-md-64 col-sm-12 col-12"));
$f->fields["agreement_institution"] = $f->get_FieldSelect("agreement_institution", array("selected" => $r["agreement_institution"], "data" => $institutions, "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Update"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]--------------------------------------------------------------------------------------------------------------
$f->groups["g01"] = $f->get_Group(array("legend" => "Regionalización / Sede principal", "fields" => ($f->fields["agreement"] . $f->fields["agreement_country"])));
$f->groups["g02"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["agreement_region"] . $f->fields["agreement_city"])));
$f->groups["g03"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["agreement_institution"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$fid = $f->get_fid();
echo($f);
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var agreement_country = document.getElementById('<?php echo($fid);?>_agreement_country');
        var agreement_region = document.getElementById('<?php echo($fid);?>_agreement_region');
        var agreement_city = document.getElementById('<?php echo($fid);?>_agreement_city');
        agreement_country.addEventListener('change', function () {
            var country = this.value;
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
            };
            xhr.onerror = function () {
                console.error("Error al cargar las regiones.");
            };
            xhr.send();
        });
        agreement_region.addEventListener('change', function () {
            var region = this.value;
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
            };
            xhr.onerror = function () {
                console.error("Error al cargar las ciudades.");
            };
            xhr.send();
        });
    });
</script>
