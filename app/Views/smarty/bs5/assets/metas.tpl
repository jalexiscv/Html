<title>{$title}</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 7">
<meta name="author" content="Higgs App">
<meta name="keywords" content="">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link rel="shortcut icon" href="/themes/bs5/img/icons/icon-48x48.png"/>

<!-- Open Graph data -->
{if isset($title)}
    <meta property="og:title" content="{$title}"/>
{/if}
{if isset($type)}
    <meta property="og:type" content="{$type}"/>
{/if}
{if isset($url)}
    <meta property="og:url" content="{$url}"/>
{/if}
{if isset($cover)}
    <meta property="og:image" content="{$cover}"/>
{/if}
{if isset($description)}
    <meta property="og:description" content="{$description}"/>
{/if}