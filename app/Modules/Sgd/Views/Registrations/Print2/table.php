<?php
/** @var string $oid */
/** @var service $request */
//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
//[models]--------------------------------------------------------------------------------------------------------------
$mpensums = model("App\Modules\Sie\Models\Sie_Pensums");
//[pdf]-----------------------------------------------------------------------------------------------------------------
$code = "";
//include("pdf.php");
//[build]---------------------------------------------------------------------------------------------------------------
$back = "/sgd/registrations/edit/" . $oid;
$card = $bootstrap->get_Card2("card-view-service", array(
    "header-title" => "Versión imprimible",
    "header-back" => $back,
    "content" => $code,
));
echo($card);
?>