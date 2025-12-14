<?php
$bootstrap = service("bootstrap");
$mfields = model("App\Modules\Users\Models\Users_Users_Fields");
$avatar = safe_get_user_avatar(); 
$croppie = new App\Modules\Users\Libraries\Croppie(array(
    'id' => "croppie-" . pk(), 
    "oid" => $oid,
    "viewport" => array("width" => 270, "height" => 480, "type" => "square"),
    "boundary" => array("width" => 300, "height" => 520),
    "output" => array("width" => 750, "height" => 1334)
));
$croppie->set_Image($avatar); 
$croppie->set_Reference("AVATAR");

$card = $bootstrap->get_Card("create", array(
    "title" => sprintf(lang("Users.profile-photo"), $oid),
    "content" => $croppie,
));
echo($card); 
?>