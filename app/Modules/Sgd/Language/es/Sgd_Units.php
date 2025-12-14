<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-02-21 17:36:13
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sgd\Views\Units\Creator\index.php]
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
    // - Campos de Unidades
    "label_unit"=>"Unidades administrativas",
    "label_reference"=>"Código de referencia",
    "label_name"=>"Nombre",
    "label_description"=>"Descripción",
    "label_author"=>"Autor",
    "label_owner"=>"Responsable",
    "label_date"=>"Fecha",
    "label_time"=>"Hora",
    "label_created_at"=>"Fecha de creación",
    "label_updated_at"=>"Fecha de actualización",
    "label_deleted_at"=>"Fecha de eliminación",
    "label_version"=>"Versión",
    "placeholder_unit"=>"Ingrese la unidad",
    "placeholder_reference"=>"Ingrese el código de referencia",
    "placeholder_name"=>"Ingrese el nombre",
    "placeholder_description"=>"Ingrese la descripción",
    "placeholder_author"=>"Ingrese el autor",
    "placeholder_owner"=>"Ingrese el responsable",
    "placeholder_date"=>"Ingrese la fecha",
    "placeholder_time"=>"Ingrese la hora",
    "placeholder_created_at"=>"Fecha de creación",
    "placeholder_updated_at"=>"Fecha de actualización",
    "placeholder_deleted_at"=>"Fecha de eliminación",
    "help_unit"=>"Unidad administrativa",
    "help_reference"=>"Código único de referencia",
    "help_name"=>"Nombre de la unidad",
    "help_description"=>"Descripción detallada",
    "help_author"=>"Autor del registro",
    "help_owner"=>"Responsable de la unidad",
    "help_date"=>"Fecha del registro",
    "help_time"=>"Hora del registro",
    "help_created_at"=>"Fecha de creación del registro",
    "help_updated_at"=>"Fecha de última actualización",
    "help_deleted_at"=>"Fecha de eliminación",
    // - Creación de Unidades
    "create-denied-title"=>"¡Acceso denegado!",
    "create-denied-message"=>"Su rol no tiene los privilegios necesarios para crear unidades administrativas. Por favor, contacte al administrador del sistema o al soporte técnico para solicitar los permisos correspondientes.",
    "create-title"=>"Crear nueva unidad administrativa",
    "create-errors-title"=>"¡Advertencia!",
    "create-errors-message"=>"Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "create-duplicate-title"=>"¡Unidad administrativa existente!",
    "create-duplicate-message"=>"Esta unidad administrativa ya está registrada. Presione continuar para volver al listado general.",
    "create-success-title"=>"¡Unidad administrativa registrada exitosamente!",
    "create-success-message"=>"La unidad administrativa se ha registrado correctamente. Presione continuar para volver al listado general.",
    // - Visualización de Unidades
    "view-denied-title"=>"¡Acceso denegado!",
    "view-denied-message"=>"No tiene los privilegios necesarios para visualizar unidades administrativas. Contacte al soporte técnico para solicitar los permisos correspondientes.",
    "view-title"=>"Detalles de la unidad administrativa",
    "view-errors-title"=>"¡Advertencia!",
    "view-errors-message"=>"Los datos solicitados son incorrectos o no están disponibles. Por favor, verifique e inténtelo nuevamente.",
    "view-noexist-title"=>"¡Registro no encontrado!",
    "view-noexist-message"=>"La unidad administrativa solicitada no existe o fue eliminada.",
    "view-success-title"=>"Visualización exitosa",
    "view-success-message"=>"Datos de la unidad administrativa cargados correctamente.",
    // - Edición de Unidades
    "edit-denied-title"=>"¡Acceso denegado!",
    "edit-denied-message"=>"No tiene los privilegios necesarios para modificar unidades administrativas. Contacte al soporte técnico para solicitar los permisos correspondientes.",
    "edit-title"=>"Modificar unidad administrativa",
    "edit-errors-title"=>"¡Advertencia!",
    "edit-errors-message"=>"Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "edit-noexist-title"=>"¡Registro no encontrado!",
    "edit-noexist-message"=>"La unidad administrativa que intenta modificar no existe o fue eliminada. Presione continuar para volver al listado general.",
    "edit-success-title"=>"¡Unidad administrativa actualizada!",
    "edit-success-message"=>"Los datos se han actualizado correctamente. Presione continuar para volver al listado general.",
    // - Eliminación de Unidades
    "delete-denied-title"=>"¡Acceso denegado!",
    "delete-denied-message"=>"No tiene los privilegios necesarios para eliminar unidades administrativas. Contacte al soporte técnico para solicitar los permisos correspondientes.",
    "delete-title"=>"Eliminar unidad administrativa",
    "delete-message"=>"¿Está seguro de que desea eliminar la unidad administrativa '%s'? Esta acción no se puede deshacer.",
    "delete-errors-title"=>"¡Advertencia!",
    "delete-errors-message"=>"Ha ocurrido un error durante el proceso de eliminación. Por favor, inténtelo nuevamente.",
    "delete-noexist-title"=>"¡Registro no encontrado!",
    "delete-noexist-message"=>"La unidad administrativa que intenta eliminar no existe o ya fue eliminada. Presione continuar para volver al listado general.",
    "delete-success-title"=>"¡Unidad administrativa eliminada!",
    "delete-success-message"=>"La unidad administrativa se ha eliminado correctamente. Presione continuar para volver al listado general.",
    // - Listado de Unidades
    "list-denied-title"=>"¡Acceso denegado!",
    "list-denied-message"=>"No tiene los privilegios necesarios para acceder al listado de unidades administrativas. Contacte al soporte técnico para solicitar los permisos correspondientes.",
    "list-title"=>"Listado de unidades administrativas",
];

?>