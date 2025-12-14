<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-01-18 01:20:07
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Crm\Views\Agents\Creator\index.php]
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
    // - Agents fields
    "label_agent" => "Código de agente",
    "label_reference" => "Referencia",
    "label_name" => "Nombre legible",
    "label_description" => "Descripción detallada",
    "label_image" => "Imagen representativa",
    "label_capacity" => "Capacidad de atención",
    "label_morning_shift_start" => "Inicio del turno de la mañana",
    "label_morning_shift_end" => "Fin del turno de la mañana",
    "label_afternoon_shift_start" => "Inicio del turno de la tarde",
    "label_afternoon_shift_end" => "Fin del turno de la tarde",
    "label_author" => "Creado por",
    "label_created_at" => "created_at",
    "label_updated_at" => "updated_at",
    "label_deleted_at" => "deleted_at",
    "placeholder_agent" => "agent",
    "placeholder_reference" => "Ej: Reclamos",
    "placeholder_name" => "Ej: Reclamos de facturación",
    "placeholder_description" => "Ej: Atiende todas solicitudes relacionadas con reclamos de facturación",
    "placeholder_image" => "image",
    "placeholder_capacity" => "capacity",
    "placeholder_morning_shift_start" => "morning_shift_start",
    "placeholder_morning_shift_end" => "morning_shift_end",
    "placeholder_afternoon_shift_start" => "afternoon_shift_start",
    "placeholder_afternoon_shift_end" => "afternoon_shift_end",
    "placeholder_author" => "author",
    "placeholder_created_at" => "created_at",
    "placeholder_updated_at" => "updated_at",
    "placeholder_deleted_at" => "deleted_at",
    "help_agent" => "agent",
    "help_reference" => "Referencia institucional",
    "help_name" => "Nombre visible en los informes",
    "help_description" => "Descripción detallada y/o de funciones",
    "help_image" => "Imagen visible",
    "help_capacity" => "Numero de turnos que pueden atender",
    "help_morning_shift_start" => "Hora (Requerido)",
    "help_morning_shift_end" => "Hora (Requerido)",
    "help_afternoon_shift_start" => "Hora (Requerido)v",
    "help_afternoon_shift_end" => "Hora (Requerido)",
    "help_author" => "author",
    "help_created_at" => "created_at",
    "help_updated_at" => "updated_at",
    "help_deleted_at" => "deleted_at",
    // - Agents creator
    "create-denied-title" => "Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevos agentes, por favor póngase en contacto con el administrador del sistema o en su efecto contacte al personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar presioné la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nuevo agente",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "create-duplicate-title" => "¡Agente existente!",
    "create-duplicate-message" => "Este agente ya se había registrado previamente, presioné continuar en la parte inferior de este mensaje para retornar al listado general de agentes.",
    "create-success-title" => "¡Agente registrado exitosamente!",
    "create-success-message" => "El agente se registró exitosamente, para retornar al listado general de agentes presioné continuar en la parte inferior de este mensaje.",
    // - Agents viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para visualizar agentes en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Vista",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "",
    "view-success-title" => "",
    "view-success-message" => "",
    // - Agents editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para actualizar agentes en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "¡Actualizar agente!",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que actualizar no existe o se elimino previamente, para retornar al listado general de agentes presioné continuar en la parte inferior de este mensaje. ",
    "edit-success-title" => "¡Agente actualizado!",
    "edit-success-message" => "Los datos de agente se <b>actualizaron exitosamente</b>, para retornar al listado general de agentes presioné el botón continuar en la parte inferior del presente mensaje.",
    // - Agents deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para eliminar agentes en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar agente!",
    "delete-message" => "Para confirmar la eliminación del agente <b>%s</b>, presioné eliminar, para retornar al listado general de agentes presioné cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "\El elemento que intenta eliminar no existe o se elimino previamente, para retornar al listado general de agentes presioné continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡agente eliminad@ exitosamente!",
    "delete-success-message" => "La agente se elimino exitosamente, para retornar al listado de general de agentes presioné el botón continuar en la parte inferior de este mensaje.",
    // - Agents list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para acceder al listado general de agentes en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Listado de agentes",
];

?>