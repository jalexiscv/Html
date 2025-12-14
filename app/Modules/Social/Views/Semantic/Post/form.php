<?php
//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service('bootstrap');
$strings = service('strings');
$bbcode = service('bbcode');
//[models]--------------------------------------------------------------------------------------------------------------
$mposts = model("App\Modules\Social\Models\Social_Posts");
//[vars]----------------------------------------------------------------------------------------------------------------
$semantic_uri = $oid;
$semantic = str_replace('.html', '', $semantic_uri);
$post = $mposts->get_Post($semantic);
//[build]---------------------------------------------------------------------------------------------------------------
$back = "/social/";
$title = $strings->get_URLDecode($post['title']);
$content = $bbcode->getHTML($strings->get_URLDecode($post['content']));
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => $title,
    "image" => $post['cover'],
    "header-back" => $back,
    "content" => $content,
));
echo($card);
?>