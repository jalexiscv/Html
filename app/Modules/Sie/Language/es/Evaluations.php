<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-08-05 12:35:23
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Evaluations\Creator\index.php]
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
    // - Evaluations fields 
    "label_evaluation" => "Evaluación",
    "label_type" => "Tipo",
    "label_teacher" => "Profesor",
    "label_q1" => "Coherencia del título del proyecto con el módulo elegido.",
    "label_q2" => "Coherencia del objetivo general con el título del proyecto.",
    "label_q3" => "Desarrollo del objetivo general con los objetivos específicos postulados.",
    "label_q4" => "Lista de actividades en relación con el logro de los objetivos específicos.",
    "label_q5" => "Metas del proyecto alineadas con el módulo elegido para el proyecto.",
    "label_q6" => "Coherencia de la propuesta de evaluación del proyecto.",
    "label_q7" => "Actividades de participación de los estudiantes en el proyecto.",
    "label_q8" => "Desarrollo de la presentación para avanzar aspectos claves del proyecto.",
    "label_q9" => "Medios usados para la presentación y sustentación de la utilidad.",
    "label_q10" => "q10",
    "label_author" => "Autor",
    "label_date" => "Fecha",
    "label_time" => "Hora",
    "label_created_at" => "Creado en",
    "label_updated_at" => "Actualizado en",
    "label_deleted_at" => "Eliminado en",
    "placeholder_evaluation" => "Evaluación",
    "placeholder_type" => "Tipo",
    "placeholder_teacher" => "Profesor",
    "placeholder_q1" => "q1",
    "placeholder_q2" => "q2",
    "placeholder_q3" => "q3",
    "placeholder_q4" => "q4",
    "placeholder_q5" => "q5",
    "placeholder_q6" => "q6",
    "placeholder_q7" => "q7",
    "placeholder_q8" => "q8",
    "placeholder_q9" => "q9",
    "placeholder_q10" => "q10",
    "placeholder_author" => "Autor",
    "placeholder_date" => "Fecha",
    "placeholder_time" => "Hora",
    "placeholder_created_at" => "Creado en",
    "placeholder_updated_at" => "Actualizado en",
    "placeholder_deleted_at" => "Eliminado en",
    "help_evaluation" => "Evaluación",
    "help_type" => "Tipo",
    "help_teacher" => "Profesor",
    "help_q1" => "q1",
    "help_q2" => "q2",
    "help_q3" => "q3",
    "help_q4" => "q4",
    "help_q5" => "q5",
    "help_q6" => "q6",
    "help_q7" => "q7",
    "help_q8" => "q8",
    "help_q9" => "q9",
    "help_q10" => "q10",
    "help_author" => "Autor",
    "help_date" => "Fecha",
    "help_time" => "Hora",
    "help_created_at" => "Creado en",
    "help_updated_at" => "Actualizado en",
    "help_deleted_at" => "Eliminado en",
    // - Evaluations creator 
    "create-denied-title" => "¡Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevos evaluaciones. Por favor, póngase en contacto con el administrador del sistema o con el personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar, presione la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nueva evaluación",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifíquelos e inténtelo nuevamente.",
    "create-duplicate-title" => "¡Evaluación existente!",
    "create-duplicate-message" => "Esta evaluación ya se había registrado previamente. Presione continuar en la parte inferior de este mensaje para retornar al listado general de evaluaciones.",
    "create-success-title" => "¡Evaluación registrada exitosamente!",
    "create-success-message" => "La evaluación se registró exitosamente. Para retornar al listado general de evaluaciones, presione continuar en la parte inferior de este mensaje.",
    // - Evaluations viewer 
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para visualizar evaluaciones en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Vista",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifíquelos e inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "",
    "view-success-title" => "",
    "view-success-message" => "",
    // - Evaluations editor 
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para actualizar evaluaciones en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "¡Actualizar evaluación!",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifíquelos e inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que intenta actualizar no existe o se eliminó previamente. Para retornar al listado general de evaluaciones, presione continuar en la parte inferior de este mensaje.",
    "edit-success-title" => "¡Evaluación actualizada!",
    "edit-success-message" => "Los datos de la evaluación se <b>actualizaron exitosamente</b>. Para retornar al listado general de evaluaciones, presione el botón continuar en la parte inferior de este mensaje.",
    // - Evaluations deleter 
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para eliminar evaluaciones en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar evaluación!",
    "delete-message" => "Para confirmar la eliminación de la evaluación <b>%s</b>, presione eliminar. Para retornar al listado general de evaluaciones, presione cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifíquelos e inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "El elemento que intenta eliminar no existe o se eliminó previamente. Para retornar al listado general de evaluaciones, presione continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡Evaluación eliminada exitosamente!",
    "delete-success-message" => "La evaluación se eliminó exitosamente. Para retornar al listado general de evaluaciones, presione el botón continuar en la parte inferior de este mensaje.",
    // - Evaluations list 
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para acceder al listado general de evaluaciones en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Listado de evaluaciones",
];


?>