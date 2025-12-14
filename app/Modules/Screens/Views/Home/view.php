<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                                                    2024-06-30 23:40:19
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Screens\Home\breadcrumb.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2024 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                                                                         consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[vars]----------------------------------------------------------------------------------------------------------------
/** @var object $parent */
/** @var string $component */
/** @var string $view */
/** @var object $authentication */
/** @var object $request */
/** @var object $module */
generate_Screens_permissions($module);
$bootstrap = service("bootstrap");
$server = service("server");
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Screens') / 102400), 6);


$video="<video width=\"100%\" height=\"480\" controls autoplay loop>";
$video.="<source src=\"/videos/utede-horarios.mp4\" type=\"video/mp4\">";
$video.="</video> ";

$image1 = "<img id=\"horarios\" src=\"/themes/temp/horarios.png?" . time() . "\" class=\"img-fluid p-3\" alt=\"Responsive image\">";
$image2 = "<img id=\"horarios\" src=\"/themes/temp/horarios.png?" . time() . "\" class=\"img-fluid p-3\" alt=\"Responsive image\">";
$image3 = "<img id=\"horarios\" src=\"/themes/temp/horarios.png?" . time() . "\" class=\"img-fluid p-3\" alt=\"Responsive image\">";


$card = $bootstrap->get_Card("card-view-Screens", array(
    "class" => "mb-3",
    "title" => lang("Screens.module") . " <span class='text-muted'>v{$version}</span>",
    //"image" => "/themes/temp/demo.gif",
    "image-class" => "img-fluid p-3",
    "content" => $video,
    //"content" => lang("Screens.intro-1") . " " . lang("Screens.more-info"),
));
//echo($card);


?>
<style>
    .slideshow-container {
        position: relative;
        width: 100%;
        height: 100vh; /* Full viewport height */
        margin: auto;
        overflow: hidden;
    }

    .slide {
        display: none;
        width: 100%;
        height: 100%;
        object-fit: cover; /* Ensure the image covers the container */
    }

    .active {
        display: block;
    }
</style>
<div class="slideshow-container">
    <div class="video-container">
        <video src="https://intranet.utede.edu.co/videos/utede-horarios.mp4" autoplay loop muted></video>
    </div>
</div>
<style>
    body, html {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .video-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: black;
    }

    .video-container video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let currentIndex = 0;
        const slides = document.querySelectorAll('.slide');
        const totalSlides = slides.length;

        function showNextSlide() {
            slides[currentIndex].classList.remove('active');
            currentIndex = (currentIndex + 1) % totalSlides;
            slides[currentIndex].classList.add('active');
        }

        setInterval(showNextSlide, 10000); // 15 seconds
    });
</script>