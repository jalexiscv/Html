<?php
/** @var string $oid */
$bootstrap = service("bootstrap");
//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Sie_Registrations."));
$request = service("request");
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sie\Models\Sie_Registrations");
$mprogams = model("App\Modules\Sie\Models\Sie_Programs");
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$mprogress = model("App\Modules\Sie\Models\Sie_Progress");
$mmodules = model("App\Modules\Sie\Models\Sie_Modules");
$menrollments = model("App\Modules\Sie\Models\Sie_Enrollments");
$mpensums = model("App\Modules\Sie\Models\Sie_Pensums");
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
$musers = model('App\Modules\Sie\Models\Sie_Users');
$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');
$mversions = model('App\Modules\Sie\Models\Sie_Versions');
$mgrids = model('App\Modules\Sie\Models\Sie_Grids');
$mexecutions = model('App\Modules\Sie\Models\Sie_Executions');
//[vars]----------------------------------------------------------------------------------------------------------------

//$identification_number = $f->get_Value("identification_number");//echo($identification_number);
//$registration = $mregistrations->getRegistrationByIdentification($identification_number);
$rback = $request->getVar("back");
$back = "/sie/progress/list/{$oid}";
if ($rback == "progress-reader") {
    $back = "/sie/progress/reader/{$oid}";
}

$table = "";
if (!empty($oid)) {
    $enrrollment = $menrollments->get_Enrollment($oid);
    //print_r($enrrollment);
    if (!empty($enrrollment['program'])) {
        $registration = $mregistrations->getRegistration($enrrollment['registration']);
        $journey = @$registration['journey'];
        $progresses = $mprogress->get_ProgressByEnrollment($enrrollment['enrollment']);
        //print_r($progresses);
        $fid = "form_preenrrolments";

        $table .= view("App\Modules\Sie\Views\Preenrollments\Edit\Components\header", array("registration" => $registration, "enrrollment" => $enrrollment));

        $table .= "<form id=\"{$fid}\" action=\"\" method=\"post\">";
        $table .= "<input type=\"hidden\" name=\"submited\" value=\"{$fid}\">";
        $table .= "<input type=\"hidden\" name=\"{$fid}_enrollment\" value=\"{$enrrollment['enrollment']}\">";
        $table .= "<table class=\"table table-bordered\">";

        $table .= "<tr>";
        $table .= " <td class=\"text-center align-middle\"><b>Nombre del Módulo</b></td>";
        $table .= " <td class=\"text-center align-middle\"><b>Momento</b></td>";
        $table .= " <td class=\"text-center align-middle\"><b>Jornada</b></td>";
        $table .= "</tr>";

        foreach ($progresses as $progress) {

            $execution = $mexecutions->get_LastByProgress($progress['progress']);
            //$vexecution = json_decode(view('App\Modules\Sie\Views\Preenrollments\Edit\execution', array("execution" => $execution, "progress" => $progress)));
            $vcalification = json_decode(view('App\Modules\Sie\Views\Preenrollments\Edit\calification', array("credits" => @$pensum['credits'], "execution" => $execution, "progress" => $progress)));

            $enrollment = $menrollments->get_Enrollment($progress['enrollment']);
            $registration = $mregistrations->getRegistration($enrollment['registration']);

            $module = $mmodules->get_Module($progress['module']);

            $pensum = $mpensums
                ->where("module", $progress['module'])
                ->where("version", $enrollment['version'])
                ->first();
            $moment_module = @$pensum['moment'];//MM
            $credits = @$pensum['credits'];
            $last_calification = "<div class=\"last_calification\"><b>" . $progress['last_calification'] . "</b></div>";
            $module = $mmodules->get_Module($progress['module']);
            $label = "" . $module['name'] . "";
            $table .= "<tr class=\"\">";
            $table .= "<td class=\"text-center align-middle\">{$label}<br>";
            $table .= "<span class=\"extra-data\">MP-{$progress['progress']} / MB-{$progress['module']} / CR-{$credits}</span>  ";

            $table .= "</td>";
            $table .= "<td class=\"text-center align-middle\">{$moment_module}</td>";

            $table .= "<td class=\"text-left align-middle\">";
            if ($vcalification->creditsearned > 0) {
                $table .= $vcalification->render;
            } else {
                include("Components/check.php");
            }
            //echo("Creditos Ganados(".$vcalification->origen."):".$vcalification->creditsearned."<br>");
            $table .= "</td>";
            $table .= "</tr>";
            //}
        }
        $table .= "<tr>";
        $table .= "<td colspan=\"5\" align=\"right\">";
        $table .= "<div class=\"align-right \">";
        $table .= "<a id=\"btn-print\" href=\"#\" class=\"btn btn-danger mx-1\">Imprimir</a>";
        $table .= "<button id=\"btn-submit\" type=\"button\" class=\"btn btn-primary floa-right\">Actualizar</button>";
        $table .= "</div>";
        $table .= "</td>";
        $table .= "</tr>";
        $table .= "</table>";
        $table .= "</form>";
    } else {
        $table .= "Estudiante no matriculado academicamente!";
        $table .= "<div id=\"group_66d251dd6aa5b\" class=\"form-group text-end\">";
        $table .= "<a href=\"/sie/tools/preenrollment/home/update?t=" . lpk() . "\" class=\"btn btn-primary\">Reintentar</a>";
        $table .= "</div>";
    }
} else {
    $table .= "No se recibio la matricula!";
    $table .= "<div id=\"group_66d251dd6aa5b\" class=\"form-group text-end\">";
    $table .= "<a href=\"/sie/tools/preenrollment/home/update?t=" . lpk() . "\" class=\"btn btn-primary\">Reintentar</a>";
    $table .= "</div>";
}
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => "Actualización de Prematricula",
    "header-back" => $back,
    "alert" => array(
        "icon" => ICON_INFO,
        "type" => "info",
        "title" => lang('Sie_Preenrollment.info-list-title'),
        "message" => lang('Sie_Preenrollment.info-list-message')
    ),
    "content" => $table,
));
echo($card);
?>
<?php include("Components/javascript.php"); ?>