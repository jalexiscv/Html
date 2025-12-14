<?php
/** @var $oid * */
$bootstrap = service("bootstrap");
//[Models]--------------------------------------------------------------------------------------------------------------
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$mattachments = model("App\Modules\Sie\Models\Sie_Attachments");
$mstatuses = model("App\Modules\Sie\Models\Sie_Statuses");
$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$mgrids = model('App\Modules\Sie\Models\Sie_Grids');
$mversions = model('App\Modules\Sie\Models\Sie_Versions');
$mpensums = model('App\Modules\Sie\Models\Sie_Pensums');
//[Request]-------------------------------------------------------------------------------------------------------------
$lastStatus = $mstatuses->get_LastStatus($oid);

// Necesito sacar el valor textual del status
$statuses = LIST_STATUSES;
$statusName="";
foreach ($statuses as $key => $value) {
    if (@$value['value'] == @$lastStatus['reference']) {
        $statusName = $value['label'];
        break;
    }
}


$responsible = $mfields->get_Profile(@$lastStatus['author']);
$responsible_name = @$responsible['name'];
$status= $statusName." - ".@$lastStatus['status'];
$period = @$lastStatus['period'];
$date=@$lastStatus['date'];
$time=@$lastStatus['time'];
$responsible_name = @$responsible['name'];
$programa=@$lastStatus['program'];

$program = $mprograms->getProgram(@$lastStatus["program"]);
$program_program=@$lastStatus["program"];
$grid = $mgrids->get_Grid(@$lastStatus["grid"]);
$version = $mversions->get_Version(@$lastStatus["version"]);
$program_name =is_array($program)?@$program["name"]:"";

$grid_grid = @$grid["grid"];
$grid_name = @$grid['name'];
$version_version = @$version["version"];
$version_reference = @$version['reference'];
$author_author=@$lastStatus["author"];

$code="";
$code.="<div id=\"card-view-service\" class=\"card\tmb-2\">\n";
$code.="<div class=\"card-body \"><div class=\"card-content \">";

$code.="<b>Último Estado</b>: {$status}<br>";
$code.="<b>Periodo</b>: {$period}<br>";
$code.="<b>Fecha</b>: {$date} <b>Hora</b>: {$time}<br>";
$code.="<b>Responsable</b>: {$responsible_name} - <span class=\"opacity-25\">{$author_author}</span><br>";
$code.="<b>" . lang("App.Program") . ":</b> $program_name - <span class=\"opacity-25\">{$program_program}</span><br>";
$code.= "<b>Malla:</b> $grid_name <span class=\"opacity-25\">$grid_grid</span><br>";
$code.= "<b>Versión:</b>$version_reference <span class=\"opacity-25\">$version_version</span><br>";


$code.="<a id=\"change-status\" class=\"btn btn-outline-secondary w-100\" href=\"#\" data-bs-toggle=\"modal\" data-bs-target=\"#statusModal\"><div class=\"btn-text-inline\">Actualizar Estado</div></a><br>\n";


$code.="</div>\n";
$code.="</div>\n";
$code.="</div>\n";
echo($code);
?>