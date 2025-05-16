<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-05-12 05:20:29
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Settings\Creator\index.php]
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
    // - Settings fields
    "label_setting" => "Código de la configuración",
    "label_name" => "Nombre legible",
    "label_value" => "Valor actual",
    "label_date" => "Fecha",
    "label_time" => "Hora",
    "label_author" => "Autor",
    "placeholder_setting" => "Código",
    "placeholder_name" => "Nombre",
    "placeholder_value" => "Valor",
    "placeholder_date" => "Fecha",
    "placeholder_time" => "Hora",
    "placeholder_author" => "Autor",
    "help_setting" => "Código único que identifica esta configuración",
    "help_name" => "Nombre descriptivo de la configuración",
    "help_value" => "Valor actual de la configuración",
    "help_date" => "Fecha de la última modificación",
    "help_time" => "Hora de la última modificación",
    "help_author" => "Usuario que realizó la última modificación",
    // - Settings creator
    "create-denied-title" => "¡Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevas configuraciones, por favor póngase en contacto con el administrador del sistema o en su defecto contacte al personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar presione la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nueva configuración",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique e inténtelo nuevamente.",
    "create-duplicate-title" => "¡Configuración existente!",
    "create-duplicate-message" => "Esta configuración ya se había registrado previamente, presione continuar en la parte inferior de este mensaje para retornar al listado general de configuraciones.",
    "create-success-title" => "¡Configuración registrada exitosamente!",
    "create-success-message" => "La configuración se registró exitosamente, para retornar al listado general de configuraciones presione continuar en la parte inferior de este mensaje.",
    // - Settings viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para visualizar configuraciones en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Vista",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique e inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "La configuración solicitada no existe o ha sido eliminada.",
    "view-success-title" => "Visualización exitosa",
    "view-success-message" => "La configuración ha sido cargada correctamente.",
    // - Settings editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para actualizar configuraciones en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "¡Actualizar configuración!",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique e inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento a actualizar no existe o se eliminó previamente, para retornar al listado general de configuraciones presione continuar en la parte inferior de este mensaje.",
    "edit-success-title" => "¡Configuración actualizada!",
    "edit-success-message" => "Los datos de la configuración se <b>actualizaron exitosamente</b>, para retornar al listado general de configuraciones presione el botón continuar en la parte inferior del presente mensaje.",
    // - Settings deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para eliminar configuraciones en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar configuración!",
    "delete-message" => "Para confirmar la eliminación de la configuración <b>%s</b>, presione eliminar, para retornar al listado general de configuraciones presione cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique e inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "El elemento que intenta eliminar no existe o se eliminó previamente, para retornar al listado general de configuraciones presione continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡Configuración eliminada exitosamente!",
    "delete-success-message" => "La configuración se eliminó exitosamente, para retornar al listado general de configuraciones presione el botón continuar en la parte inferior de este mensaje.",
    // - Settings list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para acceder al listado general de configuraciones en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Listado de configuraciones",
    "list-description" => "Listado de parámetros de configuración del sistema",
    //Settings
    "label_graduations_message_enabled" => "Mensaje de bienvenida",
    "label_graduations_message_disabled" => "Mensaje deshabilitado",
    "help_graduations_message_enabled" => "Obligatorio: Mensaje que veran los usuarios al acceder al formulario activo de graduaciones",
    "help_graduations_message_disabled" => "Obligatorio: Mensaje que veran los usuarios al acceder al formulario deshabilitado de graduaciones",
];

?>