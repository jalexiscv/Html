<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-03-27 00:41:10
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sgd\Views\Centers\Creator\index.php]
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
    "document-management-centers"=>"Centros de gestión documentales",
    "document-management-centers-code"=>"Código",
    // - Centers fields
    "label_center"=>"Centro de gestión",
    "label_reference"=>"Referencia",
    "label_location"=>"Ubicación",
    "label_name"=>"Nombre",
    "label_description"=>"Descripción",
    "label_author"=>"Autor",
    "label_created_at"=>"Fecha de creación",
    "label_updated_at"=>"Fecha de actualización",
    "label_deleted_at"=>"Fecha de eliminación",
    "placeholder_center"=>"Ingrese el centro",
    "placeholder_reference"=>"Ingrese la referencia",
    "placeholder_location"=>"Ingrese la ubicación",
    "placeholder_name"=>"Ingrese el nombre",
    "placeholder_description"=>"Ingrese la descripción",
    "placeholder_author"=>"Ingrese el autor",
    "placeholder_created_at"=>"Fecha de creación",
    "placeholder_updated_at"=>"Fecha de actualización",
    "placeholder_deleted_at"=>"Fecha de eliminación",
    "help_center"=>"Indique el centro de gestión",
    "help_reference"=>"Indique la referencia del centro",
    "help_location"=>"Indique la ubicación del centro",
    "help_name"=>"Indique el nombre del centro",
    "help_description"=>"Proporcione una descripción del centro",
    "help_author"=>"Indique el autor del registro",
    "help_created_at"=>"Fecha en que se creó el registro",
    "help_updated_at"=>"Fecha de la última actualización",
    "help_deleted_at"=>"Fecha en que se eliminó el registro",
    // - Centers creator
    "create-denied-title"=>"¡Acceso denegado!",
    "create-denied-message"=>"Su rol en la plataforma no posee los privilegios requeridos para crear nuevos centros de gestión. Por favor, póngase en contacto con el administrador del sistema o con el personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar, presione la opción correspondiente en la parte inferior de este mensaje.",
    "create-title"=>"Crear nuevo centro de gestión",
    "create-errors-title"=>"¡Advertencia!",
    "create-errors-message"=>"Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "create-duplicate-title"=>"¡Centro de gestión existente!",
    "create-duplicate-message"=>"Este centro de gestión ya se había registrado previamente. Presione continuar en la parte inferior de este mensaje para retornar al listado general de centros de gestión.",
    "create-success-title"=>"¡Centro de gestión registrado exitosamente!",
    "create-success-message"=>"El centro de gestión se registró exitosamente. Para retornar al listado general de centros de gestión, presione continuar en la parte inferior de este mensaje.",
    // - Centers viewer
    "view-denied-title"=>"¡Acceso denegado!",
    "view-denied-message"=>"Los roles asignados a su perfil no le conceden los privilegios necesarios para visualizar centros de gestión en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title"=>"Centro de gestión",
    "view-errors-title"=>"¡Advertencia!",
    "view-errors-message"=>"Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "view-noexist-title"=>"¡No existe!",
    "view-noexist-message"=>"El centro de gestión que intenta visualizar no existe o fue eliminado previamente. Para retornar al listado general, presione continuar.",
    "view-success-title"=>"Centro de gestión",
    "view-success-message"=>"Visualizando detalles del centro de gestión seleccionado.",
    // - Centers editor
    "edit-denied-title"=>"¡Advertencia!",
    "edit-denied-message"=>"Los roles asignados a su perfil no le conceden los privilegios necesarios para actualizar centros de gestión en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title"=>"Actualizar centro de gestión",
    "edit-errors-title"=>"¡Advertencia!",
    "edit-errors-message"=>"Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "edit-noexist-title"=>"¡No existe!",
    "edit-noexist-message"=>"El elemento que intenta actualizar no existe o se eliminó previamente. Para retornar al listado general de centros de gestión, presione continuar en la parte inferior de este mensaje.",
    "edit-success-title"=>"¡Centro de gestión actualizado!",
    "edit-success-message"=>"Los datos del centro de gestión se <b>actualizaron exitosamente</b>. Para retornar al listado general de centros de gestión, presione el botón continuar en la parte inferior del presente mensaje.",
    // - Centers deleter
    "delete-denied-title"=>"¡Advertencia!",
    "delete-denied-message"=>"Los roles asignados a su perfil no le conceden los privilegios necesarios para eliminar centros de gestión en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title"=>"¡Eliminar centro de gestión!",
    "delete-message"=>"Para confirmar la eliminación del centro de gestión <b>%s</b>, presione eliminar. Para retornar al listado general de centros de gestión, presione cancelar.",
    "delete-errors-title"=>"¡Advertencia!",
    "delete-errors-message"=>"Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "delete-noexist-title"=>"¡No existe!",
    "delete-noexist-message"=>"El elemento que intenta eliminar no existe o se eliminó previamente. Para retornar al listado general de centros de gestión, presione continuar en la parte inferior de este mensaje.",
    "delete-success-title"=>"¡Centro de gestión eliminado exitosamente!",
    "delete-success-message"=>"El centro de gestión se eliminó exitosamente. Para retornar al listado general de centros de gestión, presione el botón continuar en la parte inferior de este mensaje.",
    // - Centers list
    "list-denied-title"=>"¡Advertencia!",
    "list-denied-message"=>"Los roles asignados a su perfil no le conceden los privilegios necesarios para acceder al listado general de centros de gestión en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title"=>"Listado de centros de gestión",
    "list-description"=>"Los Centros de Gestión Documentales son lugares donde se almacenan físicamente los documentos antes o después de su digitalización. Para localizarlos fácilmente, es común dividir estos centros en niveles más específicos, como estantes, cajas y carpetas. Esto no solo mejora la eficiencia, sino que también ayuda a cumplir con regulaciones legales en Colombia, como la Ley General de Archivos de 2000. En Colombia, estas ubicaciones están reguladas por el marco legal, como la Ley 594 de 2000 (Ley General de Archivos), que establece estándares para la gestión documental en entidades públicas y privadas.",
];
?>