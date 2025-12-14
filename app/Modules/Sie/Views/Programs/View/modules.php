<?php
$bootstrap = service('bootstrap');
$mmodules = model('App\Modules\Sie\Models\Sie_Modules');
$mpensums = model('App\Modules\Sie\Models\Sie_Pensums');
$grid = $bootstrap->get_Grid();
$grid->set_Headers(array(
    "#",
    "Código",
    "Referencia",
    "Modulo académico",
    "IHS",
    "IHT",
    "Créditos",
    "Opciones",
));

$count = 0;
$pensums = $mpensums->where('program', $oid)->findAll();
foreach ($pensums as $pensum) {
    $count++;
    $npensum = $pensum["pensum"];
    $reference = $pensum["reference"];
    $row = $mmodules->where('module', $pensum["module"])->first();
    if (is_array($row)) {
        $module = $row["name"];
        $ihs = $pensum["weekly_hourly_intensity"];
        $iht = $pensum["hourly_intensity"];
        $credits = $pensum["credits"];
        $opciones = "<a href=\"/sie/pensums/edit/{$pensum["pensum"]}\" class=\"btn btn-sm btn-primary mx-1\"><i class=\"fa-light fa-pen-to-square\"></i></a>";
        $opciones .= "<a href=\"/sie/pensums/delete/{$pensum["pensum"]}\" class=\"btn btn-sm btn-danger\"><i class=\"fa-light fa-trash\"></i></a>";
        $grid->add_Row(array($count, $npensum, $reference, $module, $ihs, $iht, $credits, $opciones));
    }
}

echo($grid);
?>