<?php

//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]-----------------------------------------------------------------------------
$mcustomers = model("App\Modules\Cadastre\Models\Cadastre_Customers");
$mprofiles = model("App\Modules\Cadastre\Models\Cadastre_Profiles");


$f = service("forms", array("lang" => "Sense."));
$registration = $f->get_Value("search");

$customer = $mcustomers->like("registration", $registration)->first();
$profile = $mprofiles
    ->where("customer", $customer["customer"])
    ->orderBy("profile", "DESC")
    ->first();

$names = $strings->get_Protect($profile["names"], 50);
$l["back"] = "/cadastre/sense/home/" . lpk();
$l["continue"] = "/cadastre/sense/create/{$customer["customer"]}";


$resume = "Suscriptor {$profile['registration']} de nombre {$names} dirección {$profile['address']} para solicitar directamente la actualización del "
    . "propietario del predio de dicho suscriptor, se requiere adjuntar de un certificado de tradición con una vigencia no "
    . "superior a 15 días en formato .PDF y el respectivo numero de PIN del certificado generado. ";

$c = $bootstrap->get_Card("success", array(
    "class" => "card",
    "icon" => "fa-duotone fa-triangle-exclamation",
    "title" => "Datos del cliente",
    "text-class" => "text-center",
    "text" => $resume,
    "footer-continue" => $l["continue"],
    "footer-cancel" => $l["back"],
    "footer-class" => "text-center",
    "voice" => false,
));
echo($c);
?>