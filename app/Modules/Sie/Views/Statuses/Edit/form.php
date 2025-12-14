<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-12-10 04:44:38
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Statuses\Editor\form.php]
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
 * █ @link https://www.higgs.com.co
 * █ @Version 1.5.1 @since PHP 8,PHP 9
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[services]------------------------------------------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Sie_Statuses."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sie\Models\Sie_Statuses");
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
$mgrids = model('App\Modules\Sie\Models\Sie_Grids');
$mversions = model('App\Modules\Sie\Models\Sie_Versions');
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
$row = $model->get_Status($oid);
$r["status"] = $f->get_Value("status", $row["status"]);
$r["registration"] = $f->get_Value("registration", $row["registration"]);

$r["enrollment"] = $f->get_Value("enrollment", $row["enrollment"]);
$r["enrollment_date"] = $f->get_Value("enrollment_date", $row["enrollment_date"]);

$r["program"] = $f->get_Value("program", $row["program"]);
$r["grid"] = $f->get_Value("grid", $row["grid"]);
$r["version"] = $f->get_Value("version", $row["version"]);

$r["period"] = $f->get_Value("period", $row["period"]);
$r["moment"] = $f->get_Value("moment", $row["moment"]);
$r["cycle"] = $f->get_Value("cycle", $row["cycle"]);
$r["reference"] = $f->get_Value("reference", $row["reference"]);
$r["observation"] = $f->get_Value("observation", $row["observation"]);
$r["date"] = $f->get_Value("date", $row["date"]);
$r["time"] = $f->get_Value("time", $row["time"]);
$r["author"] = $f->get_Value("author", $row["author"]);
$r["locked_at"] = $f->get_Value("locked_at", $row["locked_at"]);
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
$back = "/sie/students/view/{$r["registration"]}";
$programs = $mprograms->get_SelectData();


$dgrids = array(array("value" => "", "label" => "Seleccione una malla"));
$dversions = array(array("value" => "", "label" => "Seleccione una versión"));

$grids = $mgrids->get_SelectData($r["program"]);
$versions = $mversions->get_SelectData($r["grid"]);

$dgrids = array_merge($dgrids, $grids);
$dversions = array_merge($dversions, $versions);


//[fields]----------------------------------------------------------------------------------------------------------------
$f->fields["status"] = $f->get_FieldText("status", array("value" => $r["status"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));

$f->fields["enrollment"] = $f->get_FieldText("enrollment", array("value" => $r["enrollment"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["enrollment_date"] = $f->get_FieldText("enrollment_date", array("value" => $r["enrollment_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));


$f->fields["registration"] = $f->get_FieldText("registration", array("value" => $r["registration"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["program"] = $f->get_FieldSelect("program", array("selected" => $r["program"], "data" => $programs, "proportion" => "col-12", "readonly" => true));
$f->fields["grid"] = $f->get_FieldSelect("grid", array("selected" => $r["grid"], "data" => $dgrids, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["version"] = $f->get_FieldSelect("version", array("selected" => $r["version"], "data" => $dversions, "proportion" => "col-md-6 col-sm-12 col-12"));
$f->fields["period"] = $f->get_FieldSelect("period", array("selected" => $r["period"], "data" => LIST_PERIODS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["moment"] = $f->get_FieldSelect("moment", array("selected" => $r["moment"], "data" => LIST_MOMENTS, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cycle"] = $f->get_FieldSelect("cycle", array("selected" => $r["cycle"], "data" => LIST_CYCLES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["reference"] = $f->get_FieldSelect("reference", array("selected" => $r["reference"], "data" => LIST_STATUSES, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["observation"] = $f->get_FieldTextArea("observation", array("value" => $r["observation"], "proportion" => "col-12"));
$f->fields["author"] = $f->get_FieldText("author", array("value" => $r["author"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["date"] = $f->get_FieldText("date", array("value" => $r["date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["time"] = $f->get_FieldText("time", array("value" => $r["time"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["locked_at"] = $f->get_FieldText("locked_at", array("value" => $r["locked_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]---------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["status"] . $f->fields["registration"] . $f->fields["reference"])));
$f->groups["g2"]= $f->get_Group(array("legend" => "", "fields" => ($f->fields["enrollment"] . $f->fields["enrollment_date"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["program"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["grid"] . $f->fields["version"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["period"] . $f->fields["moment"] . $f->fields["cycle"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["date"] . $f->fields["time"] . $f->fields["locked_at"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["author"])));
$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["observation"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
        "title" => lang("Sie_Statuses.edit-title"),
        "content" => $f,
        "header-back" => $back
));
echo($card);
?>
<script>
    // Función para mostrar el modal
    function showLoading() {
        const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
        loadingModal.show();
        const audio = document.getElementById('audio-wait-momment');
        audio.play();
        audio.addEventListener('ended', function () {
            hideLoading();
            location.reload();
        });
    }

    // Función para ocultar el modal
    function hideLoading() {
        const loadingModal = bootstrap.Modal.getInstance(document.getElementById('loadingModal'));
        if (loadingModal) {
            loadingModal.hide();
        }
    }

    function hideStatusModal() {
        const loadingModal = bootstrap.Modal.getInstance(document.getElementById('statusModal'));
        if (loadingModal) {
            loadingModal.hide();
        }
    }

    document.getElementById('<?php echo($f->get_FieldId("program"));?>').addEventListener('change', function () {
        var program = this.value;
        var grid = document.getElementById('<?php echo($f->get_FieldId("grid"));?>');
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
                grid.innerHTML = html;
            }
        };
        xhr.send();
    });

    document.getElementById('<?php echo($f->get_FieldId("grid"));?>').addEventListener('change', function () {
        var program = document.getElementById('<?php echo($f->get_FieldId("program"));?>').value;
        var grid = document.getElementById('<?php echo($f->get_FieldId("grid"));?>').value;
        var version = document.getElementById('<?php echo($f->get_FieldId("version"));?>');
        if (grid && grid.trim() !== "") {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', "/sie/api/versions/json/all/" + grid, true);
            xhr.responseType = 'json';
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var data = xhr.response.data;
                    var html = "";
                    html += '<option value="">Seleccione una versión...</option>';
                    for (var count = 0; count < data.length; count++) {
                        html += '<option value="' + data[count].version + '">' + data[count].reference + '</option>';
                    }
                    version.innerHTML = html;
                }
            };
            xhr.send();
        } else {
            console.log("No se consulta la version de la malla ya que no hay una malla seleccionada" + grid);
        }
    });
</script>