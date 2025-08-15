<?php
/**
 * @var $oid
 */
$bootstrap = service("bootstrap");

$mjournalists = model('App\Modules\Journalists\Models\Journalists_Journalists');
$mattachments = model('App\Modules\Storage\Models\Storage_Attachments');


$attachment = $mattachments->get_AttachmentByObject($oid);
$photo = cdn_url(@$attachment["file"]);

$croppie = new App\Libraries\Croppie(array(
    'id' => 'croppie-' . pk(),
    'oid' => $oid,
    'viewport' => array('width' => 300, 'height' => 400, 'type' => 'rectangle'),
    'boundary' => array('width' => 350, 'height' => 467),
));
$croppie->set_Image($photo);
$croppie->set_Reference("AVATAR");
$card = $bootstrap->get_Card("create", array(
    "title" => sprintf(lang("Users.profile-photo"), $oid),
    "content" => $croppie,
));
echo($card);
?>