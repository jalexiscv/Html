<?php
$bootstrap = service('bootstrap');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
$mmodules = model('App\Modules\Sie\Models\Sie_Modules');
$mgrids = model('App\Modules\Sie\Models\Sie_Grids');
$mversions = model('App\Modules\Sie\Models\Sie_Versions');
$mpensums = model('App\Modules\Sie\Models\Sie_Pensums');

$program = $mprograms->getProgram($oid);

$bgrid = $bootstrap->get_Grid();
$bgrid->set_Headers(array(
    "#",
    "Código",
    "Detalles",
    "Versión",
    "Créditos",
    "Opciones",
));

$count = 0;
$grids = $mgrids->where('program', $oid)->findAll();
if (is_array($grids)) {
    foreach ($grids as $grid) {
        $count++;
        $code = @$grid["grid"];
        $name = @$grid["name"];
        $version = @$grid["version"];
        $author = @$grid["author"];


        $last_version = $mversions->get_LastVersion($grid["grid"]);

        // Verificar si se encontró una versión válida
        if ($last_version && is_array($last_version)) {
            $version_reference = $last_version["reference"] ?? 'N/A';
        } else {
            $version_reference = 'N/A';
        }
        // Calcular créditos solo si hay versión válida
        if ($last_version && is_array($last_version)) {
            $credits = $mpensums->get_CalculateCreditsByVersion($last_version["version"]);
        } else {
            $credits = 0;
        }

        $details = "<b>Nombre</b>: {$name}<br>";
        $details .= "<b>Responsable</b>: {$author}";


        $link_view = "/sie/grids/view/{$grid["grid"]}";
        $link_edit = "/sie/grids/edit/{$grid["grid"]}";
        $link_delete = "/sie/grids/delete/{$grid["grid"]}";
        $btnview = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $link_view, "class" => "btn-sm btn-primary ml-1",));
        $btnedit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Delete"), "href" => $link_edit, "class" => "btn-secondary ml-1",));
        $btndelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $link_delete, "class" => "btn-sm btn-danger ml-1",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnview . $btnedit . $btndelete,));
        $bgrid->add_Row(array(
                $count,
                $code,
                $details,
                $version_reference,
                $credits . "/" . @$program["credits"],
                $options)
        );
    }
} else {
    //mensaje no hay mallas
}

echo($bgrid);
?>