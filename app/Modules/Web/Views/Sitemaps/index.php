<?php
$server = service('server');
$dates = service('dates');

$xml = ("<?xml version=\"1.0\" encoding=\"UTF-8\" ?>");
$xml .= "\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
$model = model("\App\Modules\Web\Models\Web_Posts", true);
$posts = $model
    ->orderBy("date", "DESC")
    ->orderBy("time", "DESC")
    ->findAll(1000, 0);
foreach ($posts as $row) {
    $url = "https://" . $server::get_Name() . "/web/semantic/{$row["semantic"]}.html";
    //$url_image = "https://" . Server::getName() . "/storage/{$row->image}";
    $xml .= "\n\t <url>";
    $xml .= "\n\t\t <loc>{$url }</loc>";
//    $xml .= "\n\t\t <image:image>";
//    $xml .= "\n\t\t\t <image:loc>{$url_image}</image:loc>";
//    $xml .= "\n\t\t\t <image:caption></image:caption>";
//    $xml .= "\n\t\t </image:image>";
    $xml .= "\n\t\t <priority>1.0</priority>";
    $xml .= "\n\t\t <changefreq>daily</changefreq>";
    $xml .= "\n\t </url>";
}
$xml .= "\n</urlset>";
echo($xml);
?>