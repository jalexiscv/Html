<?php
$data = array(
    "theme" => $theme,
    "main_template" => $main_template,
    "breadcrumb" => $breadcrumb,
    "main" => $main,
    "right" => $right,
    "logo_portrait" => $logo_portrait,
    "logo_landscape" => $logo_landscape,
    "logo_portrait_light" => $logo_portrait_light,
    "logo_landscape_light" => $logo_landscape_light,
    "canonical" => $canonical,
    "type" => $type,
    "title" => $title,
    "description" => $description,
    "messenger" => $messenger,
    "messenger_users" => $messenger_users,
);
?>



<?php echo($left); ?>


<div class="d-flex m-3">
    <?php echo(view($theme . '\Sections\Left\modules', $data)); ?>
</div>