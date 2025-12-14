<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-06-22 13:47:13
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Cadastre\Views\Profiles\List\table.php]
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
 * █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/

//[vars]-----------------------------------------------------------------------------------------------------
$back = "/cadastre";
$table = array(
    'id' => 'table-' . lpk(),
    'data-url' => '/cadastre/api/profiles/json/list/' . lpk(),
    'buttons' => array(
        'create' => array('text' => ICON_ADD . lang('App.Create'), 'href' => '/cadastre/profiles/create/' . lpk(), 'class' => 'btn-secondary'),
    ),
    'cols' => array(
        'profile' => array('text' => lang('App.profile'), 'class' => 'text-center'),
        'customer' => array('text' => lang('App.customer'), 'class' => 'text-center'),
        'registration' => array('text' => lang('App.registration'), 'class' => 'text-center'),
        'names' => array('text' => lang('App.names'), 'class' => 'text-center'),
        'address' => array('text' => lang('App.address'), 'class' => 'text-center'),
        'cycle' => array('text' => lang('App.cycle'), 'class' => 'text-center'),
        'stratum' => array('text' => lang('App.stratum'), 'class' => 'text-center'),
        'use_type' => array('text' => lang('App.use_type'), 'class' => 'text-center'),
        'consumption' => array('text' => lang('App.consumption'), 'class' => 'text-center'),
        'service' => array('text' => lang('App.service'), 'class' => 'text-center'),
        'neighborhood_description' => array('text' => lang('App.neighborhood_description'), 'class' => 'text-center'),
        'unit_id' => array('text' => lang('App.unit_id'), 'class' => 'text-center'),
        'phone' => array('text' => lang('App.phone'), 'class' => 'text-center'),
        'entry_date' => array('text' => lang('App.entry_date'), 'class' => 'text-center'),
        'reading_route' => array('text' => lang('App.reading_route'), 'class' => 'text-center'),
        'national_property_number' => array('text' => lang('App.national_property_number'), 'class' => 'text-center'),
        'rate' => array('text' => lang('App.rate'), 'class' => 'text-center'),
        'route_sequence' => array('text' => lang('App.route_sequence'), 'class' => 'text-center'),
        'diameter' => array('text' => lang('App.diameter'), 'class' => 'text-center'),
        'meter_number' => array('text' => lang('App.meter_number'), 'class' => 'text-center'),
        'historical' => array('text' => lang('App.historical'), 'class' => 'text-center'),
        'longitude' => array('text' => lang('App.longitude'), 'class' => 'text-center'),
        'latitude' => array('text' => lang('App.latitude'), 'class' => 'text-center'),
        'options' => array('text' => lang('App.Options'), 'class' => 'text-center fit px-2'),
    ),
    'data-page-size' => 10,
    'data-side-pagination' => 'server'
);
//[build]-----------------------------------------------------------------------------------------------------
$smarty = service('smarty');
$smarty->set_Mode('bs5x');
$smarty->assign('type', 'table');
$smarty->assign('header', lang('Profiles.list-title'));
$smarty->assign('header_back', $back);
$smarty->assign('body', '');
$smarty->assign('table', $table);
$smarty->assign('footer', null);
$smarty->assign('file', __FILE__);
echo($smarty->view('components/cards/index.tpl'));
?>
