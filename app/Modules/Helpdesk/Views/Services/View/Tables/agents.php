<?php
$authentication = service('authentication');
$bootstrap = service('bootstrap');
$magents = model('App\Modules\Helpdesk\Models\Helpdesk_Agents');
$musers = model('App\Modules\Helpdesk\Models\Helpdesk_Users');
$mfields = model('App\Modules\Helpdesk\Models\Helpdesk_Users_Fields');

$agents = $magents->where('service', $service)->findAll();


$thcount = $bootstrap->get_Th('thcount', array('content' => 'N°', 'class' => 'text-center'));
$thuser = $bootstrap->get_Th('thuser', array('content' => lang('App.User'), 'class' => 'text-center'));
$thname = $bootstrap->get_Th('thname', array('content' => lang('App.Name'), 'class' => 'text-center'));
$throl = $bootstrap->get_Th('thname', array('content' => lang('App.Roles'), 'class' => 'text-center'));
$thoptions = $bootstrap->get_Th('thoptions', array('content' => lang('App.Options'), 'class' => 'text-center'));
$trheader = $bootstrap->get_Tr('trheader', array('content' => $thcount . $thuser . $thname . $throl . $thoptions, 'class' => 'text-center'));

$rows = "";
$count = 0;

foreach ($agents as $agent) {
    $count++;
    $profile = $mfields->get_Profile($agent['user']);
    $agent_name = $profile['name'];
    //Verifico los permisos para saber que puede hace el agente
    $hdmc = $musers->has_Permission($agent['user'], "helpdesk-messages-create");
    $hdmv = $musers->has_Permission($agent['user'], "helpdesk-messages-view");
    $hdmva = $musers->has_Permission($agent['user'], "helpdesk-messages-view-all");

    $permissions = ($hdmc) ? "<span class=\"badge rounded-pill bg-danger p-2\" data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"Puede responder\"><i class=\"fa-regular fa-message-quote fs-4\" ></i></span>" : "";
    $permissions .= ($hdmv) ? "<span class=\"badge rounded-pill bg-danger p-2\" data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"Puede ver sus mensajes o los de su area\"><i class=\"fa-regular fa-message fs-4\" title=\"\"></i>" : "";
    $permissions .= ($hdmva) ? "<span class=\"badge rounded-pill bg-danger p-2\" data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"Puede ver todos los mensajes\"><i class=\"fa-light fa-messages fs-4\"></i>" : "";


    //[btns]------------------------------------------------------------------------------------------------------------
    //$btnAdd = $bootstrap->get_Button('btnAdd', array('icon' => ICON_ADD, 'content' => lang('App.Add'), 'class' => 'btn btn-primary', 'data-bs-toggle' => "modal", 'data-bs-target' => "#confirm-alias"));
    $btnDelete = $bootstrap->get_Button('btnDelete', array('icon' => ICON_DELETE, 'content' => lang('App.Delete'), 'class' => 'btn btn-danger', 'onclick' => "location.href='/helpdesk/agents/delete/{$agent['agent']}';"));
    //$btnContinue = $bootstrap->get_Button('btnContinue', array('icon' => ICON_BACK, 'content' => lang('App.Continue'), 'class' => 'btn btn-secondary', 'onclick' => "location.href='/c4isr/cases/view/{$oid}';"));
    $btns = $bootstrap->get_BtnGroup('btnGroup', array('content' => $btnDelete));
    //[cols]------------------------------------------------------------------------------------------------------------
    $tdcount = $bootstrap->get_Td('tdcount', array('content' => $count, 'class' => 'text-center'));
    $tduser = $bootstrap->get_Td('tduser', array('content' => $agent['user'], 'class' => 'text-center'));
    $tdname = $bootstrap->get_Td('tdname', array('content' => $agent_name, 'class' => 'text-start px-1'));
    $tdrol = $bootstrap->get_Td('tdrol', array('content' => $permissions, 'class' => 'text-start px-1'));
    $tdoptions = $bootstrap->get_Td('tdoptions', array('content' => $btns, 'class' => 'text-right'));
    $tr = $bootstrap->get_Tr('tr', array('content' => $tdcount . $tduser . $tdname . $tdrol . $tdoptions, 'class' => 'text-center'));
    $rows .= $tr;
}

$table = $bootstrap->get_Table('agents', array('content' => $trheader . $rows, 'class' => 'table table-bordered '));
echo($table);
?>