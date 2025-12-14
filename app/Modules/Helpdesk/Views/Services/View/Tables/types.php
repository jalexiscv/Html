<?php
$bootstrap = service('bootstrap');
$mtypes = model('App\Modules\Helpdesk\Models\Helpdesk_Types');
$musers = model('App\Modules\Helpdesk\Models\Helpdesk_Users');
$mfields = model('App\Modules\Helpdesk\Models\Helpdesk_Users_Fields');

$types = $mtypes->where('service', $service)->findAll();


$thcount = $bootstrap->get_Th('thcount', array('content' => 'N°', 'class' => 'text-center'));
$thtype = $bootstrap->get_Th('thtype', array('content' => lang('App.Type'), 'class' => 'text-center'));
$thname = $bootstrap->get_Th('thname', array('content' => lang('App.Name'), 'class' => 'text-center'));
$thoptions = $bootstrap->get_Th('thoptions', array('content' => lang('App.Options'), 'class' => 'text-center'));
$trheader = $bootstrap->get_Tr('trheader', array('content' => $thcount . $thtype . $thname . $thoptions, 'class' => 'text-center'));

$rows = "";
$count = 0;
foreach ($types as $type) {
    $count++;
    //[btns]------------------------------------------------------------------------------------------------------------
    $btnView = $bootstrap->get_Button('btnView', array('icon' => ICON_VIEW, 'content' => lang('App.Categories'), 'class' => 'btn btn-primary', 'onclick' => "location.href='/helpdesk/types/view/{$type['type']}';"));
    $btnDelete = $bootstrap->get_Button('btnDelete', array('icon' => ICON_DELETE, 'content' => lang('App.Delete'), 'class' => 'btn btn-danger', 'onclick' => "location.href='/helpdesk/types/delete/{$type['type']}';"));
    //$btnContinue = $bootstrap->get_Button('btnContinue', array('icon' => ICON_BACK, 'content' => lang('App.Continue'), 'class' => 'btn btn-secondary', 'onclick' => "location.href='/c4isr/cases/view/{$oid}';"));
    $btns = $bootstrap->get_BtnGroup('btnGroup', array('content' => $btnView . $btnDelete));
    //[cols]------------------------------------------------------------------------------------------------------------
    $tdcount = $bootstrap->get_Td('tdcount', array('content' => $count, 'class' => 'text-center'));
    $tdtype = $bootstrap->get_Td('tdtype', array('content' => $type['type'], 'class' => 'text-center'));
    $tdname = $bootstrap->get_Td('tdname', array('content' => $type['name'], 'class' => 'text-start px-1'));
    $tdoptions = $bootstrap->get_Td('tdoptions', array('content' => $btns, 'class' => 'text-right'));
    $tr = $bootstrap->get_Tr('tr', array('content' => $tdcount . $tdtype . $tdname . $tdoptions, 'class' => 'text-center'));
    $rows .= $tr;
}

$table = $bootstrap->get_Table('types', array('content' => $trheader . $rows, 'class' => 'table table-bordered '));
echo($table);
?>