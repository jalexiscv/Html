<?php

use App\Libraries\Sender;

/**
 * "client" => $f->get_Value("client"),
 * "smtp_host" => $f->get_Value("smtp_host"),
 * "smtp_port" => $f->get_Value("smtp_port"),
 * "smtp_smtpsecure" => $f->get_Value("smtp_smtpsecure"),
 * "smtp_smtpauth" => $f->get_Value("smtp_smtpauth"),
 * "smtp_username" => $f->get_Value("smtp_username"),
 * "smtp_password" => $f->get_Value("smtp_password"),
 * "smtp_from_email" => $f->get_Value("smtp_from_email"),
 * "smtp_from_name" => $f->get_Value("smtp_from_name"),
 * "smtp_charset" => $f->get_Value("smtp_charset"),
 * "smtp_to" => $f->get_Value("smtp_to"),
 * "smtp_subjet" => $f->get_Value("smtp_subjet"),
 * "smtp_message" => $f->get_Value("smtp_message"),
 */
//$mclients = model("App\Modules\Settings\Models\Settings_Clients");
//$client = $mclients->get_Client($f->get_Value("client"));
//$client = $mclients->get_ClientByDomain($server::get_FullName());
//[email]-----------------------------------------------------------------------------------------------------------
/** @var string $smtp_from_email */
/** @var TYPE_NAME $smtp_subjet */
/** @var string $smtp_message */
$mailer = new Sender();
$mailer->set_Host($smtp_host);
$mailer->set_Port($smtp_port);
$mailer->set_SMTPAuth($smtp_smtpauth);
$mailer->set_Username($smtp_username);
$mailer->set_Password($smtp_password);
$mailer->set_SMTPSecure($smtp_smtpsecure);
$mailer->set_CharSet($smtp_charset);
//$mailer->set_SMTPDebug(2);
$mailer->set_From($smtp_from_email);
$mailer->set_Subject($smtp_subjet);
$mailer->set_Body($smtp_message);
$mailer->add_Address($smtp_to, "");
//$mailer->add_AttachmentFromUrl("https://intranet.utede.edu.co/sie/pdf/registration/billing/{$d["registration"]}", "recibo.pdf");
$mailer->send();
//[/email]----------------------------------------------------------------------------------------------------------

?>