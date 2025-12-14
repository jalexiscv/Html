<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-10-18 00:19:31
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Executions\Creator\index.php]
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
    // - Executions fields
    "label_execution" => "Código de ejecución",
    "label_progress" => "Código de progreso",
    "label_course" => "Código de curso",
    "label_date_start" => "Fecha de inicio",
    "label_date_end" => "Fecha de finalización",
    "label_c1" => "C1",
    "label_c2" => "C2",
    "label_c3" => "C3",
    "label_total" => "Total",
    "label_author" => "Autor",
    "label_created_at" => "Creado el",
    "label_updated_at" => "Actualizado el",
    "label_deleted_at" => "Eliminado el",
    "label_includemoodle" => "Eliminar del Campus (Moodle)",
    "label_fullname"=>"Nombre completo",
    "placeholder_execution" => "Código de ejecución",
    "placeholder_progress" => "Código de progreso",
    "placeholder_course" => "Código de curso",
    "placeholder_date_start" => "Fecha de inicio",
    "placeholder_date_end" => "Fecha de finalización",
    "placeholder_total" => "0.0",
    "placeholder_author" => "Autor",
    "placeholder_created_at" => "Creado el",
    "placeholder_updated_at" => "Actualizado el",
    "placeholder_deleted_at" => "Eliminado el",
    "help_execution" => "Código de ejecución",
    "help_progress" => "Código de progreso",
    "help_course" => "Código de curso",
    "help_date_start" => "Fecha de inicio",
    "help_date_end" => "Fecha de finalización",
    "help_calification_total" => "Calificación total",
    "help_c1" => "C1",
    "help_c2" => "C2",
    "help_c3" => "C3",
    "help_total" => "Calificación",
    "help_author" => "Autor",
    "help_created_at" => "Creado el",
    "help_updated_at" => "Actualizado el",
    "help_deleted_at" => "Eliminado el",
    "help_includemoodle" => "En caso de seleccionar si, el alumno sera eliminado del curso en el moodle",
    // - Executions creator
    "create-denied-title" => "¡Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevas calificaciones. Por favor, póngase en contacto con el administrador del sistema o con el personal de soporte técnico para que le asignen los permisos necesarios, según sea el caso. Para continuar, presione la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nueva calificación",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifíquelos e inténtelo nuevamente.",
    "create-duplicate-title" => "¡Calificación existente!",
    "create-duplicate-message" => "Esta calificación ya se había registrado previamente. Presione continuar en la parte inferior de este mensaje para retornar al listado general de calificaciones.",
    "create-success-title" => "¡Calificación registrada exitosamente!",
    "create-success-message" => "La calificación se registró exitosamente. Para retornar al listado general de calificaciones, presione continuar en la parte inferior de este mensaje.",
    // - Executions viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para visualizar calificaciones en esta plataforma. Contacte al departamento de soporte técnico para información adicional o para la asignación de permisos si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Vista",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifíquelos e inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "El elemento que intenta visualizar no existe o fue eliminado previamente.",
    "view-success-title" => "¡Éxito!",
    "view-success-message" => "Los datos se visualizaron correctamente.",
    // - Executions editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para actualizar calificaciones en esta plataforma. Contacte al departamento de soporte técnico para más información o para la asignación de permisos. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "Actualizar calificación",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifíquelos e inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que intenta actualizar no existe o fue eliminado previamente. Para retornar al listado general de calificaciones, presione continuar en la parte inferior de este mensaje.",
    "edit-success-title" => "¡Calificación actualizada!",
    "edit-success-message" => "Los datos de la calificación se actualizaron exitosamente. Para retornar al listado general de calificaciones, presione el botón continuar en la parte inferior de este mensaje.",
    // - Executions deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para eliminar calificaciones en esta plataforma. Contacte al departamento de soporte técnico para más información o para la asignación de permisos. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "Eliminar calificación",
    "delete-message" => "Para confirmar la eliminación de la calificación <b>%s</b>, presione eliminar. Para retornar al listado general de calificaciones, presione cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifíquelos e inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "El elemento que intenta eliminar no existe o fue eliminado previamente. Para retornar al listado general de calificaciones, presione continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡Calificación eliminada exitosamente!",
    "delete-success-message" => "La calificación fue eliminada exitosamente. Para retornar al listado general de calificaciones, presione el botón continuar en la parte inferior de este mensaje.",
    // - Executions list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para acceder al listado general de calificaciones en esta plataforma. Contacte al departamento de soporte técnico para más información o para la asignación de permisos. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Listado de calificaciones",
    "observations-title" => "Observaciones",
    "course-execution-create-title" => "Registro Directo",
    "course-execution-alert-title" => "Recuerde",
    "course-execution-alert-message" => "Está intentando registrar un estudiante directamente en este curso. Presione Confirmar para continuar o Cancelar para volver a la vista general del curso.",
    "course-inexecution-alert-title" => "Denegado",
    "course-inexecution-alert-message" => "No puede registrar el estudiante directamente en este curso ya que se encuentra cursando el modulo en un curso diferente.",
    "course-approved-alert-title" => "Aprobado",
    "course-approved-alert-message" => "Este módulo ya fue aprobado por el estudiante. No es posible volver a matricularlo en un curso con el mismo módulo base.",
    "course-execution-create-success-message" => "El estudiante ha sido registrado directamente en el curso. Para regresar al curso, presione la opción Continuar en la parte inferior de este mensaje.",
    //Extras

];

?>