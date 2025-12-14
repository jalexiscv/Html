<?php

use App\Libraries\Html\HtmlTag;

//$search
//$case
$strings = service('strings');
$bootstrap = service('bootstrap');
$validation = service('validation');
$validation->setRules(['email' => 'required|valid_email']);
//[Models]--------------------------------------------------------------------------------------------------------------
$mmails = model("App\Modules\C4isr\Models\C4isr_Mails", false);
$mvulnerabilities = model('App\Modules\C4isr\Models\C4isr_Vulnerabilities');
$mintrusions = model('App\Modules\C4isr\Models\C4isr_Intrusions');
$maliases = model('App\Modules\C4isr\Models\C4isr_Aliases');
$c = "";

$alias = strtolower($search);
$firstChar = substr($alias, 0, 1);
//[Query Mail]------------------------------------------------------------------------------------------------------
$maliases->setTable('c4isr_aliases_' . $firstChar);
$alias = $maliases->where('user', $strings->get_URLEncode($alias))->first();


if (is_array($alias) && isset($alias['alias'])) {
    //[Search]----------------------------------------------------------------------------------------------------------------
    $btnAdd = $bootstrap->get_Button('btnAdd', array('icon' => ICON_ADD, 'content' => lang('App.Add'), 'class' => 'btn btn-primary', 'data-bs-toggle' => "modal", 'data-bs-target' => "#confirm-alias"));
    $btnContinue = $bootstrap->get_Button('btnContinue', array('icon' => ICON_BACK, 'content' => lang('App.Continue'), 'class' => 'btn btn-secondary', 'onclick' => "location.href='/c4isr/cases/view/{$oid}';"));
    $btns = $bootstrap->get_BtnGroup('btnGroup', array('content' => $btnContinue . $btnAdd));
    $tdsearch = $bootstrap->get_Td('td', array('content' => "<b>Buscado</b>: " . $search, 'class' => 'text-center'));
    $tdmail = $bootstrap->get_Td('td', array('content' => "<b>Alias</b>: " . $alias['alias'], 'class' => 'text-center'));
    $tdprofile = $bootstrap->get_Td('td', array('content' => "<b>Perfil</b>: " . $alias['profile'], 'class' => 'text-center'));
    $tdoptions = $bootstrap->get_Td('td', array('content' => $btns, 'class' => 'text-right'));
    $ralias = $bootstrap->get_Tr('tr', array('content' => $tdsearch . $tdmail . $tdprofile . $tdoptions, 'class' => 'text-center'));
    $talias = $bootstrap->get_Table('c4isr_alias', array('content' => $ralias, 'class' => 'table table-bordered'));
    $c = $talias;
    //[Query Vulnerabilities]------------------------------------------------------------------------------------------------------
    $vulnerabilities = $mvulnerabilities->where('alias', $alias['alias'])->findAll();
    $count = 0;
    $thcount = $bootstrap->get_Th('thcount', array('content' => 'N°', 'class' => 'text-center'));
    $thvulnerability = $bootstrap->get_Th('thvulnerabilityt', array('content' => lang("App.Vulnerability"), 'class' => 'text-center'));
    $thintrusion = $bootstrap->get_Th('thintrusion', array('content' => lang('App.Intrusion'), 'class' => 'text-center'));
    //$thmail = $bootstrap->get_Th('thmail', array('content' => lang('App.Mail'), 'class' => 'text-center'));
    $thpass = $bootstrap->get_Th('thpass', array('content' => lang('App.Password'), 'class' => 'text-center'));
    $thoptions = $bootstrap->get_Th('thoptions', array('content' => lang('App.Options'), 'class' => 'text-center'));
    $trheader = $bootstrap->get_Tr('trheader', array('content' => $thcount . $thvulnerability . $thintrusion . $thpass . $thoptions, 'class' => 'text-center'));

    $rows = "";
    foreach ($vulnerabilities as $vulnerabily) {
        $intrusion = $mintrusions->where('vulnerability', $vulnerabily['vulnerability'])->first();
        $count++;
        $tdcount = $bootstrap->get_Td('tdcount', array('content' => $count, 'class' => 'text-center'));
        $tdvulnerability = $bootstrap->get_Td('tdvulnerability', array('content' => $vulnerabily['vulnerability'], 'class' => 'text-center'));
        $tdintrusion = $bootstrap->get_Td('tdintrusion', array('content' => $intrusion['breach'], 'class' => 'text-center'));
        //$tdmail = $bootstrap->get_Td('tdmail', array('content' => $vulnerabily['mail'], 'class' => 'text-center'));
        $tdpass = $bootstrap->get_Td('tdpass', array('content' => $vulnerabily['password'], 'class' => 'text-center'));
        $trvulnerabily = $bootstrap->get_Tr('tr', array('content' => $tdcount . $tdvulnerability . $tdintrusion . $tdpass, 'class' => 'text-center'));
        $rows .= $trvulnerabily;
    }
    $table = $bootstrap->get_Table('c4isr_vulnerabilities', array('content' => $trheader . $rows, 'class' => 'table table-bordered'));
    $c .= $table;
} else {
    $continue = "/c4isr/cases/view/{$oid}";
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Breaches.alias-nofound-title"));
    $smarty->assign("message", lang("Breaches.alias-nofound-message"));
    $smarty->assign("continue", $continue);
    $smarty->assign("signin", true);
    $smarty->assign("voice", "app-login-required-message.mp3");
    $c .= ($smarty->view('alerts/card/warning.tpl'));
}

echo($c);
?>
<?php if (is_array($alias) && isset($alias['alias'])) { ?>
    <div class="modal fade" id="confirm-alias" tabindex="-1" aria-labelledby="confirmacionModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-danger">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmacionModalLabel">Confirmar acción</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-3">
                            <p></p>
                            <p class="text-center">
                                <i class="fa-regular fa-circle-question fa-4x"></i>
                            </p>
                        </div>
                        <div class="col-9">
                            <p>¿Está realmente seguro de añadir la presente búsqueda al caso?</p>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="confirmAlias()">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function confirmAlias() {
            var url = '/c4isr/api/incidents/json/create/<?php echo($oid);?>?t=' + Date.now();
            var token = localStorage.getItem("token");
            var hash = localStorage.getItem("hash");
            var formData = new FormData();
            formData.append('case', '<?php echo($oid); ?>');
            formData.append('alias', '<?php echo($alias['alias']); ?>');
            formData.append(token, hash);
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function (e) {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = xhr.response;
                    var json = JSON.parse(response);
                    var status = json.status;
                    //var success = document.getElementById("mus-success");
                    //var warning = document.getElementById("mus-warning");
                    if (status == "success") {
                        location.href = '/c4isr/cases/view/<?php echo($oid);?>';
                        //success.classList.remove('visually-hidden');
                        //warning.classList.add('visually-hidden');
                    } else if (status == "e02") {
                        //success.classList.add('visually-hidden');
                        //warning.classList.remove('visually-hidden');
                    }
                }
            }
            xhr.open("POST", url);
            xhr.send(formData);
        }
    </script>
<?php } ?>