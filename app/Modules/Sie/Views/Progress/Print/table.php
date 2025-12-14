<?php
/** @var string $oid */
/** @var service $request */
//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
//[models]--------------------------------------------------------------------------------------------------------------
$mpensums = model("App\Modules\Sie\Models\Sie_Pensums");
$mprogress = model("App\Modules\Sie\Models\Sie_Progress");
$mmodules = model("App\Modules\Sie\Models\Sie_Modules");
$menrollments = model("App\Modules\Sie\Models\Sie_Enrollments");
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$mgrids = model("App\Modules\Sie\Models\Sie_Grids");
$mversions = model("App\Modules\Sie\Models\Sie_Versions");
$mexecutions = model("App\Modules\Sie\Models\Sie_Executions");
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
//[vars]----------------------------------------------------------------------------------------------------------------

$offset = !empty($request->getGet("offset")) ? $request->getGet("offset") : 0;
$search = !empty($request->getGet("search")) ? $request->getGet("search") : "";
$field = !empty($request->getGet("field")) ? $request->getGet("field") : "";
$limit = !empty($request->getGet("limit")) ? $request->getGet("limit") : 10;

$enrollment = $menrollments->get_Enrollment($oid);
$registration = $mregistrations->getRegistration($enrollment['registration']);
$grid = $mgrids->get_Grid($enrollment['grid']);
$version = $mversions->get_Version($enrollment['version']);

$progresses = $mprogress->get_ProgressByEnrollment($oid);


$total = $mprogress->get_TotalByEnrollment($oid);
$fields = [
    'identification' => 'Número de identificación',
    'names' => 'Nombres',
];

$enrollment_grid = $enrollment['grid'];
$grid_name = $grid['name'];
$version_reference = @$version['reference'];

$student_full_name = "{$registration['first_name']} {$registration['second_name']} {$registration['first_surname']} {$registration['second_surname']}";

$program = $mprograms->getProgram($enrollment['program']);
$program_program = $enrollment['program'];
$program_name = safe_strtoupper(sie_get_textual_program($enrollment['program']));
$program_reg = $registration['program'];
$program_resolution = $program['resolution'];
$program_resolution_date = $program['resolution_date'];


$code = "<div id=\"printable\">";
$code .= "<b>Estudiante</b>: {$student_full_name} - <b>Identificación</b>: {$registration['identification_type']} {$registration['identification_number']} </br>";
$code .= "<b>Programa</b> : {$program_name} <i class='opacity-2'>- {$program_program}</i> </br>";
$code .= "<b>Malla</b>: {$grid_name} <i class='opacity-2'>- {$enrollment_grid}</i> <b>Versión</b>: {$version_reference}</br>";
$code .= "<b>Fecha de matrícula</b>:  {$enrollment['date']} </br>";
$code .= "</br>";
//[grid]--------------------------------------------------------------------------------------------------------------
$bgrid = $bootstrap->get_Grid();
$bgrid->set_Total($total);
$bgrid->set_Limit($limit);
$bgrid->set_Offset($offset);
$bgrid->set_Class("P-0 m-0");
$bgrid->set_Limits(array(10, 20, 40, 80, 160, 320, 640, 1200, 2400));
$bgrid->set_Headers(array(
    array("content" => "#", "class" => "text-center  align-middle"),
    array("content" => lang("App.Module"), "class" => "text-center align-middle"),
    array("content" => lang("App.Course"), "class" => "text-center align-middle"),
    array("content" => "CA", "class" => "text-center align-middle"),
    array("content" => "UC", "class" => "text-center align-middle"),
));
//$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));

$count = 0;
$cycle_prev = 0;
$credits = 0;
$average = 0;
$modulesxcycle = 0;
$creditsearned = 0;
$creditsearnedvalue = 0;


$pdfmodules = array();


