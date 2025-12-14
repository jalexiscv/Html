<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-02-21 14:17:59
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sgd\Views\Versions\Creator\index.php]
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
    // - Versions fields
    "label_version"=>"Código de versión",
    "label_reference"=>"Referencia",
    "label_name"=>"Nombre de la versión",
    "label_description"=>"Descripción de la versión",
    "label_date"=>"Fecha",
    "label_type"=>"Tipo",
    "label_author"=>"Autor",
    "label_created_at"=>"Fecha de creación",
    "label_updated_at"=>"Fecha de actualización",
    "label_deleted_at"=>"Fecha de eliminación",
    "placeholder_version"=>"Versión",
    "placeholder_reference"=>"Referencia",
    "placeholder_name"=>"Nombre",
    "placeholder_description"=>"Descripción",
    "placeholder_date"=>"Fecha",
    "placeholder_type"=>"Tipo",
    "placeholder_author"=>"Autor",
    "placeholder_created_at"=>"Fecha de creación",
    "placeholder_updated_at"=>"Fecha de actualización",
    "placeholder_deleted_at"=>"Fecha de eliminación",
    "help_version"=>"Versión",
    "help_reference"=>"Referencia",
    "help_name"=>"Nombre",
    "help_description"=>"Descripción",
    "help_date"=>"Fecha",
    "help_type"=>"Tipo",
    "help_author"=>"Autor",
    "help_created_at"=>"Fecha de creación",
    "help_updated_at"=>"Fecha de actualización",
    "help_deleted_at"=>"Fecha de eliminación",
    // - Versions creator
    "create-denied-title"=>"¡Acceso denegado!",
    "create-denied-message"=>"Su rol en la plataforma no posee los privilegios requeridos para crear nuevas versiones. Por favor, póngase en contacto con el administrador del sistema o con el personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar, presione la opción correspondiente en la parte inferior de este mensaje.",
    "create-title"=>"Crear nueva versión",
    "create-errors-title"=>"¡Advertencia!",
    "create-errors-message"=>"Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "create-duplicate-title"=>"¡Versión existente!",
    "create-duplicate-message"=>"Esta versión ya se había registrado previamente. Presione continuar en la parte inferior de este mensaje para retornar al listado general de versiones.",
    "create-success-title"=>"¡Versión registrada exitosamente!",
    "create-success-message"=>"La versión se registró exitosamente. Para retornar al listado general de versiones, presione continuar en la parte inferior de este mensaje.",
    // - Versions viewer
    "view-denied-title"=>"¡Acceso denegado!",
    "view-denied-message"=>"Los roles asignados a su perfil no le conceden los privilegios necesarios para visualizar versiones en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title"=>"Vista",
    "view-errors-title"=>"¡Advertencia!",
    "view-errors-message"=>"Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "view-noexist-title"=>"¡No existe!",
    "view-noexist-message"=>"",
    "view-success-title"=>"",
    "view-success-message"=>"",
    // - Versions editor
    "edit-denied-title"=>"¡Advertencia!",
    "edit-denied-message"=>"Los roles asignados a su perfil no le conceden los privilegios necesarios para actualizar versiones en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title"=>"¡Actualizar versión!",
    "edit-errors-title"=>"¡Advertencia!",
    "edit-errors-message"=>"Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "edit-noexist-title"=>"¡No existe!",
    "edit-noexist-message"=>"El elemento que desea actualizar no existe o se eliminó previamente. Para retornar al listado general de versiones, presione continuar en la parte inferior de este mensaje.",
    "edit-success-title"=>"¡Versión actualizada!",
    "edit-success-message"=>"Los datos de la versión se <b>actualizaron exitosamente</b>. Para retornar al listado general de versiones, presione el botón continuar en la parte inferior del presente mensaje.",
    // - Versions deleter
    "delete-denied-title"=>"¡Advertencia!",
    "delete-denied-message"=>"Los roles asignados a su perfil no le conceden los privilegios necesarios para eliminar versiones en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title"=>"¡Eliminar versión!",
    "delete-message"=>"Para confirmar la eliminación de la versión <b>%s</b>, presione eliminar. Para retornar al listado general de versiones, presione cancelar.",
    "delete-errors-title"=>"¡Advertencia!",
    "delete-errors-message"=>"Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "delete-noexist-title"=>"¡No existe!",
    "delete-noexist-message"=>"El elemento que intenta eliminar no existe o se eliminó previamente. Para retornar al listado general de versiones, presione continuar en la parte inferior de este mensaje.",
    "delete-success-title"=>"¡Versión eliminada exitosamente!",
    "delete-success-message"=>"La versión se eliminó exitosamente. Para retornar al listado de general de versiones, presione el botón continuar en la parte inferior de este mensaje.",
    // - Versions list
    "list-denied-title"=>"¡Advertencia!",
    "list-denied-message"=>"Los roles asignados a su perfil no le conceden los privilegios necesarios para acceder al listado general de versiones en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title"=>"Listado de versiones",
    //--
    "list-info"=>"En esta sección se listan todas las versiones registradas en la plataforma. Para crear una nueva versión, presione el botón <b>Crear</b> en la parte superior derecha de este mensaje. Dado que las TRD pueden cambiar con el tiempo debido a reformas normativas, reestructuraciones organizativas o nuevas necesidades, es crucial gestionar diferentes versiones. Una versión de la TRD es, por tanto, una edición específica de estas tablas en un momento dado. Para más información visite [ <a href='https://alterplex.net/tablas-de-retencion-documentaltrd-y-sus-versiones/' target='_blank'>Nota detallada</a> ]",
];

?>