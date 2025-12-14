<?php
$bootstrap = service("bootstrap");
$msettings = model("App\Modules\Security\Models\Security_Settings");
$back = base_url("/");
$voice = "security/signup/autoregister-disabled.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
    "header-back" => $back,
    "icon" => ICON_WARNING,
    "title" => lang("Signup.user-register-disabled-title"),
    "content" => lang("Signup.user-register-disabled"),
    "voice" => isset($voice) ? $voice : "",
    "footer-class" => "text-center",
    "footer-continue" => $back,
));
?>
<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 mx-auto d-table h-100">
    <div class="d-table-cell align-middle">
        <?php echo($card); ?>
    </div>
</div>