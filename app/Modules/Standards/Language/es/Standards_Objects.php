<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-01-31 15:52:18
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Standards\Views\Objects\Creator\index.php]
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
	// - Objects fields 
	"label_object"=>"Código del objeto",
	"label_name"=>"Nombre del objeto",
	"label_category"=>"Cátegorias",
	"label_parent"=>"Contenedor",
    "label_description"=>"Descripción",
	"label_attributes"=>"Atributos",
    "label_weight"=>"Peso(Orden de visualización)",
    "label_value"=>"Valor / Calificación",
    "label_evaluation"=>"Forma de Evaluación / Calificación",
    "label_type_content"=>"Tipo de Contenido",
    "label_type_node"=>"Tipo de nodo",
    "label_attachments"=>"Adjuntos",
	"placeholder_object"=>"object",
	"placeholder_name"=>"name",
	"placeholder_category"=>"category",
	"placeholder_parent"=>"parent",
    "placeholder_weight"=>"weight",
    "placeholder_description"=>"Ej: Este es un texto de ejemplo...",
	"placeholder_attributes"=>"attributes",
    "placeholder_value"=>"Ej: 0.0",
    "placeholder_evaluation"=>"Ej: Esta es la forma de calificar el contenido de este objeto",
    "placeholder_type_content"=>"Ej: Texto, Imagen, Video, Audio, Documento, etc.",
	"help_object"=>"object",
	"help_name"=>"name",
	"help_category"=>"category",
	"help_parent"=>"parent",
	"help_attributes"=>"attributes",
    "help_value"=>"Calificación inicial",
    "help_evaluation"=>"Evaluación",
    "help_type_content"=>"Seleccione el tipo de contenido",
    "help_weight"=>"Orden de visualización",
    "help_attachments"=>"Seleccione si el objeto tiene adjuntos",
	// - Objects creator
	"create-denied-title"=>"Acceso denegado!",
	"create-denied-message"=>"Su rol en la plataforma no posee los privilegios requeridos para crear nuevos objetos, por favor póngase en contacto con el administrador del sistema o en su efecto contacte al personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar presioné la opción correspondiente en la parte inferior de este mensaje.",
	"create-title"=>"Crear nuevo objeto",
	"create-errors-title"=>"¡Advertencia!",
	"create-errors-message"=>"Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
	"create-duplicate-title"=>"¡objeto existente!",
	"create-duplicate-message"=>"Este objeto ya se había registrado previamente, presioné continuar en la parte inferior de este mensaje para retornar al listado general de objetos.",
	"create-success-title"=>"¡objeto registrada exitosamente!",
	"create-success-message"=>"La objeto se registró exitosamente, para retornar al listado general de objetos presioné continuar en la parte inferior de este mensaje.",
	// - Objects viewer 
	"view-denied-title"=>"¡Acceso denegado!",
	"view-denied-message"=>"Los roles asignados a su perfil, no le conceden los privilegios necesarios para visualizar objetos en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
	"view-title"=>"Vista",
	"view-errors-title"=>"¡Advertencia!",
	"view-errors-message"=>"Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
	"view-noexist-title"=>"¡No existe!",
	"view-noexist-message"=>"",
	"view-success-title"=>"",
	"view-success-message"=>"",
	// - Objects editor 
	"edit-denied-title"=>"¡Advertencia!",
	"edit-denied-message"=>"Los roles asignados a su perfil, no le conceden los privilegios necesarios para actualizar objetos en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
	"edit-title"=>"¡Actualizar objeto!",
	"edit-errors-title"=>"¡Advertencia!", 
	"edit-errors-message"=>"Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
	"edit-noexist-title"=>"¡No existe!",
	"edit-noexist-message"=>"El elemento que actualizar no existe o se elimino previamente, para retornar al listado general de objetos presioné continuar en la parte inferior de este mensaje. ",
	"edit-success-title"=>"¡objeto actualizada!",
	"edit-success-message"=>"Los datos de objeto se <b>actualizaron exitosamente</b>, para retornar al listado general de objetos presioné el botón continuar en la parte inferior del presente mensaje.",
	// - Objects deleter 
	"delete-denied-title"=>"¡Advertencia!",
	"delete-denied-message"=>"Los roles asignados a su perfil, no le conceden los privilegios necesarios para eliminar objetos en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
	"delete-title"=>"¡Eliminar objeto!",
	"delete-message"=>"Para confirmar la eliminación del objeto <b>%s</b>, presioné eliminar, para retornar al listado general de objetos presioné cancelar.",
	"delete-errors-title"=>"¡Advertencia!",
	"delete-errors-message"=>"Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
	"delete-noexist-title"=>"¡No existe!",
	"delete-noexist-message"=>"\El elemento que intenta eliminar no existe o se elimino previamente, para retornar al listado general de objetos presioné continuar en la parte inferior de este mensaje.",
	"delete-success-title"=>"¡Objeto eliminado exitosamente!",
	"delete-success-message"=>"El objeto se elimino exitosamente, para retornar al listado de general de objetos presioné el botón continuar en la parte inferior de este mensaje.",
	// - Objects list 
	"list-denied-title"=>"¡Advertencia!",
	"list-denied-message"=>"Los roles asignados a su perfil, no le conceden los privilegios necesarios para acceder al listado general de objetos en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
	"list-title"=>"Listado de objetos",
    "list-message"=>"Acceda al listado de normas que su empresa ha contratado y gestione su cumplimiento de manera efectiva.",
];
?>