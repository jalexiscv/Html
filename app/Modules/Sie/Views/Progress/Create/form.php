<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-08-13 07:25:58
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Progress\Creator\form.php]
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
 * █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Sie_Progress."));
$server = service("server");
//[models]--------------------------------------------------------------------------------------------------------------
$mprogress = model("App\Modules\Sie\Models\Sie_Progress");
$menrollments = model("App\Modules\Sie\Models\Sie_Enrollments");
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$mgrids = model("App\Modules\Sie\Models\Sie_Grids");
$mversions = model("App\Modules\Sie\Models\Sie_Versions");
$menrollments = model("App\Modules\Sie\Models\Sie_Enrollments");
$mheadquarters = model("App\Modules\Sie\Models\Sie_Headquarters");
//[vars]----------------------------------------------------------------------------------------------------------------
$r["progress"] = $f->get_Value("progress", pk());
$r["enrollment"] = $f->get_Value("enrollment", $oid);

$r["program"] = $f->get_Value("program", $oid);
$r["grid"] = $f->get_Value("grid", $oid);
$r["version"] = $f->get_Value("version", $oid);

$r["c1"] = $f->get_Value("c1", "0.0");
$r["c2"] = $f->get_Value("c2", "0.0");
$r["c3"] = $f->get_Value("c3", "0.0");

$r["pensum"] = $f->get_Value("pensum");
$r["module"] = $f->get_Value("module");

$r["status"] = $f->get_Value("status");
$r["last_calification"] = $f->get_Value("last_calification", "0.0");
$r["last_course"] = $f->get_Value("last_course");
$r["author"] = $f->get_Value("author", safe_get_user());
$r["last_date"] = $f->get_Value("last_date", safe_get_date());
$r["last_author"] = $f->get_Value("last_author", safe_get_user());
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");

$programs = array(array("value" => "", "label" => "Seleccione un programa"));
$grids = array(array("value" => "", "label" => "Seleccione una malla"));
$versions = array(array("value" => "", "label" => "Seleccione una versión"));
$modules = array(array("value" => "", "label" => "Seleccione un módulo"));

$programs = array_merge($programs, $mprograms->get_SelectData());
$grids = array_merge($grids, $mgrids->get_SelectData($r["program"]));
$versions = array_merge($versions, $mversions->get_SelectData($r["grid"]));
//$modules=array_merge($modules,$mregistrations->get_SelectData($r["version"]));

$back = $server->get_Referer();

//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("back", $back);
$f->add_HiddenField("module", "");
$f->fields["progress"] = $f->get_FieldText("progress", array("value" => $r["progress"], "proportion" => "col-md-3 col-sm-12 col-12", "readonly" => "readonly"));
$f->fields["enrollment"] = $f->get_FieldText("enrollment", array("value" => $r["enrollment"], "proportion" => "col-md-3 col-sm-12 col-12", "readonly" => "readonly"));

$f->fields["program"] = $f->get_FieldSelect("program", array("selected" => $r["program"], "data" => $programs, "proportion" => "col-md-6 col-12"));
$f->fields["grid"] = $f->get_FieldSelect("grid", array("selected" => $r["grid"], "data" => $grids, "proportion" => "col-12"));
$f->fields["version"] = $f->get_FieldSelect("version", array("selected" => $r["version"], "data" => $versions, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["pensum"] = $f->get_FieldSelect("pensum", array("selected" => $r["pensum"], "data" => $modules, "proportion" => "col-md-6 col-sm-12 col-12"));

$f->fields["c1"] = $f->get_FieldText("c1", array("value" => $r["c1"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["c2"] = $f->get_FieldText("c2", array("value" => $r["c2"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["c3"] = $f->get_FieldText("c3", array("value" => $r["c3"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["last_calification"] = $f->get_FieldText("last_calification", array("value" => $r["last_calification"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["status"] = $f->get_FieldSelect("status", array("selected" => $r["status"], "data" => LIST_STATUSES_PROGRESS, "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));

$f->fields["last_calification"] = $f->get_FieldText("last_calification", array("value" => $r["last_calification"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["last_course"] = $f->get_FieldText("last_course", array("value" => $r["last_course"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["last_author"] = $f->get_FieldText("last_author", array("value" => $r["last_author"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["last_date"] = $f->get_FieldText("last_date", array("value" => $r["last_date"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));

$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["progress"] . $f->fields["enrollment"] . $f->fields["program"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["grid"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["version"] . $f->fields["pensum"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["c1"] . $f->fields["c2"] . $f->fields["c3"] . $f->fields["last_calification"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["status"] . $f->fields["last_date"] . $f->fields["last_course"] . $f->fields["last_author"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card("create", array(
        "title" => "Adicionar módulo de extensión",
        "content" => $f,
        "header-back" => $back
));
echo($card);
$fidprogram = $f->get_FieldId("program");
$fidgrid = $f->get_FieldId("grid");
$fidversion = $f->get_FieldId("version");
$fidpensum = $f->get_FieldId("pensum");
$fidmodule = $f->get_FieldId("module");
?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var program = document.getElementById("<?php echo($fidprogram);?>");
        var grid = document.getElementById("<?php echo($fidgrid);?>");
        var version = document.getElementById("<?php echo($fidversion);?>");
        var pensum = document.getElementById("<?php echo($fidpensum);?>");
        var module = document.getElementById("<?php echo($fidmodule);?>");

        program.addEventListener("change", function () {
            var url = "/sie/api/grids/json/select/" + program.value;
            fetch(url)
                .then(response => response.json())
                .then(responseData => {
                    // Accede a la propiedad 'data' de la respuesta
                    const data = responseData.data;
                    // Verifica si data es un array
                    if (Array.isArray(data)) {
                        grid.innerHTML = "";
                        var option = document.createElement("option");
                        option.value = "";
                        option.text = "- Seleccione una malla";
                        grid.appendChild(option);
                        data.forEach(function (item) {
                            var option = document.createElement("option");
                            option.value = item.value;
                            option.text = item.label;
                            grid.appendChild(option);
                        });
                    } else {
                        console.error("La respuesta de la API no es un array:", data);
                    }
                })
                .catch(error => {
                    console.error("Error al obtener los datos:", error);
                });
        });

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
                        var option = document.createElement("option");
                        option.value = "";
                        option.text = "- Seleccione una malla";
                        version.appendChild(option);
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

        version.addEventListener("change", function () {
            var url = "/sie/api/pensums/json/select/" + version.value;
            fetch(url)
                .then(response => response.json())
                .then(responseData => {
                    // Accede a la propiedad 'data' de la respuesta
                    const data = responseData.data;
                    // Verifica si data es un array
                    if (Array.isArray(data)) {
                        module.innerHTML = "";
                        var option = document.createElement("option");
                        option.value = "";
                        option.text = "- Seleccione un módulo";
                        pensum.appendChild(option);
                        data.forEach(function (item) {
                            var option = document.createElement("option");
                            option.value = item.value;
                            option.text = item.label;
                            pensum.appendChild(option);
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