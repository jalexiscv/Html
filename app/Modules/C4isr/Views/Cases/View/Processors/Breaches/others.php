<?php
/*
 * Copyright (c) 2023. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

use App\Libraries\Html\HtmlTag;

//$search
//$case
$strings = service('strings');
$bootstrap = service('bootstrap');
$validation = service('validation');
$validation->setRules(['email' => 'required|valid_email']);
$request = service('request');
//[Models]--------------------------------------------------------------------------------------------------------------
$mmails = model("App\Modules\C4isr\Models\C4isr_Mails", false);
$mvulnerabilities = model('App\Modules\C4isr\Models\C4isr_Vulnerabilities');
$mintrusions = model('App\Modules\C4isr\Models\C4isr_Intrusions');
$maliases = model('App\Modules\C4isr\Models\C4isr_Aliases');
$c = "";

$search = $strings->get_URLEncode(strtolower($search));
$limit = $request->getVar('limit') ?? 100;
$offset = $request->getVar('offset') ?? 0;
$total_records = $mmails->count_UnionByMail($search);
$query = $mmails->query_UnionByMail($search, $limit, $offset);

if (is_array($query) && count($query) > 0) {
    //[Search]----------------------------------------------------------------------------------------------------------------
    $btnAdd = $bootstrap->get_Button('btnAdd', array('icon' => ICON_ADD, 'content' => lang('App.Add'), 'class' => 'btn btn-primary', 'data-bs-toggle' => "modal", 'data-bs-target' => "#confirm-mail"));
    $btnContinue = $bootstrap->get_Button('btnContinue', array('icon' => ICON_BACK, 'content' => lang('App.Continue'), 'class' => 'btn btn-secondary', 'onclick' => "location.href='/c4isr/cases/view/{$oid}';"));
    $btns = $bootstrap->get_BtnGroup('btnGroup', array('content' => $btnContinue . $btnAdd));
    $tdsearch = $bootstrap->get_Td('td', array('content' => "<b>Buscado</b>: " . $search, 'class' => 'text-center w-auto'));
    $tdmail = $bootstrap->get_Td('td', array('content' => "<b>Total Resultados</b>: " . $total_records, 'class' => 'text-center'));
    $tdoptions = $bootstrap->get_Td('td', array('content' => $btns, 'class' => 'text-right'));
    $rmail = $bootstrap->get_Tr('tr', array('content' => $tdsearch . $tdmail . $tdoptions, 'class' => 'text-center'));
    $tmail = $bootstrap->get_Table('c4isr_mail', array('content' => $rmail, 'class' => 'table table-bordered'));
    $c = $tmail;
    //[Query]----------------------------------------------------------------------------------------------------------------
    $thcount = $bootstrap->get_Th('thcount', array('content' => 'N°', 'class' => 'text-center'));
    $thmail = $bootstrap->get_Th('thmail', array('content' => 'Mail', 'class' => 'text-center'));
    $thprofile = $bootstrap->get_Th('thprofile', array('content' => lang("App.Profile"), 'class' => 'text-center'));
    $themail = $bootstrap->get_Th('themail', array('content' => lang('App.Email'), 'class' => 'text-center'));
    $thpass = $bootstrap->get_Th('thpass', array('content' => lang('App.Password'), 'class' => 'text-center'));
    $thoptions = $bootstrap->get_Th('thoptions', array('content' => lang('App.Options'), 'class' => 'text-center'));
    $trheader = $bootstrap->get_Tr('trheader', array('content' => $thcount . $thmail . $thprofile . $themail . $thpass . $thoptions, 'class' => 'text-center'));

    $count = 0;
    $rows = "";
    foreach ($query as $mail) {
        $count++;
        $btnKeys = $bootstrap->get_Button('btnKeys', array('icon' => ICON_KEY, 'class' => 'btn btn-danger', 'data-bs-toggle' => "modal", 'data-bs-target' => "#view-keys", "onclick" => "loadData('{$mail['mail']}');"));
        $vulnerabily = $mvulnerabilities->where('mail', $mail['mail'])->first();
        //$intrusion = $mintrusions->where('vulnerability', $vulnerabily['vulnerability'])->first();
        $tdcount = $bootstrap->get_Td('tdcount', array('content' => $count, 'class' => 'text-center'));
        $tdmail = $bootstrap->get_Td('tdmail', array('content' => $mail['mail'], 'class' => 'text-center'));
        $tdprofile = $bootstrap->get_Td('tdprofile', array('content' => $mail['profile'], 'class' => 'text-center'));
        $tdemail = $bootstrap->get_Td('tdemail', array('content' => $strings->get_URLDecode($mail['email']), 'class' => 'text-start'));
        $tdpass = $bootstrap->get_Td('tdpass', array('content' => "*********", 'class' => 'text-center'));
        $tdoptions = $bootstrap->get_Td('tdoptions', array('content' => $btnKeys, 'class' => 'text-center'));
        //$tdvulnerability = $bootstrap->get_Td('tdvulnerability', array('content' => $vulnerabily['vulnerability'], 'class' => 'text-center'));
        //$tdintrusion = $bootstrap->get_Td('tdintrusion', array('content' => $intrusion['breach'], 'class' => 'text-center'));
        //$tdmail = $bootstrap->get_Td('tdmail', array('content' => $vulnerabily['mail'], 'class' => 'text-center'));
        //$tdpass = $bootstrap->get_Td('tdpass', array('content' => $strings->get_URLDecode($vulnerabily['password']), 'class' => 'text-center'));
        $trmail = $bootstrap->get_Tr('tr', array('content' => $tdcount . $tdmail . $tdprofile . $tdemail . $tdpass . $tdoptions, 'class' => 'text-center'));
        $rows .= $trmail;
    }
    $table = $bootstrap->get_Table('c4isr_vulnerabilities', array('content' => $trheader . $rows, 'class' => 'table table-bordered'));
    $c .= $table;
} else {
    $continue = "/c4isr/cases/view/{$oid}";
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Breaches.domain-nofound-title"));
    $smarty->assign("message", lang("Breaches.domain-nofound-message"));
    $smarty->assign("continue", $continue);
    $smarty->assign("signin", true);
    $smarty->assign("voice", "app-login-required-message.mp3");
    $c .= ($smarty->view('alerts/card/warning.tpl'));
}

echo($c);
?>
<?php if ($total_records > 0) { ?>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?php
            $current_page = (int)(($offset / $limit) + 1);
            $total_pages = ceil($total_records / $limit);
            $start_page = max(1, $current_page - 5);
            $end_page = min($total_pages, $start_page + 9);

            // Variables adicionales
            $submited = "form_" . lpk();
            $case = $oid;
            $type = "DATABREACHES";

            // Botón "Anterior"
            $prev_offset = max(0, $offset - $limit);
            $prev_disabled = $offset == 0 ? 'disabled' : '';
            echo "<li class='page-item $prev_disabled'>";
            echo "<form method='POST'>";
            echo "<input type='hidden' name='offset' value='$prev_offset'>";
            echo "<input type='hidden' name='limit' value='$limit'>";
            echo "<input type='hidden' name='submited' value='$submited'>";
            echo "<input type='hidden' name='{$submited}_case' value='$case'>";
            echo "<input type='hidden' name='{$submited}_search' value='$search'>";
            echo "<input type='hidden' name='{$submited}_type' value='$type'>";
            echo "<button type='submit' class='page-link'>&laquo; Anterior</button>";
            echo "</form>";
            echo "</li>";

            // Páginas
            for ($i = $start_page; $i <= $end_page; $i++) {
                $new_offset = $limit * ($i - 1);
                $active = $current_page == $i ? 'active' : '';
                echo "<li class='page-item $active'>";
                echo "<form method='POST'>";
                echo "<input type='hidden' name='offset' value='$new_offset'>";
                echo "<input type='hidden' name='limit' value='$limit'>";
                echo "<input type='hidden' name='submited' value='$submited'>";
                echo "<input type='hidden' name='{$submited}_case' value='$case'>";
                echo "<input type='hidden' name='{$submited}_search' value='$search'>";
                echo "<input type='hidden' name='{$submited}_type' value='$type'>";
                echo "<button type='submit' class='page-link'>$i</button>";
                echo "</form>";
                echo "</li>";
            }

            // Botón "Siguiente"
            $next_offset = min($total_records - $limit, $offset + $limit);
            $next_disabled = $offset + $limit >= $total_records ? 'disabled' : '';
            echo "<li class='page-item $next_disabled'>";
            echo "<form method='POST'>";
            echo "<input type='hidden' name='offset' value='$next_offset'>";
            echo "<input type='hidden' name='limit' value='$limit'>";
            echo "<input type='hidden' name='submited' value='$submited'>";
            echo "<input type='hidden' name='{$submited}_case' value='$case'>";
            echo "<input type='hidden' name='{$submited}_search' value='$search'>";
            echo "<input type='hidden' name='{$submited}_type' value='$type'>";
            echo "<button type='submit' class='page-link'>Siguiente &raquo;</button>";
            echo "</form>";
            echo "</li>";
            ?>
        </ul>
    </nav>
<?php } ?>

<div class="modal fade" id="confirm-mail" tabindex="-1" aria-labelledby="confirmacionModalLabel" aria-hidden="true">
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
                <button type="button" class="btn btn-primary" onclick="confirmMail()">Confirmar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="view-keys" tabindex="-1" aria-labelledby="confirmacionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmacionModalLabel">Listado de Claves</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-3">
                        <p></p>
                        <p class="text-center">
                            <i class="fa-regular fa-radiation fa-4x"></i>
                        </p>
                    </div>
                    <div id="keys-container" class="col-9">
                        <p>Consultando...</p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continuar</button>
            </div>
        </div>
    </div>
</div>


<script>
    function confirmMail() {
        var url = '/c4isr/api/incidents/json/create/<?php echo($oid);?>?t=' + Date.now();
        var token = localStorage.getItem("token");
        var hash = localStorage.getItem("hash");
        var formData = new FormData();
        formData.append('case', '<?php echo($oid); ?>');
        formData.append('mail', '<?php echo($search); ?>');
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

    function loadData(mail) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("keys-container").innerHTML = xhr.responseText;
            }
        };
        xhr.open("GET", "/c4isr/api/vulnerabilities/json/keys/" + encodeURIComponent(mail), true);
        xhr.send();
    }

</script>