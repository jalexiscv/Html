<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-07-16 20:05:50
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Journalists\Views\Invitations\Creator\index.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.higgs.com.co
 * █ @Version 1.5.1 @since PHP 8,PHP 9
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
return [
    "Tel" => "Teléfono",
    "To" => "Destinatario",
    "Invitation" => "Invitación",
    // - Invitations fields
    "label_invitation" => "Código de la invitación",
    "label_to" => "Nombre completo del destinatario",
    "label_tel" => "Teléfono",
    "label_reference" => "Referencia / Cargo",
    "label_observation" => "Observaciones",
    "label_author" => "Autor",
    "label_created_at" => "Fecha de creación",
    "label_updated_at" => "Fecha de actualización",
    "label_deleted_at" => "Fecha de eliminación",
    "placeholder_invitation" => "Ingrese el código de invitación",
    "placeholder_to" => "Ingrese el nombre completo",
    "placeholder_tel" => "Ingrese el número de teléfono",
    "placeholder_reference" => "Ingrese la referencia o cargo",
    "placeholder_observation" => "Ingrese las observaciones",
    "placeholder_author" => "Ingrese el autor",
    "placeholder_created_at" => "Fecha de creación",
    "placeholder_updated_at" => "Fecha de actualización",
    "placeholder_deleted_at" => "Fecha de eliminación",
    "help_invitation" => "Código único de identificación de la invitación",
    "help_to" => "Nombre completo de la persona destinataria",
    "help_tel" => "Número de teléfono de contacto",
    "help_reference" => "Referencia o cargo de la persona",
    "help_observation" => "Observaciones adicionales o comentarios",
    "help_author" => "Persona que creó la invitación",
    "help_created_at" => "Fecha y hora de creación del registro",
    "help_updated_at" => "Fecha y hora de la última actualización",
    "help_deleted_at" => "Fecha y hora de eliminación del registro",
    // - Invitations creator
    "create-denied-title" => "¡Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevas invitaciones. Por favor, póngase en contacto con el administrador del sistema o con el personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar, presione la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nueva invitación",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "create-duplicate-title" => "¡Invitación existente!",
    "create-duplicate-message" => "Esta invitación ya había sido registrada previamente. Presione continuar en la parte inferior de este mensaje para retornar al listado general de invitaciones.",
    "create-success-title" => "¡Invitación registrada exitosamente!",
    "create-success-message" => "La invitación se registró exitosamente. Para retornar al listado general de invitaciones, presione continuar en la parte inferior de este mensaje.",
    // - Invitations viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para visualizar invitaciones en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Vista de invitación",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "La invitación que intenta visualizar no existe o fue eliminada previamente. Para retornar al listado general de invitaciones, presione continuar en la parte inferior de este mensaje.",
    "view-success-title" => "Invitación encontrada",
    "view-success-message" => "La invitación se ha cargado correctamente.",
    // - Invitations editor
    "edit-denied-title" => "¡Acceso denegado!",
    "edit-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para actualizar invitaciones en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "Actualizar invitación",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que intenta actualizar no existe o fue eliminado previamente. Para retornar al listado general de invitaciones, presione continuar en la parte inferior de este mensaje.",
    "edit-success-title" => "¡Invitación actualizada!",
    "edit-success-message" => "Los datos de la invitación se <b>actualizaron exitosamente</b>. Para retornar al listado general de invitaciones, presione el botón continuar en la parte inferior del presente mensaje.",
    // - Invitations deleter
    "delete-denied-title" => "¡Acceso denegado!",
    "delete-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para eliminar invitaciones en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "Eliminar invitación",
    "delete-message" => "Para confirmar la eliminación de la invitación <b>%s</b>, presione eliminar. Para retornar al listado general de invitaciones, presione cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "El elemento que intenta eliminar no existe o fue eliminado previamente. Para retornar al listado general de invitaciones, presione continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡Invitación eliminada exitosamente!",
    "delete-success-message" => "La invitación se eliminó exitosamente. Para retornar al listado general de invitaciones, presione el botón continuar en la parte inferior de este mensaje.",
    // - Invitations list
    "list-denied-title" => "¡Acceso denegado!",
    "list-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para acceder al listado general de invitaciones en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Listado de invitaciones",
    "list-description" => "Administración y gestión de invitaciones del sistema",
];

?>