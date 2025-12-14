<?php

/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2024-07-24 14:29:45
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2024 - CloudEngine S.A.S., Inc. <admin@cgine.com>
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
 *  ** █ @Editor Anderson Ospina Lenis <andersonospina798@gmail.com>
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
    // - Activities fields
    "label_activity" => "Código de la actividad",
    "label_category" => "Categoría de la actividad",
    "label_order" => "Orden de la actividad",
    "label_criteria" => "Criterio de la actividad",
    "label_description" => "Descripción de la actividad",
    "label_evaluation" => "Evaluación de la actividad",
    "label_period" => "Periodo de la actividad",
    "label_score" => "Calificación de la actividad",
    "label_multiplan" => "Multiplan",
    "label_budget" => "Presupuesto de la actividad",
    "label_author" => "Autor de la actividad",
    "label_created_at" => "created_at",
    "label_updated_at" => "updated_at",
    "label_deleted_at" => "deleted_at",
    "placeholder_activity" => "Actividad",
    "placeholder_category" => "Categoría",
    "placeholder_order" => "Orden",
    "placeholder_criteria" => "Criterio",
    "placeholder_description" => "Descripción",
    "placeholder_evaluation" => "Evaluación",
    "placeholder_period" => "Periodo",
    "placeholder_score" => "Calificación",
    "placeholder_multiplan" => "Multiplan",
    "placeholder_budget" => "0",
    "placeholder_author" => "Autor",
    "placeholder_created_at" => "created_at",
    "placeholder_updated_at" => "updated_at",
    "placeholder_deleted_at" => "deleted_at",
    "help_activity" => "Código de automático (Requerido)",
    "help_category" => "Código heredado (Requerido)",
    "help_order" => "Número de orden (Requerido)",
    "help_criteria" => "Criterio (Opcional)",
    "help_description" => "Descripción detallada (Requerido)",
    "help_evaluation" => "Evaluación (Requerido)",
    "help_period" => "Período (Requerido)",
    "help_score" => "Número 1-100 (Requerido)",
    "help_multiplan" => "Multiplan (Requerido)",
    "help_budget" => "Presupuesto (Requerido)",
    "help_author" => "Autor",
    "help_created_at" => "created_at",
    "help_updated_at" => "updated_at",
    "help_deleted_at" => "deleted_at",
    // - Activities creator
    "create-denied-title" => "¡Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevas actividades. Por favor, póngase en contacto con el administrador del sistema o, en su defecto, con el personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar, presione la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nueva actividad",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "create-duplicate-title" => "¡Actividad existente!",
    "create-duplicate-message" => "Esta actividad ya se había registrado previamente. Presione continuar en la parte inferior de este mensaje para retornar al listado general de actividades.",
    "create-success-title" => "¡Actividad registrada exitosamente!",
    "create-success-message" => "La actividad se registró exitosamente. Para retornar al listado general de actividades, presione continuar en la parte inferior de este mensaje.",
    // - Activities viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para visualizar actividades en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Vista",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "",
    "view-success-title" => "",
    "view-success-message" => "",
    // - Activities editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para actualizar actividades en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "¡Actualizar actividad!",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que actualizar no existe o se elimino previamente. Para retornar al listado general de actividades presione continuar en la parte inferior de este mensaje. ",
    "edit-success-title" => "¡Actividad actualizada!",
    "edit-success-message" => "Los datos de actividad se <b>actualizaron exitosamente</b>. Para retornar al listado general de actividades presione el botón continuar en la parte inferior del presente mensaje.",
    // - Activities deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para eliminar actividades en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional o la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar actividad!",
    "delete-message" => "Para confirmar la eliminación del actividad <b>%s</b>, presione eliminar. Para retornar al listado general de actividades, presione cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "El elemento que intenta eliminar no existe o se elimino previamente. Para retornar al listado general de actividades, presione continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡Actividad eliminada exitosamente!",
    "delete-success-message" => "La actividad se eliminó exitosamente. Para retornar al listado de general de actividades, presione el botón continuar en la parte inferior de este mensaje.",
    // - Activities list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para acceder al listado general de actividades en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional o la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Listado de actividades",
    "home-title" => "Actividades de la categoría %s",
    "definition-info-title" => "¿Qué son las actividades?",
    "definition-info-message" => "En el marco del Modelo Integrado de Planeación y Gestión para Colombia (MiPG), las actividades se definen como acciones específicas diseñadas para implementar las políticas públicas establecidas. Estas acciones están estrechamente alineadas con los objetivos definidos dentro de cada componente de la política y se vinculan directamente con las categorías identificadas durante el proceso de diagnóstico. Las actividades se planifican minuciosamente, se ejecutan, se monitorean y se evalúan con el fin de lograr resultados concretos que contribuyan al cumplimiento de los objetivos más amplios de las políticas establecidas en el modelo. Dentro del MiPG, las actividades pueden abarcar una variedad de acciones, como programas de capacitación, campañas de sensibilización, desarrollo de infraestructura y aplicación de regulaciones, entre otras. El objetivo principal de estas acciones es generar un impacto positivo en la sociedad y avanzar en el logro de los objetivos de desarrollo del país. La evaluación y calificación de las actividades se lleva a cabo mediante la ejecución meticulosa de planes de acción. El cumplimiento de estos planes implica una recalificación del estado actual de la actividad, lo que permite realizar ajustes necesarios para garantizar la efectividad y el éxito en la implementación de las políticas públicas dentro del marco del MiPG.",
];

?>