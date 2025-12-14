<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-07-24 17:09:22
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Plans\Views\Plans\Creator\index.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2024 - CloudEngine S.A.S., Inc. <admin@cgine.com>
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
 * █ @Editor Anderson Ospina Lenis <andersonospina798@gmail.com>
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @var object $parent
 * █ @var object $authentication
 * █ @var object $request
 * █ @var object $dates
 * █ @var string $component
 * █ @var string $view
 * █ @var string $oid
 * █ @var string $views
 * █ @var string $prefix
 * █ @var array $data
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
return [
    "Module" => "Módulo de Planes",
    "intro-1" => "Bienvenido al módulo de planes. Aquí podrá gestionar y administrar los planes de trabajo de su organización. Un Plan de Acción, en el contexto del MIPG, es una herramienta integral que facilita la ejecución efectiva de actividades al proporcionar una guía detallada de las acciones requeridas, los plazos asociados y los responsables de llevar a cabo cada tarea. Esto ayuda a garantizar una implementación exitosa de las actividades planificadas dentro del marco de gestión.",
    // - Plans fields
    "label_plan" => "Código del plan",
    "label_plan_institutional" => "Plan institucional (Alineado)",
    "label_activity" => "Código de la actividad",
    "label_manager" => "Proceso responsable del plan de acción",
    "label_manager_process_name" => "Nombre del proceso",
    "label_manager_user" => "Responsable por proceso",
    "label_manager_subprocess" => "Responsable por subproceso",
    "label_manager_position" => "Responsable por cargo",
    "label_order" => "Orden",
    "label_description" => "Descripción detallada del plan",
    "label_formulation" => "Formulación",
    "label_value" => "Recalificación propuesta",
    "label_range" => "Fechas (Inicio/Finalización)",
    "label_start" => "Fecha Inicio",
    "label_end" => "Fecha Finalización",
    "label_evaluation" => "Evaluación",
    "label_author" => "Autor",
    "label_created_at" => "created_at",
    "label_updated_at" => "updated_at",
    "label_deleted_at" => "deleted_at",
    "label_status"=> "Estado",
    "label_status_approve"=> "Estado de aprobación",
    "label_status_date"=> "Fecha de aprobación",
    "label_status_time"=> "Hora de aprobación",
    "label_status_approval"=> "Detalle de aprobación",
    "label_status_evaluate"=>"Detalle de la solicitud de evaluación",
    "label_status_evaluation"=>"Detalle de la evaluación",
    "placeholder_plan" => "Plan",
    "placeholder_plan_institutional" => "Plan institutional",
    "placeholder_activity" => "activity",
    "placeholder_manager" => "manager",
    "placeholder_manager_subprocess" => "Responsable de subprocesos",
    "placeholder_manager_position" => "Cargo de Responsable",
    "placeholder_order" => "order",
    "placeholder_description" => "Descripción",
    "placeholder_formulation" => "Formulación",
    "placeholder_value" => "0",
    "placeholder_start" => "Inicio",
    "placeholder_end" => "Finalización",
    "placeholder_evaluation" => "Evaluación",
    "placeholder_author" => "Autor",
    "placeholder_created_at" => "created_at",
    "placeholder_updated_at" => "updated_at",
    "placeholder_deleted_at" => "deleted_at",
    "placeholder_status_approval"=> "Ej: Aprobada por motivo x",
    "help_plan" => "Código automático",
    "help_plan_institutional" => "Seleccione uno (Requerido)",
    "help_manager_process_name" => "Nombre del proceso (Automático)",
    "help_manager_user" => "Responsable por proceso (Automático)",
    "help_activity" => "Código heredado(Automático)",
    "help_manager" => "Seleccione uno (Requerido)",
    "help_manager_subprocess" => "Subproceso + Responsable",
    "help_manager_position" => "Cargo + Responsable",
    "help_order" => "Orden",
    "help_description" => "Descripción detallada del plan (Requerido)",
    "help_formulation" => "Formulación",
    "help_value" => "Númerico de 0-100 (Requerido)",
    "help_range" => "Fechas (Inicio/Finalización)",
    "help_start" => "Inicio",
    "help_end" => "Finalización",
    "help_evaluation" => "Evaluación",
    "help_author" => "Autor",
    "help_created_at" => "created_at",
    "help_updated_at" => "updated_at",
    "help_deleted_at" => "deleted_at",
    "help_status"=>"Automático",
    "help_status_approve"=>"Automático",
    "help_status_date"=>"Automático",
    "help_status_time"=>"Automático",
    "help_status_approval"=>"Requerido",
    "help_status_evaluate"=>"Requerido",
    "help_status_evaluation"=>"Requerido",
    // - Plans creator
    "info-create-title" => "Recuerde",
    "info-create-message" => "Recuerde: El criterio de calificación es el puntaje que se refiere a la calificación de cada una de las Actividades de Gestión y debe estar en una escala de 0 a 100. Al crear directamente un plan y luego asignarlo a una actividad o similar, deberá considerar el valor calificable propuesto y verificar si se adapta al valor calificable como meta de la actividad. Esto deberá realizarse en un procedimiento posterior al presente. Además, los rangos de calificación dependen de los establecidos para las actividades según el modelo que se aplique, y en teoría, solo deberá fijar un valor de calificación aplicable según la actividad seleccionada y su respectivo conjunto de rangos. ",
    "create-denied-title" => "¡Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevos planes de acción. Por favor, póngase en contacto con el administrador del sistema o, en su defecto, con el personal de soporte técnico para que le sean asignados los permisos necesarios, si corresponde. Para continuar, presione la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nuevo plan de acción",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "create-duplicate-title" => "¡Plan de acción existente!",
    "create-duplicate-message" => "Este plan de acción ya se había registrado previamente. Presione continuar en la parte inferior de este mensaje para regresar al listado general de planes de acción.",
    "create-success-title" => "¡Plan de acción registrado exitosamente!",
    "create-success-message" => "El plan de acción se registró exitosamente. Para regresar al listado general de planes de acción, presione continuar en la parte inferior de este mensaje.",
    // - Plans viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para visualizar planes de acción en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional o para la asignación de los permisos necesarios, si corresponde. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Plan de acción %s",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "",
    "view-success-title" => "",
    "view-success-message" => "",
    // - Plans editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para actualizar planes de acción en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional o para la asignación de los permisos necesarios, si corresponde. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "¡Actualizar plan de acción !",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que intenta actualizar no existe o ha sido eliminado previamente. Para regresar al listado general de planes de acción, presione continuar en la parte inferior de este mensaje. ",
    "edit-success-title" => "¡Plan de acción actualizado exitosamente!",
    "edit-success-message" => "Los datos del plan de acción se <b>actualizaron exitosamente</b>. Para regresar al listado general de planes de acción, presione el botón continuar en la parte inferior de este mensaje.",
    // - Plans deleter
    // - Plans deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para eliminar planes de acción  en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar plan de acción !",
    "delete-message" => "Para confirmar la eliminación del plan de acción <b>%s</b>, presioné eliminar, para retornar al listado general de planes de acción  presioné cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "\El elemento que intenta eliminar no existe o se elimino previamente, para retornar al listado general de planes de acción  presioné continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡Plan de acción eliminado exitosamente!",
    "delete-success-message" => "El plan de acción se elimino exitosamente, para retornar al listado de general de planes de acción  presioné el botón continuar en la parte inferior de este mensaje.",
    "status-no-actions-title" => "Recuerde",
    "status-no-actions-message" => "Debe registrar como mínimo una acción para este plan de acción.",
    "status-pendding-title" => "Plan pendiente de aprobación",
    "status-pendding-message" => "Este plan se encuentra diligenciado en su totalidad y esta listo para solicitar su aprobación.",
    "status-team-noprocess-title" => "Advertencia",
    "status-team-noprocess-message" => "Para realizar la selección del equipo de trabajo, estos deben estar registrados dentro del Módulo Organización, en su respectivo cargo, no se ha parametrizado los procesos del Módulo Organización. ",
    "status-formulation-nocauses-title" => "Recuerde",
    "status-formulation-nocauses-message" => "Un plan no puede ser formulado sin análisis de causas. Diligencie el análisis de causas y determine la mayor causa probable y sus porques para continuar. ",
    "status-noformulation-title" => "Recuerde",
    "status-noformulation-message" => "No es posible generar acciones sin haber formulado el plan previamente. Por favor formule el plan para proceder a crear las acciones correspondientes.",
    //Approval
    "approval-success-message" => "La solicitud de aprobación se registró correctamente, a partir de este momento la formulación del plan y sus acciones asociadas no podrán modificarse exceptuando que el plan sea rechazado y se deban aplicar correctivos en su formulación o acciones. Al ser aprobado o rechazado el plan de acción le será generada una notificación automática con los pormenores del procedimiento.",
    //Evaluate
    "status-evaluate-title" => "Solicitud de evaluación",
    "status-evaluate-message" => "Usted va a solicitar la aprobación de este plan de acción, lo cual indica que el plan se encuentra totalmente diligenciado y ahora usted lo presenta para validar su completa ejecución. A partir de este momento no podrá realizar modificación alguna al contenido del plan a excepción del que el plan sea rechazado. Se generara una notificación automática en caso de Aprobación o Rechazo.",
    //Evaluation
    "status-evaluation-title" => "Plan en Evaluación",
    "status-evaluation-message" => "El presente formulario le permite evaluar el Cumplimiento o NO cumplimiento del plan de acción seleccionado, una vez calificado como cumplido, la plataforma conmutará automáticamente la calificación propuesta en este, en caso contrario, si usted rechaza el plan como NO cumplido, se le generará una notificación automática al responsable del mismo",
    "status-pending-title-not-actions" => "Advertencia",
    "status-pending-message-not-actions" => "El plan de acción no posee acciones registradas.",
    "list-alert-title" => "¡Recuerde!",
    "list-alert-message" => "El presente listado corresponde al listado general de planes de esta actividad.",
    "list-title" => "Listado de planes de acción",
];

?>