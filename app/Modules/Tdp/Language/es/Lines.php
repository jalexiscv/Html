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
return [
    // - Lines fields
    "label_line" => "Código de la línea",
    "label_dimension" => "Código de la dimensión",
    "label_order" => "Orden",
    "label_name" => "Nombre de la línea",
    "label_description" => "Descripción de la línea",
    "label_author" => "Autor de la línea",
    "label_created_at" => "created_at",
    "label_updated_at" => "updated_at",
    "label_deleted_at" => "deleted_at",
    "placeholder_line" => "line",
    "placeholder_dimension" => "dimension",
    "placeholder_order" => "order",
    "placeholder_name" => "name",
    "placeholder_description" => "description",
    "placeholder_author" => "author",
    "placeholder_created_at" => "created_at",
    "placeholder_updated_at" => "updated_at",
    "placeholder_deleted_at" => "deleted_at",
    "help_line" => "Código automático",
    "help_dimension" => "Código heredado",
    "help_order" => "Número de orden(Requerido)",
    "help_name" => "Nombre(Requerido)",
    "help_description" => "Descripción (Requerido)",
    "help_author" => "author",
    "help_created_at" => "created_at",
    "help_updated_at" => "updated_at",
    "help_deleted_at" => "deleted_at",
    // - Lines creator
    "create-denied-title" => "Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevos líneas, por favor póngase en contacto con el administrador del sistema o en su efecto contacte al personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar presioné la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nueva línea",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "create-duplicate-title" => "¡línea existente!",
    "create-duplicate-message" => "Este línea ya se había registrado previamente, presioné continuar en la parte inferior de este mensaje para retornar al listado general de líneas.",
    "create-success-title" => "¡Línea registrada exitosamente!",
    "create-success-message" => "La línea se registró exitosamente, para retornar al listado general de líneas presioné continuar en la parte inferior de este mensaje.",
    // - Lines viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para visualizar líneas en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Vista",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "",
    "view-success-title" => "",
    "view-success-message" => "",
    // - Lines editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para actualizar líneas en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "¡Actualizar línea!",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que actualizar no existe o se elimino previamente, para retornar al listado general de líneas presioné continuar en la parte inferior de este mensaje. ",
    "edit-success-title" => "¡Línea actualizada!",
    "edit-success-message" => "Los datos de línea se <b>actualizaron exitosamente</b>, para retornar al listado general de líneas presioné el botón continuar en la parte inferior del presente mensaje.",
    // - Lines deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para eliminar líneas en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar línea!",
    "delete-message" => "Para confirmar la eliminación del línea <b>%s</b>, presioné eliminar, para retornar al listado general de líneas presioné cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "\El elemento que intenta eliminar no existe o se elimino previamente, para retornar al listado general de líneas presioné continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡Línea eliminada exitosamente!",
    "delete-success-message" => "La línea se elimino exitosamente, para retornar al listado de general de líneas presioné el botón continuar en la parte inferior de este mensaje.",
    // - Lines list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para acceder al listado general de líneas en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "tdp-list-title" => "Dimensión / Líneas estratégicas",
    "tdp-list-alert-title" => "Recuerde",
    "tdp-list-alert-message" => "Una dimensión en el plan de desarrollo esta conformada por las líneas estratégicas que la integran como ejes de acción o rutas que orientan la toma de decisiones y la implementación de políticas, programas y proyectos. Las líneas estratégicas derivan de un análisis situacional y buscan responder a las necesidades y problemas identificados, alineándose con los objetivos de desarrollo. Sirven de conexión entre la visión de largo plazo del plan y las acciones concretas a desarrollar.",
    "tdp-home-title" => "Líneas estratégicas",
    "tdp-home-message" => "Son ejes de acción o rutas que orientan la toma de decisiones y la implementación de políticas, programas y proyectos. Las líneas estratégicas derivan de un análisis situacional y buscan responder a las necesidades y problemas identificados, alineándose con los objetivos de desarrollo. Sirven de conexión entre la visión de largo plazo del plan y las acciones concretas a desarrollar. Una dimensión puede estar conformada por multiples líneas estratégicas.",
];

?>