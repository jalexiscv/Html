<?php
$bootstrap = service('bootstrap');
$mprofiles = model('App\Modules\Cadastre\Models\Cadastre_Profiles');
$routes = $mprofiles->get_Routes();
//print_r($routes);
$code = "";
$code .= "<ul class=\"p-0 m-0\">\n";
foreach ($routes as $route) {
    $code .= "<li class=\"d-flex\">\n";
    $code .= "<div class=\"avatar flex-shrink-0 me-3\">\n";
    $code .= "<span class=\"avatar-initial rounded bg-label-secondary\"><i class=\"bx bx-football\"></i></span>\n";
    $code .= "</div>\n";
    $code .= "<div class=\"d-flex w-100 flex-wrap align-items-center justify-content-between gap-2\">\n";
    $code .= "<div class=\"me-2\">\n";
    $code .= "<h6 class=\"my-0 py-0\">Ruta #{$route['route']}</h6>\n";
    $code .= "<small class=\"text-muted my-0 py-0\">\n";
    $code .= "<a href=\"/cadastre/maps/routes/" . lpk() . "?route={$route['route']}\" target=\"_self\">Trazar</a> | \n";
    $code .= "<a href=\"/cadastre/prints/routes/" . lpk() . "?route={$route['route']}\" target=\"_blank\">Formatos</a> | \n";
    $code .= "<a href=\"/cadastre/prints/route/{$route['route']}\" target=\"_blank\">Imprimir</a> \n";
    $code .= "</small>\n";
    $code .= "</div>\n";
    $code .= "<div class=\"user-progress\">\n";
    $code .= "<small class=\"fw-medium\">{$route['count']}</small>\n";
    $code .= "</div>\n";
    $code .= "</div>\n";
    $code .= "</li>\n";
}
$code .= "</ul>\n";
$card = $bootstrap->get_Card("option-" . lpk(), array(
    "class" => "mb-3",
    "title" => "Rutas",
    "text-class" => "text-center",
    "content" => $code,
));
echo($card);
?>