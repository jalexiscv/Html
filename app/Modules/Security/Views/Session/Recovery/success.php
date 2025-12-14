<?php
//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service('bootstrap');
//[vars]----------------------------------------------------------------------------------------------------------------
$encodedEmail = urlencode($email);
$back = "#";

//[html]----------------------------------------------------------------------------------------------------------------
$provider = explode("@", $email)[1]; // Obtenemos el proveedor de correo electrónico
switch ($provider) {
    case "gmail.com":
        $back = "https://mail.google.com/mail/u/0/#inbox?compose=new&to=" . $encodedEmail;
        $text = "visite su bandeja de entrada de Gmail";
        break;
    case "outlook.com":
        $back = "https://outlook.live.com/mail/inbox?path=/mail/action/compose&to=" . $encodedEmail;
        $text = "visite su bandeja de entrada de Outlook";
        break;
    case "yahoo.com":
        $back = "https://compose.mail.yahoo.com/?to=" . $encodedEmail;
        $text = "visite su bandeja de entrada de Yahoo";
        break;
    default:
        $back = "";
        $text = "Abrir correo electrónico";
        break;
}
//[build]----------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-success", array(
    "class" => "card-success",
    "icon" => "fas fa-check-circle",
    "title" => lang('Recovery.success-title'),
    "header-back" => $back,
    "content" => lang('Recovery.success-message'),
    "footer-continue" => array("href" => $back, "text" => $text),
    "voice" => "security/recovery/success-message.mp3",
));
?>
<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 mx-auto d-table h-100">
    <div class="d-table-cell align-middle">
        <?php echo($card); ?>
    </div>
</div>