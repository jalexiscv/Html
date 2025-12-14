<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Physicals\List\table.php]
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
$table = array(
    'id' => 'table-' . lpk(),
    'data-url' => '/c4isr/api/physicals/json/list/' . lpk(),
    'buttons' => array(
        'create' => array('text' => ICON_ADD . lang('App.Create'), 'href' => '/c4isr/physicals/create/' . lpk(), 'class' => 'btn-secondary'),
    ),
    'cols' => array(
        'physical' => array('text' => lang('App.physical'), 'class' => 'text-center'),
        'profile' => array('text' => lang('App.profile'), 'class' => 'text-center'),
        'height' => array('text' => lang('App.height'), 'class' => 'text-center'),
        'weight' => array('text' => lang('App.weight'), 'class' => 'text-center'),
        'skin_color' => array('text' => lang('App.skin_color'), 'class' => 'text-center'),
        'eye_color' => array('text' => lang('App.eye_color'), 'class' => 'text-center'),
        'eye_shape' => array('text' => lang('App.eye_shape'), 'class' => 'text-center'),
        'eye_size' => array('text' => lang('App.eye_size'), 'class' => 'text-center'),
        'hair_color' => array('text' => lang('App.hair_color'), 'class' => 'text-center'),
        'hair_type' => array('text' => lang('App.hair_type'), 'class' => 'text-center'),
        'hair_length' => array('text' => lang('App.hair_length'), 'class' => 'text-center'),
        'face_shape' => array('text' => lang('App.face_shape'), 'class' => 'text-center'),
        'nose_size_shape' => array('text' => lang('App.nose_size_shape'), 'class' => 'text-center'),
        'ear_size_shape' => array('text' => lang('App.ear_size_shape'), 'class' => 'text-center'),
        'lip_size_shape' => array('text' => lang('App.lip_size_shape'), 'class' => 'text-center'),
        'chin_size_shape' => array('text' => lang('App.chin_size_shape'), 'class' => 'text-center'),
        'facial_hair_presence_type' => array('text' => lang('App.facial_hair_presence_type'), 'class' => 'text-center'),
        'eyebrow_presence_type' => array('text' => lang('App.eyebrow_presence_type'), 'class' => 'text-center'),
        'moles_freckles_birthmarks_presence_location' => array('text' => lang('App.moles_freckles_birthmarks_presence_location'), 'class' => 'text-center'),
        'scars_presence_location' => array('text' => lang('App.scars_presence_location'), 'class' => 'text-center'),
        'tattoos_presence_location' => array('text' => lang('App.tattoos_presence_location'), 'class' => 'text-center'),
        'piercings_presence_location' => array('text' => lang('App.piercings_presence_location'), 'class' => 'text-center'),
        'interpupillary_distance' => array('text' => lang('App.interpupillary_distance'), 'class' => 'text-center'),
        'eyes_forehead_distance' => array('text' => lang('App.eyes_forehead_distance'), 'class' => 'text-center'),
        'nose_mouth_distance' => array('text' => lang('App.nose_mouth_distance'), 'class' => 'text-center'),
        'shoulder_width' => array('text' => lang('App.shoulder_width'), 'class' => 'text-center'),
        'arm_length' => array('text' => lang('App.arm_length'), 'class' => 'text-center'),
        'hand_size_shape' => array('text' => lang('App.hand_size_shape'), 'class' => 'text-center'),
        'finger_size_shape' => array('text' => lang('App.finger_size_shape'), 'class' => 'text-center'),
        'nail_size_shape' => array('text' => lang('App.nail_size_shape'), 'class' => 'text-center'),
        'leg_length' => array('text' => lang('App.leg_length'), 'class' => 'text-center'),
        'foot_size_shape' => array('text' => lang('App.foot_size_shape'), 'class' => 'text-center'),
        'author' => array('text' => lang('App.author'), 'class' => 'text-center'),
        'created_at' => array('text' => lang('App.created_at'), 'class' => 'text-center'),
        'updated_at' => array('text' => lang('App.updated_at'), 'class' => 'text-center'),
        'deleted_at' => array('text' => lang('App.deleted_at'), 'class' => 'text-center'),
        'options' => array('text' => lang('App.Options'), 'class' => 'text-center fit px-2'),
    ),
    'data-page-size' => 10,
    'data-side-pagination' => 'server'
);
/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
$smarty = service('smarty');
$smarty->set_Mode('bs5x');
$smarty->assign('type', 'table');
$smarty->assign('header', lang('Physicals.list-title'));
$smarty->assign('body', '');
$smarty->assign('table', $table);
$smarty->assign('footer', null);
$smarty->assign('file', __FILE__);
echo($smarty->view('components/cards/index.tpl'));
?>
