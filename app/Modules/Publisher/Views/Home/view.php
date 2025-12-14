<?php
$bootstrap = service("bootstrap");


if (!get_LoggedIn()) {
    $card = $bootstrap->get_Card("card-view-service", array(
        "title" => lang("Publisher.publisher-title") . "",
        "header-back" => "/",
        "image-class" => "p-3",
        "image" => "https://storage.googleapis.com/cloud-enginestorages/3dddd69aa578d795e09989893c654289/images/logos/logo-landscape-dark-1705120123_ea8c485d7978ecc4613c.png",
        "content" => lang("Publisher.publisher-intro"),
        "footer-class" => "text-center",
        "footer-register" => true,
        "footer-login" => true,
    ));
} else {
    $card = $bootstrap->get_Card("card-view-service", array(
        "title" => lang("Publisher.publisher-title") . "",
        "header-back" => "/",
        "image-class" => "p-3",
        "image" => "https://storage.googleapis.com/cloud-enginestorages/3dddd69aa578d795e09989893c654289/images/logos/logo-landscape-dark-1705120123_ea8c485d7978ecc4613c.png",
        "content" => lang("Publisher.publisher-intro"),
    ));
}
echo($card);
?>