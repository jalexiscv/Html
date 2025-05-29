<?php
/** @var $oid * */
$bootstrap = service("bootstrap");
//[Models]--------------------------------------------------------------------------------------------------------------
$massets = model("App\Modules\Maintenance\Models\Maintenance_Assets");
$mattachments = model("App\Modules\Maintenance\Models\Maintenance_Attachments");
//[Request]-------------------------------------------------------------------------------------------------------------
$asset = $massets->getAsset($oid);
$attachment = $mattachments->get_AttachmentByObject($oid);

$image = "<img src=\"" . cdn_url(@$attachment["file"]) . "\" class=\"w-100\" alt=\"\">";
$label = "Registrado";

$card = $bootstrap->get_Card("profile-photo", array(
    "title" => sprintf(lang("Users.profile-photo") . "", $oid),
    "content" => $image,
));
echo($card);
?>