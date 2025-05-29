<?php
/**
 * @var $oid
 */

//[Models]--------------------------------------------------------------------------------------------------------------
$massets = model("App\Modules\Maintenance\Models\Maintenance_Assets");
$mattachments = model("App\Modules\Maintenance\Models\Maintenance_Attachments");
//[Request]-------------------------------------------------------------------------------------------------------------
$asset = $massets->getAsset($oid);
$attachment = $mattachments->get_AttachmentByObject($oid);

$bootstrap = service("bootstrap");
//$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');
//$profile = $mfields->get_Profile($oid);
$croppie = new App\Libraries\Croppie(array(
    'id' => 'croppie-' . pk(),
    'oid' => $oid,
    'viewport' => array('width' => 300, 'height' => 400, 'type' => 'rectangle'),
    'boundary' => array('width' => 350, 'height' => 467),
));
$croppie->set_Image(@$attachment["file"]);
$croppie->set_Reference("ASSET");
$card = $bootstrap->get_Card("create", array(
    "title" => "Foto",
    "content" => $croppie,
));
echo($card);
?>