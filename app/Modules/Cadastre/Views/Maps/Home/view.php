<?php
$authentication = service('authentication');
$bootstrap = service('bootstrap');
$server = service('server');
//[Build]---------------------------------------------------------------------------------------------------------------
$banner = str_replace(".", "", strtolower($_SERVER['HTTP_HOST']));
$xclient = str_replace(".", "", strtolower($_SERVER['HTTP_HOST']));

$card = $bootstrap->get_Card("option-" . lpk(), array(
    "class" => "mb-3",
    'image' => "/themes/assets/images/header/component-maps.png?v1",
    "title" => "Opciones de mapeado",
    "text-class" => "text-center",
    "content" => lang("Sedux.intro-1"),
));
echo($card);

if ($authentication->get_LoggedIn()) {
    $html = "<div class=\"row  row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-1 row-cols-2  text-center shortcuts\">";

    $options = array(
        array("href" => "/cadastre/maps/routes/" . lpk(), "title" => "Rutas", "icon" => "fa-regular fa-signs-post", "target" => "_self"),
    );

    foreach ($options as $option) {
        $target = isset($option["target"]) ? $option["target"] : "_self";
        $html .= "<div class=\"col mb-3\">";
        $card = $bootstrap->get_Card("option-" . lpk(), array(
            "class" => "mb-3",
            "title" => $option["title"],
            "text-class" => "text-center",
            "content" => "<i class=\"icon-blue far {$option["icon"]} fa-4x\"></i>",
            "footer" => "<a href=\"{$option["href"]}\" target=\"{$target}\" class=\"w-100 btn btn-lg btn-outline-primary\">Acceder</a>"
        ));
        $html .= $card;
        $html .= "</div>";
    }
    $html .= "</div>";
    echo($html);
} else {
    $html = "<div class=\"row  row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-1 row-cols-2  text-center shortcuts\">";

    $options = array();
    $msg = "¡Hola! Gracias por intentar acceder a nuestro sistema. Sin embargo, es necesario que inicies sesión y seas un usuario autorizado para poder utilizar este sistema y sus componentes."
        . "Para tener acceso, asegúrate de tener una cuenta activa y las credenciales correctas. Si tienes alguna duda o necesitas asistencia, por favor, contacta al administrador del sistema."
        . "Recuerda que el acceso no autorizado a este sistema está prohibido y puede resultar en acciones legales correspondientes. Gracias por tu comprensión y colaboración.";
    $alert = $bootstrap->get_Alert(array(
        "type" => "info",
        "title" => "Acceso limitado",
        "message" => $msg,
        "close" => false,
        "icon" => "fa-regular fa-exclamation-triangle",
        "class" => "mb-3"
    ));
    echo($alert);
    foreach ($options as $option) {
        $target = isset($option["target"]) ? $option["target"] : "_self";
        $html .= "<div class=\"col mb-3\">";
        $card = $bootstrap->get_Card("option-" . lpk(), array(
            "class" => "mb-3",
            "title" => $option["title"],
            "text-class" => "text-center",
            "content" => "<i class=\"icon-blue far {$option["icon"]} fa-4x\"></i>",
            "footer" => "<a href=\"{$option["href"]}\" target=\"{$target}\" class=\"w-100 btn btn-lg btn-outline-primary\">Acceder</a>"
        ));
        $html .= $card;
        $html .= "</div>";
    }
    $html .= "</div>";
    echo($html);

}
?>