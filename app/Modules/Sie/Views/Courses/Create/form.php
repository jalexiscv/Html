<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-03-15 06:53:06
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Courses\Creator\form.php]
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
$f = service("forms", array("lang" => "Sie_Courses."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sie\Models\Sie_Courses");
$mprogams = model("App\Modules\Sie\Models\Sie_Programs");
$musers = model("App\Modules\Sie\Models\Sie_Users");
$mversions = model("App\Modules\Sie\Models\Sie_Versions");
$magreements = model("App\Modules\Sie\Models\Sie_Agreements");
$minstitutions = model("App\Modules\Sie\Models\Sie_Institutions");
$mspaces = model("App\Modules\Sie\Models\Sie_Spaces");
//[vars]----------------------------------------------------------------------------------------------------------------
$r["course"] = $f->get_Value("course", pk());
$r["reference"] = $f->get_Value("reference");
$r["program"] = $f->get_Value("program");
$r["grid"] = $f->get_Value("grid");
$r["version"] = $f->get_Value("version");
$r["pensum"] = $f->get_Value("pensum");
$r["teacher"] = $f->get_Value("teacher");
$r["name"] = $f->get_Value("name");
$r["description"] = $f->get_Value("description");
$r["maximum_quota"] = $f->get_Value("maximum_quota", "25");
$r["start"] = $f->get_Value("start");
$r["end"] = $f->get_Value("end");
$r["period"] = $f->get_Value("period");
$r["journey"] = $f->get_Value("journey");
$r["start_time"] = $f->get_Value("start_time");
$r["end_time"] = $f->get_Value("end_time");
$r["author"] = $f->get_Value("author", safe_get_user());
$r["agreement"] = $f->get_Value("agreement");
$r["agreement_institution"] = $f->get_Value("agreement_institution");
$r["agreement_group"] = $f->get_Value("agreement_group");
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
$r["price"] = $f->get_Value("price", "0");
$r["cycle"] = $f->get_Value("cycle");
$r["space"] = $f->get_Value("space");
$r["day"] = $f->get_Value("day");
$r["free"] = $f->get_Value("free");

$back = "/sie/courses/list/" . lpk();

$programs = array(
        array("value" => "", "label" => "Seleccione un programa"),
);
$programs = array_merge($programs, $mprogams->get_SelectData());

$pensums = array(
        array("value" => "", "label" => "Seleccione un módulo"),
);

$uteachers = $musers->get_ListByType(1000, 0, "TEACHER", "");
$teachers = array(
        array("value" => "", "label" => "Seleccione un profesor"),
);
foreach ($uteachers as $teacher) {
    $firstname = safe_urldecode($teacher["firstname"]);
    $lastname = safe_urldecode($teacher["lastname"]);
    $teachers[] = array("value" => $teacher["user"], "label" => "{$firstname} {$lastname}");
}


$grids = array(array("value" => "", "label" => "Seleccione una..."),);
$versions = array(array("value" => "", "label" => "Seleccione una..."),);

$qversions = $mversions
        ->where("grid", $r["grid"])
        ->findAll();

foreach ($qversions as $version) {
    $versions[] = array("value" => $version["version"], "label" => $version["reference"]);
}


$agreements = [];
$agreements[] = array("value" => "", "label" => "Seleccione un convenio");
$agreements = array_merge($agreements, $magreements->get_SelectData());


$agreement_institutions = [];
$agreement_institutions[] = array("value" => "", "label" => "Seleccione una institución");
$agreement_institutions = array_merge($agreement_institutions, $minstitutions->get_SelectData());

$agreement_groups = [];
$agreement_groups[] = array("value" => "", "label" => "Seleccione un grupo");


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
$f->fields["program"] = $f->get_FieldSelect("program", array("selected" => $r["program"], "data" => $programs, "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["grid"] = $f->get_FieldSelect("grid", array("selected" => $r["grid"], "data" => $grids, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["version"] = $f->get_FieldSelect("version", array("selected" => $r["version"], "data" => $versions, "proportion" => "col-md-6 col-sm-12 col-12", "readonly" => true));

$f->fields["version_reference"] = $f->get_FieldText("version_reference", array("value" => "", "proportion" => "col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["pensum"] = $f->get_FieldSelect("pensum", array("selected" => $r["pensum"], "data" => $pensums, "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["teacher"] = $f->get_FieldSelect("teacher", array("selected" => $r["teacher"], "data" => $teachers, "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["name"] = $f->get_FieldText("name", array("value" => $r["name"], "proportion" => "col-12"));
$f->fields["description"] = $f->get_FieldTextArea("description", array("value" => $r["description"], "proportion" => "col-12"));
$f->fields["maximum_quota"] = $f->get_FieldNumber("maximum_quota", array("value" => $r["maximum_quota"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["start"] = $f->get_FieldDate("start", array("value" => $r["start"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["end"] = $f->get_FieldDate("end", array("value" => $r["end"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["period"] = $f->get_FieldSelect("period", array("selected" => $r["period"], "data" => LIST_PERIODS, "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["journey"] = $f->get_FieldSelect("journey", array("selected" => $r["journey"], "data" => LIST_JOURNEYS, "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["start_time"] = $f->get_FieldTime("start_time", array("value" => $r["start_time"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["end_time"] = $f->get_FieldTime("end_time", array("value" => $r["end_time"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["price"] = $f->get_FieldNumber("price", array("value" => $r["price"], "proportion" => "col-md-3 col-sm-12 col-12"));

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
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]--------------------------------------------------------------------------------------------------------------
$f->groups["g001"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["course"] . $f->fields["reference"] . $f->fields["program"])));
$f->groups["g002"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["grid"] . $f->fields["version"])));
$f->groups["g003"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["pensum"] . $f->fields["teacher"])));
$f->groups["g004"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["name"])));
$f->groups["g005"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));
$f->groups["g006"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["agreement"] . $f->fields["agreement_institution"] . $f->fields["agreement_group"])));
$f->groups["g007"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["maximum_quota"] . $f->fields["start"] . $f->fields["end"] . $f->fields["period"])));
$f->groups["g008"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["journey"] . $f->fields["start_time"] . $f->fields["end_time"] . $f->fields["price"])));
$f->groups["g010"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["cycle"] . $f->fields["space"] . $f->fields["day"])));
$f->groups["g011"] = $f->get_Group(array("legend" => "Forma de Acceso", "fields" => ($f->fields["free"])));

//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card2("create", array(
        "header-title" => lang("Sie_Courses.create-title"),
        "alert" => array(
                "icon" => ICON_INFO,
                "type" => "info",
                "title" => lang('Sie_Courses.create-info-title'),
                "message" => lang('Sie_Courses.create-info-description')
        ),
        "content" => $f,
        "header-back" => $back
));
echo($card);

$fprogram = $f->get_FieldId("program");
$fgrid = $f->get_FieldId("grid");
$fversion = $f->get_FieldId("version");
$fversion_reference = $f->get_FieldId("version_reference");
$fpensum = $f->get_FieldId("pensum");
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
        var fpensum = document.getElementById('<?php echo($fpensum); ?>');
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
                    fpensum.innerHTML = html;
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
                    fpensum.innerHTML = html;
                }
            };
            xhr.send();
        }


        fpensum.addEventListener('change', function () {
            courseName();
        });

        function courseName() {
            var name = fpensum.options[fpensum.selectedIndex].text;
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
            /**
             var journey = fjourney.value;
             if (journey === 'JN') {
             fstart.value = '2025-08-12';
             fend.value = '2025-12-06';
             } else if (journey === 'JS') {
             fstart.value = '2025-08-17';
             fend.value = '2025-12-14';
             } else {
             fstart.value = '';
             fend.value = '';
             }
             **/
        }


    });
</script>
