<?php
//@$oid string representa el programa academico
$mpensums = model("App\Modules\Sie\Models\Sie_Pensums");
$mmodules = model("App\Modules\Sie\Models\Sie_Modules");
$pensums = $mpensums->where("program", $oid)->findAll();

$data = array();
foreach ($pensums as $pensum) {
    $module = $mmodules->where("module", $pensum['module'])->first();
    if (is_array($module)) {
        array_push($data, array("value" => $module['module'], "label" => "{$module['name']} - {$module['reference']}"));
    }
}
if (count($data) == 0) {
    array_push($data, array("value" => "", "label" => "No hay módulos"));
}

echo json_encode($data);

?>