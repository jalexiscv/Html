<?php

$bootstrap = service('bootstrap');
$mmodules = model('App\Modules\Sie\Models\Sie_Modules');
$mversions = model('App\Modules\Sie\Models\Sie_Versions');
$mpensums = model('App\Modules\Sie\Models\Sie_Pensums');
$musers = model('App\Modules\Sie\Models\Sie_Users');
$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');


$bgrid = $bootstrap->get_Grid();
$bgrid->set_Headers(array(
    "#",
    "",
    "Detalles",
    "Ciclo",
    "Momento",
    "Creditos",
    "Opciones",
));

$count = 0;
$pensums = $mpensums->where('version', $oid)->findAll();
if (is_array($pensums)) {
    foreach ($pensums as $pensum) {
        $count++;
        $code = $pensum["pensum"];
        $version = $pensum["version"];
        $author = @$pensum["author"];
        $author_name = $mfields->get_FullName($author);

        $module = $mmodules->get_Module($pensum["module"]);
        $opciones = "<div class=\"btn-group\">";
        //$opciones = "<a href=\"/sie/versions/view/{$version["version"]}\" class=\"btn btn-sm btn-primary mx-1\"><i class=\"fa-light fa-eye\"></i></a>";
        $opciones .= "<a href=\"/sie/pensums/edit/{$code}\" class=\"btn btn-sm btn-primary mx-1\"><i class=\"fa-light fa-pen-to-square\"></i></a>";
        $opciones .= "<a href=\"/sie/pensums/delete/{$code}\" class=\"btn btn-sm btn-danger\"><i class=\"fa-light fa-trash\"></i></a>";
        $opciones .= "</div>";
        $img = "<img src=\"/themes/assets/images/cd.webp\" class=\"\" alt=\"\" width=\"64\">";


        $details = "<b>Nombre</b>:{$module['name']} - <span class='opacity-25'>{$code}</span>";
        $details .= "<br><b>Modulo base</b>:{$module['module']}";
        $details .= "<br><b>Responsable</b>:{$author_name} - <span class='opacity-25'>{$author}</span>";
        $details .= "<br><b>Fecha</b>:{$pensum['created_at']}";

        $bgrid->add_Row(array(
                array("content" => $count, "class" => "text-center align-middle"),
                array("content" => $img, "class" => "text-center align-middle"),
                array("content" => $details, "class" => "text-left align-middle"),
                array("content" => $pensum['cycle'], "class" => "text-center align-middle"),
                array("content" => $pensum['moment'], "class" => "text-center align-middle"),
                array("content" => $pensum['credits'], "class" => "text-center align-middle"),
                $opciones)
        );
    }
} else {
    //mensaje no hay mallas
}

echo($bgrid);
?>