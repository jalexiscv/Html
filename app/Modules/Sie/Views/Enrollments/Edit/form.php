<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-09-12 04:42:56
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Enrollments\Editor\form.php]
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
 * █ @var object $menrollments Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[services]------------------------------------------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Sie_Enrollments."));
//[models]--------------------------------------------------------------------------------------------------------------
$menrollments = model("App\Modules\Sie\Models\Sie_Enrollments");
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$mgrids = model("App\Modules\Sie\Models\Sie_Grids");
$mversions = model("App\Modules\Sie\Models\Sie_Versions");
$mheadquarters = model("App\Modules\Sie\Models\Sie_Headquarters");
//[vars]----------------------------------------------------------------------------------------------------------------
$row = $menrollments->get_Enrollment($oid);
$registration = $mregistrations->getRegistration($row["registration"]);
$program = $mprograms->getProgram($registration["program"]);
$grid = $mgrids->get_GridByProgram(@$program["program"]);
$version = $mversions->get_Active(@$grid["grid"]);
$r["enrollment"] = $f->get_Value("enrollment", @$row["enrollment"]);
$r["registration"] = $f->get_Value("registration", $row["registration"]);
$r["student_name"] = $f->get_Value("student_name", $registration["first_name"] . " " . $registration["second_name"] . " " . $registration["first_surname"] . " " . $registration["second_surname"]);
$r["program"] = $f->get_Value("program", $row["program"]);
$r["program_name"] = $f->get_Value("program_name", @$program["name"]);
$r["grid"] = $f->get_Value("grid", @$row["grid"]);
$r["version"] = $f->get_Value("version", @$version["version"]);
$r["version_reference"] = $f->get_Value("version_reference", @$version["reference"]);
$r["cycle"] = $f->get_Value("cycle", $row["cycle"]);
$r["moment"] = $f->get_Value("moment", $row["moment"]);
$r["headquarter"] = $f->get_Value("version", $row["headquarter"]);
$r["journey"] = $f->get_Value("journey", $row["journey"]);
$r["period"] = $f->get_Value("period", $row["period"]);
$r["linkage_type"] = $f->get_Value("linkage_type", $row['linkage_type']);
$r["observation"] = $f->get_Value("observation", $row["observation"]);
$r["date"] = $f->get_Value("date", $row["date"]);
$r["renewal"] = $f->get_Value("renewal", $row["renewal"]);
$r["status"] = $f->get_Value("status", $row["status"]);
$r["time"] = $f->get_Value("time", service("dates")::get_Time());
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
$grids = $mgrids->get_SelectData($r["program"]);
$versions = $mversions->get_SelectData($r["grid"]);
$headquarters = $mheadquarters->get_SelectData();
$back = "/sie/students/view/{$r['registration']}#enrollments";

$r['renewal'] = empty($r['renewal']) ? service("dates")::get_Date() : $r['renewal'];
//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("back", $back);
$f->fields["enrollment"] = $f->get_FieldText("enrollment", array("value" => $r["enrollment"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["registration"] = $f->get_FieldText("registration", array("value" => $r["registration"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["student_name"] = $f->get_FieldText("student_name", array("value" => $r["student_name"], "proportion" => "col-12", "readonly" => true));
$f->fields["program"] = $f->get_FieldText("program", array("value" => $r["program"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["program_name"] = $f->get_FieldText("program_name", array("value" => $r["program_name"], "proportion" => "col-12", "readonly" => true));
$f->fields["grid"] = $f->get_FieldSelect("grid", array("selected" => $r["grid"], "data" => $grids, "proportion" => "col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12"));
$f->fields["version"] = $f->get_FieldSelect("version", array("selected" => $r["version"], "data" => $versions, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["version_reference"] = $f->get_FieldText("version_reference", array("value" => $r["version_reference"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["cycle"] = $f->get_FieldSelect("cycle", array("selected" => $r["cycle"], "data" => LIST_CYCLES, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["moment"] = $f->get_FieldSelect("moment", array("selected" => $r["moment"], "data" => LIST_MOMENTS, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["observation"] = $f->get_FieldTextArea("observation", array("value" => $r["observation"], "proportion" => "col-12"));
$f->fields["headquarter"] = $f->get_FieldSelect("headquarter", array("selected" => $r["headquarter"], "data" => $headquarters, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["journey"] = $f->get_FieldSelect("journey", array("selected" => $r["journey"], "data" => LIST_JOURNEYS, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["linkage_type"] = $f->get_FieldSelect("linkage_type", array("selected" => $r["linkage_type"], "data" => LIST_LINKAGE_TYPES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["date"] = $f->get_FieldText("date", array("value" => $r["date"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["renewal"] = $f->get_FieldDate("renewal", array("value" => $r["renewal"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["time"] = $f->get_FieldText("time", array("value" => $r["time"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["period"] = $f->get_FieldSelect("period", array("selected" => $r["period"], "data" => LIST_PERIODS, "proportion" => "col-md-3 col-sm-12 col-12"));

$f->fields["status"] = $f->get_FieldSelect("status", array("selected" => $r["status"], "data" => LIST_ENRROLMENTS_STATUS, "proportion" => "col-md-3 col-sm-12 col-12"));

$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Update"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["enrollment"] . $f->fields["registration"] . $f->fields["program"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["student_name"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["program_name"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["grid"] . $f->fields["version"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["linkage_type"] . $f->fields["cycle"] . $f->fields["moment"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["headquarter"] . $f->fields["journey"])));
$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["date"] . $f->fields["renewal"] . $f->fields["period"]) . $f->fields["status"]));
$f->groups["g9"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["observation"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
        "title" => lang("Sie_Enrollments.edit-title"),
        "content" => $f,
        "header-back" => $back
));
echo($card);
$fidgrid = $f->get_FieldId("grid");
$fidversion = $f->get_FieldId("version");

?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var grid = document.getElementById("<?php echo($fidgrid);?>");
        var version = document.getElementById("<?php echo($fidversion);?>");
        grid.addEventListener("change", function () {
            var url = "/sie/api/versions/json/all/" + grid.value;
            fetch(url)
                .then(response => response.json())
                .then(responseData => {
                    // Accede a la propiedad 'data' de la respuesta
                    const data = responseData.data;

                    // Verifica si data es un array
                    if (Array.isArray(data)) {
                        version.innerHTML = "";
                        data.forEach(function (item) {
                            var option = document.createElement("option");
                            option.value = item.version;
                            option.text = item.reference;
                            version.appendChild(option);
                        });
                    } else {
                        console.error("La respuesta de la API no es un array:", data);
                    }
                })
                .catch(error => {
                    console.error("Error al obtener los datos:", error);
                });
        });
    });
</script>