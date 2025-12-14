<?php
//[models]--------------------------------------------------------------------------------------------------------------
$mprogress = model("App\Modules\Sie\Models\Sie_Progress");
$mmodules = model("App\Modules\Sie\Models\Sie_Modules");
//[vars]----------------------------------------------------------------------------------------------------------------

$progresses = $mprogress->get_ProgressByEnrollment($oid);
$count = count($progresses);
$code = "";
$code .= "<div class=\"card flex-row align-items-center align-items-stretch mb-3\">\n";
$code .= "\t\t<div class=\"col-4 d-flex align-items-center bg-gray justify-content-center rounded-left\">\n";
$code .= "\t\t\t\t<i class=\"fa-regular fa-book fa-3x\"></i>\n";
$code .= "\t\t</div>\n";
$code .= "\t\t<div class=\"col-8 py-3 bg-gray rounded-right\">\n";
$code .= "\t\t\t\t<div class=\"fs-1 lh-5 my-2 py-2\">\n";
$code .= "\t\t\t\t\t\t{$count}\t\t\t\t</div>\n";
$code .= "\t\t\t\t<div class=\"\t\tmy-0\">\n";
$code .= "\t\t\t\t\t\t Módulos Matriculados \t\t\t\t</div>\n";
$code .= "\t\t</div>\n";
$code .= "</div>\n";
echo($code);


?>