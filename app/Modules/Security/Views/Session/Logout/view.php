<?php
$server = service("server");
$bootstrap = service("bootstrap");
$version = "1.1";//round(($server->get_DirectorySize('app\Modules\Cadastre') / 1024000), 6);

$card = $bootstrap->get_Card("card-view-service", array(
    "class" => "card-warning",
    "title" => lang('Session.logout-confirmation-title'),
    "header-back" => "/",
    "icon" => ICON_SIGNOUT,
    "content" => lang("Session.logout-confirmation-message"),
    "footer-class" => "text-center",
    "footer-logout" => "/security/session/disconect/" . lpk(),
    "footer-cancel" => "/",
    "voice" => "security/session/logout-confirmation-message.mp3",
));
echo($card);
?>