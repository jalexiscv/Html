<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-04-17 08:54:39
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Plans\Views\Actions\Creator\index.php]
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
 * █ @var object $parent Trasferido desde el controlador
 * █ @var object $authentication Trasferido desde el controlador
 * █ @var object $request Trasferido desde el controlador
 * █ @var object $dates Trasferido desde el controlador
 * █ @var string $component Trasferido desde el controlador
 * █ @var string $view Trasferido desde el controlador
 * █ @var string $oid Trasferido desde el controlador
 * █ @var string $views Trasferido desde el controlador
 * █ @var string $prefix Trasferido desde el controlador
 * █ @var array $data Trasferido desde el controlador
 * █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
return [
    // - Actions fields
    "label_action" => "Codigo de acción",
    "label_plan" => "Plan de acción",
    "label_variables" => "Variable (¿Que hacer?)",
    "label_alternatives" => "",
    "label_implementation" => "Implementación (¿Como se va a hacer?)",
    "label_evaluation" => "Evaluación (¿Como se va a evidenciar?)",
    "label_percentage" => "percentage",
    "label_range" => "Fechas (Inicio/Finalización)",
    "label_start" => "Fecha de inicio",
    "label_end" => "Fecha de finalización",
    "label_owner" => "Encargado",
    "label_author" => "author",
    "label_created_at" => "created_at",
    "label_updated_at" => "updated_at",
    "label_deleted_at" => "deleted_at",
    "placeholder_action" => "action",
    "placeholder_plan" => "plan",
    "placeholder_variables" => "Ej: Aumentar las ventas en un 20%.",
    "placeholder_alternatives" => "",
    "placeholder_implementation" => "Ej: Desarrollar e implementar una nueva campaña de marketing en redes sociales. Esto puede incluir pasos como la investigación de la audiencia objetivo, la creación de contenido atractivo, y la elección de las mejores plataformas de redes sociales para la campaña.",
    "placeholder_evaluation" => "Ej: Podremos ver la evidencia de este logro a través de métricas de ventas y rendimiento de la campaña de marketing. Por ejemplo, podríamos medir: aumento en la cantidad de clientes, incremento en las ventas mensuales y la efectividad de la campaña de marketing en términos de aumento en el compromiso del cliente y generación de leads.",
    "placeholder_percentage" => "percentage",
    "placeholder_start" => "start",
    "placeholder_end" => "end",
    "placeholder_owner" => "Ej: Juan Perez",
    "placeholder_author" => "author",
    "placeholder_created_at" => "created_at",
    "placeholder_updated_at" => "updated_at",
    "placeholder_deleted_at" => "deleted_at",
    "help_action" => "action",
    "help_plan" => "plan",
    "help_variables" => "variables",
    "help_alternatives" => "alternatives",
    "help_implementation" => "implementation",
    "help_evaluation" => "evaluation",
    "help_range" => "Rago de fechas (Inicio/Limite)",
    "help_percentage" => "percentage",
    "help_start" => "start",
    "help_end" => "end",
    "help_owner" => "owner",
    "help_author" => "author",
    "help_created_at" => "created_at",
    "help_updated_at" => "updated_at",
    "help_deleted_at" => "deleted_at",
    // - Actions creator
    "create-denied-title" => "Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevos acciones, por favor póngase en contacto con el administrador del sistema o en su efecto contacte al personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar presioné la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nueva acción",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "create-duplicate-title" => "¡acción existente!",
    "create-duplicate-message" => "Este acción ya se había registrado previamente, presioné continuar en la parte inferior de este mensaje para retornar al listado general de acciones.",
    "create-success-title" => "¡acción registrada exitosamente!",
    "create-success-message" => "La acción se registró exitosamente, para retornar al listado general de acciones presioné continuar en la parte inferior de este mensaje.",
    "create-info-title" => "¡Información!",
    "create-info-message" => "Recuerde que el rango de fecha de inicio y finalización de la acción, debe de coincidir con el rango de fecha establecido para la ejecución total del plan. Fechas anteriores o posteriores al rango efectivo del plan de acción <b>%s</b> a <b>%s</b> serán rechazadas. ",
    "create-definition-info-title" => "¿Que es una acción?",
    "create-definition-info-message" => "Dentro de un plan de acción, una \"acción\" es un paso específico, una tarea o una actividad que necesita ser llevada a cabo para avanzar hacia el logro de una meta o objetivo establecido. Cada acción contribuye, de manera directa o indirecta, al logro del objetivo final. La acción debe ser claramente definida con suficiente detalle como para saber exactamente qué se necesita hacer. Por lo general, incluye una descripción de la tarea, quién es responsable de realizarla, cuándo debería completarse, y qué recursos son necesarios para su realización. Por ejemplo, si el objetivo es \"Aumentar las ventas en un 20% para el final del año fiscal\", una acción podría ser \"Implementar una nueva campaña de marketing en las redes sociales para el próximo trimestre\". Esta acción es un paso concreto y medible que contribuye a la consecución de la meta global.",
    // - Actions viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para visualizar acciones en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Vista",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "",
    "view-success-title" => "",
    "view-success-message" => "",
    // - Actions editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para actualizar acciones en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "¡Actualizar acción!",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que actualizar no existe o se elimino previamente, para retornar al listado general de acciones presioné continuar en la parte inferior de este mensaje. ",
    "edit-success-title" => "¡Acción actualizada!",
    "edit-success-message" => "Los datos de la acción se <b>actualizaron exitosamente</b>, para retornar al listado general de acciones presioné el botón continuar en la parte inferior del presente mensaje.",
    // - Actions deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para eliminar acciones en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar acción!",
    "delete-message" => "Para confirmar la eliminación del acción <b>%s</b>, presioné eliminar, para retornar al listado general de acciones presioné cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "\El elemento que intenta eliminar no existe o se elimino previamente, para retornar al listado general de acciones presioné continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡Acción eliminada exitosamente!",
    "delete-success-message" => "La acción se elimino exitosamente, para retornar al listado de general de acciones presioné el botón continuar en la parte inferior de este mensaje.",
    // - Actions list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para acceder al listado general de acciones en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Listado de acciones",
    "list-definition-info-title" => "Recuerde",
    "list-definition-info-message" => "Recuerde que una vez halla creado una o mas acciones, todas ellas estarán en estado de propuestas, por tal motivo un plan de acción con sus acciones propuestas podrá ya ser presentado para su aprobación. Si y solo si el plan ha sido aprobado las acciones pasaran a un estado de aprobadas y a la espera de evidenciar su cumplimiento, hasta que esto no suceda las acciones en la lista anterior podrán ser editas o eliminadas libremente. ",
];

?>