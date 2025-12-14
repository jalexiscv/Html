<?php
$bootstrap = service("bootstrap");

$options = array(
    array("href" => "/cadastre/tools/anomalies/list/" . lpk(), "title" => "Anomalias", "icon" => "fas fa-tasks"),
    array("href" => "/cadastre/tools/georeferences/updater/" . lpk(), "title" => "Actualizador", "icon" => "fas fa-tasks"),
);

$shortcuts = "<div class=\"row  row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-1 row-cols-1  text-center shortcuts\">";
foreach ($options as $option) {
    $shortcuts .= "<div class=\"col mb-3\">";
    $shortcuts .= $bootstrap->get_Card("option-" . lpk(), array(
        "title" => $option["title"],
        "icon" => $option["icon"],
        "footer-continue" => $option["href"],
    ));
    $shortcuts .= "</div>";
}
$shortcuts .= "</div>";

$card = $bootstrap->get_Card("card-tools", array(
    "title" => "Analisis de Roles",
    "header-back" => "/development/home/" . lpk(),
    "content" => $shortcuts,
));
echo($card);
?>