<?php

$b = service('Bootstrap');

$content = view("App\Modules\Disa\Views\Mipg\Control\Home\dimensions");
$content .= view("App\Modules\Disa\Views\Mipg\Control\Home\politics");
$content .= view("App\Modules\Disa\Views\Mipg\Control\Home\diagnostics");
$content .= view("App\Modules\Disa\Views\Mipg\Control\Home\components");
$content .= view("App\Modules\Disa\Views\Mipg\Control\Home\categories");
$content .= view("App\Modules\Disa\Views\Mipg\Control\Home\activities");
$content .= view("App\Modules\Disa\Views\Mipg\Control\Home\plans");

$main = $b->get_card("card_" . uniqid(), array(
    "title" => "Cuadro de control",
    "content-class" => "bg-white",
    "content" => $content
));

$right = "";
session()->set('page_template', 'page');
session()->set('main_template', 'c9c3');
session()->set('messenger', true);
session()->set('main', $main);
session()->set('right', '');