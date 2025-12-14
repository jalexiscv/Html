<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-07-14 04:22:15
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Institutions\Creator\index.php]
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
    // - Institutions fields
    "label_institution" => "Código de la institución",
    "label_parent" => "Principal",
    "label_name" => "Nombre legible",
    "label_description" => "Descripción",
    "label_address" => "Dirección",
    "label_phone" => "Teléfono",
    "label_email" => "Correo electrónico",
    "label_author" => "author",
    "label_created_at" => "created_at",
    "label_updated_at" => "updated_at",
    "label_deleted_at" => "deleted_at",
    "placeholder_institution" => "institution",
    "placeholder_parent" => "parent",
    "placeholder_name" => "name",
    "placeholder_description" => "description",
    "placeholder_address" => "address",
    "placeholder_phone" => "phone",
    "placeholder_email" => "email",
    "placeholder_author" => "author",
    "placeholder_created_at" => "created_at",
    "placeholder_updated_at" => "updated_at",
    "placeholder_deleted_at" => "deleted_at",
    "help_institution" => "institution",
    "help_parent" => "parent",
    "help_name" => "name",
    "help_description" => "description",
    "help_address" => "address",
    "help_phone" => "phone",
    "help_email" => "email",
    "help_author" => "author",
    "help_created_at" => "created_at",
    "help_updated_at" => "updated_at",
    "help_deleted_at" => "deleted_at",

    // - Institutions creator
    "create-denied-title" => "¡Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevas instituciones. Por favor, póngase en contacto con el administrador del sistema o con el personal de soporte técnico para que le sean asignados los permisos necesarios. Para continuar, presione la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nueva institución",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "create-duplicate-title" => "¡Institución existente!",
    "create-duplicate-message" => "Esta institución ya ha sido registrada previamente. Presione continuar en la parte inferior de este mensaje para regresar al listado general de instituciones.",
    "create-success-title" => "¡Institución registrada exitosamente!",
    "create-success-message" => "La institución se registró exitosamente. Para regresar al listado general de instituciones, presione continuar en la parte inferior de este mensaje.",

    // - Institutions viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para visualizar instituciones en esta plataforma. Contacte al departamento de soporte técnico para más información o para la asignación de los permisos necesarios. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Institución: %s",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "La institución que intenta ver no existe o ha sido eliminada previamente. Para regresar al listado general de instituciones, presione continuar en la parte inferior de este mensaje.",
    "view-success-title" => "¡Vista exitosa!",
    "view-success-message" => "La institución se ha visualizado correctamente.",

    // - Institutions editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para actualizar instituciones en esta plataforma. Contacte al departamento de soporte técnico para más información o para la asignación de los permisos necesarios. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "Actualizar institución",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que intenta actualizar no existe o ha sido eliminado previamente. Para regresar al listado general de instituciones, presione continuar en la parte inferior de este mensaje.",
    "edit-success-title" => "¡Institución actualizada!",
    "edit-success-message" => "Los datos de la institución se han <b>actualizado exitosamente</b>. Para regresar al listado general de instituciones, presione el botón continuar en la parte inferior de este mensaje.",

    // - Institutions deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para eliminar instituciones en esta plataforma. Contacte al departamento de soporte técnico para más información o para la asignación de los permisos necesarios. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "Eliminar institución",
    "delete-message" => "Para confirmar la eliminación de la institución <b>%s</b>, presione eliminar. Para regresar al listado general de instituciones, presione cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "El elemento que intenta eliminar no existe o ha sido eliminado previamente. Para regresar al listado general de instituciones, presione continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡Institución eliminada exitosamente!",
    "delete-success-message" => "La institución se ha eliminado exitosamente. Para regresar al listado general de instituciones, presione el botón continuar en la parte inferior de este mensaje.",

    // - Institutions list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para acceder al listado general de instituciones en esta plataforma. Contacte al departamento de soporte técnico para más información o para la asignación de los permisos necesarios. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Listado de instituciones",
    "list-description" => "Este listado incluye todas las instituciones y sedes donde la entidad ofrece sus productos y servicios. No se refiere exclusivamente a instituciones educativas, sino que también abarca empresas y sedes contratantes de servicios a través de convenios y/o acuerdos similares.",
];


?>