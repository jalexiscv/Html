<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Vulnerabilities\Creator\index.php]
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
    // - Vulnerabilities fields
    "vulnerabilities-label_vulnerability" => "vulnerability",
    "vulnerabilities-label_mail" => "mail",
    "vulnerabilities-label_alias" => "alias",
    "vulnerabilities-label_password" => "password",
    "vulnerabilities-label_hash" => "hash",
    "vulnerabilities-label_salt" => "salt",
    "vulnerabilities-label_author" => "author",
    "vulnerabilities-label_created_at" => "created_at",
    "vulnerabilities-label_updated_at" => "updated_at",
    "vulnerabilities-label_deleted_at" => "deleted_at",
    "vulnerabilities-placeholder_vulnerability" => "vulnerability",
    "vulnerabilities-placeholder_mail" => "mail",
    "vulnerabilities-placeholder_alias" => "alias",
    "vulnerabilities-placeholder_password" => "password",
    "vulnerabilities-placeholder_hash" => "hash",
    "vulnerabilities-placeholder_salt" => "salt",
    "vulnerabilities-placeholder_author" => "author",
    "vulnerabilities-placeholder_created_at" => "created_at",
    "vulnerabilities-placeholder_updated_at" => "updated_at",
    "vulnerabilities-placeholder_deleted_at" => "deleted_at",
    "vulnerabilities-help_vulnerability" => "vulnerability",
    "vulnerabilities-help_mail" => "mail",
    "vulnerabilities-help_alias" => "alias",
    "vulnerabilities-help_password" => "password",
    "vulnerabilities-help_hash" => "hash",
    "vulnerabilities-help_salt" => "salt",
    "vulnerabilities-help_author" => "author",
    "vulnerabilities-help_created_at" => "created_at",
    "vulnerabilities-help_updated_at" => "updated_at",
    "vulnerabilities-help_deleted_at" => "deleted_at",
    // - Vulnerabilities creator
    "vulnerabilities-create-denied-title" => "Acceso denegado!",
    "vulnerabilities-create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevas vulnerabilidades, por favor póngase en contacto con el administrador del sistema o en su efecto contacte al personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar presioné la opción correspondiente en la parte inferior de este mensaje.",
    "vulnerabilities-create-title" => "Crear nueva vulnerabilidad",
    "vulnerabilities-create-errors-title" => "¡Advertencia!",
    "vulnerabilities-create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "vulnerabilities-create-duplicate-title" => "¡vulnerabilidad existente!",
    "vulnerabilities-create-duplicate-message" => "Esta vulnerabilidad ya se había registrado previamente, presioné continuar en la parte inferior de este mensaje para retornar al listado general de vulnerabilidades.",
    "vulnerabilities-create-success-title" => "¡vulnerabilidad registrada exitosamente!",
    "vulnerabilities-create-success-message" => "La vulnerabilidad se registró exitosamente, para retornar al listado general de vulnerabilidades presioné continuar en la parte inferior de este mensaje.",
    // - Vulnerabilities viewer
    "vulnerabilities-view-denied-title" => "¡Acceso denegado!",
    "vulnerabilities-view-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para vulnerabilidades en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "vulnerabilities-view-title" => "",
    "vulnerabilities-view-errors-title" => "",
    "vulnerabilities-view-errors-message" => "",
    "vulnerabilities-view-noexist-title" => "¡No existe!",
    "vulnerabilities-view-noexist-message" => "",
    "vulnerabilities-view-success-title" => "",
    "vulnerabilities-view-success-message" => "",
    // - Vulnerabilities editor
    "vulnerabilities-edit-denied-title" => "¡Advertencia!",
    "vulnerabilities-edit-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para actualizar vulnerabilidades en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "vulnerabilities-edit-title" => "¡Actualizar vulnerabilidades!",
    "vulnerabilities-edit-errors-title" => "¡Advertencia!",
    "vulnerabilities-edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "vulnerabilities-edit-noexist-title" => "¡No existe!",
    "vulnerabilities-edit-noexist-message" => "El elemento que actualizar no existe o se elimino previamente, para retornar al listado general de vulnerabilidades presioné continuar en la parte inferior de este mensaje. ",
    "vulnerabilities-edit-success-title" => "¡vulnerabilidad actualizada!",
    "vulnerabilities-edit-success-message" => "Los datos de vulnerabilidades se <b>actualizaron exitosamente</b>, para retornar al listado general de vulnerabilidades presioné el botón continuar en la parte inferior del presente mensaje.",
    // - Vulnerabilities deleter
    "vulnerabilities-delete-denied-title" => "¡Advertencia!",
    "vulnerabilities-delete-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para eliminar vulnerabilidades en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "vulnerabilities-delete-title" => "¡Eliminar vulnerabilities!",
    "vulnerabilities-delete-message" => "Para confirmar la eliminación del vulnerabilities <b>%s</b>, presioné eliminar, para retornar al listado general de vulnerabilidades presioné cancelar.",
    "vulnerabilities-delete-errors-title" => "¡Advertencia!",
    "vulnerabilities-delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "vulnerabilities-delete-noexist-title" => "¡No existe!",
    "vulnerabilities-delete-noexist-message" => "\El elemento que intenta eliminar no existe o se elimino previamente, para retornar al listado general de vulnerabilidades presione continuar en la parte inferior de este mensaje.",
    "vulnerabilities-delete-success-title" => "¡vulnerabilidad eliminada exitosamente!",
    "vulnerabilities-delete-success-message" => "La vulnerabilidad se elimino exitosamente, para retornar al listado de general de vulnerabilidades presioné el botón continuar en la parte inferior de este mensaje.",
    // - Vulnerabilities list
    "vulnerabilities-list-denied-title" => "¡Advertencia!",
    "vulnerabilities-list-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para acceder al listado general de vulnerabilidades en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "vulnerabilities-list-title" => "Listado de vulnerabilidades",
];

?>