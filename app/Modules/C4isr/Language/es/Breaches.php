<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Breaches\Creator\index.php]
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
    // - Breaches fields
    "label_breach" => "Código de la brecha",
    "label_domain" => "Dominio",
    "label_reference" => "Referencia",
    "label_title" => "Título",
    "label_description" => "Descripción",
    "label_date" => "Fecha de acontecimiento",
    "label_hacker" => "Hacker(s)",
    "label_created_at" => "created_at",
    "label_updated_at" => "updated_at",
    "label_deleted_at" => "deleted_at",
    "placeholder_breach" => "breach",
    "placeholder_domain" => "Ej: www.facebook.com",
    "placeholder_reference" => "Ej: FACEBOOK2020",
    "placeholder_date" => "date",
    "placeholder_hacker" => "hacker",
    "placeholder_title" => "Ej: Facebook DataLeak",
    "placeholder_description" => "Ej: Filracion masiva de datos debido a etc...",
    "placeholder_created_at" => "created_at",
    "placeholder_updated_at" => "updated_at",
    "placeholder_deleted_at" => "deleted_at",
    "help_breach" => "breach",
    "help_domain" => "Dominio vulnerado (Pwned website)",
    "help_reference" => "Referencia (Opcional)",
    "help_date" => "date",
    "help_hacker" => "hacker",
    "help_title" => "Titulo legible (Obligatorio)",
    "help_description" => "Descripción detallada (Obligatoria)",
    "help_created_at" => "created_at",
    "help_updated_at" => "updated_at",
    "help_deleted_at" => "deleted_at",
    // - Breaches creator
    "create-denied-title" => "Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevas brechas, por favor póngase en contacto con el administrador del sistema o en su efecto contacte al personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar presioné la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Registrar brecha de seguridad",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "create-duplicate-title" => "¡brecha existente!",
    "create-duplicate-message" => "Esta brecha de seguridad  ya se había registrado previamente, presioné continuar en la parte inferior de este mensaje para retornar al listado general de brechas.",
    "create-success-title" => "¡Brecha de seguridad  registrada exitosamente!",
    "create-success-message" => "La brecha de seguridad  se registró exitosamente, para retornar al listado general de brechas de seguridad  presioné continuar en la parte inferior de este mensaje.",
    // - Breaches viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para visualizar las brechas de seguridad registradas en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Brecha de seguridad",
    "view-errors-title" => "",
    "view-errors-message" => "",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "",
    "view-success-title" => "",
    "view-success-message" => "",
    // - Breaches editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para actualizar brechas de seguridad en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "Actualizando brecha de seguridad",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que actualizar no existe o se elimino previamente, para retornar al listado general de brechas presioné continuar en la parte inferior de este mensaje. ",
    "edit-success-title" => "¡Brecha de seguridad actualizada!",
    "edit-success-message" => "Los datos de la brecha de seguridad se <b>actualizaron exitosamente</b>, para retornar al listado general de brechas de seguridad  presioné el botón continuar en la parte inferior del presente mensaje.",
    // - Breaches deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para eliminar brechas en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar brecha de seguridad!",
    "delete-message" => "Para confirmar la eliminación de la <u>brecha de seguridad</u> <b>%s</b>, presioné eliminar, para retornar al listado general de brechas de seguridad presioné cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "\El elemento que intenta eliminar no existe o se elimino previamente, para retornar al listado general de brechas de seguridad  presioné continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡Brecha de seguridad eliminada exitosamente!",
    "delete-success-message" => "La brecha de seguridad se elimino exitosamente, para retornar al listado de general de brechas de seguridad presioné el botón continuar en la parte inferior de este mensaje.",
    // - Breaches list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para acceder al listado general de brechas de seguridad  en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Catalogo de brechas de seguridad",
    "domain-nofound-title" => "¡Dominio no encontrado!",
    "domain-nofound-message" => "La inteligencia artificial no pudo encontrar el dominio proporcionado. Se ha programado una búsqueda automática exhaustiva que tardará aproximadamente 24 horas antes de generar nuevos resultados. Para regresar al listado general de brechas de seguridad, por favor presione el botón continuar ubicado al final de este mensaje.",
    "alias-nofound-title" => "¡Alias no encontrado!",
    "alias-nofound-message" => "La inteligencia artificial no pudo encontrar el alias proporcionado. Se ha programado una búsqueda automática exhaustiva que tardará aproximadamente 24 horas antes de generar nuevos resultados. Para regresar al listado general de brechas de seguridad, por favor presione el botón continuar ubicado al final de este mensaje.",
    "email-nofound-title" => "¡Correo electrónico no encontrado!",
    "email-nofound-message" => "La inteligencia artificial no pudo encontrar el correo electrónico proporcionado. Se ha programado una búsqueda automática exhaustiva que tardará aproximadamente 24 horas antes de generar nuevos resultados. Para regresar al listado general de brechas de seguridad, por favor presione el botón continuar ubicado al final de este mensaje.",
];

?>