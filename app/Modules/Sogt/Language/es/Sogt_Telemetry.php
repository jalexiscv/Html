<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-08-26 00:44:33
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sogt\Views\Telemetry\Creator\index.php]
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
    // - Telemetry fields
    "label_telemetry" => "Telemetría",
    "label_device" => "Dispositivo",
    "label_user" => "Usuario",
    "label_latitude" => "Latitud",
    "label_longitude" => "Longitud",
    "label_altitude" => "Altitud",
    "label_speed" => "Velocidad",
    "label_heading" => "Rumbo",
    "label_gps_valid" => "GPS Válido",
    "label_satellites" => "Satélites",
    "label_network" => "Red",
    "label_battery" => "Batería",
    "label_ignition" => "Ignición",
    "label_event" => "Evento",
    "label_motion" => "Movimiento",
    "label_timestamp" => "Marca de Tiempo",
    "label_author" => "Autor",
    "label_created_at" => "Fecha de Creación",
    "label_updated_at" => "Fecha de Actualización",
    "label_deleted_at" => "Fecha de Eliminación",
    "placeholder_telemetry" => "ID de Telemetría",
    "placeholder_device" => "ID del Dispositivo",
    "placeholder_user" => "ID del Usuario",
    "placeholder_latitude" => "Ej: 4.60971",
    "placeholder_longitude" => "Ej: -74.08175",
    "placeholder_altitude" => "Metros sobre el nivel del mar",
    "placeholder_speed" => "Velocidad en Km/h",
    "placeholder_heading" => "Grados (0-359)",
    "placeholder_gps_valid" => "1 para válido, 0 para inválido",
    "placeholder_satellites" => "Número de satélites",
    "placeholder_network" => "Tipo de red (e.g., GSM, LTE)",
    "placeholder_battery" => "Nivel de batería (%)",
    "placeholder_ignition" => "1 para encendido, 0 para apagado",
    "placeholder_event" => "Código del evento",
    "placeholder_motion" => "1 para en movimiento, 0 para detenido",
    "placeholder_timestamp" => "Fecha y hora del evento",
    "placeholder_author" => "Autor del registro",
    "placeholder_created_at" => "Fecha de creación",
    "placeholder_updated_at" => "Fecha de actualización",
    "placeholder_deleted_at" => "Fecha de eliminación",
    "help_telemetry" => "Identificador único del registro de telemetría.",
    "help_device" => "Dispositivo que envió los datos.",
    "help_user" => "Usuario asociado al dispositivo.",
    "help_latitude" => "Coordenada de latitud.",
    "help_longitude" => "Coordenada de longitud.",
    "help_altitude" => "Altitud en metros.",
    "help_speed" => "Velocidad en Km/h.",
    "help_heading" => "Dirección o rumbo en grados.",
    "help_gps_valid" => "Indica si la señal GPS es válida.",
    "help_satellites" => "Número de satélites enlazados.",
    "help_network" => "Tipo de red de comunicación.",
    "help_battery" => "Nivel de carga de la batería.",
    "help_ignition" => "Estado de la ignición del vehículo.",
    "help_event" => "Código o nombre del evento reportado.",
    "help_motion" => "Indica si el dispositivo está en movimiento.",
    "help_timestamp" => "Fecha y hora en que se generó el evento.",
    "help_author" => "Usuario que creó el registro.",
    "help_created_at" => "Fecha de creación del registro.",
    "help_updated_at" => "Fecha de última actualización.",
    "help_deleted_at" => "Fecha de eliminación del registro.",
    // - Telemetry creator
    "create-denied-title" => "Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevas telemetrías, por favor póngase en contacto con el administrador del sistema o en su efecto contacte al personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar presioné la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Registrar nueva telemetría",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "create-duplicate-title" => "¡Telemetría existente!",
    "create-duplicate-message" => "Esta telemetría ya se había registrado previamente, presioné continuar en la parte inferior de este mensaje para retornar al listado general de telemetrías.",
    "create-success-title" => "¡Telemetría registrada exitosamente!",
    "create-success-message" => "La telemetría se registró exitosamente, para retornar al listado general de telemetrías presioné continuar en la parte inferior de este mensaje.",
    // - Telemetry viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para visualizar telemetrías en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Detalles de la Telemetría",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "",
    "view-success-title" => "",
    "view-success-message" => "",
    // - Telemetry editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para actualizar telemetrías en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "Actualizar Telemetría",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que intenta actualizar no existe o se eliminó previamente, para retornar al listado general de telemetrías presioné continuar en la parte inferior de este mensaje. ",
    "edit-success-title" => "¡Telemetría actualizada!",
    "edit-success-message" => "Los datos de la telemetría se <b>actualizaron exitosamente</b>, para retornar al listado general de telemetrías presioné el botón continuar en la parte inferior del presente mensaje.",
    // - Telemetry deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para eliminar telemetrías en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar Telemetría!",
    "delete-message" => "Para confirmar la eliminación de la telemetría <b>%s</b>, presioné eliminar. Para retornar al listado general de telemetrías presioné cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "El elemento que intenta eliminar no existe o se eliminó previamente, para retornar al listado general de telemetrías presioné continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡Telemetría eliminada exitosamente!",
    "delete-success-message" => "La telemetría se eliminó exitosamente, para retornar al listado de general de telemetrías presioné el botón continuar en la parte inferior de este mensaje.",
    // - Telemetry list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para acceder al listado general de telemetrías en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Listado de Telemetrías",
    "list-description" => "Listado y gestión de los registros de telemetría.",
];

?>