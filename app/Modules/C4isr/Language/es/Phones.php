<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\teléfonos\Creator\index.php]
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
    // - teléfonos fields
    "label_phone" => "Código automático",
    "label_profile" => "Código del perfil",
    "label_country_code" => "Código del país",
    "label_area_code" => "Código de area",
    "label_local_number" => "Numero Local",
    "label_extension" => "Extensión",
    "label_type" => "Tipo de linea",
    "label_carrier" => "Operador",
    "label_normalized_number" => "Numero Normalizado",
    "label_author" => "author",
    "label_created_at" => "created_at",
    "label_updated_at" => "updated_at",
    "label_deleted_at" => "deleted_at",
    "placeholder_phone" => "phone",
    "placeholder_profile" => "profile",
    "placeholder_country_code_" => "country_code_",
    "placeholder_area_code_" => "area_code_",
    "placeholder_local_number_" => "local_number_",
    "placeholder_extension_" => "extension_",
    "placeholder_type_" => "type_",
    "placeholder_carrier_" => "carrier_",
    "placeholder_normalized_number" => "Ej: 573003000000",
    "placeholder_author" => "author",
    "placeholder_created_at" => "created_at",
    "placeholder_updated_at" => "updated_at",
    "placeholder_deleted_at" => "deleted_at",
    "help_phone" => "phone",
    "help_profile" => "profile",
    "help_country_code_" => "country_code_",
    "help_area_code_" => "area_code_",
    "help_local_number_" => "local_number_",
    "help_extension_" => "extension_",
    "help_type_" => "type_",
    "help_carrier_" => "carrier_",
    "help_normalized_number" => "Número completo(Requerido)",
    "help_author" => "author",
    "help_created_at" => "created_at",
    "help_updated_at" => "updated_at",
    "help_deleted_at" => "deleted_at",
    // - teléfonos creator
    "create-denied-title" => "Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevos teléfonos, por favor póngase en contacto con el administrador del sistema o en su efecto contacte al personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar presioné la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nuevo teléfonos",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "create-duplicate-title" => "¡teléfonos existente!",
    "create-duplicate-message" => "Este teléfonos ya se había registrado previamente, presioné continuar en la parte inferior de este mensaje para retornar al listado general de teléfonos.",
    "create-success-title" => "¡teléfonos registrada exitosamente!",
    "create-success-message" => "La teléfonos se registró exitosamente, para retornar al listado general de teléfonos presioné continuar en la parte inferior de este mensaje.",
    // - teléfonos viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para teléfonos en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Vista",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "",
    "view-success-title" => "",
    "view-success-message" => "",
    // - teléfonos editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para actualizar ABCDE en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "¡Actualizar teléfonos!",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que actualizar no existe o se elimino previamente, para retornar al listado general de XXX presioné continuar en la parte inferior de este mensaje. ",
    "edit-success-title" => "¡teléfonos actualizada!",
    "edit-success-message" => "Los datos de teléfonos se <b>actualizaron exitosamente</b>, para retornar al listado general de teléfonos presioné el botón continuar en la parte inferior del presente mensaje.",
    // - teléfonos deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para eliminar teléfonos en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar teléfonos!",
    "delete-message" => "Para confirmar la eliminación del teléfonos <b>%s</b>, presioné eliminar, para retornar al listado general de teléfonos presioné cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "\El elemento que intenta eliminar no existe o se elimino previamente, para retornar al listado general de XXX presioné continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡teléfonos eliminad@ exitosamente!",
    "delete-success-message" => "La teléfonos se elimino exitosamente, para retornar al listado de general de teléfonos presioné el botón continuar en la parte inferior de este mensaje.",
    // - teléfonos list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para acceder al listado general de ABCDE en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Listado de teléfonos",
];

?>