<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-10-09 15:10:38
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Helpdesk\Views\Conversations\Creator\index.php]
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
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
return [
    "requests-received" => "Solicitudes recibidas!",
    "requests-closed" => "Solicitudes atendidas",
    // - Conversations fields
    "label_conversation" => "Código del soporte",
    "label_service" => "Area",
    "label_title" => "Asunto",
    "label_description" => "Contenido(Descripción)",
    "label_status" => "Estado",
    "label_priority" => "Prioridad",
    "label_author" => "author",
    "label_created_at" => "created_at",
    "label_updated_at" => "updated_at",
    "label_deleted_at" => "deleted_at",
    "label_document_type" => "Tipo de documento",
    "label_document_number" => "Número de documento",
    "label_first_name" => "Nombres",
    "label_last_name" => "Apellidos",
    "label_email" => "Correo electrónico",
    "label_phone" => "Teléfono",
    "label_agents" => "Soporte directo",
    "label_type" => "Tipo de solicitud",
    "label_category" => "Categoría",
    "label_attachment" => "Adjuntar archivo",
    "label_customer" => "Usuario(Cliente)",
    "label_agent" => "Agente de soporte",
    "placeholder_conversation" => "conversation",
    "placeholder_service" => "service",
    "placeholder_title" => "Ej: Olvide mi codigo de estudiante",
    "placeholder_description" => "Ej: Olvide mi codigo de estudiante, por favor ayudeme a recuperarlo.",
    "placeholder_status" => "status",
    "placeholder_priority" => "priority",
    "placeholder_author" => "author",
    "placeholder_created_at" => "created_at",
    "placeholder_updated_at" => "updated_at",
    "placeholder_deleted_at" => "deleted_at",
    "placeholder_document_type" => "Tipo de documento",
    "placeholder_document_number" => "Ej: 94000000",
    "placeholder_first_name" => "Ej: Jose Alexis",
    "placeholder_last_name" => "Ej: Correa Valencia",
    "placeholder_email" => "Ej: email@gmail.com",
    "placeholder_phone" => "Ej: 3000000000",
    "help_conversation" => "Código automático (Requerido)",
    "help_service" => "Centro de servicio (Requerido)",
    "help_title" => "title",
    "help_description" => "description",
    "help_status" => "status",
    "help_priority" => "priority",
    "help_author" => "author",
    "help_attachment" => "Opcional (Archivos: .JPG,.DOCX,.ZIP)",
    "help_created_at" => "created_at",
    "help_updated_at" => "updated_at",
    "help_deleted_at" => "deleted_at",
    "help_document_type" => "Tipo de documento",
    "help_document_number" => "Número de documento",
    "help_first_name" => "Nombres(Requerido)",
    "help_last_name" => "Apellidos(Requerido)",
    "help_email" => "Correo electrónico(Requerido)",
    "help_phone" => "Numero telefónico(Requerido)",
    // - Conversations creator
    "create-denied-title" => "Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevos solicitudes, por favor póngase en contacto con el administrador del sistema o en su efecto contacte al personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar presioné la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nueva solicitud de soporte",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "create-duplicate-title" => "¡conversación existente!",
    "create-duplicate-message" => "Este conversación ya se había registrado previamente, presioné continuar en la parte inferior de este mensaje para retornar al listado general de solicitudes.",
    "create-success-title" => "¡Solicitud registrada exitosamente!",
    "create-success-message" => "La solicitud se registró exitosamente, para retornar al listado general de solicitudes presioné continuar en la parte inferior de este mensaje.",
    // - Conversations viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para visualizar solicitudes en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Vista",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "",
    "view-success-title" => "",
    "view-success-message" => "",
    // - Conversations editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para actualizar solicitudes en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "¡Actualizar conversación!",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que actualizar no existe o se elimino previamente, para retornar al listado general de solicitudes presioné continuar en la parte inferior de este mensaje. ",
    "edit-success-title" => "¡conversación actualizada!",
    "edit-success-message" => "Los datos de conversación se <b>actualizaron exitosamente</b>, para retornar al listado general de solicitudes presioné el botón continuar en la parte inferior del presente mensaje.",
    // - Conversations deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para eliminar solicitudes en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar conversación!",
    "delete-message" => "Para confirmar la eliminación de la solicitud <b>%s</b>, presioné eliminar, para retornar al listado general de solicitudes presioné cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "\El elemento que intenta eliminar no existe o se elimino previamente, para retornar al listado general de solicitudes presioné continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡Conversación eliminada exitosamente!",
    "delete-success-message" => "La conversación ha sido eliminada con éxito. Para regresar al listado general de solicitudes, simplemente presiona el botón <u>Continuar</u> ubicado en la parte inferior de este mensaje.",
    // - Conversations list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para acceder al listado general de solicitudes en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Listado de solicitudes",
    "table-full-access-info" => "Tu rol actual incluye el permiso '<b>helpdesk-conversations-view-all</b>', lo que te permite ver todas las solicitudes y conversaciones registradas en el sistema.",
    "table-normal-access-info" => "En este momento, tienes acceso a las solicitudes de soporte asignadas a las áreas de servicio donde estás registrado, así como a aquellas que te han sido asignadas directamente. Puedes ver los detalles pertinentes a cada solicitud en la sección de referencia correspondiente a cada solicitud de soporte en el presente listado.",
];

?>