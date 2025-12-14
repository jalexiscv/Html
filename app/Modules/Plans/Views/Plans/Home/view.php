<?php
/** @var string $version */
$server = service("server");
$bootstrap = service("bootstrap");
generate_plans_permissions();

$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang('Plans.Module') . ": <span class='text-muted'>v{$version}</span>",
    "header-back" => "/",
    "image" => "/themes/assets/images/header/module-plans.png",
    "content" => lang("Plans.intro-1"),
));
echo($card);
?>