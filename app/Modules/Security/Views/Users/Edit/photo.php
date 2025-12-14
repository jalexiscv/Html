<?php
/**
 * @var $oid
 */
$bootstrap = service("bootstrap");
$mfields = model("App\Modules\Security\Models\Security_Users_Fields");
$avatar = $mfields->get_Avatar($oid);
$croppie = new App\Libraries\Croppie(array('id' => "croppie-" . pk(), "oid" => $oid));
$croppie->set_Image($avatar);
$croppie->set_Reference("AVATAR");

$card = $bootstrap->get_Card("create", array(
    "title" => sprintf(lang("Users.profile-photo"), $oid),
    "content" => $croppie,
));
echo($card);
?>