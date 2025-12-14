<?php


$strings = service("strings");

$mstyles = model("App\Modules\Nexus\Models\Nexus_Styles");


$css = "";


$styles = $mstyles->orderBy("selectors", "ASC")->findAll();

foreach ($styles as $style) {
    $selectors = urldecode($style["selectors"]);
    $rules = $strings->get_Clear(urldecode($style["default"]));
    if (!empty($rules)) {
        $css .= "{$selectors}{{$rules}}\n";
    }
}


$css .= "\n@media (max-width:1400px){";
foreach ($styles as $style) {
    $selectors = urldecode($style["selectors"]);
    $rules = $strings->get_Clear(urldecode($style["xxl"]));
    if (!empty($rules)) {
        $css .= "{$selectors}{{$rules}}\n";
    }
}
$css .= "}";

$css .= "\n@media (max-width:1200px){";
foreach ($styles as $style) {
    $selectors = urldecode($style["selectors"]);
    $rules = $strings->get_Clear(urldecode($style["xl"]));
    if (!empty($rules)) {
        $css .= "{$selectors}{{$rules}}\n";
    }
}
$css .= "}";

$css .= "\n@media (max-width:992px){";
foreach ($styles as $style) {
    $selectors = urldecode($style["selectors"]);
    $rules = $strings->get_Clear(urldecode($style["lg"]));
    if (!empty($rules)) {
        $css .= "{$selectors}{{$rules}}\n";
    }
}
$css .= "}";

$css .= "\n@media (max-width:768px){";
foreach ($styles as $style) {
    $selectors = urldecode($style["selectors"]);
    $rules = $strings->get_Clear(urldecode($style["md"]));
    if (!empty($rules)) {
        $css .= "{$selectors}{{$rules}}\n";
    }
}
$css .= "}";

$css .= "\n@media (max-width:576px){";
foreach ($styles as $style) {
    $selectors = urldecode($style["selectors"]);
    $rules = $strings->get_Clear(urldecode($style["sm"]));
    if (!empty($rules)) {
        $css .= "{$selectors}{{$rules}}\n";
    }
}
$css .= "}";

$css .= "\n@media (max-width:320px){";
foreach ($styles as $style) {
    $selectors = urldecode($style["selectors"]);
    $rules = $strings->get_Clear(urldecode($style["xs"]));
    if (!empty($rules)) {
        $css .= "{$selectors}{{$rules}}\n";
    }
}


$css .= "}";

echo($css);
?>