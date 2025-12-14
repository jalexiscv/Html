<?php

/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */
//[vars]----------------------------------------------------------------------------------------------------------------
/** @var object $parent */
/** @var string $component */
/** @var string $view */
/** @var object $authentication */
/** @var object $request */
generate_edux_permissions($module);
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-Edux", array(
    "class" => "mb-3",
    "title" => lang("Edux.module") . "",
    "header-back" => "/",
    "image" => "/themes/assets/images/header/module-edux.png",
    "image-class" => "img-fluid p-3",
    "content" => lang("Edux.intro-1")
));
//echo($card);

$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("type", "normal");
$smarty->assign("header", "Listado de documentos para procesos Registro Calificado");
$smarty->assign("header_back", "/sedux/home/index/" . lpk());
$smarty->assign("image", "/themes/assets/images/header/men.png?v3");
$smarty->assign("body", lang("Sedux.intro-1"));
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));

if ($authentication->get_LoggedIn()) {
    $html = "<div class=\"row  row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-1 row-cols-2  text-center shortcuts\">";
    $options = array(
        array("href" => "/edux/documents/list/" . lpk(), "title" => "Documentos", "icon" => "fa-archive", "target" => "_self"),
        array("href" => "/edux/references/list/" . lpk(), "title" => "Referencias", "icon" => "fa-landmark"),
    );
    foreach ($options as $option) {
        $target = isset($option["target"]) ? $option["target"] : "_self";
        $html .= "<div class=\"col mb-3\">";
        $card = service("smarty");
        $card->set_Mode("bs5x");
        $card->caching = 0;
        $card->assign("type", "normal");
        $card->assign("class", "mb-3");
        $card->assign("header", $option["title"]);
        $card->assign("title_class", "   ");
        $card->assign("header_back", false);
        $card->assign("image", false);
        $card->assign("body", "<i class=\"icon-blue far {$option["icon"]} fa-4x\"></i>");
        $card->assign("footer", "<a href=\"{$option["href"]}\" target=\"{$target}\" class=\"w-100 btn btn-lg btn-outline-primary\">Acceder</a>");
        $html .= $card->view('components/cards/index.tpl');
        $html .= "</div>";
    }
    $html .= "</div>";
    echo($html);
} else {
    $html = "<div class=\"row  row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-1 row-cols-2  text-center shortcuts\">";
    $options = array(
        array("href" => "https://ita.edu.co", "title" => "Corporativo", "icon" => "fa-regular fa-globe", "target" => "_blank"),
        array("href" => "https://ita.edu.co/contacto/login", "title" => "PQRSD", "icon" => "fa-regular fa-headset", "target" => "_blank"),
        array("href" => "https://site2.q10.com/login", "title" => "Q10", "icon" => "fa-regular fa-building-columns", "target" => "_self"),
    );
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
        $card = service("smarty");
        $card->set_Mode("bs5x");
        $card->caching = 0;
        $card->assign("type", "normal");
        $card->assign("class", "mb-3");
        $card->assign("header", $option["title"]);
        $card->assign("title_class", "   ");
        $card->assign("header_back", false);
        $card->assign("image", false);
        $card->assign("body", "<i class=\"icon-blue far {$option["icon"]} fa-4x\"></i>");
        $card->assign("footer", "<a href=\"{$option["href"]}\" target=\"{$target}\" class=\"w-100 btn btn-lg btn-outline-primary\">Acceder</a>");
        $html .= $card->view('components/cards/index.tpl');
        $html .= "</div>";
    }
    $html .= "</div>";
    echo($html);

}
?>
