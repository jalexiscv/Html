<?php
/** @var object $registration */
/** @var object $enrrollment */
//model-----------------------------------------------------------------------------------------------------------------
$mprogams = model("App\Modules\Sie\Models\Sie_Programs");
$mgrids = model('App\Modules\Sie\Models\Sie_Grids');
$mversions = model('App\Modules\Sie\Models\Sie_Versions');
$mpensums = model('App\Modules\Sie\Models\Sie_Pensums');
$mstatuses = model('App\Modules\Sie\Models\Sie_Statuses');
//vars------------------------------------------------------------------------------------------------------------------
$name = $registration['first_name'] . " " . $registration['second_name'] . " " . $registration['first_surname'] . " " . $registration['second_surname'];
$registration_registration = $registration['registration'];
$program = $mprogams->getProgram($enrrollment['program']);
$program_program = @$program['program'];
$program_name = @$program['name'];
$grid = $mgrids->get_Grid(@$enrrollment['grid']);
$grid_name = @$grid['name'];
$grid_grid = @$grid['grid'];
$version = $mversions->get_Version($enrrollment['version']);
$version_reference = @$version['reference'];
$version_version = @$version['version'];
$moment_student = $registration['moment'];
$journey = $registration['journey'];


$last_status = $mstatuses->get_LastStatus($registration_registration);
$credits = $mpensums->get_CalculateCredits(@$program["program"], @$grid["grid"], @$version["version"], @$last_status["cycle"]);


//build-----------------------------------------------------------------------------------------------------------------

$code = "";
$code .= "<div class=\"col-12 col-12 p-2 border mb-2\">";
$code .= "    <div class=\"row \">";
$code .= "        <div class=\"col-8\">";
$code .= "            <div class=\"row\">";
$code .= "                <div class=\"col-4 text-end\"><b>Estudiante</b>:</div>";
$code .= "                <div class=\"col-8\">{$name} <span class=\"opacity-25\">{$registration_registration}</span></div>";
$code .= "            </div>";
$code .= "            <div class=\"row\">";
$code .= "                <div class=\"col-4 text-end\"><b>Programa</b>:</div>";
$code .= "                <div class=\"col-8\">{$program_name} <span class=\"opacity-25\">{$program_program}</span></div>";
$code .= "            </div>";
$code .= "            <div class=\"row\">";
$code .= "                <div class=\"col-4 text-end\"><b>Malla</b>:</div>";
$code .= "                <div class=\"col-8\">{$grid_name} <span class=\"opacity-25\">{$grid_grid}</span></div>";
$code .= "            </div>";
$code .= "            <div class=\"row\">";
$code .= "                <div class=\"col-4 text-end\"><b>Versión</b>:</div>";
$code .= "                <div class=\"col-8\">{$version_reference} <span class=\"opacity-25\">{$version_version}</span></div>";
$code .= "            </div>";
$code .= "            <div class=\"row\">";
$code .= "                <div class=\"col-4 text-end\"><b>Momento Actual</b>:</div>";
$code .= "                <div class=\"col-8\">{$moment_student} <b>Jornada</b>: {$journey}</div>";
$code .= "            </div>";
$code .= "        </div>";
$code .= "<div class=\"col-4\">";
$code .= "    <div class=\"row\">";
$code .= "        <div class=\"col-12 text-center\">";
$code .= "            <b>Créditos Matriculables</b>";
$code .= "        </div>";
$code .= "    </div>";
$code .= "    <div class=\"row\">";
$code .= "        <div class=\"col-12 text-center fs-1 p-2\">";
$code .= "            <span id=\"count-credits\">0</span>/{$credits}";
$code .= "        </div>";
$code .= "    </div>";
$code .= "</div>";
$code .= "</div>";
$code .= "</div>";
echo($code);
?>
<script>
    var credits =<?php echo($credits);?>;

</script>
