<?php


/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/

$menu = array(
    array("href" => "/c4isr", "text" => "c4isr", "class" => false),
);

if ($oid == 'databreaches') {
    $item = array("href" => "/c4isr/cases/home/{$oid}/" . lpk(), "text" => lang("App.Databreaches"), "class" => "active");
} elseif ($oid == 'osints') {
    $item = array("href" => "/c4isr/cases/home/{$oid}/" . lpk(), "text" => lang("App.SInt"), "class" => "active");
} elseif ($oid == 'darkweb') {
    $item = array("href" => "/c4isr/cases/home/{$oid}/" . lpk(), "text" => lang("App.Darkweb"), "class" => "active");
} elseif ($oid == 'cveweb') {
    $item = array("href" => "/c4isr/cases/home/{$oid}/" . lpk(), "text" => lang("App.Cveweb"), "class" => "active");
} elseif ($oid == 'phishing') {
    $item = array("href" => "/c4isr/cases/home/{$oid}/" . lpk(), "text" => lang("App.Phishing"), "class" => "active");
} elseif ($oid == 'geolocation') {
    $item = array("href" => "/c4isr/cases/home/{$oid}/" . lpk(), "text" => lang("App.Geolocation"), "class" => "active");
} elseif ($oid == 'perimeter') {
    $item = array("href" => "/c4isr/cases/home/{$oid}/" . lpk(), "text" => lang("App.Perimeter"), "class" => "active");
} else {

}


array_push($menu, $item);

$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("menu", $menu);
echo($smarty->view('components/breadcrumb/index.tpl'));

?>