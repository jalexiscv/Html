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
    "disa-home" => array('uri' => $views . '\Home\index', 'data' => $data),
    "disa-mipg-home" => array('uri' => $views . '\Mipg\Home\index', 'data' => $data),
    "disa-mipg-enter" => array('uri' => $views . '\Mipg\Enter\index', 'data' => $data),
    "disa-mipg-control" => array('uri' => $views . '\Mipg\Control\Home\index', 'data' => $data),
    "disa-institutionality-home" => array('uri' => $views . '\Mipg\Institutionality\Home\index', 'data' => $data),
    "disa-institutionality-delete" => array('uri' => $views . '\Mipg\Institutionality\Delete\index', 'data' => $data),
    "disa-institutionality-committee" => array('uri' => $views . '\Mipg\Institutionality\Upload\index', 'data' => $data),
    /* Dimensions */
    "disa-dimensions-home" => component("{$views}\Mipg\Dimensions\Home\index", $data),
    "disa-dimensions-list" => component("{$views}\Mipg\Dimensions\List\index", $data),
    "disa-dimensions-view" => component("{$views}\Mipg\Dimensions\View\index", $data),
    "disa-dimensions-create" => component("{$views}\Mipg\Dimensions\Create\index", $data),
    "disa-dimensions-edit" => component("{$views}\Mipg\Dimensions\Edit\index", $data),
    "disa-dimensions-delete" => component("{$views}\Mipg\Dimensions\Delete\index", $data),
    /* Politics */
    "disa-politics-list" => component("{$views}\Mipg\Politics\List\index", $data),
    "disa-politics-create" => component("{$views}\Mipg\Politics\Create\index", $data),
    "disa-politics-view" => component("{$views}\Mipg\Politics\View\index", $data),
    "disa-politics-edit" => component("{$views}\Mipg\Politics\Edit\index", $data),
    "disa-politics-delete" => component("{$views}\Mipg\Politics\Delete\index", $data),
    /* Diagnostics */
    "disa-diagnostics-home" => component("{$views}\Mipg\Diagnostics\Home\index", $data),
    "disa-diagnostics-list" => component("{$views}\Mipg\Diagnostics\List\index", $data),
    "disa-diagnostics-view" => component("{$views}\Mipg\Diagnostics\View\index", $data),
    "disa-diagnostics-create" => component("{$views}\Mipg\Diagnostics\Create\index", $data),
    "disa-diagnostics-edit" => component("{$views}\Mipg\Diagnostics\Edit\index", $data),
    "disa-diagnostics-delete" => component("{$views}\Mipg\Diagnostics\Delete\index", $data),
    /* Components */
    "disa-components-home" => component("{$views}\Mipg\Components\Home\index", $data),
    "disa-components-list" => component("{$views}\Mipg\Components\List\index", $data),
    "disa-components-view" => component("{$views}\Mipg\Components\View\index", $data),
    "disa-components-create" => component("{$views}\Mipg\Components\Create\index", $data),
    "disa-components-edit" => component("{$views}\Mipg\Components\Edit\index", $data),
    "disa-components-delete" => component("{$views}\Mipg\Components\Delete\index", $data),
    /* Components */
    "disa-categories-home" => component("{$views}\Mipg\Categories\Home\index", $data),
    "disa-categories-list" => component("{$views}\Mipg\Categories\List\index", $data),
    "disa-categories-view" => component("{$views}\Mipg\Categories\View\index", $data),
    "disa-categories-create" => component("{$views}\Mipg\Categories\Create\index", $data),
    "disa-categories-edit" => component("{$views}\Mipg\Categories\Edit\index", $data),
    "disa-categories-delete" => component("{$views}\Mipg\Categories\Delete\index", $data),
    /* Activities */
    "disa-activities-home" => component("{$views}\Mipg\Activities\Home\index", $data),
    "disa-activities-list" => component("{$views}\Mipg\Activities\List\index", $data),
    "disa-activities-view" => component("{$views}\Mipg\Activities\View\index", $data),
    "disa-activities-create" => component("{$views}\Mipg\Activities\Create\index", $data),
    "disa-activities-edit" => component("{$views}\Mipg\Activities\Edit\index", $data),
    "disa-activities-delete" => component("{$views}\Mipg\Activities\Delete\index", $data),
    /* Scores */
    "disa-scores-home" => component("{$views}\Scores\Home\index", $data),
    "disa-scores-list" => component("{$views}\Scores\List\index", $data),
    "disa-scores-view" => component("{$views}\Scores\View\index", $data),
    "disa-scores-create" => component("{$views}\Scores\Create\index", $data),
    "disa-scores-edit" => component("{$views}\Scores\Edit\index", $data),
    "disa-scores-delete" => component("{$views}\Scores\Delete\index", $data),
    "disa-scores-attachments-create" => component("{$views}\Scores\Attachments\Create\index", $data),
    "disa-scores-attachments-delete" => component("{$views}\Scores\Attachments\Delete\index", $data),
    /* Plans*/
    "disa-plans-home" => component("{$views}\Mipg\Plans\Home\index", $data),
    "disa-plans-list" => component("{$views}\Mipg\Plans\List\index", $data),
    "disa-plans-view" => component("{$views}\Mipg\Plans\View\index", $data),
    "disa-plans-create" => component("{$views}\Mipg\Plans\Create\index", $data),
    "disa-plans-edit" => component("{$views}\Mipg\Plans\Edit\index", $data),
    "disa-plans-delete" => component("{$views}\Mipg\Plans\Delete\index", $data),
    "disa-plans-details" => component("{$views}\Mipg\Plans\Details\index", $data),
    "disa-plans-team" => component("{$views}\Mipg\Plans\Team\index", $data),
    /* Causes */
    "disa-plans-causes-list" => component("{$views}\Mipg\Plans\Causes\List\index", $data),
    "disa-plans-causes-view" => component("{$views}\Mipg\Plans\Causes\View\index", $data),
    "disa-plans-causes-create" => component("{$views}\Mipg\Plans\Causes\Create\index", $data),
    "disa-plans-causes-edit" => component("{$views}\Mipg\Plans\Causes\Edit\index", $data),
    "disa-plans-causes-delete" => component("{$views}\Mipg\Plans\Causes\Delete\index", $data),
    "disa-plans-causes-evaluate" => component("{$views}\Mipg\Plans\Causes\Evaluate\index", $data),
    /* Whys */
    "disa-whys-home" => component("{$views}\Mipg\Plans\Whys\Home\index", $data),
    "disa-whys-list" => component("{$views}\Mipg\Plans\Whys\List\index", $data),
    "disa-whys-view" => component("{$views}\Mipg\Plans\Whys\View\index", $data),
    "disa-whys-create" => component("{$views}\Mipg\Plans\Whys\Create\index", $data),
    "disa-whys-edit" => component("{$views}\Mipg\Plans\Whys\Edit\index", $data),
    "disa-whys-delete" => component("{$views}\Mipg\Plans\Whys\Delete\index", $data),
    /* Formulation */
    "disa-plans-formulation-view" => component("{$views}\Mipg\Plans\Formulation\View\index", $data),
    "disa-plans-formulation-edit" => component("{$views}\Mipg\Plans\Formulation\Edit\index", $data),
    /* Actions */
    "disa-actions-home" => component("{$views}\Mipg\Plans\Actions\Home\index", $data),
    "disa-actions-list" => component("{$views}\Mipg\Plans\Actions\List\index", $data),
    "disa-actions-view" => component("{$views}\Mipg\Plans\Actions\View\index", $data),
    "disa-actions-create" => component("{$views}\Mipg\Plans\Actions\Create\index", $data),
    "disa-actions-edit" => component("{$views}\Mipg\Plans\Actions\Edit\index", $data),
    "disa-actions-delete" => component("{$views}\Mipg\Plans\Actions\Delete\index", $data),
    "disa-actions-status" => component("{$views}\Mipg\Plans\Actions\Status\index", $data),
    /* Statuses */
    "disa-statuses-home" => component("{$views}\Mipg\Plans\Statuses\Home\index", $data),
    "disa-statuses-list" => component("{$views}\Mipg\Plans\Statuses\List\index", $data),
    "disa-statuses-view" => component("{$views}\Mipg\Plans\Statuses\View\index", $data),
    "disa-statuses-create" => component("{$views}\Mipg\Plans\Statuses\Create\index", $data),
    "disa-statuses-edit" => component("{$views}\Mipg\Plans\Statuses\Edit\index", $data),
    "disa-statuses-delete" => component("{$views}\Mipg\Plans\Statuses\Delete\index", $data),
    "disa-statuses-approval" => component("{$views}\Mipg\Plans\Statuses\Approval\index", $data),
    "disa-statuses-approve" => component("{$views}\Mipg\Plans\Statuses\Approve\index", $data),
    "disa-statuses-evaluate" => component("{$views}\Mipg\Plans\Statuses\Evaluate\index", $data),
    "disa-statuses-evaluation" => component("{$views}\Mipg\Plans\Statuses\Evaluation\index", $data),
    /* Recommendations */
    "disa-recommendations-home" => component("{$views}\Mipg\Recommendations\Home\index", $data),
    "disa-recommendations-list" => component("{$views}\Mipg\Recommendations\List\index", $data),
    "disa-recommendations-view" => component("{$views}\Mipg\Recommendations\View\index", $data),
    "disa-recommendations-create" => component("{$views}\Mipg\Recommendations\Create\index", $data),
    "disa-recommendations-edit" => component("{$views}\Mipg\Recommendations\Edit\index", $data),
    "disa-recommendations-assign" => component("{$views}\Mipg\Recommendations\Assign\index", $data),
    "disa-recommendations-unassign" => component("{$views}\Mipg\Recommendations\Unassign\index", $data),
    "disa-recommendations-delete" => component("{$views}\Mipg\Recommendations\Delete\index", $data),
    /* Settings */
    "disa-settings-home" => component("{$views}\Mipg\Settings\Home\index", $data),
    "disa-settings-characterization-view" => component("{$views}\Mipg\Settings\Characterization\View\index", $data),
    "disa-settings-characterization-create" => component("{$views}\Mipg\Settings\Characterization\Create\index", $data),
    "disa-settings-macroprocesses-view" => component("{$views}\Mipg\Settings\Macroprocesses\View\index", $data),
    "disa-settings-macroprocesses-create" => component("{$views}\Mipg\Settings\Macroprocesses\Create\index", $data),
    "disa-settings-macroprocesses-edit" => component("{$views}\Mipg\Settings\Macroprocesses\Edit\index", $data),
    "disa-settings-macroprocesses-delete" => component("{$views}\Mipg\Settings\Macroprocesses\Delete\index", $data),
    "disa-settings-macroprocesses-list" => component("{$views}\Mipg\Settings\Macroprocesses\List\index", $data),
    "disa-settings-processes-view" => component("{$views}\Mipg\Settings\Processes\View\index", $data),
    "disa-settings-processes-create" => component("{$views}\Mipg\Settings\Processes\Create\index", $data),
    "disa-settings-processes-edit" => component("{$views}\Mipg\Settings\Processes\Edit\index", $data),
    "disa-settings-processes-delete" => component("{$views}\Mipg\Settings\Processes\Delete\index", $data),
    "disa-settings-processes-list" => component("{$views}\Mipg\Settings\Processes\List\index", $data),
    "disa-settings-subprocesses-view" => component("{$views}\Mipg\Settings\Subprocesses\View\index", $data),
    "disa-settings-subprocesses-create" => component("{$views}\Mipg\Settings\Subprocesses\Create\index", $data),
    "disa-settings-subprocesses-edit" => component("{$views}\Mipg\Settings\Subprocesses\Edit\index", $data),
    "disa-settings-subprocesses-delete" => component("{$views}\Mipg\Settings\Subprocesses\Delete\index", $data),
    "disa-settings-subprocesses-list" => component("{$views}\Mipg\Settings\Subprocesses\List\index", $data),
    "disa-settings-positions-view" => component("{$views}\Mipg\Settings\Positions\View\index", $data),
    "disa-settings-positions-create" => component("{$views}\Mipg\Settings\Positions\Create\index", $data),
    "disa-settings-positions-edit" => component("{$views}\Mipg\Settings\Positions\Edit\index", $data),
    "disa-settings-positions-delete" => component("{$views}\Mipg\Settings\Positions\Delete\index", $data),
    "disa-settings-positions-list" => component("{$views}\Mipg\Settings\Positions\List\index", $data),
    /* Institutional */
    "disa-institutional-home" => component("{$views}\Institutional\Home\index", $data),
    "disa-institutional-plans-list" => component("{$views}\Institutional\Plans\List\index", $data),
    "disa-institutional-plans-view" => component("{$views}\Institutional\Plans\View\index", $data),
    "disa-institutional-plans-create" => component("{$views}\Institutional\Plans\Create\index", $data),
    "disa-institutional-plans-edit" => component("{$views}\Institutional\Plans\Edit\index", $data),
    "disa-institutional-plans-delete" => component("{$views}\Institutional\Plans\Delete\index", $data),
    /* History */
    "disa-history-home" => component("{$views}\History\List\index", $data),
    /* Programs */
    "disa-programs-home" => component("{$views}\Programs\Home\index", $data),
    "disa-programs-list" => component("{$views}\Programs\List\index", $data),
    "disa-programs-view" => component("{$views}\Programs\View\index", $data),
    "disa-programs-create" => component("{$views}\Programs\Create\index", $data),
    "disa-programs-edit" => component("{$views}\Programs\Edit\index", $data),
    "disa-programs-delete" => component("{$views}\Programs\Delete\index", $data),
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
$smarty->assign("sidebar", get_disa_sidebar("/disa/"));
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