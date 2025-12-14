<?php


$options = array(
    "uploader" => array("text" => "Cargar acta", "href" => "/disa/institutionality/committees/upload/" . lpk()),
    "separator" => array("separator" => true),
    "list" => array("text" => lang("App.Update"), "href" => "/disa/mipg/institutionality/" . lpk()),
);

$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("type", "normal");
$smarty->assign("header", "Institucionalidad");
$smarty->assign("body", lang("Disa.institutionality-intro"));
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
$smarty->assign("class", "mb-2");
$smarty->assign("header_menu", $options);
echo($smarty->view('components/cards/index.tpl'));


?>


<div class="row mb-2">
    <div class="col-md-3">
        <div class="card profile-card-3">
            <div class="background-block">
                <img src="/themes/assets/images/backgrounds/disa/001.jpg" alt="profile-sample1" class="background">
            </div>
            <div class="profile-thumb-block">
                <img src="/themes/assets/images/icons/setting.png" alt="profile-image" class="profile">
            </div>
            <div class="card-content">
                <h2>Comité departamental distrital o municipal <small>de gestión y desempeño.</small></h2>
            </div>
            <div class="card-footer">
                <a href="/storages/disa/01.doc" target="_blank" class="btn btn-primary">Modelo</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card profile-card-3">
            <div class="background-block">
                <img src="/themes/assets/images/backgrounds/disa/002.jpg" alt="profile-sample1" class="background">
            </div>
            <div class="profile-thumb-block">
                <img src="/themes/assets/images/icons/setting.png" alt="profile-image" class="profile">
            </div>
            <div class="card-content">
                <h2>Comité institucional <small>de gestión y desempeño. </small></h2>
            </div>
            <div class="card-footer">
                <a href="/storages/disa/03.doc" target="_blank" class="btn btn-primary">Modelo</a>
            </div>
        </div>

    </div>

    <div class="col-md-3">
        <div class="card profile-card-3">
            <div class="background-block">
                <img src="/themes/assets/images/backgrounds/disa/003.jpg" alt="profile-sample1" class="background">
            </div>
            <div class="profile-thumb-block">
                <img src="/themes/assets/images/icons/setting.png" alt="profile-image" class="profile">
            </div>
            <div class="card-content">
                <h2>Comité departamental distrital o municipal <small>de auditoria.</small></h2>
            </div>
            <div class="card-footer">
                <a href="/storages/disa/02.doc" target="_blank" class="btn btn-primary">Modelo</a>
            </div>
        </div>

    </div>
    <div class="col-md-3">
        <div class="card profile-card-3">
            <div class="background-block">
                <img src="/themes/assets/images/backgrounds/disa/004.jpg" alt="profile-sample1" class="background">
            </div>
            <div class="profile-thumb-block">
                <img src="/themes/assets/images/icons/setting.png" alt="profile-image" class="profile">
            </div>
            <div class="card-content">
                <h2>Comité institucional de coordinación <small>de control interno.</small></h2>
            </div>
            <div class="card-footer">
                <a href="/storages/disa/04.doc" target="_blank" class="btn btn-primary">Modelo</a>
            </div>
        </div>

    </div>
</div>