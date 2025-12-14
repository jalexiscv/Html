<?php

session()->set('main_template', null);
session()->set('main', null);
session()->set('right', null);
session()->set('plugin_ace', null);
session()->set('plugin_cropper', null);
session()->set('page_id', uniqid());
session()->set('page_header', null);
session()->set('page_template', null);
session()->set('page_message', null);
session()->set('page_trace', null);
session()->set('extra', null);
session()->set('schema', false);
session()->set('google_maps', false);
session()->set('title', '');
session()->set('description', '');
session()->set('image', '');
session()->set('ads', false);
session()->set('author', '');
session()->set('genre', 'news');
session()->set('geo_placename', 'Colombia');
session()->set('geo_position', '4.570868;-74.297333');
session()->set('geo_region', 'CO');
session()->set('language', 'spanish');
session()->set('published_time', '');
session()->set('modified_time', '');

//$views es traferidopor el controller
//$prefix es trasferido por el controller
$data = $parent->get_Array();
$components = array(
    "default" => component("{$views}\E404\index", $data),
    "web-denied" => component("{$views}\Denied\index", $data),
    "web-home" => component("{$views}\Home\index", $data),
    "web-semantic-post" => component("{$views}\Semantic\index", $data),
);

$component = isset($components[$prefix]) ? $prefix : "default";
$uri = $components[$component]['uri'];
$data = $components[$component]['data'];
$json = view($uri, $data);
//echo("Prefix: {$prefix}<br>");
//echo("URI: {$uri}\n");

//[build]---------------------------------------------------------------------------------------------------------------
$assign = array();
$assign['type'] = safe_json($json, 'type');
$assign['canonical'] = safe_json($json, 'canonical');
$assign['title'] = safe_json($json, 'title');
$assign['description'] = safe_json($json, 'description');
$assign['categories'] = safe_json($json, 'categories');
$assign['featureds'] = safe_json($json, 'featureds');
$assign['sponsoreds'] = safe_json($json, 'sponsoreds');
$assign['articles'] = safe_json($json, 'articles');
$assign['themostseens'] = safe_json($json, 'themostseens');
$assign['article'] = safe_json($json, 'article');
$assign['next'] = safe_json($json, 'next');
$assign['previus'] = safe_json($json, 'previus');
//[print]---------------------------------------------------------------------------------------------------------------
$template = view("App\Views\Themes\Web\index", $assign);
echo($template);
?>