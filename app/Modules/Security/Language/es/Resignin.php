<?php
/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2024-07-31 15:30:18
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2024 - CloudEngine S.A.S., Inc. <admin@cgine.com>
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
 *  ** █ @Editor Anderson Ospina Lenis <andersonospina798@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */

return [
    "deny-message" => "Hemos recibido tu intento de restablecimiento de contraseña y/o acceso. Lamentablemente, el código proporcionado es incorrecto o ha expirado. Por razones de seguridad, los códigos de restablecimiento de contraseña tienen una duración limitada. Asegúrate de utilizar el código dentro del plazo especificado. Si este problema persiste o si crees que has recibido este mensaje por error, te recomendamos solicitar un nuevo código de restablecimiento. Puedes hacerlo desde la opción 'Olvidé mi contraseña' en la pantalla de inicio de sesión. Para cualquier pregunta o asistencia adicional, no dudes en ponerte en contacto con nuestro equipo de soporte. ¡Gracias por tu comprensión!",
    "deny-title" => "Código de seguridad no valido",
    "success-title" => "Código de seguridad valido",
    "success-message" => "Te informamos con gusto que el código de restablecimiento de contraseña que proporcionaste ha sido verificado con éxito. Ahora tienes acceso nuevamente a tu cuenta. Para mantener la seguridad de tu cuenta, te recomendamos cambiar tu contraseña inmediatamente. Este código de acceso era de un solo uso, y en caso de no actualizar tu contraseña, deberás repetir el proceso de restablecimiento si necesitas acceder nuevamente. Para cambiar tu contraseña, inicia sesión en tu cuenta y dirígete a la configuración de la cuenta. Si tienes alguna dificultad o preguntas, no dudes en ponerte en contacto con nuestro equipo de soporte. ¡Gracias por tu comprensión!",
];

