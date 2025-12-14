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

session()->set('title', "Modulo C4ISR");
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


if (isset($characterization) && isset($surveyable)) {
    $data['characterization'] = $characterization;
    $data['surveyable'] = $surveyable;
}

/* [switch] */
$quotations = "{$views}\Quotations";
$components = array(
    "denied" => array('uri' => $views . '\Denied\index', 'data' => $data),
    "default" => array('uri' => $views . '\E404\index', 'data' => $data),
    "c4isr-home" => array('uri' => $views . '\Home\index', 'data' => $data),
    "c4isr-denied" => array('uri' => $views . '\Denied\index', 'data' => $data),
    "c4isr-settings" => array('uri' => $views . '\Settings\Home\index', 'data' => $data),
    //[Breaches]--------------------------------------------------------------------------------------------------------
    "c4isr-mongo-processor" => component("{$views}\Mongo\Processor\index", $data),
    "c4isr-mongo-duplicates" => component("{$views}\Mongo\Duplicates\index", $data),
    //[Breaches]--------------------------------------------------------------------------------------------------------
    "c4isr-breaches-home" => component("{$views}\Breaches\Home\index", $data),
    "c4isr-breaches-list" => component("{$views}\Breaches\List\index", $data),
    "c4isr-breaches-view" => component("{$views}\Breaches\View\index", $data),
    "c4isr-breaches-create" => component("{$views}\Breaches\Create\index", $data),
    "c4isr-breaches-edit" => component("{$views}\Breaches\Edit\index", $data),
    "c4isr-breaches-delete" => component("{$views}\Breaches\Delete\index", $data),
    "c4isr-breaches-import" => component("{$views}\Breaches\Import\index", $data),
    //[Cases]-----------------------------------------------------------------------------------------------------------
    "c4isr-cases-home" => component("{$views}\Cases\Home\index", $data),
    "c4isr-cases-list" => component("{$views}\Cases\List\index", $data),
    "c4isr-cases-view" => component("{$views}\Cases\View\index", $data),
    "c4isr-cases-create" => component("{$views}\Cases\Create\index", $data),
    "c4isr-cases-edit" => component("{$views}\Cases\Edit\index", $data),
    "c4isr-cases-delete" => component("{$views}\Cases\Delete\index", $data),
    //[Profiles]--------------------------------------------------------------------------------------------------------
    "c4isr-profiles-home" => component("{$views}\Profiles\Home\index", $data),
    "c4isr-profiles-list" => component("{$views}\Profiles\List\index", $data),
    "c4isr-profiles-view" => component("{$views}\Profiles\View\index", $data),
    "c4isr-profiles-create" => component("{$views}\Profiles\Create\index", $data),
    "c4isr-profiles-edit" => component("{$views}\Profiles\Edit\index", $data),
    "c4isr-profiles-delete" => component("{$views}\Profiles\Delete\index", $data),
    //[Vulnerabilities]-------------------------------------------------------------------------------------------------
    "c4isr-vulnerabilities-home" => component("{$views}\Vulnerabilities\Home\index", $data),
    "c4isr-vulnerabilities-list" => component("{$views}\Vulnerabilities\List\index", $data),
    "c4isr-vulnerabilities-view" => component("{$views}\Vulnerabilities\View\index", $data),
    "c4isr-vulnerabilities-create" => component("{$views}\Vulnerabilities\Create\index", $data),
    "c4isr-vulnerabilities-edit" => component("{$views}\Vulnerabilities\Edit\index", $data),
    "c4isr-vulnerabilities-delete" => component("{$views}\Vulnerabilities\Delete\index", $data),
    //[Intrusions]------------------------------------------------------------------------------------------------------
    "c4isr-intrusions-home" => component("{$views}\Intrusions\Home\index", $data),
    "c4isr-intrusions-list" => component("{$views}\Intrusions\List\index", $data),
    "c4isr-intrusions-view" => component("{$views}\Intrusions\View\index", $data),
    "c4isr-intrusions-create" => component("{$views}\Intrusions\Create\index", $data),
    "c4isr-intrusions-edit" => component("{$views}\Intrusions\Edit\index", $data),
    "c4isr-intrusions-delete" => component("{$views}\Intrusions\Delete\index", $data),
    "c4isr-intrusions-import" => component("{$views}\Intrusions\Import\index", $data),
    //[Aliases]---------------------------------------------------------------------------------------------------------
    "c4isr-aliases-home" => component("{$views}\Aliases\Home\index", $data),
    "c4isr-aliases-list" => component("{$views}\Aliases\List\index", $data),
    "c4isr-aliases-view" => component("{$views}\Aliases\View\index", $data),
    "c4isr-aliases-create" => component("{$views}\Aliases\Create\index", $data),
    "c4isr-aliases-edit" => component("{$views}\Aliases\Edit\index", $data),
    "c4isr-aliases-delete" => component("{$views}\Aliases\Delete\index", $data),
    //[Mails]-----------------------------------------------------------------------------------------------------------
    "c4isr-mails-home" => component("{$views}\Mails\Home\index", $data),
    "c4isr-mails-list" => component("{$views}\Mails\List\index", $data),
    "c4isr-mails-view" => component("{$views}\Mails\View\index", $data),
    "c4isr-mails-create" => component("{$views}\Mails\Create\index", $data),
    "c4isr-mails-edit" => component("{$views}\Mails\Edit\index", $data),
    "c4isr-mails-delete" => component("{$views}\Mails\Delete\index", $data),
    "c4isr-mails-import" => component("{$views}\Mails\Import\index", $data),
    //[Incidents]-------------------------------------------------------------------------------------------------------
    "c4isr-incidents-home" => component("{$views}\Incidents\Home\index", $data),
    "c4isr-incidents-list" => component("{$views}\Incidents\List\index", $data),
    "c4isr-incidents-view" => component("{$views}\Incidents\View\index", $data),
    "c4isr-incidents-create" => component("{$views}\Incidents\Create\index", $data),
    "c4isr-incidents-edit" => component("{$views}\Incidents\Edit\index", $data),
    "c4isr-incidents-delete" => component("{$views}\Incidents\Delete\index", $data),
    //[Services]--------------------------------------------------------------------------------------------------------
    "c4isr-services-osint" => component("{$views}\Services\Osint\index", $data),
    //[Phones]----------------------------------------------------------------------------------------------------------
    "c4isr-phones-home" => component("{$views}\Phones\Home\index", $data),
    "c4isr-phones-list" => component("{$views}\Phones\List\index", $data),
    "c4isr-phones-view" => component("{$views}\Phones\View\index", $data),
    "c4isr-phones-create" => component("{$views}\Phones\Create\index", $data),
    "c4isr-phones-edit" => component("{$views}\Phones\Edit\index", $data),
    "c4isr-phones-delete" => component("{$views}\Phones\Delete\index", $data),
    //[Addresses]-------------------------------------------------------------------------------------------------------
    "c4isr-addresses-home" => component("{$views}\Addresses\Home\index", $data),
    "c4isr-addresses-list" => component("{$views}\Addresses\List\index", $data),
    "c4isr-addresses-view" => component("{$views}\Addresses\View\index", $data),
    "c4isr-addresses-create" => component("{$views}\Addresses\Create\index", $data),
    "c4isr-addresses-edit" => component("{$views}\Addresses\Edit\index", $data),
    "c4isr-addresses-delete" => component("{$views}\Addresses\Delete\index", $data),
    //[Socials]---------------------------------------------------------------------------------------------------------
    "c4isr-socials-home" => component("{$views}\Socials\Home\index", $data),
    "c4isr-socials-list" => component("{$views}\Socials\List\index", $data),
    "c4isr-socials-view" => component("{$views}\Socials\View\index", $data),
    "c4isr-socials-create" => component("{$views}\Socials\Create\index", $data),
    "c4isr-socials-edit" => component("{$views}\Socials\Edit\index", $data),
    "c4isr-socials-delete" => component("{$views}\Socials\Delete\index", $data),
    //[Identifications]-------------------------------------------------------------------------------------------------
    "c4isr-identifications-home" => component("{$views}\Identifications\Home\index", $data),
    "c4isr-identifications-list" => component("{$views}\Identifications\List\index", $data),
    "c4isr-identifications-view" => component("{$views}\Identifications\View\index", $data),
    "c4isr-identifications-create" => component("{$views}\Identifications\Create\index", $data),
    "c4isr-identifications-edit" => component("{$views}\Identifications\Edit\index", $data),
    "c4isr-identifications-delete" => component("{$views}\Identifications\Delete\index", $data),
    //[Physicals]-------------------------------------------------------------------------------------------------------
    "c4isr-physicals-home" => component("{$views}\Physicals\Home\index", $data),
    "c4isr-physicals-list" => component("{$views}\Physicals\List\index", $data),
    "c4isr-physicals-view" => component("{$views}\Physicals\View\index", $data),
    "c4isr-physicals-create" => component("{$views}\Physicals\Create\index", $data),
    "c4isr-physicals-edit" => component("{$views}\Physicals\Edit\index", $data),
    "c4isr-physicals-delete" => component("{$views}\Physicals\Delete\index", $data),
    //[Darkweb]
    "c4isr-darkweb-home" => component("{$views}\Darkweb\Home\index", $data),
    "c4isr-darkweb-list" => component("{$views}\Darkweb\List\index", $data),
    "c4isr-darkweb-view" => component("{$views}\Darkweb\View\index", $data),
    "c4isr-darkweb-create" => component("{$views}\Darkweb\Create\index", $data),
    "c4isr-darkweb-edit" => component("{$views}\Darkweb\Edit\index", $data),
    "c4isr-darkweb-delete" => component("{$views}\Darkweb\Delete\index", $data),
);

$mmodules = model("App\Modules\C4isr\Models\C4isr_Modules");
$mclientsxmodules = model("App\Modules\C4isr\Models\C4isr_Clients_Modules");
$client = $authentication->get_Client();
$module = $mmodules->get_ModuleByAlias('c4isr');
$cxm = $mclientsxmodules->get_CachedAuthorizedClientByModule($client, $module);

if (isset($components[$prefix]) && ($cxm == "authorized")) {
    view($components[$prefix]['uri'], $components[$prefix]['data']);
} elseif (!isset($components[$prefix]) && ($cxm)) {
    view($components['default']['uri'], $components['default']['data']);
} else {
    view($components['denied']['uri'], $components['denied']['data']);
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
$smarty->assign("sidebar", get_C4isr_sidebar("/C4isr/"));
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