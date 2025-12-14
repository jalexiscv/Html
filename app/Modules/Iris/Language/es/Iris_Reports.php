<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-04-10 06:52:10
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Iris\Views\Reports\Creator\index.php]
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
	// - Reports fields 
	"label_report"=>"report",
	"label_study"=>"study",
	"label_professional"=>"professional",
	"label_validation_date"=>"validation_date",
	"label_final_diagnosis"=>"final_diagnosis",
	"label_observations"=>"observations",
	"label_is_validated"=>"is_validated",
	"label_author"=>"author",
	"label_created_at"=>"created_at",
	"label_updated_at"=>"updated_at",
	"label_deleted_at"=>"deleted_at",
	"placeholder_report"=>"report",
	"placeholder_study"=>"study",
	"placeholder_professional"=>"professional",
	"placeholder_validation_date"=>"validation_date",
	"placeholder_final_diagnosis"=>"final_diagnosis",
	"placeholder_observations"=>"observations",
	"placeholder_is_validated"=>"is_validated",
	"placeholder_author"=>"author",
	"placeholder_created_at"=>"created_at",
	"placeholder_updated_at"=>"updated_at",
	"placeholder_deleted_at"=>"deleted_at",
	"help_report"=>"report",
	"help_study"=>"study",
	"help_professional"=>"professional",
	"help_validation_date"=>"validation_date",
	"help_final_diagnosis"=>"final_diagnosis",
	"help_observations"=>"observations",
	"help_is_validated"=>"is_validated",
	"help_author"=>"author",
	"help_created_at"=>"created_at",
	"help_updated_at"=>"updated_at",
	"help_deleted_at"=>"deleted_at",
	// - Reports creator 
	"create-denied-title"=>"Acceso denegado!",
	"create-denied-message"=>"Su rol en la plataforma no posee los privilegios requeridos para crear nuevos #plural, por favor póngase en contacto con el administrador del sistema o en su efecto contacte al personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar presioné la opción correspondiente en la parte inferior de este mensaje.",
	"create-title"=>"Crear nuevo #singular",
	"create-errors-title"=>"¡Advertencia!",
	"create-errors-message"=>"Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
	"create-duplicate-title"=>"¡#singular existente!",
	"create-duplicate-message"=>"Este #singular ya se había registrado previamente, presioné continuar en la parte inferior de este mensaje para retornar al listado general de #plural.",
	"create-success-title"=>"¡#singular registrada exitosamente!",
	"create-success-message"=>"La #singular se registró exitosamente, para retornar al listado general de #plural presioné continuar en la parte inferior de este mensaje.",
	// - Reports viewer 
	"view-denied-title"=>"¡Acceso denegado!",
	"view-denied-message"=>"Los roles asignados a su perfil, no le conceden los privilegios necesarios para visualizar #plural en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
	"view-title"=>"Vista",
	"view-errors-title"=>"¡Advertencia!",
	"view-errors-message"=>"Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
	"view-noexist-title"=>"¡No existe!",
	"view-noexist-message"=>"",
	"view-success-title"=>"",
	"view-success-message"=>"",
	// - Reports editor 
	"edit-denied-title"=>"¡Advertencia!",
	"edit-denied-message"=>"Los roles asignados a su perfil, no le conceden los privilegios necesarios para actualizar #plural en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
	"edit-title"=>"¡Actualizar #singular!",
	"edit-errors-title"=>"¡Advertencia!",
	"edit-errors-message"=>"Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
	"edit-noexist-title"=>"¡No existe!",
	"edit-noexist-message"=>"El elemento que actualizar no existe o se elimino previamente, para retornar al listado general de #plural presioné continuar en la parte inferior de este mensaje. ",
	"edit-success-title"=>"¡#singular actualizada!",
	"edit-success-message"=>"Los datos de #singular se <b>actualizaron exitosamente</b>, para retornar al listado general de #plural presioné el botón continuar en la parte inferior del presente mensaje.",
	// - Reports deleter 
	"delete-denied-title"=>"¡Advertencia!",
	"delete-denied-message"=>"Los roles asignados a su perfil, no le conceden los privilegios necesarios para eliminar #plural en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
	"delete-title"=>"¡Eliminar #singular!",
	"delete-message"=>"Para confirmar la eliminación del #singular <b>%s</b>, presioné eliminar, para retornar al listado general de #plural presioné cancelar.",
	"delete-errors-title"=>"¡Advertencia!",
	"delete-errors-message"=>"Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
	"delete-noexist-title"=>"¡No existe!",
	"delete-noexist-message"=>"\El elemento que intenta eliminar no existe o se elimino previamente, para retornar al listado general de #plural presioné continuar en la parte inferior de este mensaje.",
	"delete-success-title"=>"¡#Singular eliminad@ exitosamente!",
	"delete-success-message"=>"La #singular se elimino exitosamente, para retornar al listado de general de #plural presioné el botón continuar en la parte inferior de este mensaje.",
	// - Reports list 
	"list-denied-title"=>"¡Advertencia!",
	"list-denied-message"=>"Los roles asignados a su perfil, no le conceden los privilegios necesarios para acceder al listado general de #plural en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
	"list-title"=>"Listado de #plural",
	"list-description"=>"Descripción de #plural",
];

?>