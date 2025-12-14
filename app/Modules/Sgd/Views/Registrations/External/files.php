<?php
$bootstrap = service('bootstrap');
$mattachments = model('App\Modules\Storage\Models\Storage_Attachments');

//[grid]----------------------------------------------------------------------------------------------------------------
$bgrid = $bootstrap->get_Grid();
$bgrid->set_Class("P-0 m-0");
$bgrid->set_Headers(array(
    array("content" => "#", "class" => "text-center text-nowrap align-middle"),
    array("content" => "Tipo", "class" => "text-center align-middle"),
    array("content" => "Archivo", "class" => "text-center align-middle"),
    array("content" => "Opciones", "class" => "text-center text-nowrap align-middle"),
));
$count = 0;
$files = $mattachments->where('object', $oid)->orderBy("created_at", "DESC")->findAll();
if (is_array($files)) {
    foreach ($files as $file) {
        $count++;

        $type = "Otro"; // Valor por defecto
        foreach (LIST_FILE_TYPES_GENERAL as $fileType) {
            if ($file["reference"] == $fileType["value"]) {
                $type = $fileType["label"];
                break;
            }
        }

        $url=cdn_url($file["file"]);
        $url_delete = "#";
        $options = "";
        $cell_count = array("content" => $count, "class" => "text-center  align-middle",);
        $cell_type = array("content" => $type, "class" => "text-center  align-middle",);
        $cell_url = array("content" => "<a href=\"" . $url . "\" target=\"_blank\">" . $file["attachment"] . "</a>", "class" => "text-center  align-middle",);
        //$cell_url = array("content" => "{$file["attachment"]}", "class" => "text-center  align-middle",);
        $cell_options = "<div class=\"btn-group w-auto\">";
        $cell_options .= "<a href=\"" . $url . "\" class=\"btn btn-sm btn-primary\" target=\"_blank\"><i class=\"fa-light fa-eye\"></i></a>";
        //$cell_options .= "<a href=\"" . $url_delete . "\" data-attachment=\"" . $file["attachment"] . "\" class=\"btn btn-sm btn-danger  btn-delete\"><i class=\"fa-light fa-trash\"></i></a>";
        $cell_options .= "</div>";
        $bgrid->add_Row(array($cell_count, $cell_type, $cell_url, $cell_options));
    }
} else {
    //mensaje no hay mallas
}
//[/grid]---------------------------------------------------------------------------------------------------------------
$code = "<!-- [files] //-->\n";
$code .= "<div class=\"container m-0 p-0\">\n";
$code .= "\t\t<div class=\"row w-100 p-0 m-0\">\n";
$code .= "\t\t\t\t<div class=\"col-12 p-2\">\n";
$code .= "\t\t\t\t\t\t<div id=\"grid-files\">\n";
$code .= "\t\t\t\t\t\t{$bgrid}\n";
$code .= "\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t</div>\n";
$code .= "</div>\n";
$code .= "<!-- [/files] //-->\n";
echo($code);
?>