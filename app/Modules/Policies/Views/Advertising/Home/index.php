<?php
generate_acredit_permissions();

$c = lang("Policies.intro");

$b = service('Bootstrap');
$main = $b->get_card("card_" . uniqid(), array(
    "title" => "Publicidad",
    "content" => view("App\Modules\Policies\Views\Advertising\Home\intro"),
));

$right = "";

session()->set('page_template', 'page');
session()->set('main_template', 'c8c4');
session()->set('main', $main);
session()->set('right', $right);

?>