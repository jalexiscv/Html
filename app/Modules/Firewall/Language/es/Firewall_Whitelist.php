<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-05-15 23:13:02
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Firewall\Views\Whitelist\Creator\index.php]
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
* █ @link https://www.higgs.com.co
* █ @Version 1.5.1 @since PHP 8,PHP 9
* █ ---------------------------------------------------------------------------------------------------------------------
**/
return [
	// - Whitelist fields 
	"label_id"=>"id",
	"label_ip"=>"ip",
	"label_notes"=>"notes",
	"label_author"=>"author",
	"label_created_at"=>"created_at",
	"label_updated_at"=>"updated_at",
	"label_deleted_at"=>"deleted_at",
	"placeholder_id"=>"id",
	"placeholder_ip"=>"ip",
	"placeholder_notes"=>"notes",
	"placeholder_author"=>"author",
	"placeholder_created_at"=>"created_at",
	"placeholder_updated_at"=>"updated_at",
	"placeholder_deleted_at"=>"deleted_at",
	"help_id"=>"id",
	"help_ip"=>"ip",
	"help_notes"=>"notes",
	"help_author"=>"author",
	"help_created_at"=>"created_at",
	"help_updated_at"=>"updated_at",
	"help_deleted_at"=>"deleted_at",
	// - Whitelist creator 
	"create-denied-title"=>"¡Acceso denegado!",
	"create-denied-message"=>"Su rol en la plataforma no posee los privilegios requeridos para crear nuevas IPs, por favor póngase en contacto con el administrador del sistema o en su efecto contacte al personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar presione la opción correspondiente en la parte inferior de este mensaje.",
	"create-title"=>"Crear nueva IP",
	"create-errors-title"=>"¡Advertencia!",
	"create-errors-message"=>"Los datos proporcionados son incorrectos o están incompletos, por favor verifique e inténtelo nuevamente.",
	"create-duplicate-title"=>"¡IP existente!",
	"create-duplicate-message"=>"Esta IP ya se había registrado previamente, presione continuar en la parte inferior de este mensaje para retornar al listado general de IPs.",
	"create-success-title"=>"¡IP registrada exitosamente!",
	"create-success-message"=>"La IP se registró exitosamente, para retornar al listado general de IPs presione continuar en la parte inferior de este mensaje.",
	// - Whitelist viewer 
	"view-denied-title"=>"¡Acceso denegado!",
	"view-denied-message"=>"Los roles asignados a su perfil, no le conceden los privilegios necesarios para visualizar IPs en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
	"view-title"=>"Vista",
	"view-errors-title"=>"¡Advertencia!",
	"view-errors-message"=>"Los datos proporcionados son incorrectos o están incompletos, por favor verifique e inténtelo nuevamente.",
	"view-noexist-title"=>"¡No existe!",
	"view-noexist-message"=>"",
	"view-success-title"=>"",
	"view-success-message"=>"",
	// - Whitelist editor 
	"edit-denied-title"=>"¡Advertencia!",
	"edit-denied-message"=>"Los roles asignados a su perfil, no le conceden los privilegios necesarios para actualizar IPs en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
	"edit-title"=>"¡Actualizar IP!",
	"edit-errors-title"=>"¡Advertencia!",
	"edit-errors-message"=>"Los datos proporcionados son incorrectos o están incompletos, por favor verifique e inténtelo nuevamente.",
	"edit-noexist-title"=>"¡No existe!",
	"edit-noexist-message"=>"El elemento que desea actualizar no existe o se eliminó previamente, para retornar al listado general de IPs presione continuar en la parte inferior de este mensaje.",
	"edit-success-title"=>"¡IP actualizada!",
	"edit-success-message"=>"Los datos de IP se <b>actualizaron exitosamente</b>, para retornar al listado general de IPs presione el botón continuar en la parte inferior del presente mensaje.",
	// - Whitelist deleter 
	"delete-denied-title"=>"¡Advertencia!",
	"delete-denied-message"=>"Los roles asignados a su perfil, no le conceden los privilegios necesarios para eliminar IPs en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
	"delete-title"=>"¡Eliminar IP!",
	"delete-message"=>"Para confirmar la eliminación de la IP <b>%s</b>, presione eliminar, para retornar al listado general de IPs presione cancelar.",
	"delete-errors-title"=>"¡Advertencia!",
	"delete-errors-message"=>"Los datos proporcionados son incorrectos o están incompletos, por favor verifique e inténtelo nuevamente.",
	"delete-noexist-title"=>"¡No existe!",
	"delete-noexist-message"=>"El elemento que intenta eliminar no existe o se eliminó previamente, para retornar al listado general de IPs presione continuar en la parte inferior de este mensaje.",
	"delete-success-title"=>"¡IP eliminada exitosamente!",
	"delete-success-message"=>"La IP se eliminó exitosamente, para retornar al listado general de IPs presione el botón continuar en la parte inferior de este mensaje.",
	// - Whitelist list 
	"list-denied-title"=>"¡Advertencia!",
	"list-denied-message"=>"Los roles asignados a su perfil, no le conceden los privilegios necesarios para acceder al listado general de IPs en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
	"list-title"=>"Recuerde",
	"list-description"=>"Listado de IPs permitidas en el firewall del sistema, para la creación de nuevas IPs permitidas, presione el botón crear nueva IP en la parte superior derecha de este mensaje.",
];

?>