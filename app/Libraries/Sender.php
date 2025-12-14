<?php
/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */

namespace App\Libraries;

use App\Libraries\Mailer\Exception;
use App\Libraries\Mailer\Mailer;
use App\Libraries\Mailer\SMTP;


class Sender
{
    private $sender;
    private $Body;
    private $Host;
    private $Port;
    private $SMTPAuth;
    private $Username;
    private $Password;
    private $SMTPSecure;
    private $CharSet;
    private $isHTML;
    private $SMTPDebug;

    private $Subject;

    private $from;

    private $to;



    public function __construct()
    {
        $this->isHTML = true;
        $this->sender = new Mailer(true);

    }

    public function set_Subject($subject)
    {
        //$strings = service('strings');
        $this->Subject = mb_encode_mimeheader($subject, 'UTF-8');
    }

    public function setFrom($from)
    {
        $this->from = $from;
    }


    public function set_Body($body)
    {
        $this->Body = $body;
    }

    public function set_From($from)
    {
        $this->from = $from;
    }

    public function add_Address($address, $name)
    {
        $this->sender->addAddress($address, $name);
    }

    public function add_AttachmentFromUrl($url): void
    {
        $nombreTemporal = tempnam(sys_get_temp_dir(), 'archivo') . '.pdf'; // Crear nombre de archivo temporal
        file_put_contents($nombreTemporal, fopen($url, 'r')); // Descargar el archivo
        $this->sender->addAttachment($nombreTemporal, 'nombreArchivo.pdf');
    }


    public function send()
    {
        try {
            // Configuración del servidor SMTP
            $mail = $this->sender;
            $mail->SMTPDebug = $this->SMTPDebug;
            $mail->isSMTP();
            $mail->SMTPSecure = $this->SMTPSecure; // Activar SSL/TLS
            $mail->Host = $this->Host;
            $mail->SMTPAuth = $this->SMTPAuth; // Habilitar autenticación SMTP
            $mail->Username = $this->Username;
            $mail->Password = $this->Password;
            $mail->Port = $this->Port; // Puerto SMTP
            $mail->isHTML($this->isHTML);
            $mail->CharSet = $this->CharSet;
            // Configuración del correo electrónico
            $mail->setFrom($this->from, $this->from);
            //$mail->addAddress('jalexiscv@gmail.com', 'Alexis Correa');
            $mail->Subject = $this->Subject;
            $mail->Body = $this->Body;
            $mail->send();
            //echo 'El correo electrónico se envió correctamente.';
        } catch (Exception $e) {
            echo 'Error al enviar el correo electrónico: ', $mail->ErrorInfo;
        }
    }


    public function send2()
    {
        try {
            // Configuración del servidor SMTP
            $mail = $this->sender;
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->SMTPSecure = Mailer::ENCRYPTION_SMTPS; // Activar SSL/TLS
            $mail->Host = 'edux.com.co';
            $mail->SMTPAuth = true; // Habilitar autenticación SMTP
            $mail->Username = 'soporte@edux.com.co';
            $mail->Password = '@Edux2024';
            $mail->Port = 465; // Puerto SMTP
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            // Configuración del correo electrónico
            //$mail->setFrom('soporte@edux.com.co', 'Soporte');
            //$mail->addAddress('jalexiscv@gmail.com', 'Alexis Correa');
            //$mail->Subject = 'Asunto del correo';
            //$mail->Body = 'Contenido del correo';
            // Enviar el correo electrónico
            $mail->send();
            //echo 'El correo electrónico se envió correctamente.';
        } catch (Exception $e) {
            echo 'Error al enviar el correo electrónico: ', $mail->ErrorInfo;
        }
    }

    public function set_Host($host)
    {
        $this->Host = $host;
    }

    public function set_Port($port)
    {
        $this->Port = $port;
    }

    public function set_SMTPAuth($smtpauth)
    {
        $this->SMTPAuth = $smtpauth;
    }

    public function set_Username($username)
    {
        $this->Username = $username;
    }

    public function set_Password($password)
    {
        $this->Password = $password;
    }

    public function set_SMTPSecure($smtpsecure)
    {
        $this->SMTPSecure = $smtpsecure;
    }

    public function set_CharSet($charset)
    {
        $this->CharSet = $charset;
    }

    public function set_HTML($html)
    {
        $this->isHTML($html);
    }

    public function set_SMTPDebug($smtpdebug)
    {
        $this->SMTPDebug = $smtpdebug;
    }


    public function sendOLD()
    {
        try {
            // Configuración del servidor SMTP
            $mail = $this->sender;
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->SMTPSecure = Mailer::ENCRYPTION_STARTTLS; // Activar STARTTLS
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'no-reply@utede.edu.co';
            $mail->Password = 'utede2024';
            $mail->Port = 587; // Puerto SMTP
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            // Configuración del correo electrónico
            //$mail->setFrom('soporte@utede.edu.co', 'Soporte');
            //$mail->addAddress('jalexiscv@gmail.com', 'Alexis Correa');
            //$mail->Subject = 'Asunto del correo';
            //$mail->Body = 'Contenido del correo';
            // Enviar el correo electrónico
            $mail->send();
            //echo 'El correo electrónico se envió correctamente.';
        } catch (Exception $e) {
            echo 'Error al enviar el correo electrónico: ', $mail->ErrorInfo;
        }
    }

}

?>