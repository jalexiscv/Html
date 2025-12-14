<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Wallet\Views\Transactions\Creator\index.php]
*  ╩ ╩╝╚╝╚═╝╚═╝╩╚═╝╩═╝╚═╝
* -----------------------------------------------------------------------------
* Copyright 2021 - Higgs Bigdata S.A.S., Inc. <admin@Higgs.com>
* Este archivo es parte de Higgs Bigdata Framework 7.1
* Para obtener información completa sobre derechos de autor y licencia, consulte
* la LICENCIA archivo que se distribuyó con este código fuente.
* -----------------------------------------------------------------------------
* EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
* IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
* APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
* LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
* RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
* AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
* O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
* -----------------------------------------------------------------------------
* @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
* @link https://www.Higgs.com
* @Version 1.5.0
* @since PHP 7, PHP 8
* -----------------------------------------------------------------------------
* Datos recibidos desde el controlador - @ModuleController
* -----------------------------------------------------------------------------
* @Authentication
* @request
* @dates
* @view
* @oid
* @component
* @views
* @prefix
* @parent
* -----------------------------------------------------------------------------
* El código resultante corresponde con los elementos parciales del vector de 
* lenguaje utilizado para traducir la interface del módulo, estos elementos se deben copiar 
* y pegar en el archivo de traducción modular según corresponda, teniendo por finalidad 
* acelerar el proceso de programación al servir como una plantilla base para las posibles 
* cadenas de lenguaje y traducción asociadas a la creación de los formatos de visualización, 
* creación, edición y eliminación de componentes puntuales.* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
return [
    // - Transactions fields
    "label_transaction" => "Código de la transacción",
    "label_module" => "Modulo",
    "label_user" => "Usuario",
    "label_reference" => "Referencia(transacción bancaria)",
    "label_description" => "description",
    "label_currency" => "Moneda",
    "label_debit" => "Debito",
    "label_credit" => "Credito",
    "label_balance" => "Balance",
    "label_status" => "Estado de la transacción",
    "label_author" => "author",
    "label_created_at" => "created_at",
    "label_updated_at" => "updated_at",
    "label_deleted_at" => "deleted_at",
    "placeholder_transaction" => "transaction",
    "placeholder_module" => "module",
    "placeholder_user" => "Ej: 000000000000",
    "placeholder_reference" => "Ej: 000000000000",
    "placeholder_description" => "description",
    "placeholder_currency" => "currency",
    "placeholder_debit" => "Ej: 0",
    "placeholder_credit" => "Ej: 0",
    "placeholder_balance" => "Ej: 0",
    "placeholder_status" => "status",
    "placeholder_author" => "author",
    "placeholder_created_at" => "created_at",
    "placeholder_updated_at" => "updated_at",
    "placeholder_deleted_at" => "deleted_at",
    "help_transaction" => "transaction",
    "help_module" => "module",
    "help_user" => "Código del usuario",
    "help_reference" => "reference",
    "help_description" => "description",
    "help_currency" => "currency",
    "help_debit" => "debit",
    "help_credit" => "credit",
    "help_balance" => "balance",
    "help_status" => "status",
    "help_author" => "author",
    "help_created_at" => "created_at",
    "help_updated_at" => "updated_at",
    "help_deleted_at" => "deleted_at",
    // - Transactions creator
    "create-denied-title" => "Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevos transactions, por favor póngase en contacto con el administrador del sistema o en su efecto contacte al personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar presioné la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nueva transacción",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "create-duplicate-title" => "¡transactions existente!",
    "create-duplicate-message" => "Este transactions ya se había registrado previamente, presioné continuar en la parte inferior de este mensaje para retornar al listado general de transactions.",
    "create-success-title" => "¡transactions registrada exitosamente!",
    "create-success-message" => "La transactions se registró exitosamente, para retornar al listado general de transactions presioné continuar en la parte inferior de este mensaje.",
    // - Transactions viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para transactions en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "",
    "view-errors-title" => "",
    "view-errors-message" => "",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "",
    "view-success-title" => "",
    "view-success-message" => "",
    // - Transactions editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para actualizar ABCDE en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "¡Actualizar transactions!",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que actualizar no existe o se elimino previamente, para retornar al listado general de XXX presioné continuar en la parte inferior de este mensaje. ",
    "edit-success-title" => "¡transactions actualizada!",
    "edit-success-message" => "Los datos de transactions se <b>actualizaron exitosamente</b>, para retornar al listado general de transactions presioné el botón continuar en la parte inferior del presente mensaje.",
    // - Transactions deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para eliminar transactions en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar transactions!",
    "delete-message" => "Para confirmar la eliminación del transactions <b>%s</b>, presioné eliminar, para retornar al listado general de transactions presioné cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "\El elemento que intenta eliminar no existe o se elimino previamente, para retornar al listado general de XXX presioné continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡transactions eliminad@ exitosamente!",
    "delete-success-message" => "La transactions se elimino exitosamente, para retornar al listado de general de transactions presioné el botón continuar en la parte inferior de este mensaje.",
    // - Transactions list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para acceder al listado general de ABCDE en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Listado de transactions",
];

?>