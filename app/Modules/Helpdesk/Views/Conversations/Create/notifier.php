<?php

//$conversation
//$email
//$name
//$title
//$description
//$service

//[services]------------------------------------------------------------------------------------------------------------
$server = service("server");
//[models]--------------------------------------------------------------------------------------------------------------
$magents = model("App\Modules\Helpdesk\Models\Helpdesk_Agents");
$mfields = model("App\Modules\Helpdesk\Models\Helpdesk_Users_Fields");
$mservices = model("App\Modules\Helpdesk\Models\Helpdesk_Services");
$mtypes = model("App\Modules\Helpdesk\Models\Helpdesk_Types");
$mcategories = model("App\Modules\Helpdesk\Models\Helpdesk_Categories");
//[vars]----------------------------------------------------------------------------------------------------------------
$server_name = $server::get_Name();
$subject = "Su solicitud de soporte ha sido recibida #{$conversation}";
$service_name = safe_urldecode($mservices->get_Name($service));
$type_name = safe_urldecode($mtypes->get_Name($type));
$category_name = safe_urldecode($mcategories->get_Name($category));
$link['agents'] = "https://{$server::get_FullName()}/helpdesk/conversations/view/{$conversation}";
$link['customer'] = "https://{$server::get_FullName()}/helpdesk/conversations/review/{$conversation}";
//[customer]------------------------------------------------------------------------------------------------------------
$message = "";
$message .= "<div style=\"margin:2rem;\">";
$message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">Su solicitud de soporte ha sido recibida los datos de la solicitud son los siguientes: </p>";
$message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">";
$message .= "<br><b>Numero de solicitud</b>: {$conversation}";
$message .= "<br><b>Area (Centro de servicio)</b>: {$service_name}";
$message .= "<br><b>Tipo de solicitud</b>: {$type_name}";
$message .= "<br><b>Categoria</b>: {$category_name}";
$message .= "<br><b>Asunto</b>: {$title}";
$message .= "<br><b>Solicitud</b>: {$description}";
$message .= "</p>";
$message .= "<div style=\"min-height:30px;background-color:#1a73e8;border-radius:2px;text-align:center\">";
$message .= "<div style=\"line-height:120%;color:#ffffff;font-size:20px;font-weight:normal;padding:20px 5px 20px 5px;border-radius:2px;border:0.8px solid #2f5cb9\">";
$message .= "<a href=\"{$link['customer']}\" style=\"text-decoration:none;display:block;color:#ffffff;width:auto\" target=\"_blank\" data-saferedirecturl=\"https://www.google.com/url?q={$link['customer']}\">";
$message .= "Revisar Solicitud";
$message .= "</a>";
$message .= "</div>";
$message .= "</div>";
$message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">";
$message .= "Pronto nos pondremos en contacto con usted y le proporcionaremos el enlace para realizar un seguimiento de su solicitud.";
$message .= "</p>";
$message .= "</div>";
//$msg = new \App\Libraries\Message();
//$msg->setFrom("soporte-" . md5($server_name) . "@ita.edu.co", " ");
//$msg->setSubject($subject);
//$msg->addTo($email, $name);
//$msg->addContentText($message);
//$msg->addContentHTML($message);
//$msg->send("email");
$sender = new \App\Libraries\Sender();
$sender->set_From("soporte@edux.com.co");
$sender->set_Subject($subject);
$sender->set_Body($message);
$sender->add_Address($email, $name);
$sender->send();
//[agents]--------------------------------------------------------------------------------------------------------------
$direct = $mservices->get_Direct($service);
if ($direct == "N") {
    $subject = "Solicitud de soporte pendiente #{$conversation}";
    $message = "";
    $message .= "<div style=\"margin:2rem;\">";
    $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">";
    $message .= "Estimado(a) colaborador(a), espero que estés teniendo un buen día. Quería informarte que en nuestro sistema de tickets se ha generado una solicitud que requiere tu atención. Te agradeceríamos si pudieras revisarla y proporcionar una respuesta en un plazo no superior a las 72 horas a partir de este aviso.";
    $message .= "</p>";
    $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">";
    $message .= "Tu pronta atención a esta solicitud es fundamental para garantizar una respuesta eficiente y satisfactoria a los integrantes de nuestra comunidad académica . A continuación, se proporciona la descripción de la solicitud:";
    $message .= "</p>";
    $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">";
    $message .= "<br><b>Numero de solicitud</b>: {$conversation}";
    $message .= "<br><b>Area (Centro de servicio)</b>: {$service_name}";
    $message .= "<br><b>Tipo de solicitud</b>: {$type_name}";
    $message .= "<br><b>Categoria</b>: {$category_name}";
    $message .= "<br><b>Asunto</b>: {$title}";
    $message .= "<br><b>Solicitud</b>: {$description}";
    $message .= "</p>";
    $message .= "<div style=\"min-height:30px;background-color:#1a73e8;border-radius:2px;text-align:center\">";
    $message .= "<div style=\"line-height:120%;color:#ffffff;font-size:20px;font-weight:normal;padding:20px 5px 20px 5px;border-radius:2px;border:0.8px solid #2f5cb9\">";
    $message .= "<a href=\"{$link['agents']}\" style=\"text-decoration:none;display:block;color:#ffffff;width:auto\" target=\"_blank\" data-saferedirecturl=\"https://www.google.com/url?q={$link['agents']}\">";
    $message .= "Revisar Solicitud";
    $message .= "</a>";
    $message .= "</div>";
    $message .= "</div>";
    $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">";
    $message .= "Apreciamos tu compromiso y contribución a nuestro servicio oportuno . Gracias por tu atención y tiempo .";
    $message .= "</p>";
    $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">";
    $message .= "Cordialmente, <br> Equipo de Mesa de Ayuda del ITA .";
    $message .= "</p>";
    $message .= "</div>";
    $agents = $magents->where("service", $service)->findAll();
    foreach ($agents as $agent) {
        $email = safe_urldecode($mfields->get_Email($agent['user']));
        $profile = $mfields->get_Profile($agent['user']);
        $name = $profile['name'];
        $sender = new \App\Libraries\Sender();
        $sender->set_From("soporte@edux.com.co");
        $sender->set_Subject($subject);
        $sender->set_Body($message);
        $sender->add_Address($email, $name);
        $sender->send();
    }
} else {
    //Si la conversacion es enviada aun servicio directo la identidad del destiratario esta en el campo agent
    // de la conversacion
    $email = safe_urldecode($mfields->get_Email($agent));
    $profile = $mfields->get_Profile($agent);
    $name = $profile['name'];
    $subject = "Solicitud de soporte directo pendiente #{$conversation}";
    $message = "";
    $message .= "<div style=\"margin:2rem;\">";
    $message .= "<p style=\"font-size:1.25rem;\">";
    $message .= "Espero que estés teniendo un buen día. Quería informarte que en nuestro sistema de tickets se ha "
        . "recibido una solicitud que <u>requiere tu atención exclusiva</u>. Este ticket ha sido asignado específicamente a "
        . "ti, y depende expresamente de tu respuesta. Te agradeceríamos si pudieras revisarlo y proporcionar una "
        . "respuesta en un plazo no superior a las 72 horas a partir de este aviso. Tu pronta atención a esta solicitud "
        . "es fundamental para garantizar una respuesta eficiente y satisfactoria a los integrantes de nuestra comunidad "
        . "académica. A continuación, se proporciona la descripción de la solicitud:";
    $message .= "</p>";
    $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">";
    $message .= "<br><b>Numero de solicitud</b>: {$conversation}";
    $message .= "<br><b>Asunto</b>: {$title}";
    $message .= "<br><b>Solicitud</b>: {$description}";
    $message .= "<br><b>Area (Centro de servicio)</b>: {$service_name}";
    $message .= "<br><b>Tipo de solicitud</b>: {$type_name}";
    $message .= "<br><b>Categoria</b>: {$category_name}";
    $message .= "</p>";
    $message .= "<div style=\"min-height:30px;background-color:#1a73e8;border-radius:2px;text-align:center\">";
    $message .= "<div style=\"line-height:120%;color:#ffffff;font-size:20px;font-weight:normal;padding:20px 5px 20px 5px;border-radius:2px;border:0.8px solid #2f5cb9\">";
    $message .= "<a href=\"{$link['agents']}\" style=\"text-decoration:none;display:block;color:#ffffff;width:auto\" target=\"_blank\" data-saferedirecturl=\"https://www.google.com/url?q={$link['agents']}\">";
    $message .= "Revisar Solicitud";
    $message .= "</a>";
    $message .= "</div>";
    $message .= "</div>";
    $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">";
    $message .= "Apreciamos tu compromiso y contribución a nuestro servicio oportuno. Gracias por tu atención y tiempo.";
    $message .= "</p>";
    $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">";
    $message .= "Cordialmente, <br> Equipo de Mesa de Ayuda del ITA .";
    $message .= "</p>";
    $message .= "</div>";
    $sender = new \App\Libraries\Sender();
    $sender->set_From("soporte@edux.com.co");
    $sender->set_Subject($subject);
    $sender->set_Body($message);
    $sender->add_Address($email, $name);
    $sender->send();
}
?>