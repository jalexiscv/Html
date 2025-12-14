<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['javascript'])) {
    if (isset($_POST['leftSidebar'])) {
        $_SESSION['leftSidebar'] = $_POST['leftSidebar'];
    }
    if (isset($_POST['rightSidebar'])) {
        $_SESSION['rightSidebar'] = $_POST['rightSidebar'];
    }
    exit;
}

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
$theme = 'App\\Views\\Themes\\' . $theme;
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

<!DOCTYPE html>
<html lang="es" data-bs-theme="auto">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="robots" content="noindex, nofollow">
    <title>Higgs</title>
    <?php include("Includes/head-css.php"); ?>
    <?php include("Includes/head-js.php"); ?>
</head>
<body>
<?php if ($type != 'denied') { ?>
    <div class="container-fluid vh-100 d-flex p-0 ">
        <?php if ($main_template == "c0") { ?>
            <?php echo(view($theme . '\Sections\all', $data)); ?>
        <?php } else { ?>
            <div class="sidebar bg-navbar border-right <?php echo(@$_SESSION['leftSidebar']) ?> overflow-hidden vh-100 d-none d-lg-block"
                 id="leftSidebar">
                <div class="sidebar-header overflow-hidden border-bottom p-2 ">
                    <a href="/" class="navbar-brand">
                        <img alt="Logotipo" class="logo-fluid" src="<?php echo($logo_landscape); ?>">
                    </a>
                </div>
                <?php echo(view($theme . '\Sections\left', $data)); ?>
            </div>
            <div class="main-content vh-100 d-flex flex-column w-100">
                <?php echo(view($theme . '\Sections\header', $data)); ?>
                <!-- [main] -->
                <?php echo(view($theme . '\Sections\main', $data)); ?>
                <!-- [/main] -->
            </div>
            <div class="sidebar bg-navbar border-left border-bottom vh-100 d-none d-lg-block <?php echo(@$_SESSION['rightSidebar']) ?>"
                 id="rightSidebar">
                <?php echo(view($theme . '\Sections\right', $data)); ?>
            </div>
        <?php } ?>
    </div>
<?php } else { ?>
    <?php echo(view($theme . '\Gadgets\denied', $data)); ?>

<?php } ?>
<?php include("Includes/modals.php"); ?>
<?php include("Includes/end-css.php"); ?>
<?php include("Includes/end-js.php"); ?>
</body>
</html>