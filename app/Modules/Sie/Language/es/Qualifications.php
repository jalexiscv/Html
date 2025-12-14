<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-08-02 18:24:32
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Qualifications\Creator\index.php]
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
    // - Qualifications fields
    "label_qualification" => "Calificación",
    "label_teacher" => "Profesor",
    "label_score" => "Puntaje",
    "label_weighting" => "Ponderación",
    "label_author" => "Autor",
    "label_created_at" => "Creado el",
    "label_update_at" => "Actualizado el",
    "label_delete_at" => "Eliminado el",
    "placeholder_qualification" => "Ingrese la calificación",
    "placeholder_teacher" => "Seleccione el profesor",
    "placeholder_score" => "Ingrese el puntaje",
    "placeholder_weighting" => "Ingrese la ponderación",
    "placeholder_author" => "Seleccione el autor",
    "placeholder_created_at" => "Fecha de creación",
    "placeholder_update_at" => "Fecha de actualización",
    "placeholder_delete_at" => "Fecha de eliminación",
    "help_qualification" => "Información sobre la calificación",
    "help_teacher" => "Información sobre el profesor",
    "help_score" => "Información sobre el puntaje",
    "help_weighting" => "Información sobre la ponderación",
    "help_author" => "Información sobre el autor",
    "help_created_at" => "Información sobre la fecha de creación",
    "help_update_at" => "Información sobre la fecha de actualización",
    "help_delete_at" => "Información sobre la fecha de eliminación",
    // - Qualifications creator
    "create-denied-title" => "¡Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevos #plural. Por favor, póngase en contacto con el administrador del sistema o con el personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar, presione la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nueva calificación",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "create-duplicate-title" => "¡Calificación existente!",
    "create-duplicate-message" => "Esta calificación ya se había registrado previamente. Presione continuar en la parte inferior de este mensaje para retornar al listado general de #plural.",
    "create-success-title" => "¡Calificación registrada exitosamente!",
    "create-success-message" => "La calificación se registró exitosamente. Para retornar al listado general de #plural, presione continuar en la parte inferior de este mensaje.",
    // - Qualifications viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para visualizar #plural en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional o la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Ver calificación",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "La calificación solicitada no existe o ha sido eliminada.",
    "view-success-title" => "Detalles de la calificación",
    "view-success-message" => "A continuación se muestran los detalles de la calificación seleccionada.",
    // - Qualifications editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para actualizar #plural en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional o la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "¡Actualizar calificación!",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que desea actualizar no existe o se eliminó previamente. Para retornar al listado general de #plural, presione continuar en la parte inferior de este mensaje.",
    "edit-success-title" => "¡Calificación actualizada!",
    "edit-success-message" => "Los datos de la calificación se <b>actualizaron exitosamente</b>. Para retornar al listado general de #plural, presione el botón continuar en la parte inferior del presente mensaje.",
    // - Qualifications deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para eliminar #plural en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional o la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar calificación!",
    "delete-message" => "Para confirmar la eliminación de la calificación <b>%s</b>, presione eliminar. Para retornar al listado general de #plural, presione cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "El elemento que intenta eliminar no existe o se eliminó previamente. Para retornar al listado general de #plural, presione continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡Calificación eliminada exitosamente!",
    "delete-success-message" => "La calificación se eliminó exitosamente. Para retornar al listado general de #plural, presione el botón continuar en la parte inferior de este mensaje.",
    // - Qualifications list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para acceder al listado general de #plural en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional o la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Listado de #plural",
];

?>