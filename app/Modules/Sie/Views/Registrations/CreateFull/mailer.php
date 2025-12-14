<?php

use App\Libraries\Sender;

/** @var string $email */
/** @var string $oid */
/** @var string $name */
/** @var string $server */
$subject = "¡Gracias por tu interés en unirte a nuestra comunidad este es tu recibo de pago de inscripción!";
$code = "<p style=\"font-size: 1.3rem;font-weight: bold;\"'>¡Gracias por tu interés en unirte a nuestra comunidad!\n</p>";
$code .= "<p>¡Hola {$name}!</p>\n";
$code .= "<p>Espero que este mensaje te encuentre bien.\tEstamos emocionados de que hayas decidido dar el primer paso hacia la educación superior en Utedé, enviando tu solicitud de preinscripción para el semestre 2025A.</p>\n";
$code .= "<p><b>Primero lo primero</b>: el pago de la preinscripción.\tEncontrarás adjunto el recibo necesario para realizar este pago.\tPor favor, efectúa el pago según las indicaciones y no olvides subir los documentos requeridos a nuestra plataforma usando este enlace:\t <a href=\"https://intranet.utede.edu.co/sie/registrations/documents/{$oid}\">Cargar Documentos!</a>. Recuerda que al escribir de nuevo donde debes registrar tu número de documento podrás completar el registro hasta el último paso donde debes cargar estos documentos escaneados.</p>\n";
$code .= "<ol>\n";
$code .= "<li>Documento de identidad ampliado al 150% (No aceptamos scans desde el móvil).</li>\n";
$code .= "<li>Resultados de las pruebas Saber ICFES 11 o un acta de compromiso si aún no los tienes.</li>\n";
$code .= "<li>Acta de grado de bachiller.</li>\n";
$code .= "<li>Diploma de bachiller.</li>\n";
$code .= "<li>Certificado de tu EPS, que puedes consultar aquí: <a href=\"https://www.adres.gov.co/consulte-su-eps\" target=\"_blank\">https://www.adres.gov.co/consulte-su-eps</a>.</li>\n";
$code .= "<li>Certificado del Sisbén, disponible aquí: <a href=\"https://www.sisben.gov.co/Paginas/consulta-tu-grupo.html\">https://www.sisben.gov.co/sisben/</a>.</li>\n";
$code .= "<li>Foto digital tamaño 3x4 cm con fondo blanco para tu carnet.</li>\n";
$code .= "<li>Si tienes más de 18 años y votaste en las elecciones de 2023, incluye tu certificado de votación.</li>\n";
$code .= "<li>Una copia de un recibo de servicio público que confirme tu dirección.</li>\n";
$code .= "</ol>\n";
$code .= "<p>Una vez cargados los documentos, desde el área de Bienestar te estaremos contactando para continuar con el proceso de selección.</b></p>\n";
$code .= "<p>Atentamente,</p>\n";
$code .= "</br>\n";
$code .= "<p><b>Leidy Johana Ortiz</b>\n";
$code .= "<br>Psicología de Bienestar \n";
//$code .= "<br>Tel: +57 3104218097";
$code .= "</p>\n";
$code .= "\n";

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
$mailer->set_Body($code);
$mailer->add_Address($email, "");
$mailer->add_AttachmentFromUrl("https://intranet.utede.edu.co/sie/pdf/registration/billing/{$oid}", "recibo.pdf");
$mailer->send();
//[/email]----------------------------------------------------------------------------------------------------------
?>