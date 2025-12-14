<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-03-30 18:05:00
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Social\Views\Posts\Editor\processor.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
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
 * █ @var object $parent Trasferido desde el controlador
 * █ @var object $authentication Trasferido desde el controlador
 * █ @var object $request Trasferido desde el controlador
 * █ @var object $dates Trasferido desde el controlador
 * █ @var string $component Trasferido desde el controlador
 * █ @var string $view Trasferido desde el controlador
 * █ @var string $oid Trasferido desde el controlador
 * █ @var string $views Trasferido desde el controlador
 * █ @var string $prefix Trasferido desde el controlador
 * █ @var array $data Trasferido desde el controlador
 * █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[services]------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[vars]----------------------------------------------------------------------------------------------------------------
$f = service("forms", array("lang" => "Posts."));
$model = model("App\Modules\Social\Models\Social_Posts");
$d = array(
    "post" => $f->get_Value("post"),
    "semantic" => $f->get_Value("semantic"),
    "title" => $f->get_Value("title"),
    "content" => $f->get_Value("content"),
    "type" => $f->get_Value("type"),
    "cover" => $f->get_Value("cover"),
    "cover_visible" => $f->get_Value("cover_visible"),
    "description" => $f->get_Value("description"),
    "date" => $f->get_Value("date"),
    "time" => $f->get_Value("time"),
    "country" => $f->get_Value("country"),
    "region" => $f->get_Value("region"),
    "city" => $f->get_Value("city"),
    "latitude" => $f->get_Value("latitude"),
    "longitude" => $f->get_Value("longitude"),
    "author" => safe_get_user(),
    "views" => $f->get_Value("views"),
    "views_initials" => $f->get_Value("views_initials"),
    "viewers" => $f->get_Value("viewers"),
    "likes" => $f->get_Value("likes"),
    "shares" => $f->get_Value("shares"),
    "comments" => $f->get_Value("comments"),
    "video" => $f->get_Value("video"),
    "source" => $f->get_Value("source"),
    "source_alias" => $f->get_Value("source_alias"),
    "verified" => $f->get_Value("verified"),
    "status" => $f->get_Value("status"),
);
//[build]---------------------------------------------------------------------------------------------------------------
$row = $model->find($d["post"]);
if (isset($row["post"])) {
//$edit = $model->update($d);
    $c = $bootstrap->get_Card('warning', array(
        'class' => 'card-warning',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'title' => lang("Posts.view-success-title"),
        'text' => lang("Posts.view-success-message"),
        'footer-class' => 'text-center',
        'footer-continue' => base_url("/social/posts/view/{$d["post"]}/" . lpk()),
        'voice' => "social/posts-view-success-message.mp3",
    ));
} else {
    $c = $bootstrap->get_Card('success', array(
        'class' => 'card-success',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'title' => lang("Posts.view-noexist-title"),
        'text' => lang("Posts.view-noexist-message"),
        'footer-class' => 'text-center',
        'footer-continue' => base_url("/social/posts"),
        'voice' => "social/posts-view-noexist-message.mp3",
    ));
}
echo($c);
?>
