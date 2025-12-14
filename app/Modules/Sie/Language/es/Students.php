<?php

/*
 **
 ** █ ---------------------------------------------------------------------------------------------------------------
 ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 ** █ ---------------------------------------------------------------------------------------------------------------
 ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 ** █ ---------------------------------------------------------------------------------------------------------------
 ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 ** █ @link https://www.codehiggs.com
 ** █ @Version 1.5.0 @since PHP 7, PHP 8
 ** █ ---------------------------------------------------------------------------------------------------------------
 ** █ Datos recibidos desde el controlador - @ModuleController
 ** █ ---------------------------------------------------------------------------------------------------------------
 ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 ** █ ---------------------------------------------------------------------------------------------------------------
 **
 */
return [
    'list-title' => 'Listado de estudiantes',
    'rol-info' => 'Un estudiante es un individuo que se encuentra matriculado en un programa educativo, ya sea en una institución académica como una escuela, colegio, universidad u otro centro de enseñanza. Su principal objetivo es adquirir conocimientos, habilidades y competencias en diversas áreas de estudio. Los estudiantes participan activamente en el proceso de aprendizaje, asistiendo a clases, realizando tareas y proyectos asignados, participando en discusiones y actividades educativas, y completando evaluaciones para demostrar su comprensión y progreso académico.',
    //[fields]----------------------------------------------------------------------------------------------------------
    "label_user" => "Código de usuario",
    "label_alias" => "Alias",
    "label_type" => "Tipo de usuario",
    "label_password" => "Contraseña",
    "label_confirm" => "Confirmación",
    "label_firstname" => "Nombres",
    "label_lastname" => "Apellidos",
    "label_address" => "Dirección de residencia",
    "label_email" => "Correo Electrónico",
    "label_phone" => "Teléfono",
    "label_birthday" => "Fecha de nacimiento (Cumpleaños)",
    "label_sex" => "Sexo",
    "label_citizenshipcard" => "Cedula",
    "label_expedition_date" => "Fecha de expedición ",
    "label_expedition_place" => "Lugar de expedición ",
    "label_fb-uid" => "Facebook UID",
    "label_reference" => "Referencia",
    "label_moodle-username" => "Usuario en Moodle",
    "label_moodle-password" => "Contraseña en Moodle",
    "help_expedition_date" => "Fecha de expedición de la cédula",
    "label_notes" => "Notas",
    "edit-denied-message" => "Su rol en la plataforma <b>no posee los privilegios necesarios para acceder a este componente</b>, para hacer uso del mismo al menos uno de sus roles en la plataforma deberá disponer del permiso <code>SECURITY-EDIT</code> o <code>SECURITY-EDIT-ALL</code>, solo un administrador del sistema podrá concederle tal nivel de acceso, por favor contacte al soporte técnico para solicitar a su rol le sean asignados los privilegios requeridos si es el caso, o presioné continuar para retornar al listado de usuarios. ",
    "help_citizenshipcard" => "Número del documento de identificación (Obligatorio)",
    "help_phone" => "Número telefónico incluyendo prefijo de nacionalidad (Obligatorio)",
    "help_expedition_place" => "Generalmente el nombre textual de una ciudad (Obligatorio)",
    "help_email" => "Correo electrónico valido (Obligatorio)",
    "help_birthday" => "Fecha valida (Requerida)",
    "help_alias" => "Alias o sobrenombre de usuario",
    "help_type" => "Predefinido (Profesor)",
    "help_password" => "Contraseña de acceso",
    "help_confirm" => "Confirmacion de la contraseña de acceso",
    "help_firstname" => "Nombres del usuario (Obligatorio)",
    "help_lastname" => "Apellidos del usuario (Obligatorio)",
    "help_address" => "Direccion de residencia del usuario (Obligatorio)",
    "help_reference" => "Referencia general",
    "help_notes" => "Notas u observaciones",
    "placeholder_expedition_place" => "Ciudad / Lugar de Expedición",
    "placeholder_alias" => "Alias",
    "placeholder_password" => "Contraseña",
    "placeholder_confirm" => "Confirmacion",
    "placeholder_firstname" => "Nombres",
    "placeholder_lastname" => "Apellidos",
    "placeholder_address" => "Dirección de residencia",
    "placeholder_phone" => "Ejemplo: (+57)-318-413-6417",
    "placeholder_citizenshipcard" => "Cédula de ciudadanía",
    "placeholder_email" => "Ejemplo: usuario@mail.com",
    "placeholder_reference" => "Ejemplo: Algo",
    "placeholder_notes" => "Notas u observaciones",
    "placeholder_birthday" => "Fecha de nacimiento",
    "placeholder_expedition_date" => "Fecha de expedición",
    "placeholder_moodle-username" => "Ej: estudiantexyz",
    "placeholder_moodle-password" => "Ej: est123",
    "label_file-citizenshipcard" => "Archivo adjunto de imagen de la cédula de ciudadanía",
    "label_file-drivinglicense" => "Archivo adjunto de imagen de la licencia de conducción",
    "help_file-citizenshipcard" => "Generalmente una imagen en JPG, GIF, BMP o PDF",
    "help_file-drivinglicense" => "Generalmente una imagen en JPG, GIF, BMP o PDF",
    "edit-title" => "Actualizar Usuario: %s",
    "profile-photo" => "Foto de perfil",
    //Create
    "create-title" => "Crear nuevo estudiante",
];
?>
