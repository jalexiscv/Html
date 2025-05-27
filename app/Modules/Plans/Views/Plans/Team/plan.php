<?php
/** @var  $bootstrap */
/** @var  $model */
/** @var  $oid */

$bootstrap = service("bootstrap");
$numbers = service("numbers");
//[models]--------------------------------------------------------------------------------------------------------------
$mdimensions = model('App\Modules\Plans\Models\Plans_Dimensions');
$mpolitics = model('App\Modules\Plans\Models\Plans_Politics');
$mdiagnostics = model('App\Modules\Plans\Models\Plans_Diagnostics');
$mcomponents = model('App\Modules\Plans\Models\Plans_Components');
$mcategories = model('App\Modules\Plans\Models\Plans_Categories');
$mactivities = model('App\Modules\Plans\Models\Plans_Activities');
$mplans = model('App\Modules\Plans\Models\Plans_Plans');
$mprocess = model('App\Modules\Plans\Models\Plans_Processes');
$msubprocess = model('App\Modules\Plans\Models\Plans_Subprocesses');
$users = model('App\Modules\Plans\Models\Plans_Users');
$mfields = model('App\Modules\Plans\Models\Plans_Users_Fields');
//[var]-----------------------------------------------------------------------------------------------------------------
// $oid Recibe  "Plan"
$plan = $mplans->getPlan($oid);
$process = $mprocess->get_Process(@$plan['manager']);
//print_r($process);
//exit();
$profile = $mfields->get_Profile(@$process['responsible']);

$f = service("forms", array("lang" => "Plans_Plans."));

$r["manager"] = $f->get_Value("manager", @$plan['manager']);
$r["manager_process_name"] = @$process['name'];
$r["manager_user"] = @$profile['name'];
$r["manager_subprocess"] = $f->get_Value("manager_subprocess", @$plan['manager_subprocess']);
$r["manager_position"] = $f->get_Value("manager_position", @$plan['manager_position']);
$back = "/plans/plans/view/{$oid}";
$row = $model->where('plan', $oid)->first();

$positions = array(
    array("value" => "", "label" => "- [ Seleccione uno ]"),
);

$subprocess = array(array("value" => "", "label" => "- [ Seleccione uno ]"));
$dsubprocess = $msubprocess->get_SelectDataWithPosition(@$process['process']);
$list_subprocess = array_merge($subprocess, $dsubprocess);

//array_push($subprocess, $dsubprocess);


$status = "";
if ($plan['status'] == "COMPLETED") {
    $status = "disabled";
}

//[fields]--------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("plan", $oid);
$f->fields["manager"] = $f->get_FieldText("manager", array("value" => $r["manager"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["manager_process_name"] = $f->get_FieldText("manager_process_name", array("value" => $r["manager_process_name"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["manager_user"] = $f->get_FieldText("manager_user", array("value" => $r["manager_user"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));


$f->fields["manager_subprocess"] = $f->get_FieldSelect("manager_subprocess", array("data" => $list_subprocess, "selected" => $r["manager_subprocess"], "class" => "{$status}", "proportion" => "col-12"));
$f->fields["manager_position"] = $f->get_FieldSelect("manager_position", array("data" => $positions, "selected" => $r["manager_position"], "class" => "{$status}", "proportion" => "col-12"));

$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Update"), "class" => "{$status}", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]--------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["manager"] . $f->fields["manager_process_name"] . $f->fields["manager_user"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["manager_subprocess"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["manager_position"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => sprintf("Equipo de trabajo del Plan de acción %s", $numbers->pad_LeftWithZeros($plan['order'], 4)),
    "header-back" => $back,
    //"footer-continue" => $back,
    "content" => $f,
));
echo($card);
?>
<script>

    const field_subprocess = document.getElementById("<?php echo($f->get_fid());?>_manager_subprocess");
    const field_position = document.getElementById("<?php echo($f->get_fid());?>_manager_position");
    field_subprocess.addEventListener("change", function () {
        //alert("field_subprocess change");
        changeSubprocess();
    });
    changeSubprocess();

    function changeSubprocess() {
        let subprocess = field_subprocess.value;
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "/plans/api/positions/json/list/" + subprocess, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response) {
                    field_position.innerHTML = "";
                    response.forEach(position => {
                        const option = document.createElement("option");
                        option.value = position.value;
                        option.textContent = position.label;
                        field_position.appendChild(option);
                    });
                } else {
                    console.log("No hay datos disponibles para este proceso.");
                }
            } else {
                console.error("Error en la solicitud XHR.");
            }
        };
        xhr.send();
    }

</script>