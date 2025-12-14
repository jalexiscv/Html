<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Profiles\Creator\index.php]
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
    // - Profiles fields
    "label_country" => "País",
    "label_type" => "Tipo de identificación",
    "label_number" => "Número de identificación",
    "label_profile" => "Código del peril",
    "label_alias" => "Alias",
    "label_firstname" => "Nombres",
    "label_lastname" => "Apellidos",
    "label_author" => "author",
    "label_created_at" => "created_at",
    "label_updated_at" => "updated_at",
    "label_deleted_at" => "deleted_at",
    "placeholder_profile" => "profile",
    "placeholder_number" => "Ej: 000000000",
    "placeholder_alias" => "Ej: ELBARTHO",
    "placeholder_firstname" => "firstname",
    "placeholder_lastname" => "lastname",
    "placeholder_author" => "author",
    "placeholder_created_at" => "created_at",
    "placeholder_updated_at" => "updated_at",
    "placeholder_deleted_at" => "deleted_at",
    "help_profile" => "Código automático",
    "help_alias" => "Opcional(Alias,Apodo,Sobrenombre)",
    "help_firstname" => "firstname",
    "help_lastname" => "lastname",
    "help_author" => "author",
    "help_created_at" => "created_at",
    "help_updated_at" => "updated_at",
    "help_deleted_at" => "deleted_at",
    "help_number" => "Requerido(Solo números)",
    "help_country" => "Requerido(Seleccione uno)",
    "help_type" => "Requerido(Seleccione uno)",
    // - Profiles creator
    "create-denied-title" => "Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevos perfiles, por favor póngase en contacto con el administrador del sistema o en su efecto contacte al personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar presioné la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nuevo perfil",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "create-duplicate-title" => "¡Perfil existente!",
    "create-duplicate-message" => "Este perfil ya se había registrado previamente, presioné continuar en la parte inferior de este mensaje para retornar al listado general de perfiles.",
    "create-success-title" => "¡Perfil registrado exitosamente!",
    "create-success-message" => "El perfil se registró exitosamente, para retornar al listado general de perfiles presioné continuar en la parte inferior de este mensaje.",
    "create-info" => "La creación del perfil es el primer y fundamental paso en el proceso de construcción de una identidad digital en nuestra plataforma. Al completar este paso, podrá agregar y gestionar de manera eficiente información adicional, como documentos de identidad, números de teléfono, correos electrónicos, direcciones físicas y demás elementos contemplados como datos de Inteligencia (Source Intelligence). Los datos adicionales se podrán agregar durante la edición del perfil, en una segunda instancia, lo que le permite personalizar y controlar la información que se comparte con nuestra plataforma. Una vez que haya creado el perfil, podrá acceder fácilmente a las opciones para añadir y gestionar estos elementos adicionales mediante el proceso de edición. Este enfoque le brinda flexibilidad y mayor control sobre la información proporcionada.",
    // - Profiles viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para perfiles en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "",
    "view-errors-title" => "",
    "view-errors-message" => "",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "",
    "view-success-title" => "",
    "view-success-message" => "",
    // - Profiles editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para actualizar perfiles en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "¡Actualizar perfiles!",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que actualizar no existe o se elimino previamente, para retornar al listado general de perfiles presioné continuar en la parte inferior de este mensaje. ",
    "edit-success-title" => "¡profiles actualizada!",
    "edit-success-message" => "Los datos de perfiles se <b>actualizaron exitosamente</b>, para retornar al listado general de profiles presioné el botón continuar en la parte inferior del presente mensaje.",
    // - Profiles deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para eliminar perfiles en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar perfil!",
    "delete-message" => "Para confirmar la eliminación del perfil <b>%s</b>, presioné eliminar, para retornar al listado general de perfiles presioné cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "\El elemento que intenta eliminar no existe o se elimino previamente, para retornar al listado general de perfiles presioné continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡perfil eliminado exitosamente!",
    "delete-success-message" => "El perfil se elimino exitosamente, para retornar al listado de general de perfiles presioné el botón continuar en la parte inferior de este mensaje.",
    // - Profiles list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para acceder al listado general de perfiles en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Listado de perfiles",
];

?>