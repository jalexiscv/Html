<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=2,shrink-to-fit=no">

{if $title }
    <title>{$title}</title>
    <meta name="title" content="{$title}"/>
{/if}
<meta name="description" content="{$description}"/>
<meta property="og:image" content="{$image}"/>
<meta name="twitter:card" content="summary"/>
<meta name="twitter:site" content="@jalexiscv"/>
<meta name="twitter:title" content="{$title}"/>
{if isset($description)}
    <meta name="twitter:description" content="{$description}"/>
{/if}
<meta name="twitter:image" content="{$image}"/>
<meta name="publisuites-verify-code" content="aHR0cHM6Ly9idWdhdmlzaW9uLmNvbS9zb2NpYWwvaW5kZXg="/>
<link rel="alternate" type="application/rss+xml" title="Feed" href="{base_url("social/feeds/general.xml")}"/>
<meta property="fb:pages" content="480918228636086"/>
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
{/if}


<script type="text/javascript" src="{base_url("themes/default/node_modules/jquery/dist/jquery.js")}"></script>
<script type="text/javascript" src="{base_url("themes/assets/javascripts/jquery-ui/jquery-ui.min.js")}"></script>
<script type="text/javascript" src="{base_url("themes/default/node_modules/popper.js/dist/umd/popper.js")}"></script>
<script type="text/javascript" src="{base_url("themes/assets/libraries/bootstrap/4.6.0/js/bootstrap.min.js")}"></script>
<script type="text/javascript" src="{base_url("themes/assets/javascripts/cropper/dist/cropper.min.js")}"></script>
<!-- include common vendor stylesheets -->
<link rel="stylesheet" type="text/css" href="{base_url("themes/assets/fonts/Higgs/Higgs.css")}?v=1.1"/>
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
<link rel="stylesheet" type="text/css" href="{base_url("themes/default/dist/css/ace.css?v=67")}"/>


<script type="text/javascript" src="{base_url("themes/default/node_modules/chart.js/dist/chart.js")}"></script>
<script type="text/javascript" src="{base_url("themes/default/node_modules/sortablejs/Sortable.js")}"></script>
<!--<script type="text/javascript" src="{base_url("themes/default/dist/js/ace.js")}"></script>//-->
<script type="text/javascript"
        src="{base_url("themes/assets/javascripts/monthpicker/jquery.ui.monthpicker.js")}"></script>
<link rel="stylesheet" type="text/css" href="{base_url("themes/assets/javascripts/monthpicker/styles.css")}"/>

<!-- dropzone //-->
<link href="{base_url("/themes/assets/javascripts/dropzone/dropzone.min.css")}" rel="stylesheet" type="text/css"/>
<script src="{base_url("/themes/assets/javascripts/dropzone/dropzone.min.js")}" type="text/javascript"></script>


<script type="text/javascript" src="{base_url("themes/default/assets/js/demo.js?v4")}"></script>

<!-- Higgs css //-->

<link href="{base_url("/themes/assets/css/messenger/users.css")}?v=1.1" rel="stylesheet" type="text/css"/>
<link href="{base_url("/themes/assets/css/messenger/chat.css")}?v=1.1" rel="stylesheet" type="text/css"/>
<link href="{base_url("/themes/assets/css/posts.css")}?v=1.1" rel="stylesheet" type="text/css"/>
<link href="{base_url("/themes/assets/css/modals.css")}?v=1.1" rel="stylesheet" type="text/css"/>
<link href="{base_url("/themes/assets/css/texts.css")}?v=1.2" rel="stylesheet" type="text/css"/>
<link href="{base_url("/themes/assets/css/buttons.css")}?v=1.1" rel="stylesheet" type="text/css"/>
<link href="{base_url("/themes/assets/css/alerts.css")}?v=1.1" rel="stylesheet" type="text/css"/>
{if isset($styles)}
    {if is_array($styles)}
        <!-- module css //-->
        {foreach from=$styles item=$style}
            <link href="{base_url($style)}" rel="stylesheet" type="text/css"/>
        {/foreach}
    {/if}
{/if}

{if isset($theme_color)}
    <style>
        {$theme_color}
        }
    </style>
{/if}


{if isset($ads)}

{/if}


{if isset($ads)}
    {if $ads===true}
<script data-ad-client="ca-pub-1567513595638732" async
        src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js">
    {/if}
    {/if}

    {if isset($schema)}
    {$schema}
    {/if}

    {if isset($arc)}
    < script
    async
    src = "https://arc.io/widget.min.js#{$arc}" ></script>
{/if}

{if isset($google_maps)}
    {if $google_maps}

    {/if}
{/if}

<!-- js //-->
<script src="/themes/assets/javascripts/dropdown/fstdropdown.js" type="text/javascript"></script>
<script src="/themes/assets/javascripts/idle-timer.min.js" type="text/javascript"></script>
<script src="/themes/assets/javascripts/ace/src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
<script src="/themes/assets/javascripts/upload/js/jquery.fileupload.js" type="text/javascript"></script>
<!-- css //-->
<link href="/themes/assets/javascripts/dropdown/fstdropdown.css" rel="stylesheet" type="text/css"/>
<link href="https://vjs.zencdn.net/7.3.0/video-js.css" rel="stylesheet">
<link href="https://unpkg.com/silvermine-videojs-quality-selector@1.1.2/dist/css/quality-selector.css" rel="stylesheet">
<link href="/themes/assets/javascripts/upload/css/jquery.fileupload.css" rel="stylesheet" type="text/css"/>