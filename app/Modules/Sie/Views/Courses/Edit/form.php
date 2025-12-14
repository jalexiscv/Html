<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-03-15 12:20:32
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Courses\Editor\form.php]
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
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Sie_Courses."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sie\Models\Sie_Courses");
$mprogams = model("App\Modules\Sie\Models\Sie_Programs");
$musers = model("App\Modules\Sie\Models\Sie_Users");
$mversions = model("App\Modules\Sie\Models\Sie_Versions");
$mgrids = model("App\Modules\Sie\Models\Sie_Grids");
$mpensums = model("App\Modules\Sie\Models\Sie_Pensums");
$mmodules = model("App\Modules\Sie\Models\Sie_Modules");
$magreements = model("App\Modules\Sie\Models\Sie_Agreements");
$minstitutions = model("App\Modules\Sie\Models\Sie_Institutions");
$mgroups = model("App\Modules\Sie\Models\Sie_Groups");
$mspaces = model("App\Modules\Sie\Models\Sie_Spaces");
//[vars]----------------------------------------------------------------------------------------------------------------
$row = $model->where('course', $oid)->first();
$r["course"] = $f->get_Value("course", $row["course"]);
$r["reference"] = $f->get_Value("reference", $row["reference"]);
$r["program"] = $f->get_Value("program", $row["program"]);
$r["grid"] = $f->get_Value("grid", $row["grid"]);
$r["pensum"] = $f->get_Value("pensum", $row["pensum"]);
$r["version"] = $f->get_Value("version", $row["version"]);
$r["teacher"] = $f->get_Value("teacher", $row["teacher"]);
$r["name"] = $f->get_Value("name", $row["name"]);
$r["description"] = $f->get_Value("description", $row["description"]);
$r["maximum_quota"] = $f->get_Value("maximum_quota", $row["maximum_quota"]);
$r["start"] = $f->get_Value("start", $row["start"]);
$r["end"] = $f->get_Value("end", $row["end"]);
$r["period"] = $f->get_Value("period", $row["period"]);
$r["space"] = $f->get_Value("space", $row["space"]);
$r["journey"] = $f->get_Value("journey", $row["journey"]);
$r["start_time"] = $f->get_Value("start_time", $row["start_time"]);
$r["end_time"] = $f->get_Value("end_time", $row["end_time"]);
$r["price"] = $f->get_Value("price", @$row["price"]);
$r["agreement"] = $f->get_Value("agreement", @$row["agreement"]);
$r["agreement_institution"] = $f->get_Value("agreement_institution", @$row["agreement_institution"]);
$r["agreement_group"] = $f->get_Value("agreement_group", @$row["agreement_group"]);
$r["moodle_course"] = $f->get_Value("moodle_course", @$row["moodle_course"]);
$r["free"] = $f->get_Value("free", @$row["free"]);



$r["cycle"] = $f->get_Value("cycle", @$row["cycle"]);
$r["space"] = $f->get_Value("space", @$row["space"]);
$r["day"] = $f->get_Value("day", @$row["day"]);

$r["status"] = $f->get_Value("status", @$row["status"]);
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);

$back = "/sie/courses/list/" . lpk();

$programs = $mprogams->get_SelectData();
$grids = array(array("value" => "", "label" => "Seleccione una malla..."),);
$versions = array(array("value" => "", "label" => "Seleccione una versión..."),);
$pensums = array(array("value" => "", "label" => "Seleccione un módulo..."),);
$teachers = array(array("value" => "", "label" => "Seleccione un profesor"),);

$query_grids = $mgrids->get_AllGridsByProgram($r["program"]);
foreach ($query_grids as $grid) {
    $grids[] = array("value" => $grid["grid"], "label" => $grid["name"]);
}

$qversions = $mversions->where("grid", $r["grid"])->findAll();
foreach ($qversions as $version) {
    $versions[] = array("value" => $version["version"], "label" => $version["reference"]);
}

