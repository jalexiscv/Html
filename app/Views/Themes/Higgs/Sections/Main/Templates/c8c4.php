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
<!--[c8c4]-->
<!--[c8]-->
<div class="col-xxl-9 col-md-12">
    <?php echo($main); ?>
</div>
<!--[/c8]-->
<!--[c4]-->
<div class="col-xxl-3 col-md-12 ">
    <?php echo($right); ?>
    <!--[benchmark]-->
    <?php echo(view($theme . '\Gadgets\benchmark', $data)); ?>
    <!--[/benchmark]-->
</div>
<!--[/c4]-->
<!--[/c8c4]-->