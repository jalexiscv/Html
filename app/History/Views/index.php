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

session()->set('plugin_tables', null);
session()->set('plugin_ace', null);
session()->set('plugin_cropper', null);

session()->set('page_id', uniqid());
session()->set('page_header', null);
session()->set('page_template', null);
session()->set('page_message', null);
session()->set('page_trace', null);
session()->set('extra', null);
session()->set('schema', false);
session()->set('messenger', false);

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
$data = $parent->get_Array();
/* [switch] */
$quotations = "{$views}\Quotations";
$components = array(
    "default" => array('uri' => $views . '\E404\index', 'data' => $data),
    "history-home" => array('uri' => $views . '\Home\index', 'data' => $data),
    "history-general" => array('uri' => $views . '\General\index', 'data' => $data),
    //[Stats]
    "history-stats-home" => component("{$views}\Stats\Home\index", $data),
    "history-stats-list" => component("{$views}\Stats\List\index", $data),
    "history-stats-view" => component("{$views}\Stats\View\index", $data),
    "history-stats-create" => component("{$views}\Stats\Create\index", $data),
    "history-stats-edit" => component("{$views}\Stats\Edit\index", $data),
    "history-stats-delete" => component("{$views}\Stats\Delete\index", $data),
);

if (isset($components[$prefix])) {
    $view = $components[$prefix];
    view($view['uri'], $view['data']);
} else {
    $view = $components['default'];
    view($view['uri'], $view['data']);
}
/* [/switch] */


/* Styles */
$theme_color = $authentication->get_ClientThemeColor();
$theme_color = ".navbar-default {background-color:{$theme_color}}";
$styles = array(
    "/themes/assets/css/social/calendar.css?t=" . time()
);
/* Smarty */
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->caching = 0;
/* ui */
$smarty->assign("page_id", session()->get('page_id'));
$smarty->assign("page_template", session()->get('page_template'));
$smarty->assign("main_template", session()->get('main_template'));// Determina la variante del template de contenidos principal
$smarty->assign("plugin_tables", session()->get('plugin_tables'));// Indica si se utilizaran tablas en la vista
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
$smarty->assign("sidebar", get_history_sidebar("/history/"));
$smarty->assign("sidebar_modules", get_application_sidebar());
$smarty->assign("page_header", session()->get('page_header'));
$smarty->assign("page_message", session()->get('page_message'));
$smarty->assign("main", session()->get('main'));
$smarty->assign("ads", session()->get('ads'));
$smarty->assign("right", session()->get('right') . get_application_copyright());
/* Messenger */
$smarty->assign("messenger", session()->get('messenger'));
$smarty->assign("messenger_users", array());
echo($smarty->view('index.tpl'));
?>