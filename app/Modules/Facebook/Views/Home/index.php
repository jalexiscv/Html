<?php
generate_facebook_permissions();
$b = service('Bootstrap');
$content = "<img src=\"/themes/assets/images/slide/facebook-1.png\" width=\"100%\"/>";
$main = "";
$main .= $b->get_card("card_" . uniqid(), array(
    "title" => "Facebook Development 2020",
    "content" => $content,
    "footer" => ""
));
//$main.=$b->get_card("card_". uniqid(),array(
//    "title"=>"Próximo Concierto  - 26 de Septiembre de 2020",
//    "content"=>$content2,
//    "footer"=>"<a href=\"https://checkout.wompi.co/l/S1p2g8\" class=\"btn btn-danger float-right disabled\">Comprar Boleto</a>"
//));
$right = get_application_copyright();
session()->set('page_template', 'page');
session()->set('main_template', 'c8c4');
session()->set('main', $main);
session()->set('right', $right);
?>