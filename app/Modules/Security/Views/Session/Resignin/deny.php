<?php
//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service('bootstrap');
$back = "/";
//[vars]----------------------------------------------------------------------------------------------------------------

//[html]----------------------------------------------------------------------------------------------------------------

//[build]----------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-deny", array(
    "class" => "card-warning",
    "icon" => ICON_WARNING,
    "title" => lang('Resignin.deny-title'),
    "header-back" => $back,
    "content" => lang('Resignin.deny-message'),
    "footer-continue" => array("href" => $back, "text" => lang('App.Continue')),
    "voice" => "security/resignin/deny-message.mp3",
));
?>
<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 mx-auto d-table h-100">
    <div class="d-table-cell align-middle">
        <?php echo($card); ?>
    </div>
</div>