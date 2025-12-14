<?php
$theme = 'App\Views\Themes\Web';
$s = service('strings');
$data = array(
    "theme" => $theme,
    "canonical" => $canonical,
    "type" => $type,
    "title" => $s->get_URLDecode($title),
    "articles" => $articles,
    "article" => $article,
    "description" => $s->get_URLDecode($description),
);
?>
<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
    <title><?php echo($data['title']); ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo($data['description']); ?>">
    <meta name="author" content="Higgs (AI) ">
    <meta name="generator" content="WordPress 1.0.0">
    <meta name="robots" content="follow, index, max-snippet:-1, max-video-preview:-1, max-image-preview:large"/>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="canonical" href="<?php echo($data['canonical']); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="/themes/assets/libraries/bootstrap/5.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
    <link href="/themes/Default/css/default.css?v=<?php echo(time()); ?>" rel="stylesheet">
    <link href="/themes/assets/fonts/Higgs/Higgs.css?v=1.1" rel="stylesheet" type="text/css"/>
    <link href="/themes/assets/fonts/fontawesome/5/css/all.min.css?v=1.1" rel="stylesheet" type="text/css"/>
    <link href="/themes/assets/fonts/fontawesome/6/css/all.min.css?v=1.1" rel="stylesheet" type="text/css"/>
    <script src="/themes/assets/libraries/bootstrap/5.3.1/js/color-modes.js"></script>
</head>
<body>
<?php if ($type != 'denied') { ?>
    <?php echo(view($theme . '\plugins\color', $data)); ?>
    <div class="container">
        <?php echo(view($theme . '\sections\header', $data)); ?>
        <div class="nav-scroller py-1 mb-3 border-bottom">
            <?php echo(view($theme . '\gadgets\nav', $data)); ?>
        </div>
    </div>
    <?php echo(view($theme . '\sections\main', $data)); ?>
    <?php echo(view($theme . '\sections\footer', $data)); ?>
<?php } else { ?>
    <?php echo(view($theme . '\plugins\color', $data)); ?>
    <?php echo(view($theme . '\gadgets\denied', $data)); ?>
<?php } ?>
<script src="/themes/assets/libraries/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>

</body>
</html>