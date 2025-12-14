<?php

use App\Libraries\Message;

$server = service("server");
$mfields = model("App\Modules\Security\Models\Security_Users_Fields");
//[vars]----------------------------------------------------------------------------------------------------------------
$server_name = $server::get_Name();
$user = $mfields->get_UserByEmail($email);
$rtoken = $mfields->get_ResetToken($user);

$profile = $mfields->get_Profile($user);

$fullname = $profile["name"];
$backlink = "https://" . $server->get_FullName() . "/security/session/resignin/{$rtoken}";
$subject = "Enlace de recuperación de contraseña";
//[build]---------------------------------------------------------------------------------------------------------------
$code = "";
$code .= "<div style=\"\n";
$code .= "border-collapse:collapse;\n";
$code .= "font-family:'Lato',Arial,sans-serif;margin:0;padding-bottom:0px;\n";
$code .= "padding-top:42px;padding-right:50px;text-align:left;font-size:32px;\n";
$code .= "line-height:32px;color:#3c4043;font-weight:bold;width:100%\">¡Recuperar contraseña!\n";
$code .= "</div>\n";
$code .= "<p>Se ha recibido una solicitud de recuperación de acceso a su cuenta en <b>{$server_name}</b>, para acceder y cambiar la\n";
$code .= "\t\tactual\t\tcontraseña podrá hacer uso del siguiente <a href=\"{$backlink}\">enlace</a>. Al acceder al sistema podrá cambiar\n";
$code .= "\t\tlibremente su contraseña en las opciones de su perfil personal.</p>\n";
$code .= "\n";
$code .= "<a style=\"\n";
$code .= "background-color:#1a73e8;\n";
$code .= "border-bottom-left-radius:3px;\n";
$code .= "border-bottom-right-radius:3px;\n";
$code .= "border-color:#1a73e8;\n";
$code .= "border-radius:3px;\n";
$code .= "border-style:solid;\n";
$code .= "border-top-left-radius:3px;\n";
$code .= "border-top-right-radius:3px;\n";
$code .= "border-width:12px 9px 12px 10px;\n";
$code .= "color:#ffffff;display:inline-block;\n";
$code .= "font-family:Google Sans,Arial;font-size:14px;\n";
$code .= "font-weight:500;line-height:16px;margin:0;\n";
$code .= "text-align:center;text-decoration:none;\n";
$code .= "letter-spacing:0.44px\"\n";
$code .= "\t href=\"{$backlink}\" bgcolor=\"#1A73E8\"\n";
$code .= "\t align=\"center\"\n";
$code .= "\t target=\"_blank\"\n";
$code .= "\t data-saferedirecturl=\"https://www.google.com/url?q={$backlink}\"><span\n";
$code .= "\t\t\t\t\t\talign=\"center\" style=\"display:block;padding-left:6px;padding-right:6px\">Acceder</span></a>\n";
$code .= "\n";
$code .= "<p>Recuerde que hacer uso de este método de acceso no modifica su actual contraseña solo le concede acceso a la\n";
$code .= "\t\tcuenta, para que realice las modificaciones que estime pertinentes. Este enlace funcionará en una única ocasión,\n";
$code .= "\t\tsi desea acceder nuevamente utilizando este servicio deberá solicitar un nuevo enlace en las opciones\n";
$code .= "\t\tcorrespondientes.</p>\n";
$message = $code;
$msg = new Message();
$msg->setFrom("support" . lpk() . "@codehiggs.com", " ");
$msg->setSubject($subject);
$msg->addTo($email, $fullname);
$msg->addContentText($message);
$msg->addContentHTML($message);
$msg->send("email");
?>