$qpensums = $mpensums->where("version", $r["version"])->findAll();

foreach ($qpensums as $pensum) {
    $module = $mmodules->get_Module($pensum["module"]);
    $pensums[] = array("value" => $pensum["pensum"], "label" => $module["name"]);
}

$uteachers = $musers->get_ListByType(1000, 0, "TEACHER", "");

foreach ($uteachers as $teacher) {
    $firstname = safe_urldecode($teacher["firstname"]);
    $lastname = safe_urldecode($teacher["lastname"]);
    $teachers[] = array("value" => $teacher["user"], "label" => "{$firstname} {$lastname}");
}

$agreements = [];
$agreements[] = array("value" => "", "label" => "Seleccione un convenio");
$agreements = array_merge($agreements, $magreements->get_SelectData());

$agreement_institutions = [];
$agreement_institutions[] = array("value" => "", "label" => "Seleccione una institución");
$agreement_institutions = array_merge($agreement_institutions, $minstitutions->get_SelectData());

$agreement_groups = [];
$agreement_groups[] = array("value" => "", "label" => "Seleccione una un grupo");
$agreement_groups = array_merge($agreement_groups, $mgroups->getSelectData($r["agreement_institution"]));


$cycles = array(
        array("value" => "", "label" => "Seleccione un ciclo"),
        array("value" => "0", "label" => "0"),
        array("value" => "1", "label" => "1"),
        array("value" => "2", "label" => "2"),
        array("value" => "3", "label" => "3"),
        array("value" => "4", "label" => "4"),
        array("value" => "5", "label" => "5"),
        array("value" => "6", "label" => "6"),
        array("value" => "7", "label" => "7"),
        array("value" => "8", "label" => "8"),
        array("value" => "9", "label" => "9"),
        array("value" => "10", "label" => "10"),
);


$dspaces = $mspaces->get_SelectData();

$spaces = array(
        array("value" => "", "label" => "Seleccione un espacio"),
);


$spaces = array_merge($spaces, $dspaces);


$days = array(
        array("value" => "", "label" => "Seleccione un dia"),
        array("value" => "LUNES", "label" => "Lunes"),
        array("value" => "MARTES", "label" => "Martes"),
        array("value" => "MIERCOLES", "label" => "Miércoles"),
        array("value" => "JUEVES", "label" => "Jueves"),
        array("value" => "VIERNES", "label" => "Viernes"),
        array("value" => "SABADO", "label" => "Sábado"),
        array("value" => "DOMINGO", "label" => "Domingo"),
);

