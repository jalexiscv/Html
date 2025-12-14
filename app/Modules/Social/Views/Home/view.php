<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                                                    2024-03-30 13:14:41
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Social\Home\breadcrumb.php]
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
generate_social_permissions($module);
$authentication = service('authentication');
$dates = service('Dates');
$strings = service('strings');
$request = service('request');
$offset = $oid; //$request->getVar("offset");
$limit = 20;
if (empty($offset)) {
    $offset = 1;
}
//[models]---------------------------------------------------------------------------------------------------------------
$mposts = model('App\Modules\Social\Models\Social_Posts', true);
//[build]---------------------------------------------------------------------------------------------------------------
$posts = $mposts->get_List($limit, $offset - 1);

$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-Social", array(
    "class" => "mb-3",
    "title" => lang("Social.module") . "",
    "header-back" => "/",
    "image" => "/themes/assets/images/header/module-social.png",
    "image-class" => "img-fluid p-3",
    "content" => lang("Social.intro-1")
));
//echo($card);

$bposts = $bootstrap->get_Posts(array("id" => "posts-panel"));
foreach ($posts as $post) {
    $post = $mposts->get_Post($post['post']);
    $bposts->add(
        $bootstrap->get_Post(array(
                'post' => $post['post'],
                'title' => $post['title'],
                'description' => $post['description'],
                'content' => $post['content'],
                'cover' => $post['cover'],
                'semantic' => $post['semantic'],
                'type' => $post['type'],
                'author' => $post['author'],
                'alias' => $post['alias'],
                'date' => $post['date'],
                'time' => $post['time'],
                'keywords' => ""
            )
        )
    );
}
echo($bposts);


$fe = frontend("bootstrap", "5.3.3");
echo($fe->get_Builder()->get_Version());

?>