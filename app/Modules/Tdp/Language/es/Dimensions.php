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
    // - Dimensions fields
    "label_dimension" => "Código de la dimensión",
    "label_reference" => "Referencia",
    "label_process" => "Proceso",
    "label_order" => "Orden",
    "label_name" => "Nombre de la dimensión",
    "label_description" => "Descripción de la dimensión",
    "label_author" => "Autor de la dimensión",
    "label_created_at" => "created_at",
    "label_updated_at" => "updated_at",
    "label_deleted_at" => "deleted_at",
    "placeholder_dimension" => "dimension",
    "placeholder_reference" => "reference",
    "placeholder_process" => "process",
    "placeholder_order" => "order",
    "placeholder_name" => "name",
    "placeholder_description" => "description",
    "placeholder_author" => "author",
    "placeholder_created_at" => "created_at",
    "placeholder_updated_at" => "updated_at",
    "placeholder_deleted_at" => "deleted_at",
    "help_dimension" => "dimension",
    "help_reference" => "reference",
    "help_process" => "process",
    "help_order" => "order",
    "help_name" => "name",
    "help_description" => "description",
    "help_author" => "author",
    "help_created_at" => "created_at",
    "help_updated_at" => "updated_at",
    "help_deleted_at" => "deleted_at",
    // - Dimensions creator
    "create-denied-title" => "Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevos dimensiónes, por favor póngase en contacto con el administrador del sistema o en su efecto contacte al personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar presioné la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nueva dimensión",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "create-duplicate-title" => "¡Dimensión existente!",
    "create-duplicate-message" => "Este dimensión ya se había registrado previamente, presioné continuar en la parte inferior de este mensaje para retornar al listado general de dimensiónes.",
    "create-success-title" => "¡Dimensión registrada exitosamente!",
    "create-success-message" => "La dimensión se registró exitosamente, para retornar al listado general de dimensiónes presioné continuar en la parte inferior de este mensaje.",
    // - Dimensions viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para visualizar dimensiónes en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Vista",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "",
    "view-success-title" => "",
    "view-success-message" => "",
    // - Dimensions editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para actualizar dimensiónes en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "¡Actualizar dimensión!",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que actualizar no existe o se elimino previamente, para retornar al listado general de dimensiónes presioné continuar en la parte inferior de este mensaje. ",
    "edit-success-title" => "¡dimensión actualizada!",
    "edit-success-message" => "Los datos de dimensión se <b>actualizaron exitosamente</b>, para retornar al listado general de dimensiónes presioné el botón continuar en la parte inferior del presente mensaje.",
    // - Dimensions deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para eliminar dimensiónes en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar dimensión!",
    "delete-message" => "Para confirmar la eliminación del dimensión <b>%s</b>, presioné eliminar, para retornar al listado general de dimensiónes presioné cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "\El elemento que intenta eliminar no existe o se elimino previamente, para retornar al listado general de dimensiónes presioné continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡Dimensión eliminada exitosamente!",
    "delete-success-message" => "La dimensión se elimino exitosamente, para retornar al listado de general de dimensiónes presioné el botón continuar en la parte inferior de este mensaje.",
    // - Dimensions list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para acceder al listado general de dimensiónes en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Listado de dimensiónes",
    "dimensions-info" => "En el contexto de MiPG(Modelo Integrado de Planeación y Gestión), una dimensión se refiere a un aspecto o área temática específica que se considera importante en la planeación y gestión pública. Estas dimensiones representan áreas clave que deben ser abordadas para lograr los objetivos estratégicos y mejorar la gestión gubernamental. ",
    "info-title" => "Recuerde",
    "info-message" => "Estas dimensiones proporcionan un marco integral para la planificación y gestión pública en Colombia, permitiendo que las entidades gubernamentales aborden de manera efectiva los desafíos y oportunidades que enfrenta el país en su camino hacia el desarrollo sostenible y el bienestar de sus ciudadanos.",
    "tdp-dimensions-info" => "Un plan de desarrollo municipal en Colombia generalmente se concibe como un instrumento de planificación que orienta las acciones del gobierno municipal hacia el desarrollo integral y sostenible del territorio. Dicho plan integra diferentes dimensiones que son fundamentales para abordar el desarrollo de manera holística.",
    "tdp-info-title" => "Integración de dimensiones",
    "tdp-info-message" => "La integración de estas dimensiones permite abordar el desarrollo desde una perspectiva integral, reconociendo la interdependencia entre los diferentes aspectos que afectan la vida en el municipio. La efectividad del plan de desarrollo depende de cómo estas dimensiones se articulan y complementan en la estrategia de intervención territorial.",


];

?>