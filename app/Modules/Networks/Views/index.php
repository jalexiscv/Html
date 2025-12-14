<?php

/*
 * -----------------------------------------------------------------------------
 *  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
 *  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK]
 *  ╩ ╩╝╚╝╚═╝╚═╝╩╚═╝╩═╝╚═╝
 * -----------------------------------------------------------------------------
 * Copyright 2021 - Higgs Bigdata S.A.S., Inc. <admin@Higgs.com>
 * Este archivo es parte de Higgs Bigdata Framework 7.1
 * Para obtener información completa sobre derechos de autor y licencia, consulte
 * la LICENCIA archivo que se distribuyó con este código fuente.
 * -----------------------------------------------------------------------------
 * EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * -----------------------------------------------------------------------------
 * @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * @link https://www.Higgs.com
 * @Version 1.5.0
 * @since PHP 7, PHP 8
 * -----------------------------------------------------------------------------
 * Datos recibidos desde el controlador - @ModuleController
 * -----------------------------------------------------------------------------
 * @Authentication
 * @request
 * @dates
 * @view
 * @oid
 * @component
 * @prefix
 *
 */
session()->set('main_template', null);
session()->set('main', null);
session()->set('right', null);
session()->set('plugin_ace', null);
session()->set('plugin_cropper', null);
session()->set('page_id', uniqid());
session()->set('page_header', null);
session()->set('page_template', null);
session()->set('page_message', null);
session()->set('page_trace', null);
session()->set('extra', null);
session()->set('schema', false);
session()->set('google_maps', false);
session()->set('title', '');
session()->set('description', '');
session()->set('image', '');
session()->set('ads', false);
session()->set('author', '');
session()->set('genre', 'news');
session()->set('geo_placename', 'Colombia');
session()->set('geo_position', '4.570868;-74.297333');
session()->set('geo_region', 'CO');
session()->set('language', 'spanish');
session()->set('published_time', '');
session()->set('modified_time', '');
/*
 * -----------------------------------------------------------------------------
 * [Switch]
 * -----------------------------------------------------------------------------
*/
$data = $parent->get_Array();
$clients = "{$views}\Clients";
$generators = "{$views}\Generators";
$components = array(
    "default" => component("{$views}\E404\index", $data),
    "networks-home" => component("{$views}\Home\index", $data),
    "networks-denied" => array('uri' => "{$views}\Denied\index", 'data' => $data),
    //[Resources]
    "networks-resources-home" => component("{$views}\Resources\Home\index", $data),
    "networks-resources-list" => component("{$views}\Resources\List\index", $data),
    "networks-resources-view" => component("{$views}\Resources\View\index", $data),
    "networks-resources-create" => component("{$views}\Resources\Create\index", $data),
    "networks-resources-edit" => component("{$views}\Resources\Edit\index", $data),
    "networks-resources-delete" => component("{$views}\Resources\Delete\index", $data),
    //[Profiles]
    "networks-profiles-home" => component("{$views}\Profiles\Home\index", $data),
    "networks-profiles-list" => component("{$views}\Profiles\List\index", $data),
    "networks-profiles-view" => component("{$views}\Profiles\View\index", $data),
    "networks-profiles-create" => component("{$views}\Profiles\Create\index", $data),
    "networks-profiles-edit" => component("{$views}\Profiles\Edit\index", $data),
    "networks-profiles-delete" => component("{$views}\Profiles\Delete\index", $data),
);

/*
 * -----------------------------------------------------------------------------
 * [Eval]
 * -----------------------------------------------------------------------------
*/
if (isset($components[$prefix])) {
    $view = $components[$prefix];
    view($view['uri'], $view['data']);
} else {
    $view = $components['default'];
    view($view['uri'], $view['data']);
}
/*
 * -----------------------------------------------------------------------------
 * [Extra]
 * -----------------------------------------------------------------------------
*/
$theme_color = $authentication->get_ClientThemeColor();
$theme_color = ".navbar-default {background-color:{$theme_color}}";
$styles = array("/themes/assets/css/social/calendar.css?t=" . time());
/*
 * -----------------------------------------------------------------------------
 * [Build]
 * -----------------------------------------------------------------------------
*/
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->caching = 0;
/* ui */
$smarty->assign("page_id", session()->get('page_id'));
$smarty->assign("page_template", session()->get('page_template'));
$smarty->assign("main_template", session()->get('main_template'));// Determina la variante del template de contenidos principal
$smarty->assign("plugin_ace", session()->get('plugin_ace'));// Ace editor
$smarty->assign("plugin_cropper", session()->get('plugin_cropper'));
$smarty->assign("page_trace", session()->get('page_trace'));
$smarty->assign("google_maps", session()->get('google_maps'));
$smarty->assign("extra", session()->get('extra'));
$smarty->assign("csrf_token", $authentication->csrf_token());
$smarty->assign("csrf_hash", $authentication->csrf_hash());
$smarty->assign("arc", $authentication->get_ArcID());
/* Schema: Controla los valores asociados al manejod e datos estructurados  */
$smarty->assign("schema", session()->get('schema'));
/* Datas */
$smarty->assign("title", session()->get('title'));
$smarty->assign("description", session()->get('description'));
$smarty->assign("image", session()->get('image'));
$smarty->assign("author", session()->get('author'));
$smarty->assign("genre", session()->get('genre'));
$smarty->assign("geo_placename", session()->get('geo_placename'));
$smarty->assign("geo_position", session()->get('geo_position'));
$smarty->assign("geo_region", session()->get('geo_region'));
$smarty->assign("language", session()->get('language'));
$smarty->assign("published_time", session()->get('published_time'));
$smarty->assign("modified_time", session()->get('modified_time'));
/** Styles **/
$smarty->assign("styles", $styles);
$smarty->assign("theme_color", $theme_color);
$smarty->assign("loggedin", $authentication->get_LoggedIn(), true);
$smarty->assign("user", $authentication->get_Value("user"), true);
$smarty->assign("alias", $authentication->get_Value("alias"), true);
$smarty->assign("avatar", $authentication->get_Value("avatar"), true);
$smarty->assign("host", $authentication->get_Value("host"), true);
$smarty->assign("sidebar", get_networks_sidebar("/networks/"));
$smarty->assign("sidebar_modules", get_application_sidebar());
$smarty->assign("page_header", session()->get('page_header'));
$smarty->assign("page_message", session()->get('page_message'));
$smarty->assign("main", session()->get('main'));
$smarty->assign("ads", session()->get('ads'));
$smarty->assign("right", get_application_copyright());
/* Messenger */
$smarty->assign("messenger", true);
$smarty->assign("messenger_users", array());
echo($smarty->view('index.tpl'));
?>