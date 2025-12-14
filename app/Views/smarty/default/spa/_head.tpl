<meta charset="utf-8">
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">

{if $title }
    <title>{$title}</title>
    <meta name="title" content="{$title}"/>
{/if}
<meta name="description" content="{$description}"/>
<meta property="og:image" content="{$image}"/>
{if isset($author)}
    <meta name="author" content="{$author}"/>
    <meta name="genre" content="{$genre}"/>
    <meta name="geo.placename" content="{$geo_placename}"/>
    <meta name="geo.position" content="{$geo_position}"/>
    <meta name="geo.region" content="{$geo_region}"/>
    <meta name="google" content="notranslate"/>
    <meta name="ICBM" content="{$geo_position}"/>
    <meta name="language" content="{$language}"/>
    <meta property="og:type" content="article"/>
    <meta property="article:published_time" content="{$published_time}"/>
    <meta property="article:modified_time" content="{$modified_time}"/>
    <meta property="article:author" content="{$author}"/>
    <meta property="article:section" content="general"/>
    <meta property="fb:pages" content="114505522053385"/>
{/if}
<meta name="theme-color" content="#778298">

<script type="text/javascript" src="{base_url("themes/default/node_modules/jquery/dist/jquery.js")}"></script>
<script type="text/javascript" src="{base_url("themes/assets/javascripts/jquery-ui/jquery-ui.min.js")}"></script>
<script type="text/javascript" src="{base_url("themes/default/node_modules/popper.js/dist/umd/popper.js")}"></script>
<script type="text/javascript" src="{base_url("themes/assets/libraries/bootstrap/4.6.0/js/bootstrap.min.js")}"></script>
<script type="text/javascript" src="{base_url("themes/assets/javascripts/cropper/dist/cropper.min.js")}"></script>
<!-- include common vendor stylesheets -->
<link rel="stylesheet" type="text/css" href="{base_url("themes/assets/libraries/bootstrap/4.6.0/css/bootstrap.css")}"/>
<link rel="stylesheet" type="text/css"
      href="{base_url("themes/assets/libraries/bootstrap/4.6.0/css/bootstrap-grid.min.css")}"/>
<link rel="stylesheet" type="text/css" href="{base_url("themes/assets/javascripts/jquery-ui/jquery-ui.min.css")}"/>
<link rel="stylesheet" type="text/css" href="{base_url("themes/default/dist/fonts/fontawesome/css/all.min.css")}"/>
<link rel="stylesheet" type="text/css" href="{base_url("themes/default/dist/css/ace-font.css")}"/>
<link rel="stylesheet" type="text/css" href="{base_url("themes/assets/javascripts/cropper/dist/cropper.min.css")}"/>

<link rel="icon" type="image/png" href="{base_url("themes/favicon.png")}"/>

{if plugin_tables}
    <link rel="stylesheet" type="text/css"
          href="{base_url("themes/default/node_modules/bootstrap-table/dist/bootstrap-table.css")}"/>
{/if}

<!-- "Dashboard" page styles specific to this page for demo purposes -->
<link rel="stylesheet" type="text/css" href="{base_url("themes/default/dist/css/ace.css?v=55")}"/>

<script type="text/javascript" src="{base_url("themes/default/assets/js/demo.js?v4")}"></script>

<!-- Higgs CSS //-->
<link href="{base_url("/themes/assets/css/messenger.css")}" rel="stylesheet" type="text/css"/>
<link href="{base_url("/themes/assets/css/posts.css")}?v={time()}" rel="stylesheet" type="text/css"/>
<link href="{base_url("/themes/assets/css/modals.css")}" rel="stylesheet" type="text/css"/>
<link href="{base_url("/themes/assets/css/alerts.css")}" rel="stylesheet" type="text/css"/>

<style>
    {$styles}
</style>