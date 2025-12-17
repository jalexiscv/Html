<?php
generate_facebook_permissions();
$b = service('Bootstrap');
$main = "";
$main .= $b->get_card("card_" . uniqid(), array(
    "title" => "Inicio de sesión con facebook",
    "content" => view('App\Modules\Facebook\Views\Signin\view'),
    "footer" => ""
));
$right = get_application_copyright();
session()->set('page_template', 'page');
session()->set('main_template', 'c8c4');
session()->set('main', $main);
session()->set('right', $right);
?>