foreach ($progresses as $progress) {
    $count++;
    $module = $mmodules->get_Module($progress['module']);
    $pensum = $mpensums->get_Pensum($progress['pensum']);
    $module_name = "<br><b>Módulo</b>: " . @$module['name'] . " - <i class=\"opacity-25\">{$progress['progress']}</i>";
    // Se debe establecer la última calificacion por encima de la fijada en el sistema última no es la última si no las última 3 UC
    $last_calification = "<div class=\"last_calification\"></div>";
    $img = "";
    $execution = $mexecutions->get_LastByProgress($progress['progress']);
    $cycle_actual = @$pensum['cycle'];
    $cycle_prev = ($cycle_prev == 0) ? $cycle_actual : $cycle_prev;
    $ct = 0;
    $creditsearnedvalue += $creditsearned;
    $status = "";
    foreach (LIST_STATUSES_PROGRESS as $lstatus) {
        if ($progress['status'] == $lstatus['value']) {
            $status = $lstatus['label'];
            break;
        }
    }
    if ($progress['status'] == "APPROVED") {
        $img = "<img src=\"/themes/temp/cdcolor.png\" class=\"\" alt=\"" . $progress['module'] . "\" width=\"64\">";
        $status = "<span class=\"badge bg-success\">$status</span>";
    } elseif ($progress['status'] == "HOMOLOGATION") {
        $img = "<img src=\"/themes/temp/cdcolor.png\" class=\"\" alt=\"" . $progress['module'] . "\" width=\"64\">";
        $status = "<span class=\"badge bg-success\">$status</span>";
    } elseif ($progress['status'] == "IMPROVEMENT") {
        $img = "<img src=\"/themes/temp/cdred.png\" class=\"\" alt=\"" . $progress['module'] . "\" width=\"64\">";
        $status = "<span class=\"badge bg-danger\">$status</span>";
    } else {
        $img = "<img src=\"/themes/assets/images/cd.webp\" class=\"\" alt=\"" . $progress['module'] . " \" width=\"64\">";
        $status = "<span class=\"badge bg-secondary\">$status</span>";
    }
    $progress_author = $progress['author'];
    $author_data = $mfields->get_Profile($progress_author);
    $author = "<br><b>Responsable</b>: " . $author_data['name'] . " - <span class=\"opacity-25\">$progress_author</span>";
    $ciclo = "<br><b>Ciclo</b>: " . @$pensum['cycle'] . " ";
    $momento = "<b>Momento</b>: " . @$pensum['moment'] . " ";
    $status = "<br><b>Estado Adminitrativo</b>: {$status}";
    $details = $module_name . $author . $ciclo . $momento . $status;
    $vexecution = json_decode(view('App\Modules\Sie\Views\Progress\List\execution', array("execution" => $execution, "progress" => $progress)));
    //[links]-----------------------------------------------------------------------------------------------------------
    $href_edit = "/sie/progress/edit/{$progress['progress']}?lpk=" . lpk();
    $href_delete = "/sie/progress/delete/{$progress['progress']}?lpk=" . lpk();
    //[btns]------------------------------------------------------------------------------------------------------------
    $btnedit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $href_edit, "class" => "btn-secondary ml-1"));
    $btndelete = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $href_delete, "class" => "btn-sm btn-danger ml-1"));
    $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnedit . $btndelete));
    $calification = json_decode(view('App\Modules\Sie\Views\Progress\List\calification', array("credits" => @$pensum['credits'], "execution" => $execution, "progress" => $progress)));
    $creditsearnedvalue += $calification->creditsearned;
    $average += $calification->average;
    $modulesxcycle += $calification->module;
    //[pdf]-------------------------------------------------------------------------------------------------------------
    $pdfmodulename = safe_substr(mb_convert_encoding($module['name'], 'ISO-8859-1', 'UTF-8'), 0, 55);
    $pdfmodulename = strlen($pdfmodulename) > 70 ? substr($pdfmodulename, 0, 70) . "..." : $pdfmodulename;

    $pensum_credits = !empty(@$pensum['credits']) ? @$pensum['credits'] : 0;

    $pdfmodules[] = array(
        "module" => $pdfmodulename,
        "cycle" => @$pensum['cycle'],
        "moment" => @$pensum['moment'],
        "status" => $status,
        "author" => @$author_data['name'],
        "calification" => $calification->render,
        "creditsearned" => $calification->creditsearned,
        "credits" => $calification->creditsearned . "/" . $pensum_credits,
        "execution" => $vexecution->render,
        'reference' => $calification->reference,
        'uc1' => $calification->uc1,
        'uc2' => $calification->uc2,
        'uc3' => $calification->uc3,
        'ct' => $calification->ct,
    );
    //[/pdf]------------------------------------------------------------------------------------------------------------
    $bgrid->add_Row(array(
        array("content" => $count, "class" => "text-center  align-middle"),
        array("content" => $details, "class" => "text-left  align-middle"),
        array("content" => $vexecution->render, "class" => "align-middle"),
        array("content" => $calification->creditsearned . "/" . @$pensum['credits'], "class" => "text-center  align-middle"),
        array("content" => $calification->render, "class" => "text-center  align-middle"),
    ));
    if ($cycle_actual != $cycle_prev || count($progresses) == $count) {
        if ($modulesxcycle > 0) {
            $average = round($average / $modulesxcycle, 2);
        }
        $bgrid->add_Row(array(
            array("content" => "Consolidados:", "class" => "text-end  align-middle", "colspan" => "3"),
            array("content" => "{$creditsearnedvalue}/{$credits}", "class" => "text-center  align-middle", "colspan" => "1"),
            array("content" => $average, "class" => "text-center  align-middle", "colspan" => "1"),
        ));
        $credits = 0;
        $average = 0;
        $modulesxcycle = 0;
        $creditsearnedvalue = 0;
    }
    $credits += @$pensum['credits'];
    $cycle_prev = $cycle_actual;
}
$code .= $bgrid;
$code .= "</div>";
$code = "";
//[pdf]-----------------------------------------------------------------------------------------------------------------
include("pdf.php");
//[build]---------------------------------------------------------------------------------------------------------------
$back = "/sie/students/view/{$enrollment['registration']}";
$preenrrollment = "/sie/tools/preenrollment/home/update?identification_number={$registration['identification_number']}";
$card = $bootstrap->get_Card2("card-view-service", array(
    "header-title" => "Versión imprimible",
    "header-back" => $back,
    "header-add" => array("href" => "/sie/progress/create/{$oid}?lpk=" . lpk(), "target" => "_blank"),
    //"header-print" => array("href" => "javascript:doPrint();", "target" => "_self", "onclick" => ""),
    "content" => $code,
));
echo($card);
?>