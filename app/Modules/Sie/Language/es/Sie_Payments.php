<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-06-20 06:59:26
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Payments\Creator\index.php]
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
    // - Payments fields
    "label_payment" => "Código del pago",
    "label_record_type" => "record_type",
    "label_agreement" => "agreement",
    "label_id_number" => "Numero de Identificación",
    "label_ticket" => "Numero del Ticket(Factura)",
    "label_value" => "Valor",
    "label_description" => "Descripción del pago",
    "label_payment_origin" => "Origen del pago",
    "label_payment_methods" => "Métodos de pago",
    "label_operation_number" => "Numero de operación",
    "label_authorization" => "authorization",
    "label_financial_entity" => "financial_entity",
    "label_branch" => "branch",
    "label_sequence" => "sequence",
    "label_created_at" => "created_at",
    "label_updated_at" => "updated_at",
    "label_deleted_at" => "deleted_at",
    "placeholder_payment" => "payment",
    "placeholder_record_type" => "record_type",
    "placeholder_agreement" => "agreement",
    "placeholder_id_number" => "Ejemplo: 1234567890",
    "placeholder_ticket" => "Ejemplo: 1234567890",
    "placeholder_value" => "Ejemplo: 91000",
    "placeholder_payment_origin" => "payment_origin",
    "placeholder_payment_methods" => "payment_methods",
    "placeholder_operation_number" => "operation_number",
    "placeholder_authorization" => "authorization",
    "placeholder_financial_entity" => "financial_entity",
    "placeholder_branch" => "branch",
    "placeholder_sequence" => "sequence",
    "placeholder_description" => "Ejemplo: Pago de matricula por Servientrega",
    "placeholder_created_at" => "created_at",
    "placeholder_updated_at" => "updated_at",
    "placeholder_deleted_at" => "deleted_at",
    "help_payment" => "payment",
    "help_record_type" => "record_type",
    "help_agreement" => "agreement",
    "help_id_number" => "id_number",
    "help_ticket" => "ticket",
    "help_value" => "value",
    "help_payment_origin" => "payment_origin",
    "help_payment_methods" => "payment_methods",
    "help_operation_number" => "operation_number",
    "help_authorization" => "authorization",
    "help_financial_entity" => "financial_entity",
    "help_branch" => "branch",
    "help_sequence" => "sequence",
    "help_created_at" => "created_at",
    "help_updated_at" => "updated_at",
    "help_deleted_at" => "deleted_at",
    // - Payments creator
    "create-denied-title" => "Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevos pagos, por favor póngase en contacto con el administrador del sistema o en su efecto contacte al personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar presioné la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nuevo pago",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "create-duplicate-title" => "¡pago existente!",
    "create-duplicate-message" => "Este pago ya se había registrado previamente, presioné continuar en la parte inferior de este mensaje para retornar al listado general de pagos.",
    "create-success-title" => "¡pago registrada exitosamente!",
    "create-success-message" => "La pago se registró exitosamente, para retornar al listado general de pagos presioné continuar en la parte inferior de este mensaje.",
    // - Payments viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para visualizar pagos en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Vista",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "",
    "view-success-title" => "",
    "view-success-message" => "",
    // - Payments editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para actualizar pagos en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "¡Actualizar pago!",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que actualizar no existe o se elimino previamente, para retornar al listado general de pagos presioné continuar en la parte inferior de este mensaje. ",
    "edit-success-title" => "¡pago actualizada!",
    "edit-success-message" => "Los datos de pago se <b>actualizaron exitosamente</b>, para retornar al listado general de pagos presioné el botón continuar en la parte inferior del presente mensaje.",
    // - Payments deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para eliminar pagos en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar pago!",
    "delete-message" => "Para confirmar la eliminación del pago <b>%s</b>, presioné eliminar, para retornar al listado general de pagos presioné cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "\El elemento que intenta eliminar no existe o se elimino previamente, para retornar al listado general de pagos presioné continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡#Singular eliminad@ exitosamente!",
    "delete-success-message" => "La pago se elimino exitosamente, para retornar al listado de general de pagos presioné el botón continuar en la parte inferior de este mensaje.",
    // - Payments list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para acceder al listado general de pagos en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Listado de pagos",
    "list-message" => "En esta sección se listan todos los pagos registrados en la plataforma, para crear un nuevo pago presioné el botón correspondiente en la parte superior derecha de este mensaje.",
];

?>