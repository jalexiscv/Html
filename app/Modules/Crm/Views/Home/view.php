<?php
/** @var string $version */
$server = service("server");
$bootstrap = service("bootstrap");
generate_crm_permissions();

$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang('Crm.Module') . ": <span class='text-muted'>v{$version}</span>",
    "header-back" => "/",
    "image" => "/themes/assets/images/header/crm.png",
    "content" => lang("Crm.intro-1"),
));
echo($card);
?>