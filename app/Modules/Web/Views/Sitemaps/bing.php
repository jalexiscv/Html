<?php
$server = service('server');
$dates = service('dates');

$xml = "";
$model = model("\App\Modules\Web\Models\Web_Posts", true);
$posts = $model
    ->orderBy("date", "DESC")
    ->orderBy("time", "DESC")
    ->findAll(100, 0);
foreach ($posts as $row) {
    $url = "https://" . $server::get_Name() . "/web/semantic/{$row["semantic"]}.html";
    $xml .= "{$url }<br>";
}
$xml .= "\n</urlset>";
echo($xml);
?>