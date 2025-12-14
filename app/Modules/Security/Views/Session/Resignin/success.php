<?php
//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service('bootstrap');
$back = "/";
//[vars]----------------------------------------------------------------------------------------------------------------
$musers = model("App\Modules\Security\Models\Security_Users");
$mfields = model("App\Modules\Security\Models\Security_Users_Fields");
$authentication->set("user", $user);
$authentication->set("alias", $mfields->get_Field($user, 'alias'));
$authentication->set("avatar", $mfields->get_Field($user, 'avatar'));
$authentication->set("loggedin", true);
$authentication->set("rsignup", "access");
$mfields->where("user", $user)->where("name", "reset-token")->delete();
//[html]----------------------------------------------------------------------------------------------------------------

//[build]----------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-success", array(
    "class" => "card-success",
    "icon" => ICON_SUCCESS,
    "title" => lang('Resignin.success-title'),
    "header-back" => $back,
    "content" => lang('Resignin.success-message'),
    "footer-continue" => array("href" => $back, "text" => lang('App.Continue')),
    "voice" => "security/resignin/success-message.mp3",
));
?>
<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 mx-auto d-table h-100">
    <div class="d-table-cell align-middle">
        <?php echo($card); ?>
    </div>
</div>