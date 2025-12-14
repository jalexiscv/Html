<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
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