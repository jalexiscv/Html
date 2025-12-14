<?php

use App\Libraries\Sender;

$server = service("server");

$mclients = model("App\Modules\Settings\Models\Settings_Clients");
$client = $mclients->get_ClientByDomain($server::get_FullName());
//[email]-----------------------------------------------------------------------------------------------------------
/** @var string $smtp_from_email */
/** @var string $smtp_subjet */
/** @var string $smtp_message */
$mailer = new Sender();
$mailer->set_Host($client["smtp_host"]);
$mailer->set_Port($client["smtp_port"]);
$mailer->set_SMTPAuth($client["smtp_smtpauth"]);
$mailer->set_Username($client["smtp_username"]);
$mailer->set_Password($client["smtp_password"]);
$mailer->set_SMTPSecure($client["smtp_smtpsecure"]);
$mailer->set_CharSet($client["smtp_charset"]);
$mailer->set_SMTPDebug(2);
$mailer->set_From($client["smtp_from_email"]);
$mailer->set_Subject($subject);
$mailer->set_Body($message);
$mailer->add_Address($to, "");
$mailer->add_AttachmentFromUrl("https://intranet.utede.edu.co/sie/pdf/registration/billing/{$registration}", "recibo.pdf");
$mailer->send();
//[/email]----------------------------------------------------------------------------------------------------------
?>