<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-12-10 04:44:40
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Statuses\Creator\index.php]
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
    // - Statuses fields
    "label_status" => "Código de estado",
    "label_registration" => "Código de registro",
    "label_program" => "Código de programa",
    "label_period" => "Periodo",
    "label_moment" => "Momento",
    "label_cycle" => "Ciclo",
    "label_reference" => "Referencia",
    "label_observation" => "Observación",
    "label_date" => "Fecha",
    "label_time" => "Hora",
    "label_enrollment"=>"Matricula",
    "label_enrollment_date"=>"Fecha de matricula",
    "label_author" => "author",
    "label_locked_at" => "locked_at",
    "label_created_at" => "created_at",
    "label_updated_at" => "updated_at",
    "label_deleted_at" => "deleted_at",
    "label_grid" => "Malla curricular",
    "label_version" => "Versión del pensum",
    "placeholder_status" => "status",
    "placeholder_registration" => "registration",
    "placeholder_program" => "program",
    "placeholder_cycle" => "cycle",
    "placeholder_reference" => "reference",
    "placeholder_date" => "date",
    "placeholder_time" => "time",
    "placeholder_enrollment"=>"Ej: 123456789",
    "placeholder_enrollment_date"=>"Ej: 2026-01-01",
    "placeholder_author" => "author",
    "placeholder_locked_at" => "locked_at",
    "placeholder_created_at" => "created_at",
    "placeholder_updated_at" => "updated_at",
    "placeholder_deleted_at" => "deleted_at",
    "help_status" => "status",
    "help_registration" => "registration",
    "help_program" => "program",
    "help_cycle" => "cycle",
    "help_reference" => "reference",
    "help_date" => "date",
    "help_time" => "time",
    "help_author" => "author",
    "help_locked_at" => "locked_at",
    "help_created_at" => "created_at",
    "help_updated_at" => "updated_at",
    "help_deleted_at" => "deleted_at",
    "help_grid" => "Seleccione la malla(Obligatorio)",
    "help_version" => "Seleccione la versión(Obligatorio)",
    // - Statuses creator
    "create-denied-title" => "Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevos estados, por favor póngase en contacto con el administrador del sistema o en su efecto contacte al personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar presioné la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nuevo estado",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "create-duplicate-title" => "¡estado existente!",
    "create-duplicate-message" => "Este estado ya se había registrado previamente, presioné continuar en la parte inferior de este mensaje para retornar al listado general de estados.",
    "create-success-title" => "¡estado registrada exitosamente!",
    "create-success-message" => "El estado se registró exitosamente, para retornar al listado general de estados presioné continuar en la parte inferior de este mensaje.",
    // - Statuses viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para visualizar estados en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Vista",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "",
    "view-success-title" => "",
    "view-success-message" => "",
    // - Statuses editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para actualizar estados en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "Actualizar estado",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que actualizar no existe o se elimino previamente, para retornar al listado general de estados presioné continuar en la parte inferior de este mensaje. ",
    "edit-success-title" => "¡Estado actualizado!",
    "edit-success-message" => "Los datos del estado se <b>actualizaron exitosamente</b>, para retornar al listado general de estados presioné el botón continuar en la parte inferior del presente mensaje.",
    // - Statuses deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para eliminar estados en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar estado!",
    "delete-message" => "Para confirmar la eliminación del estado <b>%s</b>, presioné eliminar, para retornar al listado general de estados presioné cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "\El elemento que intenta eliminar no existe o se elimino previamente, para retornar al listado general de estados presioné continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡Estado eliminado exitosamente!",
    "delete-success-message" => "El estado se elimino exitosamente, para retornar al listado de general de estados presioné el botón continuar en la parte inferior de este mensaje.",
    // - Statuses list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para acceder al listado general de estados en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Listado de estados",
    "message-statuses-student-list-info" => "El siguiente listado presenta los distintos estados que un estudiante puede tener a lo largo del tiempo. Estos estados son fundamentales para la generación de diversos reportes y para determinar la situación académica actual del estudiante en la institución.",
    "delete-locked-title" => "¡Advertencia!",
    "delete-locked-message" => "El estado que intenta eliminar se encuentra bloqueado debido a que solo se le concede un plazo de 24 horas para eliminar cambios de estado, por lo tanto no puede ser eliminado. Para continuar presioné la opción correspondiente en la parte inferior de este mensaje.",
];

?>