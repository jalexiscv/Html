<?php
$mattachments = model("App\Modules\Storage\Models\Storage_Attachments");
$mattachments = $mattachments->get_List(10000000, 0, $oid);

$code = "";
if (count($mattachments) > 0) {
    $count = 0;
    $code .= "<div class=\"row\">";
    $code .= "<div class=\"col-12 align-center\">";
    $code .= "<table class='table table-bordered'>";
    foreach ($mattachments as $attachment) {
        $count++;
        $code .= "<tr>";
        $code .= "<td>{$count}</td>";
        $code .= "<td><a href=\"{$attachment['file']}\" target=\"_blank\">{$attachment['file']}</a></td>";
        $code .= "<td>{$attachment['reference']}</td>";
        $code .= "</tr>";
    }
    $code .= "</table>";
    $code .= "</div>";
    $code .= "</div>";
    $code .= "<div class=\"row\">";
    $code .= "<div class=\"col-12 text-center\">";
    $code .= "<a href=\"/sint/importers/breaches/{$oid}\" class=\"btn btn-primary\">Procesar</a>";
    $code .= "</div>";
    $code .= "</div>";
}
//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => "Archivos Relacionados",
    "header-back" => false,
    "content" => $code,
    "content-class" => "px-2",
));
echo($card);
?>