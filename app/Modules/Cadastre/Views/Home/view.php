<?php
/** @var string $version */
$server = service("server");
$bootstrap = service("bootstrap");


$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang('Cadastre.Module') . ": <span class='text-muted'>v{$version}</span>",
    "header-back" => "/",
    "image" => "/themes/assets/images/header/cadastre.png",
    "content" => lang("Cadastre.intro-1"),
));
echo($card);
?>