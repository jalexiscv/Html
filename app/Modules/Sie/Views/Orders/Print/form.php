<?php
require_once(APPPATH . 'ThirdParty/FPDF/fpdf.php');
require_once(APPPATH . 'ThirdParty/FPDI/autoload.php');
require_once(APPPATH . 'ThirdParty/Barcode/autoload.php');
require_once(APPPATH . 'ThirdParty/GS1/autoload.php');

use setasign\Fpdi\Fpdi;
use Picqer\Barcode\BarcodeGeneratorPNG;

//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Sie_Orders."));
//[Request]-----------------------------------------------------------------------------
$origin = !empty($request->getGet("origin")) ? $request->getGet("origin") : $f->get_Value("origin");

$order = $model->get_Order($oid);

if ($origin == "students-view") {
    $back = "/sie/students/view/{$order['user']}#finance";
} elseif ($origin == "registrations") {
    $back = "/sie/registrations/edit/{$order['user']}";
} else {
    $back = "NOBACK: " . $origin;
}


include("Formats/general.php");
//if ($order["type"] == "CREDIT") {
//    include("Formats/cuotas.php");
//} else {
//    include("Formats/general.php");
//}

$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card2("card-view-service", array(
    "header-title" => lang("Sie_Orders.view-title"),
    "header-back" => $back,
    "content" => $code,
));
echo($card);
include("modal.php");
?>