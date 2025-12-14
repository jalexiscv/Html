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
$mcustomers = model("App\Modules\Helpdesk\Models\Helpdesk_Customers");
$mconversations = model("App\Modules\Helpdesk\Models\Helpdesk_Conversations");
//[vars]----------------------------------------------------------------------------------------------------------------
$server_name = $server::get_Name();
$conversation = $mconversations->where("conversation", $conversation)->first();
$link['agents'] = "https://{$server::get_FullName()}/helpdesk/conversations/view/{$conversation['conversation']}";
$link['customer'] = "https://{$server::get_FullName()}/helpdesk/conversations/review/{$conversation['conversation']}";

echo(safe_get_user());

if (safe_get_user() == "anonymous") {
    //[customer]------------------------------------------------------------------------------------------------------------
    $subject = "Se ha enviado su mensaje #{$conversation['conversation']}";
    $customer = $mcustomers->where("conversation", $conversation['conversation'])->first();
    $email_cliente = $customer['email'];
    $name_cliente = $customer['first_name'] . " " . $customer['last_name'];
    $message = "";
    $message .= "<div style=\"margin:2rem;\">";
    $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">Su mensaje se ha enviado correctamente en cuanto el equipo de soporte proporcione una respuesta le será notificada inmediatamente: </p>";
    $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">";
    $message .= "<br><b>Numero de solicitud</b>: {$conversation['conversation']}";
    $message .= "</p>";
    $message .= "<div style=\"min-height:30px;background-color:#1a73e8;border-radius:2px;text-align:center\">";
    $message .= "<div style=\"line-height:120%;color:#ffffff;font-size:20px;font-weight:normal;padding:20px 5px 20px 5px;border-radius:2px;border:0.8px solid #2f5cb9\">";
    $message .= "<a href=\"{$link['customer']}\" style=\"text-decoration:none;display:block;color:#ffffff;width:auto\" target=\"_blank\" data-saferedirecturl=\"https://www.google.com/url?q={$link['customer']}\">";
    $message .= "Revisar Solicitud";
    $message .= "</a>";
    $message .= "</div>";
    $message .= "</div>";
    $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">";
    $message .= "";
    $message .= "</p>";
    $message .= "</div>";
    //$msg = new \App\Libraries\Message();
    //$msg->setFrom("soporte-" . md5($server_name) . "@ita.edu.co", " ");
    //$msg->setSubject($subject);
    //$msg->addTo($email_cliente, $name_cliente);
    //$msg->addContentText($message);
    //$msg->addContentHTML($message);
    //$msg->send("email");
    $sender = new \App\Libraries\Sender();
    $sender->set_From("soporte@edux.com.co");
    $sender->set_Subject($subject);
    $sender->set_Body($message);
    $sender->add_Address($email_cliente, $name_cliente);
    $sender->send();
    //[agente]------------------------------------------------------------------------------------------------------------

    $direct = $mservices->get_Direct($conversation['service']);
    $subject = "Se ha recibido un nuevo mensaje en la solicitud #{$conversation['conversation']} enviado por el usuario";
    if ($direct == "N") {
        $message = "";
        $message .= "<div style=\"margin:2rem;\">";
        $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">Se ha recibido un mensaje del usuario: </p>";
        $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">";
        $message .= "<br><b>Numero de solicitud</b>: {$conversation['conversation']}";
        $message .= "</p>";
        $message .= "<div style=\"min-height:30px;background-color:#1a73e8;border-radius:2px;text-align:center\">";
        $message .= "<div style=\"line-height:120%;color:#ffffff;font-size:20px;font-weight:normal;padding:20px 5px 20px 5px;border-radius:2px;border:0.8px solid #2f5cb9\">";
        $message .= "<a href=\"{$link['customer']}\" style=\"text-decoration:none;display:block;color:#ffffff;width:auto\" target=\"_blank\" data-saferedirecturl=\"https://www.google.com/url?q={$link['customer']}\">";
        $message .= "Revisar Solicitud";
        $message .= "</a>";
        $message .= "</div>";
        $message .= "</div>";
        $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">";
        $message .= "";
        $message .= "</p>";
        $message .= "</div>";
        $agents = $magents->where("service", $conversation['service'])->findAll();
        foreach ($agents as $agent) {
            $email = safe_urldecode($mfields->get_Email($agent['user']));
            $profile = $mfields->get_Profile($agent['user']);
            $name = $profile['name'];
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
        }
    } else {
        $profile = $mfields->get_Profile($conversation["agent"]);
        $email = safe_urldecode($profile['email']);
        $name = $profile['name'];
        $message = "";
        $message .= "<div style=\"margin:2rem;\">";
        $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">Se ha recibido un mensaje del usuario: </p>";
        $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">";
        $message .= "<br><b>Numero de solicitud</b>: {$conversation['conversation']}";
        $message .= "</p>";
        $message .= "<div style=\"min-height:30px;background-color:#1a73e8;border-radius:2px;text-align:center\">";
        $message .= "<div style=\"line-height:120%;color:#ffffff;font-size:20px;font-weight:normal;padding:20px 5px 20px 5px;border-radius:2px;border:0.8px solid #2f5cb9\">";
        $message .= "<a href=\"{$link['customer']}\" style=\"text-decoration:none;display:block;color:#ffffff;width:auto\" target=\"_blank\" data-saferedirecturl=\"https://www.google.com/url?q={$link['customer']}\">";
        $message .= "Revisar Solicitud";
        $message .= "</a>";
        $message .= "</div>";
        $message .= "</div>";
        $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">";
        $message .= "";
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
    }
} else {
    //[customer]------------------------------------------------------------------------------------------------------------
    $subject = "Se ha actualizado su solicitud #{$conversation['conversation']}";
    $customer = $mcustomers->where("conversation", $conversation['conversation'])->first();
    $email_cliente = $customer['email'];
    $name_cliente = $customer['first_name'] . " " . $customer['last_name'];
    $message = "";
    $message .= "<div style=\"margin:2rem;\">";
    $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">Se ha generado una nueva respuesta de Soporte para su solicitud. Por favor, ingrese al sistema para revisar y verificar la información proporcionada: </p>";
    $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">";
    $message .= "<br><b>Numero de solicitud</b>: {$conversation['conversation']}";
    $message .= "</p>";
    $message .= "<div style=\"min-height:30px;background-color:#1a73e8;border-radius:2px;text-align:center\">";
    $message .= "<div style=\"line-height:120%;color:#ffffff;font-size:20px;font-weight:normal;padding:20px 5px 20px 5px;border-radius:2px;border:0.8px solid #2f5cb9\">";
    $message .= "<a href=\"{$link['customer']}\" style=\"text-decoration:none;display:block;color:#ffffff;width:auto\" target=\"_blank\" data-saferedirecturl=\"https://www.google.com/url?q={$link['customer']}\">";
    $message .= "Revisar Solicitud";
    $message .= "</a>";
    $message .= "</div>";
    $message .= "</div>";
    $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">";
    $message .= "";
    $message .= "</p>";
    $message .= "</div>";
    //$msg = new \App\Libraries\Message();
    //$msg->setFrom("soporte-" . md5($server_name) . "@ita.edu.co", " ");
    //$msg->setSubject($subject);
    //$msg->addTo($email_cliente, $name_cliente);
    //$msg->addContentText($message);
    //$msg->addContentHTML($message);
    //$msg->send("email");
    $sender = new \App\Libraries\Sender();
    $sender->set_From("soporte@edux.com.co");
    $sender->set_Subject($subject);
    $sender->set_Body($message);
    $sender->add_Address($email_cliente, $name_cliente);
    $sender->send();
    //[agente]------------------------------------------------------------------------------------------------------------
    $direct = $mservices->get_Direct($conversation['service']);
    $subject = "Se ha notificado al usuario su respuesta en la solicitud  #{$conversation['conversation']}";
    if ($direct == "N") {
        $message = "";
        $message .= "<div style=\"margin:2rem;\">";
        $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">Se ha enviado un mensaje de respuesta al usuario: </p>";
        $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">";
        $message .= "<br><b>Numero de solicitud</b>: {$conversation['conversation']}";
        $message .= "</p>";
        $message .= "<div style=\"min-height:30px;background-color:#1a73e8;border-radius:2px;text-align:center\">";
        $message .= "<div style=\"line-height:120%;color:#ffffff;font-size:20px;font-weight:normal;padding:20px 5px 20px 5px;border-radius:2px;border:0.8px solid #2f5cb9\">";
        $message .= "<a href=\"{$link['customer']}\" style=\"text-decoration:none;display:block;color:#ffffff;width:auto\" target=\"_blank\" data-saferedirecturl=\"https://www.google.com/url?q={$link['customer']}\">";
        $message .= "Revisar Solicitud";
        $message .= "</a>";
        $message .= "</div>";
        $message .= "</div>";
        $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">";
        $message .= "";
        $message .= "</p>";
        $message .= "</div>";
        $agents = $magents->where("service", $conversation['service'])->findAll();
        foreach ($agents as $agent) {
            $email = safe_urldecode($mfields->get_Email($agent['user']));
            $profile = $mfields->get_Profile($agent['user']);
            $name = $profile['name'];
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
        }
    } else {
        $email = safe_urldecode($mfields->get_Email($conversation["agent"]));
        $profile = $mfields->get_Profile($conversation["agent"]);
        $name = $profile['name'];
        $message = "";
        $message .= "<div style=\"margin:2rem;\">";
        $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">Se ha enviado su mensaje de respuesta al usuario: </p>";
        $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">";
        $message .= "<br><b>Numero de solicitud</b>: {$conversation['conversation']}";
        $message .= "</p>";
        $message .= "<div style=\"min-height:30px;background-color:#1a73e8;border-radius:2px;text-align:center\">";
        $message .= "<div style=\"line-height:120%;color:#ffffff;font-size:20px;font-weight:normal;padding:20px 5px 20px 5px;border-radius:2px;border:0.8px solid #2f5cb9\">";
        $message .= "<a href=\"{$link['customer']}\" style=\"text-decoration:none;display:block;color:#ffffff;width:auto\" target=\"_blank\" data-saferedirecturl=\"https://www.google.com/url?q={$link['customer']}\">";
        $message .= "Revisar Solicitud";
        $message .= "</a>";
        $message .= "</div>";
        $message .= "</div>";
        $message .= "<p style=\"font-size:1.25rem;line-height:1.25rem;\">";
        $message .= "";
        $message .= "</p>";
        $message .= "</div>";
        //$msg = new \App\Libraries\Message();
        //$msg->setFrom("soporte-" . md5($server_name) . "@ita.edu.co", " ");
        //$msg->setSubject($subject);
        //if (!empty($email)) {
        //    $msg->addTo($email, $name);
        //}
        //$msg->addContentText($message);
        //$msg->addContentHTML($message);
        //$msg->send("email");
        $sender = new \App\Libraries\Sender();
        $sender->set_From("soporte@edux.com.co");
        $sender->set_Subject($subject);
        $sender->set_Body($message);
        if (!empty($email)) {
            $sender->add_Address($email, $name);
            $sender->send();
        }
    }
}

?>