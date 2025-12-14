<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-07-08 09:29:12
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Orders\Items\Creator\index.php]
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
    // - Orders fields
    "label_item" => "Código del ítem",
    "label_order" => "Código de la factura",
    "label_type" => "Tipo de ítem",
    "label_value" => "Valor",
    "label_amount" => "Cantidad",
    "label_description" => "Descripción",
    "label_percentage" => "Porcentaje",
    "label_author" => "Autor",
    "label_created_at" => "Fecha de Creación",
    "label_updated_at" => "Fecha de Actualización",
    "label_deleted_at" => "Fecha de Eliminación",
    "placeholder_item" => "Ítem",
    "placeholder_order" => "Orden",
    "placeholder_type" => "Tipo",
    "placeholder_value" => "Valor",
    "placeholder_amount" => "Cantidad",
    "placeholder_description" => "Descripción",
    "placeholder_percentage" => "Porcentaje",
    "placeholder_author" => "Autor",
    "placeholder_created_at" => "Fecha de creación",
    "placeholder_updated_at" => "Fecha de actualización",
    "placeholder_deleted_at" => "Fecha de eliminación",
    "help_item" => "Ítem",
    "help_order" => "Orden",
    "help_type" => "Tipo",
    "help_value" => "Valor",
    "help_amount" => "Cantidad",
    "help_description" => "Descripción",
    "help_percentage" => "Porcentaje",
    "help_author" => "Autor",
    "help_created_at" => "Fecha de creación",
    "help_updated_at" => "Fecha de actualización",
    "help_deleted_at" => "Fecha de eliminación",
    // - Orders creator
    "create-denied-title" => "¡Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevos ítems. Por favor, póngase en contacto con el administrador del sistema o con el personal de soporte técnico para que le sean asignados los permisos necesarios, según sea el caso. Para continuar, presione la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nuevo ítem",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "create-duplicate-title" => "¡Ítem existente!",
    "create-duplicate-message" => "Este ítem ya se había registrado previamente. Presione continuar en la parte inferior de este mensaje para retornar al listado general de ítems.",
    "create-success-title" => "¡Ítem registrado exitosamente!",
    "create-success-message" => "El ítem se registró exitosamente. Para retornar al listado general de ítems, presione continuar en la parte inferior de este mensaje.",
    // - Orders viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para visualizar ítems en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional o la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Vista",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "",
    "view-success-title" => "",
    "view-success-message" => "",
    // - Orders editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para actualizar ítems en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional o la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "¡Actualizar ítem!",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que intenta actualizar no existe o se eliminó previamente. Para retornar al listado general de ítems, presione continuar en la parte inferior de este mensaje.",
    "edit-success-title" => "¡Ítem actualizado!",
    "edit-success-message" => "Los datos del ítem se <b>actualizaron exitosamente</b>. Para retornar al listado general de ítems, presione el botón continuar en la parte inferior del presente mensaje.",
    // - Orders deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para eliminar ítems en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional o la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar ítem!",
    "delete-message" => "Para confirmar la eliminación del ítem <b>%s</b>, presione eliminar. Para retornar al listado general de ítems, presione cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "El elemento que intenta eliminar no existe o se eliminó previamente. Para retornar al listado general de ítems, presione continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡Ítem eliminado exitosamente!",
    "delete-success-message" => "El ítem se eliminó exitosamente. Para retornar al listado general de ítems, presione el botón continuar en la parte inferior de este mensaje.",
    // - Orders list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para acceder al listado general de ítems en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional o la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Listado de ítems",
];

?>