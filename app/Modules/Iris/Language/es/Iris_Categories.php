<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-10-03 06:34:17
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Iris\Views\Categories\Creator\index.php]
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
    // - Categories fields
    "label_category" => "Categoría",
    "label_code" => "Código",
    "label_name" => "Nombre",
    "label_description" => "Descripción",
    "label_is_active" => "¿Está Activa?",
    "label_created_by" => "Creado por",
    "label_updated_by" => "Actualizado por",
    "label_deleted_by" => "Eliminado por",
    "label_created_at" => "Fecha de Creación",
    "label_updated_at" => "Fecha de Actualización",
    "label_deleted_at" => "Fecha de Eliminación",
    "placeholder_category" => "ID de la categoría",
    "placeholder_code" => "Ingrese el código de la categoría",
    "placeholder_name" => "Ingrese el nombre de la categoría",
    "placeholder_description" => "Ingrese una descripción para la categoría",
    "placeholder_is_active" => "Indica si la categoría está activa",
    "placeholder_created_by" => "Usuario que creó el registro",
    "placeholder_updated_by" => "Usuario que actualizó el registro",
    "placeholder_deleted_by" => "Usuario que eliminó el registro",
    "placeholder_created_at" => "Fecha de creación",
    "placeholder_updated_at" => "Fecha de actualización",
    "placeholder_deleted_at" => "Fecha de eliminación",
    "help_category" => "Identificador único de la categoría.",
    "help_code" => "Código único para la categoría.",
    "help_name" => "Nombre de la categoría (ej. Retina, Glaucoma).",
    "help_description" => "Descripción detallada de la especialidad o área anatómica.",
    "help_is_active" => "Activa o desactiva la categoría en el sistema.",
    "help_created_by" => "Autor original del registro.",
    "help_updated_by" => "Último usuario en modificar el registro.",
    "help_deleted_by" => "Usuario que eliminó el registro.",
    "help_created_at" => "Fecha de creación del registro.",
    "help_updated_at" => "Fecha de la última actualización.",
    "help_deleted_at" => "Fecha en que se eliminó el registro.",
    // - Categories creator
    "create-denied-title" => "¡Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevas Categorías. Por favor, póngase en contacto con el administrador del sistema o con el personal de soporte técnico para que le sean asignados. Para continuar, presione la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nueva Categoría",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "create-duplicate-title" => "¡Categoría existente!",
    "create-duplicate-message" => "Esta Categoría ya se había registrado previamente. Presione continuar en la parte inferior de este mensaje para retornar al listado general de Categorías.",
    "create-success-title" => "¡Categoría registrada exitosamente!",
    "create-success-message" => "La Categoría se registró exitosamente. Para retornar al listado general de Categorías, presione continuar en la parte inferior de este mensaje.",
    // - Categories viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para visualizar Categorías en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Ver Categoría",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "view-noexist-title" => "¡La Categoría no existe!",
    "view-noexist-message" => "La categoría que intenta consultar no existe o fue eliminada previamente. Presione continuar para volver al listado de categorías.",
    "view-success-title" => "Detalles de la Categoría",
    "view-success-message" => "Información de la categoría cargada exitosamente.",
    // - Categories editor
    "edit-denied-title" => "¡Acceso denegado!",
    "edit-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para actualizar Categorías en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "Actualizar Categoría",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "edit-noexist-title" => "¡La Categoría no existe!",
    "edit-noexist-message" => "El elemento que intenta actualizar no existe o se eliminó previamente. Para retornar al listado general de Categorías, presione continuar en la parte inferior de este mensaje.",
    "edit-success-title" => "¡Categoría actualizada!",
    "edit-success-message" => "Los datos de la Categoría se <b>actualizaron exitosamente</b>. Para retornar al listado general de Categorías, presione el botón continuar en la parte inferior del presente mensaje.",
    // - Categories deleter
    "delete-denied-title" => "¡Acceso denegado!",
    "delete-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para eliminar Categorías en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar Categoría!",
    "delete-message" => "Para confirmar la eliminación de la Categoría <b>%s</b>, presione eliminar. Para retornar al listado general de Categorías, presione cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "delete-noexist-title" => "¡La Categoría no existe!",
    "delete-noexist-message" => "El elemento que intenta eliminar no existe o se eliminó previamente. Para retornar al listado general de Categorías, presione continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡Categoría eliminada exitosamente!",
    "delete-success-message" => "La Categoría se eliminó exitosamente. Para retornar al listado general de Categorías, presione el botón continuar en la parte inferior de este mensaje.",
    // - Categories list
    "list-denied-title" => "¡Acceso denegado!",
    "list-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para acceder al listado general de Categorías en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Listado de Categorías",
    "list-description" => "A continuación se listan las categorías de alto nivel para la clasificación de estudios médicos.",
];

?>