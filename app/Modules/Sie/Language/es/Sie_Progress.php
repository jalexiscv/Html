<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-08-13 07:26:04
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Progress\Creator\index.php]
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
    // - Progress fields
    "label_progress" => "Progreso",
    "label_enrollment" => "Matrícula",
    "label_program" => "Programa",
    "label_grid" => "Malla",
    "label_pensum" => "Pensum",
    "label_version" => "Versión",
    "label_module" => "Módulo",
    "label_period" => "Periodo",
    "label_status" => "Estado",
    "label_last_calification" => "Calificación final", // Corrección: "Calificación"
    "label_c1" => "Unidad de Competencia #1",
    "label_c2" => "Unidad de Competencia #2",
    "label_c3" => "Unidad de Competencia #3",
    "label_last_course" => "Último Curso",
    "label_last_author" => "Último Autor",
    "label_last_date" => "Última Fecha",
    "label_author" => "Autor",
    "label_created_at" => "Fecha de Creación",
    "label_updated_at" => "Fecha de Actualización",
    "label_deleted_at" => "Fecha de Eliminación",
    "label_module_name" => "Nombre del Módulo",
    "placeholder_progress" => "Progreso",
    "placeholder_enrollment" => "Matrícula",
    "placeholder_module" => "Módulo",
    "placeholder_status" => "Estado",
    "placeholder_last_calification" => "0", // Corrección: "Calificación"

    "placeholder_c1" => "0",
    "placeholder_c2" => "0",
    "placeholder_c3" => "0",

    "placeholder_last_course" => "Último Curso",
    "placeholder_last_author" => "Último Autor",
    "placeholder_last_date" => "Última Fecha",
    "placeholder_author" => "Autor",
    "placeholder_created_at" => "Fecha de Creación",
    "placeholder_updated_at" => "Fecha de Actualización",
    "placeholder_deleted_at" => "Fecha de Eliminación",

    "help_progress" => "Progreso",
    "help_enrollment" => "Matrícula",
    "help_module" => "Módulo",
    "help_status" => "Estado",
    "help_last_calification" => "Última Calificación", // Corrección: "Calificación"

    "help_period" => "Obligatorio",
    "help_c1" => "Calificación",
    "help_c2" => "Calificación",
    "help_c3" => "Calificación",

    "help_last_course" => "Último Curso",
    "help_last_author" => "Último Autor",
    "help_last_date" => "Última Fecha",
    "help_author" => "Autor",
    "help_created_at" => "Fecha de Creación",
    "help_updated_at" => "Fecha de Actualización",
    "help_deleted_at" => "Fecha de Eliminación",
    "help_module_name" => "Nombre del módulo base",
    "help_pensum" => "Pensum",
    // - Progress creator
    "create-denied-title" => "Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevos progresos, por favor póngase en contacto con el administrador del sistema o en su efecto contacte al personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar presioné la opción correspondiente en la parte inferior de este mensaje.", // Corrección: "progresos"
    "create-title" => "Crear nuevo progreso",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique e inténtelo nuevamente.", // Corrección: "e" en lugar de "eh"
    "create-duplicate-title" => "¡Progreso existente!", // Corrección: "Progreso"
    "create-duplicate-message" => "Este progreso ya se había registrado previamente, presione continuar en la parte inferior de este mensaje para retornar al listado general de progresos.", // Corrección: "progresos"
    "create-success-title" => "¡Progreso registrado exitosamente!", // Corrección: "Progreso"
    "create-success-message" => "El progreso se registró exitosamente, para retornar al listado general de progresos presione continuar en la parte inferior de este mensaje.", // Corrección: "El progreso" y "progresos"
    // - Progress viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para visualizar progresos en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.", // Corrección: "progresos"
    "view-title" => "Vista",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique e inténtelo nuevamente.", // Corrección: "e" en lugar de "eh"
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "El progreso que intenta visualizar no existe o se eliminó previamente.", // Corrección: Mensaje más descriptivo
    "view-success-title" => "", //  No es necesario un título para el éxito en la vista
    "view-success-message" => "", // No es necesario un mensaje para el éxito en la vista
    // - Progress editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para actualizar progresos en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.", // Corrección: "progresos"
    "edit-title" => "¡Actualizar progreso!",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique e inténtelo nuevamente.", // Corrección: "e" en lugar de "eh"
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que intenta actualizar no existe o se eliminó previamente, para retornar al listado general de progresos presione continuar en la parte inferior de este mensaje. ", // Corrección: "progresos"
    "edit-success-title" => "¡Progreso actualizado!",
    "edit-success-message" => "Los datos del progreso se <b>actualizaron exitosamente</b>, para retornar al listado general de progresos presione el botón continuar en la parte inferior del presente mensaje.", // Corrección: "del progreso" y "progresos"
    // - Progress deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para eliminar progresos en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.", // Corrección: "progresos"
    "delete-title" => "¡Eliminar progreso!",
    "delete-message" => "Para confirmar la eliminación del progreso <b>%s</b>, presione eliminar, para retornar al listado general de progresos presione cancelar.", // Corrección: "progresos"
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique e inténtelo nuevamente.", // Corrección: "e" en lugar de "eh"
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "El elemento que intenta eliminar no existe o se eliminó previamente, para retornar al listado general de progresos presione continuar en la parte inferior de este mensaje.", // Corrección: "progresos" y se eliminó la "\" extra
    "delete-success-title" => "¡Progreso eliminado exitosamente!", // Corrección: "eliminado"
    "delete-success-message" => "El progreso se eliminó exitosamente, para retornar al listado general de progresos presione el botón continuar en la parte inferior de este mensaje.", // Corrección: "El progreso" y "progresos"
    // - Progress list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para acceder al listado general de progresos en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.", // Corrección: "progresos"
    "list-title" => "Listado de módulos en progreso",
    "info-list-title" => "Recuerde",
    "info-list-message" => "En esta sección se listan los módulos en progreso del estudiante seleccionado y en la matricula especifica consultada, para visualizar los detalles de cada módulo recuerde las siguientes de abreviaturas. <b>CA</b>=Créditos Académicos, <b>UC</b>=Ultima Calificación. Si desea acceder a la prematricula para este estudiante por favor use el correspondiente boton en la parte inferior a este mensaje. ",
    // - Deleted denied
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Este módulo no puede ser eliminado de la matrícula, ya que contiene calificaciones y otros datos asociados al historial académico del estudiante.", // Corrección: "progresos"
];

?>