<?php
/** @var string $theme */
/** @var string $main_template */
/** @var string $breadcrumb */
/** @var string $main */
/** @var string $right */
/** @var string $left */
/** @var string $logo_portrait */
/** @var string $logo_landscape */
/** @var string $logo_portrait_light */
/** @var string $logo_landscape_light */
/** @var string $canonical */
/** @var string $type */
/** @var string $title */
/** @var string $description */
/** @var string $messenger */
/** @var string $messenger_users */
/** @var string $benchmark */
/** @var string $version */
$s = service('strings');
$data = array(
    "theme" => $theme,
    "main_template" => $main_template,
    "breadcrumb" => $breadcrumb,
    "main" => $main,
    "right" => $right,
    "left" => $left,
    "logo_portrait" => $logo_portrait,
    "logo_landscape" => $logo_landscape,
    "logo_portrait_light" => $logo_portrait_light,
    "logo_landscape_light" => $logo_landscape_light,
    "canonical" => $canonical,
    "type" => $type,
    "title" => $s->get_URLDecode($title),
    "description" => $s->get_URLDecode($description),
    "messenger" => $messenger,
    "messenger_users" => $messenger_users,
    "benchmark" => $benchmark,
    "version" => $version,
);
?>
<div class="flex-grow-1 overflow-y-scroll">
    <?php if ($data["main_template"] == "chat") { ?>
        <?php echo(view($theme . '\Sections\Main\Templates\index.php', $data)); ?>
    <?php } elseif ($data["main_template"] == "c12p1") { ?>
        <div class="p-1">
            <?php echo(view($theme . '\Sections\Main\breadcrumb.php', $data)); ?>
            <div class="row">
                <?php echo(view($theme . '\Sections\Main\Templates\index.php', $data)); ?>
            </div>
        </div>
    <?php } else { ?>
        <div class="p-3">
            <?php echo(view($theme . '\Sections\Main\breadcrumb.php', $data)); ?>
            <div class="row">
                <?php echo(view($theme . '\Sections\Main\Templates\index.php', $data)); ?>
            </div>
        </div>
    <?php } ?>
</div>