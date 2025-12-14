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
 * @views
 * @prefix
 * @parent
 * -----------------------------------------------------------------------------
 */


$f = service('forms', array('lang' => 'Nexus.'));
$model = model('App\Modules\Nexus\Models\Nexus_Clients');
/*
 * -----------------------------------------------------------------------------
 * [Fields]
 * -----------------------------------------------------------------------------
*/
$domain = str_replace('www.', '', $f->get_Value('domain'));
$d = array(
    'client' => $f->get_Value('client'),
    'name' => $f->get_Value('name', true, true),
    'domain' => $domain,
    'default_url' => $f->get_Value('default_url'),
    'db' => $f->get_Value('db'),
    'db_host' => $f->get_Value('db_host'),
    'db_port' => $f->get_Value('db_port'),
    'db_user' => $f->get_Value('db_user'),
    'db_password' => $f->get_Value('db_password'),
    'theme_color' => $f->get_Value('theme_color'),
    'fb_app_id' => $f->get_Value('fb_app_id'),
    'fb_app_secret' => $f->get_Value('fb_app_secret'),
    'fb_page' => $f->get_Value('fb_page'),
    'arc_id' => $f->get_Value('arc_id'),
    'matomo' => $f->get_Value('matomo'),
    'author' => $authentication->get_User(),
);
/*
 * -----------------------------------------------------------------------------
 * [Processing]
 * -----------------------------------------------------------------------------
*/
$row = $model->find($d['client']);
if (isset($row['client'])) {
    $path = '/storages/nexus/' . $row['client'];
    /* Extras */
    $logo = $request->getFile($f->get_fieldId('logo'));
    if (!is_null($logo) && $logo->isValid()) {
        $rname = $logo->getRandomName();
        $logo->move(ROOTPATH . 'public' . $path, $rname);
        $name = $logo->getClientName();
        $type = $logo->getClientMimeType();
        $d['logo'] = $path . "/" . $rname;
        $authentication->set_Logo($d['logo']);
    }
    $logo_portrait = $request->getFile($f->get_fieldId('logo_portrait'));
    if (!is_null($logo_portrait) && $logo_portrait->isValid()) {
        $rname = $logo_portrait->getRandomName();
        $logo_portrait->move(ROOTPATH . 'public' . $path, $rname);
        $name = $logo_portrait->getClientName();
        $type = $logo_portrait->getClientMimeType();
        $d['logo_portrait'] = $path . "/" . $rname;
    }
    $logo_landscape = $request->getFile($f->get_fieldId('logo_landscape'));
    if (!is_null($logo_landscape) && $logo_landscape->isValid()) {
        $rname = $logo_landscape->getRandomName();
        $logo_landscape->move(ROOTPATH . 'public' . $path, $rname);
        $name = $logo_landscape->getClientName();
        $type = $logo_landscape->getClientMimeType();
        $d['logo_landscape'] = $path . "/" . $rname;
    }
    /* Update */
    $model->update($d['client'], $d);
    /* Build */
    $smarty = service('smarty');
    $smarty->set_Mode('bs5x');
    $smarty->assign('title', lang('Nexus.clients-edit-success-title'));
    $smarty->assign('message', lang('Nexus.clients-edit-success-message'));
    $smarty->assign('continue', base_url('/nexus/clients'));
    $smarty->assign('voice', 'nexus/clients-edit-success-message.mp3');
    $c = $smarty->view('alerts/success.tpl');

} else {
    $smarty = service('smarty');
    $smarty->set_Mode('bs5x');
    $smarty->assign('title', lang('Nexus.clients-edit-noexist-title'));
    $smarty->assign('message', sprintf(lang('Nexus.clients-edit-noexist-message'), $d['client']));
    $smarty->assign('continue', base_url('/nexus/clients/'));
    $smarty->assign('voice', 'nexus/clients-edit-noexist-message.mp3');
    $c = $smarty->view('alerts/warning.tpl');
}
echo($c);
?>