//[fields]----------------------------------------------------------------------------------------------------------------
$f->fields["course"] = $f->get_FieldText("course", array("value" => $r["course"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["reference"] = $f->get_FieldText("reference", array("value" => $r["reference"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["program"] = $f->get_FieldSelect("program", array("selected" => $r["program"], "data" => $programs, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["grid"] = $f->get_FieldSelect("grid", array("selected" => $r["grid"], "data" => $grids, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["version"] = $f->get_FieldSelect("version", array("selected" => $r["version"], "data" => $versions, "proportion" => "col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["pensum"] = $f->get_FieldSelect("pensum", array("selected" => $r["pensum"], "data" => $pensums, "proportion" => "col-12"));
$f->fields["teacher"] = $f->get_FieldSelect("teacher", array("selected" => $r["teacher"], "data" => $teachers, "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["name"] = $f->get_FieldText("name", array("value" => $r["name"], "proportion" => "col-12"));
$f->fields["description"] = $f->get_FieldTextArea("description", array("value" => $r["description"], "proportion" => "col-12"));
$f->fields["maximum_quota"] = $f->get_FieldNumber("maximum_quota", array("value" => $r["maximum_quota"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["start"] = $f->get_FieldDate("start", array("value" => $r["start"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["end"] = $f->get_FieldDate("end", array("value" => $r["end"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["period"] = $f->get_FieldSelect("period", array("selected" => $r["period"], "data" => LIST_PERIODS, "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["journey"] = $f->get_FieldSelect("journey", array("selected" => $r["journey"], "data" => LIST_JOURNEYS, "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["journey"] = $f->get_FieldSelect("journey", array("selected" => $r["journey"], "data" => LIST_JOURNEYS, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["start_time"] = $f->get_FieldTime("start_time", array("value" => $r["start_time"], "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["end_time"] = $f->get_FieldTime("end_time", array("value" => $r["end_time"], "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["price"] = $f->get_FieldNumber("price", array("value" => $r["price"], "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["status"] = $f->get_FieldSelect("status", array("selected" => $r["status"], "data" => LIST_COURSES_STATUSES, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["moodle_course"] = $f->get_FieldText("moodle_course", array("value" => $r["moodle_course"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));


$f->fields["agreement"] = $f->get_FieldSelect("agreement", array("selected" => $r["agreement"], "data" => $agreements, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["agreement_institution"] = $f->get_FieldSelect("agreement_institution", array("selected" => $r["agreement_institution"], "data" => $agreement_institutions, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["agreement_group"] = $f->get_FieldSelect("agreement_group", array("selected" => $r["agreement_group"], "data" => $agreement_groups, "proportion" => "col-md-4 col-sm-12 col-12"));

$f->fields["cycle"] = $f->get_FieldSelect("cycle", array("selected" => $r["cycle"], "data" => $cycles, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["space"] = $f->get_FieldSelect("space", array("selected" => $r["space"], "data" => $spaces, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["day"] = $f->get_FieldSelect("day", array("selected" => $r["day"], "data" => $days, "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["free"] = $f->get_FieldSelect("free", array("selected" => $r["free"], "data" => LIST_NY, "proportion" => "col-md-4 col-sm-12 col-12"));


$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["course"] . $f->fields["reference"] . $f->fields["teacher"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["program"] . $f->fields["grid"] . $f->fields["version"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["pensum"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["name"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["agreement"] . $f->fields["agreement_institution"] . $f->fields["agreement_group"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["maximum_quota"] . $f->fields["start"] . $f->fields["end"] . $f->fields["period"])));
$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["journey"] . $f->fields["start_time"] . $f->fields["end_time"])));
$f->groups["g9"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["price"] . $f->fields["status"])));
$f->groups["g010"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["cycle"] . $f->fields["space"] . $f->fields["day"])));
$f->groups["g011"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["moodle_course"])));
$f->groups["g012"] = $f->get_Group(array("legend" => "Forma de Acceso", "fields" => ($f->fields["free"])));

//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("create", array(
        "header-title" => lang("Sie_Courses.edit-title"),
        "content" => $f,
        "header-back" => $back
));
echo($card);
$fprogram = $f->get_FieldId("program");
$fgrid = $f->get_FieldId("grid");
$fversion = $f->get_FieldId("version");
$fversion_reference = $f->get_FieldId("version_reference");
$fmodule = $f->get_FieldId("pensum");
$fname = $f->get_FieldId("name");
$fversion_reference = $f->get_FieldId("version_reference");
$fperiod = $f->get_FieldId("period");
$fjourney = $f->get_FieldId("journey");
$fstart = $f->get_FieldId("start");
$fend = $f->get_FieldId("end");
$fid = $f->get_fid("agreement");
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var fprogram = document.getElementById('<?php echo($fprogram); ?>');
        var fgrid = document.getElementById('<?php echo($fgrid); ?>');
        var fversion = document.getElementById('<?php echo($fversion); ?>');
        var fmodule = document.getElementById('<?php echo($fmodule); ?>');
        var fversion_reference = document.getElementById('<?php echo($fversion_reference); ?>');
        var fname = document.getElementById('<?php echo($fname); ?>');
        var fversion_reference = document.getElementById('<?php echo($fversion_reference); ?>');
        var fperiod = document.getElementById('<?php echo($fperiod); ?>');

        // [Institucion & Grupos]---------------------------------------------------------------------------------------
        var agreement_institution = document.getElementById('<?php echo($fid);?>_agreement_institution');
        var agreement_group = document.getElementById('<?php echo($fid);?>_agreement_group');
        agreement_institution.addEventListener('change', function () {
            var institution = this.value;
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
            };
            xhr.onerror = function () {
                console.error("Error al cargar los grupos.");
            };
            xhr.send();
        });


        fprogram.addEventListener('change', function () {
            var program = this.value;
            var xhr = new XMLHttpRequest();
            xhr.open('GET', "/sie/api/grids/json/select/" + program, true);
            xhr.responseType = 'json';
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var data = xhr.response.data;
                    console.log(data);
                    var html = "";
                    html += '<option value="">Seleccione una (Actualizado)...</option>';
                    for (var count = 0; count < data.length; count++) {
                        html += '<option value="' + data[count].value + '">' + data[count].label + '</option>';
                    }
                    fgrid.innerHTML = html;
                }
            };
            xhr.send();
        });


        fgrid.addEventListener('change', function () {
            gridChange();
        });

        fversion.addEventListener('change', function () {
            versionChange();
        });


        function gridChange() {
            var program = fprogram.value;
            var grid = fgrid.value;
            if (grid && grid.trim() !== "") {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', "/sie/api/versions/json/all/" + grid, true);
                xhr.responseType = 'json';
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var data = xhr.response.data;
                        console.log(data);
                        var html = "";
                        html += '<option value="">Seleccione una versión...</option>';
                        for (var count = 0; count < data.length; count++) {
                            html += '<option value="' + data[count].version + '">' + data[count].reference + '</option>';
                        }
                        fversion.innerHTML = html;
                        pensums();
                    }
                };
                xhr.send();
            } else {
                console.log("No se consulta la version de la malla ya que no hay una malla seleccionada");
            }
        }

        function versionChange() {
            var version = fversion.value;
            var xhr = new XMLHttpRequest();
            xhr.open('GET', "/sie/api/pensums/json/select/" + version, true);
            xhr.responseType = 'json';
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var data = xhr.response.data;
                    console.log(data);
                    var html = "";
                    html += '<option value="">Seleccione uno (Actualizado)...</option>';
                    for (var count = 0; count < data.length; count++) {
                        html += '<option value="' + data[count].value + '">' + data[count].label + '</option>';
                    }
                    fmodule.innerHTML = html;
                }
            };
            xhr.send();
        }


        function pensums() {
            var version = fversion.value;
            var xhr = new XMLHttpRequest();
            xhr.open('GET', "/sie/api/pensums/json/select/" + version, true);
            xhr.responseType = 'json';
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var data = xhr.response.data;
                    console.log(data);
                    var html = "";
                    html += '<option value="">Seleccione uno (Actualizado)...</option>';
                    for (var count = 0; count < data.length; count++) {
                        html += '<option value="' + data[count].value + '">' + data[count].label + '</option>';
                    }
                    fmodule.innerHTML = html;
                }
            };
            xhr.send();
        }


        fmodule.addEventListener('change', function () {
            courseName();
        });

        function courseName() {
            var name = fmodule.options[fmodule.selectedIndex].text;
            var reference = fversion_reference.value;
            var period = fperiod.value;
            fname.value = name + reference + "p" + period;
        }


        var fjourney = document.getElementById('<?php echo($fjourney); ?>');
        var fstart = document.getElementById('<?php echo($fstart); ?>');
        var fend = document.getElementById('<?php echo($fend); ?>');

        fjourney.addEventListener('change', function () {
            updateDates();
        });


        function updateDates() {
            var journey = fjourney.value;
            if (journey === 'JN') {
                fstart.value = '2024-08-12';
                fend.value = '2024-12-06';
            } else if (journey === 'JS') {
                fstart.value = '2024-08-17';
                fend.value = '2024-12-14';
            } else {
                fstart.value = '';
                fend.value = '';
            }
        }


    });
</script>
