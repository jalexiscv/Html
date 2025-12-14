<?php
$bootstrap = service('bootstrap');
$mmodules = model('App\Modules\Sie\Models\Sie_Modules');
$mversions = model('App\Modules\Sie\Models\Sie_Versions');
$bgrid = $bootstrap->get_Grid();
$bgrid->set_Headers(array(
    array("content" => "#", "class" => "text-center text-nowrap align-middle"),
    array("content" => "Código", "class" => "text-center align-middle"),
    array("content" => "Nombre", "class" => "text-center align-middle"),
    array("content" => "Fecha", "class" => "text-center align-middle"),
    array("content" => "Hora", "class" => "text-center align-middle"),
    array("content" => "Opciones", "class" => "text-center text-nowrap align-middle"),
));

$count = 0;
$versions = $mversions->where('grid', $oid)->findAll();
if (is_array($versions)) {
    foreach ($versions as $version) {
        $count++;
        $code = $version["version"];
        $name = $version["reference"];
        $grid = $version["grid"];
        $opciones = "<div class=\"btn-group w-auto\">";
        $opciones .= "<a href=\"/sie/versions/view/{$version["version"]}\" class=\"btn btn-sm btn-primary\"><i class=\"fa-light fa-eye\"></i></a>";
        $opciones .= "<a href=\"/sie/versions/edit/{$version["version"]}\" class=\"btn btn-sm btn-warning\"><i class=\"fa-light fa-pen-to-square\"></i></a>";
        $opciones .= "<a href=\"/sie/versions/delete/{$version["version"]}\" class=\"btn btn-sm btn-danger\"><i class=\"fa-light fa-trash\"></i></a>";
        if (!empty($version["status"]) && $version["status"] == "ACTIVE") {
            $opciones .= "<a href=\"/sie/versions/status/{$version["version"]}\" class=\"btn btn-sm btn-success\"><i class=\"fa-light fa-bolt \"></i></a>";
        } else {
            $opciones .= "<a href=\"/sie/versions/status/{$version["version"]}\" class=\"btn btn-sm btn-secondary\"><i class=\"fa-light fa-power-off\"></i></a>";

        }


        $opciones .= "</div>";

        $cell_count = array("content" => $count, "class" => "text-center  align-middle text-nowrap",);
        $cell_code = array("content" => $code, "class" => "text-center  align-middle text-nowrap",);
        $cell_name = array("content" => $name, "class" => "text-center  align-middle text-nowrap",);
        $cell_date = array("content" => $version["date"], "class" => "text-center  align-middle text-nowrap",);
        $cell_time = array("content" => $version["time"], "class" => "text-center  align-middle text-nowrap",);
        $cell_opciones = array("content" => $opciones, "class" => "text-center align-middle",);
        $bgrid->add_Row(array($cell_count, $cell_code, $cell_name, $cell_date, $cell_time, $cell_opciones));
    }
} else {
    //mensaje no hay mallas
}

echo($bgrid);
?>