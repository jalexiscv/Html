<?php
/**
 * @var $oid
 */
$bootstrap = service("bootstrap");
$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');
$profile = $mfields->get_Profile($oid);
$croppie = new App\Libraries\Croppie(array(
    'id' => 'croppie-' . pk(),
    'oid' => $oid,
    'viewport' => array('width' => 300, 'height' => 400, 'type' => 'rectangle'),
    'boundary' => array('width' => 350, 'height' => 467),
));
$croppie->set_Image($profile['avatar']);
$croppie->set_Reference("AVATAR");
$card = $bootstrap->get_Card("create", array(
    "title" => sprintf(lang("Users.profile-photo"), $oid),
    "content" => $croppie,
));
echo($card);
?>