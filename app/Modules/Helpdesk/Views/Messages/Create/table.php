<?php
$bootstrap = service('bootstrap');
$magents = model('App\Modules\Helpdesk\Models\Helpdesk_Agents');
$musers = model('App\Modules\Helpdesk\Models\Helpdesk_Users');
$mfields = model('App\Modules\Helpdesk\Models\Helpdesk_Users_Fields');
$mconversations = model('App\Modules\Helpdesk\Models\Helpdesk_Conversations');
$mmesagges = model('App\Modules\Helpdesk\Models\Helpdesk_Messages');
$mesagges = $mmesagges->where('conversation', $conversation)->orderBy("date,time", 'DESC')->findAll();

$user = safe_get_user();

$thcount = $bootstrap->get_Th('thcount', array('content' => 'N°', 'class' => 'text-center'));
//$thuser = $bootstrap->get_Th('thuser', array('content' => lang('App.User'), 'class' => 'text-center'));
$thcontent = $bootstrap->get_Th('thcontent', array('content' => lang('App.Message'), 'class' => 'text-start'));
$thdate = $bootstrap->get_Th('thdate', array('content' => lang('App.Date'), 'class' => 'text-center'));
$thtime = $bootstrap->get_Th('thtime', array('content' => lang('App.Time'), 'class' => 'text-center'));

$thoptions = $bootstrap->get_Th('thoptions', array('content' => lang('App.Options'), 'class' => 'text-center'));
if ($user != "anonymous") {
    $trheader = $bootstrap->get_Tr('trheader', array('content' => $thcount . $thcontent . $thdate . $thtime . $thoptions, 'class' => 'text-center'));
} else {
    $trheader = $bootstrap->get_Tr('trheader', array('content' => $thcount . $thcontent . $thdate . $thtime, 'class' => 'text-center'));
}

$rows = "";
$count = count($mesagges) + 1;
foreach ($mesagges as $message) {
    $count--;
    $content = $message['content'];
    //[btns]------------------------------------------------------------------------------------------------------------
    //$btnAdd = $bootstrap->get_Button('btnAdd', array('icon' => ICON_ADD, 'content' => lang('App.Add'), 'class' => 'btn btn-primary', 'data-bs-toggle' => "modal", 'data-bs-target' => "#confirm-alias"));
    $btnDelete = $bootstrap->get_Button('btnDelete', array('icon' => ICON_DELETE, 'content' => lang('App.Delete'), 'class' => 'btn btn-danger', 'onclick' => "location.href='/helpdesk/messages/delete/{$message['message']}';"));
    //$btnContinue = $bootstrap->get_Button('btnContinue', array('icon' => ICON_BACK, 'content' => lang('App.Continue'), 'class' => 'btn btn-secondary', 'onclick' => "location.href='/c4isr/cases/view/{$oid}';"));
    $btns = $bootstrap->get_BtnGroup('btnGroup', array('content' => $btnDelete));
    //[cols]------------------------------------------------------------------------------------------------------------
    $tdcount = $bootstrap->get_Td('tdcount', array('content' => $count, 'class' => 'text-center'));
    $tdcontent = $bootstrap->get_Td('tdcontent', array('content' => $content, 'class' => 'text-start px-1'));
    $tddate = $bootstrap->get_Td('tddate', array('content' => $message['date'], 'class' => 'text-center'));
    $tdtime = $bootstrap->get_Td('tdtime', array('content' => $message['time'], 'class' => 'text-center'));
    $tdoptions = $bootstrap->get_Td('tdoptions', array('content' => $btns, 'class' => 'text-right'));

    if ($user != "anonymous") {
        $tr = $bootstrap->get_Tr('tr', array('content' => $tdcount . $tdcontent . $tddate . $tdtime . $tdoptions, 'class' => 'text-center'));
    } else {
        $tr = $bootstrap->get_Tr('tr', array('content' => $tdcount . $tdcontent . $tddate . $tdtime, 'class' => 'text-center'));
    }

    $rows .= $tr;
}

$table = $bootstrap->get_Table('agents', array('content' => $trheader . $rows, 'class' => 'table table-bordered '));
echo($table);
?>