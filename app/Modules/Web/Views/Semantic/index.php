<?php
$mcategorias = model("App\Modules\Web\Models\Web_Categories");
$mposts = model("App\Modules\Web\Models\Web_Posts");

$offset = 0;
$limit = 10;
$categories = $mcategorias->get_List();
$sponsoreds = $mposts->get_Sponsoreds();
$article = $mposts->get_Post($oid);

$json = array(
    "canonical" => site_url("/web/semantic/{$article['semantic']}.html"),
    "title" => $article['title'],
    "description" => $article['description'],
    "type" => "post",
    "categories" => $categories,
    "sponsoreds" => $sponsoreds,
    "article" => $article,
);
echo(json_encode($json));
?>