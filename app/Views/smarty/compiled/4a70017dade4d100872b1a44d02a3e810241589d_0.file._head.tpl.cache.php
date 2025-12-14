<?php
/* Smarty version 3.1.36, created on 2020-11-08 07:39:01
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\_head.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5fa7e6e5594625_92131835',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            '4a70017dade4d100872b1a44d02a3e810241589d' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\_head.tpl',
                    1 => 1604484100,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(),
), false)) {
    function content_5fa7e6e5594625_92131835(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '3950205115fa7e6e5586882_51985974';
        ?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
        <base href="../"/>

        <?php if ($_smarty_tpl->tpl_vars['title']->value) { ?>
        <title><?php echo $_smarty_tpl->tpl_vars['title']->value; ?>
        </title>
        <meta name="title" content="<?php echo $_smarty_tpl->tpl_vars['title']->value; ?>
"/>
    <?php } ?>
        <meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['description']->value; ?>
"/>
        <meta property="og:image" content="<?php echo $_smarty_tpl->tpl_vars['image']->value; ?>
"/>
        <?php if ((isset($_smarty_tpl->tpl_vars['author']->value))) { ?>
        <meta name="author" content="<?php echo $_smarty_tpl->tpl_vars['author']->value; ?>
"/>
        <meta name="genre" content="<?php echo $_smarty_tpl->tpl_vars['genre']->value; ?>
"/>
        <meta name="geo.placename" content="<?php echo $_smarty_tpl->tpl_vars['geo_placename']->value; ?>
"/>
        <meta name="geo.position" content="<?php echo $_smarty_tpl->tpl_vars['geo_position']->value; ?>
"/>
        <meta name="geo.region" content="<?php echo $_smarty_tpl->tpl_vars['geo_region']->value; ?>
"/>
        <meta name="google" content="notranslate"/>
        <meta name="ICBM" content="<?php echo $_smarty_tpl->tpl_vars['geo_position']->value; ?>
"/>
        <meta name="language" content="<?php echo $_smarty_tpl->tpl_vars['language']->value; ?>
"/>
        <meta property="og:type" content="article"/>
        <meta property="article:published_time" content="<?php echo $_smarty_tpl->tpl_vars['published_time']->value; ?>
"/>
        <meta property="article:modified_time" content="<?php echo $_smarty_tpl->tpl_vars['modified_time']->value; ?>
"/>
        <meta property="article:author" content="<?php echo $_smarty_tpl->tpl_vars['author']->value; ?>
"/>
        <meta property="article:section" content="general"/>
    <?php } ?>


        <?php echo '<script'; ?>
        type="text/javascript" src="<?php echo base_url("themes/default/node_modules/jquery/dist/jquery.js"); ?>
        "><?php echo '</script'; ?>
        >
        <?php echo '<script'; ?>
        type="text/javascript" src="<?php echo base_url("themes/assets/javascripts/jquery-ui/jquery-ui.min.js"); ?>
        " ><?php echo '</script'; ?>
        >
        <?php echo '<script'; ?>
        type="text/javascript" src="<?php echo base_url("themes/default/node_modules/popper.js/dist/umd/popper.js"); ?>
        "><?php echo '</script'; ?>
        >
        <?php echo '<script'; ?>
        type="text/javascript" src="<?php echo base_url("themes/assets/libraries/bootstrap/js/bootstrap.min.js"); ?>
        "><?php echo '</script'; ?>
        >
        <?php echo '<script'; ?>
        type="text/javascript" src="<?php echo base_url("themes/assets/javascripts/cropper/dist/cropper.min.js"); ?>
        " ><?php echo '</script'; ?>
        >
        <!-- include common vendor stylesheets -->
        <link rel="stylesheet" type="text/css"
              href="<?php echo base_url("themes/assets/libraries/bootstrap/css/bootstrap.css"); ?>
"/>
        <link rel="stylesheet" type="text/css"
              href="<?php echo base_url("themes/assets/libraries/bootstrap/css/bootstrap-grid.min.css"); ?>
"/>
        <link rel="stylesheet" type="text/css"
              href="<?php echo base_url("themes/assets/javascripts/jquery-ui/jquery-ui.min.css"); ?>
"/>
        <link rel="stylesheet" type="text/css"
              href="<?php echo base_url("themes/default/dist/fonts/fontawesome/css/all.min.css"); ?>
"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("themes/default/dist/css/ace-font.css"); ?>
"/>
        <link rel="stylesheet" type="text/css"
              href="<?php echo base_url("themes/assets/javascripts/cropper/dist/cropper.min.css"); ?>
"/>

        <link rel="icon" type="image/png" href="<?php echo base_url("themes/favicon.png"); ?>
"/>

        <?php if ('plugin_tables') { ?>
        <link rel="stylesheet" type="text/css"
              href="<?php echo base_url("themes/default/node_modules/bootstrap-table/dist/bootstrap-table.css"); ?>
"/>
    <?php } ?>

        <!-- "Dashboard" page styles specific to this page for demo purposes -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("themes/default/dist/css/ace.css?v=44"); ?>
"/>


        <?php echo '<script'; ?>
        type="text/javascript" src="<?php echo base_url("themes/default/node_modules/chart.js/dist/Chart.js"); ?>
        "><?php echo '</script'; ?>
        >
        <?php echo '<script'; ?>
        type="text/javascript" src="<?php echo base_url("themes/default/node_modules/sortablejs/Sortable.js"); ?>
        "><?php echo '</script'; ?>
        >
        <!--<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo base_url("themes/default/dist/js/ace.js"); ?>
"><?php echo '</script'; ?>
>//-->
        <?php echo '<script'; ?>
        type="text/javascript" src="<?php echo base_url("themes/assets/javascripts/monthpicker/jquery.ui.monthpicker.js"); ?>
        "><?php echo '</script'; ?>
        >
        <link rel="stylesheet" type="text/css"
              href="<?php echo base_url("themes/assets/javascripts/monthpicker/styles.css"); ?>
"/>

        <!-- DropZone //-->
        <link href="<?php echo base_url("/themes/assets/javascripts/dropzone/dropzone.min.css"); ?>
" rel="stylesheet" type="text/css"/>
        <?php echo '<script'; ?>
        src="<?php echo base_url("/themes/assets/javascripts/dropzone/dropzone.min.js"); ?>
        " type="text/javascript"><?php echo '</script'; ?>
        >

        <?php echo '<script'; ?>
        type="text/javascript" src="<?php echo base_url("themes/default/assets/js/demo.js"); ?>
        "><?php echo '</script'; ?>
        >
        <style>
            <?php echo $_smarty_tpl->tpl_vars['styles']->value;?>

        </style>

        <?php if ((isset($_smarty_tpl->tpl_vars['ads']->value))) {
        echo '<script'; ?>
        async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"><?php echo '</script'; ?>
        >
    <?php } ?>

        <?php if ((isset($_smarty_tpl->tpl_vars['google_maps']->value))) { ?>
        <?php if ($_smarty_tpl->tpl_vars['google_maps']->value) { ?>
            <?php echo '<script'; ?>
            async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoea0nq4GgeYgtjpvCgVIeSUD1PDvG4j4&callback=initMap"><?php echo '</script'; ?>
            >
        <?php }
    }
    }
}
