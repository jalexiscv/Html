<?php
/** @var string $oid */
$mprojects = model('App\Modules\Project\Models\Project_Projects');
$mtasks = model('App\Modules\Project\Models\Project_Tasks');
$mstatuses = model('App\Modules\Project\Models\Project_Statuses');


$ctasks = $mtasks->getCountByProject($oid);
$ccompleted = $mtasks->getCountByStatusByProject("COMPLETED", $oid);

$percentaje_completed = round((($ctasks > 0) ? ($ccompleted / $ctasks) * 100 : 0), 2);

$code = "";
$code .= "<div class=\"card flex-row align-items-center align-items-stretch mb-3\">\n";
$code .= "\t\t<div class=\"col-4 d-flex align-items-center bg-gray justify-content-center rounded-left\">\n";
$code .= "\t\t\t\t<i class=\"icon fa-regular fa-thumbtack fa-3x\"></i>\n";
$code .= "\t\t</div>\n";
$code .= "\t\t<div class=\"col-8 py-3 bg-gray rounded-right\">\n";
$code .= "\t\t\t\t<div class=\"fs-5 lh-5 my-0\">\n";
$code .= "\t\t\t\t\t\t{$ctasks}\t\t\t\t</div>\n";
$code .= "\t\t\t\t<div class=\"\t\tmy-0\">\n";
$code .= "\t\t\t\t\t\t" . lang("Project.Task-Count") . "\t\t\t\t</div>\n";
$code .= "\t\t</div>\n";
$code .= "</div>\n";

$code .= "<div class=\"card flex-row align-items-center align-items-stretch mb-3\">\n";
$code .= "\t\t<div class=\"col-4 d-flex align-items-center bg-gray justify-content-center rounded-left\">\n";
$code .= "\t\t\t\t<i class=\"icon fa-regular fa-circle-check fa-3x text-success \"></i>\n";
$code .= "\t\t</div>\n";
$code .= "\t\t<div class=\"col-8 py-3 bg-gray rounded-right\">\n";
$code .= "\t\t\t\t<div class=\"fs-5 lh-5 my-0\">\n";
$code .= "\t\t\t\t\t\t{$percentaje_completed}%\t\t\t\t</div>\n";
$code .= "\t\t\t\t<div class=\"\t\tmy-0\">\n";
$code .= "\t\t\t\t\t\t" . lang("Project.Task-Completed-Count") . ": " . "{$ccompleted}\t\t\t\t</div>\n";
$code .= "\t\t</div>\n";
$code .= "</div>\n";


echo($code);

?>